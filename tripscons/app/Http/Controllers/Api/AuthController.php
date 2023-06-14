<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Notification\SendPushNotificationController;
use App\Models\Country;
use App\Models\DeviceBadge;
use App\Models\DeviceDetail;
use App\Models\LoginLogs;
use App\Models\Notification;
use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use App\Events\SignUp;
use App\Events\UserRegistration;
use App\Events\ForgotPassword;
use App\Events\ConfirmationLink;
use App\Mail\WelcomeEmail;
use App\Http\Controllers\SmsController;
use Telnyx;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;
use File;

class AuthController extends Controller
{
    protected $SendPushNotificationController;

    public function __construct(SendPushNotificationController $SendPushNotificationController)
    {
        $this->SendPushNotificationController = $SendPushNotificationController;
    }

    /**
     * @var array
     */
    protected $response = [];
    protected $status = 200;

    /**
     * @Description Registration
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @Author Khuram Qadeer.
     */
    public function register(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'device_type' => 'required',
            'type'=>'required',
        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        // if(isset($request->token_generate) && !empty($request->token_generate)){
        //     $result = captachSiteverify($request->token_generate);
        //     return $result;
        //     if(!$result){
        //         $this->status = 422;
        //         $this->response['success'] = false;
        //         $this->response['message'] = 'Something went wrong, please try again!';
        //         return response()->json($this->response, $this->status);
        //     }
        // }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'switchProfile' => $request->type,
            'device_type' =>$request->device_type,
            'password' => bcrypt($request->password),
            'verified' => 0,
        ]);
        // Notification Push to User Profile updated
        $title = "Registration";
        $message = "Your Profile has been created at our platform (Tripscon). please complete your profile";
        $action     = "account_info";

        $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();
        if(isset($admin) && !empty($admin)){
            
            PushNotification::createNotification($user,$admin->id,$title,$message,User::TYPE_REGISTER,$action,$user->id);

            $message = "New User ".$user->name." has been registered.";
            PushNotification::createNotification($admin,$user->id,$title,$message,User::TYPE_REGISTER,$action,$user->id);
        }

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'User has been logged in.';
            if ($user->type == 1) {
                $user->ServiceProviderRates;
            }
            Auth::login($user);
            $token = $user->createToken('TripsCon')->accessToken;
            if(isset(request()->phone) && !empty(request()->phone)){
                $user->update([
                    'api_token' => $token,
                    'phone' => request()->phone
                ]);
            }else{
                $user->update([
                    'api_token' => $token
                ]);
            }

            $user->makeVisible('api_token');

            LoginLogs::createRecord($token, $request->device_type);
            $users = Auth::user();
            $this->response['data'] = $users->makeVisible('api_token');

            $token_random = Str::random(40) . 'Ti_' . time();
            PasswordReset::whereEmail($users->email)->where('type',2)->delete();
            PasswordReset::create([
                'email' => $users->email,
                'token' => $token_random,
                'type'  => 2
            ]);
            $guest_user = (isset(request()->guest_user) && !empty(request()->guest_user)) ? request()->guest_user : 0;
            $data = ['token'=> $token_random,'name'=>$users->name,'email'=>$users->email, 'random_password' => request()->password, 'guest_user' => $guest_user];
            event(new ConfirmationLink($data));

        }

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Email sent,please check own email for confirmation email';
        return response()->json($this->response, $this->status);
    }

    public function confirmationMail(){
        $user = Auth::user();
        if ($user && $user->verified == 0) {
            $token = Str::random(40) . 'Ti_' . time();
            PasswordReset::whereEmail($user->email)->delete();
            PasswordReset::create([
                'email' => $user->email,
                'token' => $token
            ]);
            $data = ['token'=> $token,'name'=>$user->name,'email'=>$user->email];
            event(new ConfirmationLink($data));
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Email has been sent';
        }else if($user && $user->verified == 1){
            $title = "Account Verified";
            $message = "Your account has been verified.";
            $action     = "account_info";
            $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();
            if(isset($admin) && !empty($admin)){
                PushNotification::createNotification($user,$admin->id,$title,$message,User::TYPE_VERIFIED,$action,$user->id);
            }

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Your account has been verified';
            $this->response['data'] = $user->makeVisible('api_token');
            return response()->json($this->response, $this->status);

        }else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Something went wrong';

        }
        return response()->json($this->response, $this->status);
    }

    public function verifyAccount(Request $request) {

        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'verification_code' => 'required',
        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, $this->status);
        }

        $user = User::where('email', base64_decode($request->email))->first();
        $alreadyFlag =0;
        if ($user) {
            if($user->verified == 1){
                $alreadyFlag = 1;
                $user->makeVisible('api_token');
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['alreadyFlag'] = $alreadyFlag;
                $this->response['data'] = $user;
                $this->response['message'] = 'user has been already verified.';
                return response()->json($this->response, $this->status);
            }else{
                if (PasswordReset::where([['email', $user->email], ['token', $request->verification_code]])->exists()) {
                    PasswordReset::where('email', $user->email)->where('type',2)->delete();

                    $user->update([
                        'verified' => 1
                    ]);
                    // Send Notifications
                    $title = "Account Verified";
                    $message = "Your account has been verified.";
                    $action     = "account_info";
                    $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();
                    if(isset($admin) && !empty($admin)){
                        PushNotification::createNotification($user,$admin->id,$title,$message,User::TYPE_VERIFIED,$action,$user->id);

                        $message = "".$user->name." account has been verified.";
                        PushNotification::createNotification($admin,$user->id,$title,$message,User::TYPE_VERIFIED,$action,$user->id);
                    }
                    $user->makeVisible('api_token');
                    $this->status = 200;
                    $this->response['success'] = true;

                    $this->response['data'] = $user;
                    $this->response['alreadyFlag'] = $alreadyFlag;
                    $this->response['message'] = 'user has been verified.';

                }else{
                    $this->status = 422;
                    $this->response['success'] = false;
                    $this->response['message'] = 'token has been expired';
                    return response()->json($this->response, $this->status);
                }
            }

        } else {
            $this->status = 422;
            $this->response['success'] = false;

            $this->response['message'] = 'user does not exist/unauthenticated';
            return response()->json($this->response, $this->status);
        }

        return response()->json($this->response, $this->status);
    }

    /**
     * @Description Login
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @Author Khuram Qadeer.
     */
    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'device_type' => 'required',
        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        // Unauthorized
        $this->status = 401;
        $this->response['success'] = false;
        $this->response['message'] = 'Invalid credentials';

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {

            $user = Auth::user();
            if($user->role_id == 2)
            {
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'User has been logged in.';
            if ($user->type == 1) {
                $user->ServiceProviderRates;
            }
            Auth::login($user);
            $token = $user->createToken('TripsCon')->accessToken;
            $user->update([
                'api_token' => $token
            ]);

            $user->makeVisible('api_token');

            LoginLogs::createRecord($token, $request->device_type);
            $users = Auth::user();
            $this->response['data'] = $users->makeVisible('api_token');
           }else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Unknown User';
            return response()->json($this->response, $this->status);
           }
        }
        return response()->json($this->response, $this->status);
    }

    /**
     * @Description Logout
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @Author Khuram Qadeer.
     */
    public function logout(Request $request)
    {

        LoginLogs::deleteByToken(User::getUserToken($request->user()->id));
        $request->user()->update([
            'api_token' => '',
            'is_logout' => 1
        ]);
        $request->user()->token()->revoke();
        $this->response['success'] = true;
        $this->response['message'] = 'user logout.';
        return response($this->response, $this->status);
    }

    /**
     * @Description Forgot password sending email with verification code
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @Author Khuram Qadeer.
     */
    public function sendEmailForResetPassword(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, $this->status);
        }

        $email = $request->email;
        //->where('verified',1)
        $users = User::where('email', '=', $email)->first();
        // web link send
        if ($users) {
            $token = Str::random(40) . 'Ti_' . time();
            PasswordReset::where('email', $email)->where('type',0)->delete();
            PasswordReset::create([
                'email' => $users->email,
                'token' => $token
            ]);
            $toName = $users->name;
            $toEmail = $users->email;
            $data = ['user_id' => $users->id, 'token' => $token,'name'=>$toName,'email'=>$toEmail];
            event(new ForgotPassword($data));

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Email sent,Please check own email for reset password';
        } else {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'email does not exists/account not verified.';
        }
        return response()->json($this->response, $this->status);
    }

    /**
     * @Description Update user password after apply with email for reset/forgot password working
     *              according correct verification code.
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @Author Khuram Qadeer.
     */
    public function updateForgotPassword(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'user_id' => 'required',
            'verification_code' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, $this->status);
        }
        $user = User::find((int)$request->user_id);

        if ($user) {

            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'verification code is invalid.';

            if (PasswordReset::where([['email', $user->email], ['token', $request->verification_code],['type',0]])->exists()) {
                PasswordReset::where('email', $user->email)->where('type',0)->delete();
                $user->update([
                    'password' => bcrypt($request->password),
                    'is_password_changed' =>1

                ]);

                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'password has been updated.';
            }
        } else {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'user does not exists';
            return response()->json($this->response, $this->status);
        }

        return response()->json($this->response, $this->status);
    }

    public function byPassAuth(Request $request){

        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'token' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, $this->status);
        }
        $user = User::where('email', $request->email)->first();

        if ($user) {

            if (PasswordReset::where([['email', $user->email], ['token', $request->token],['type',$request->type]])->exists()) {
                PasswordReset::where('email', $user->email)->where('type',$request->type)->delete();
                $token = $user->createToken('TripsCon')->accessToken;
                $user->update([
                    'api_token' => $token
                ]);

                $this->response['data'] = $user->makeVisible('api_token');
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'User has been logged in.';
                return response()->json($this->response, $this->status);
            }else{
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = 'unauthenticated/invalid token';
                return response()->json($this->response, $this->status);
            }
        } else {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'user does not exists';
            return response()->json($this->response, $this->status);
        }

        return response()->json($this->response, $this->status);
    }

    public function changePassword(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'old_password' => 'required'
        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, $this->status);
        }
        if (!(Hash::check($request->old_password, $request->user()->password))) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Old password is incorrect!';
            return response()->json($this->response, $this->status);
        }

        if (Hash::check($request->password, $request->user()->password)) {

            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Old and new passwords are the same!';
            return response()->json($this->response, $this->status);
        }
        // echo bcrypt($request->old_password);exit;
        $user = $request->user();
        if ($user) {
            $user->update([
                'password' => bcrypt($request->password),
                'is_password_changed' =>1
            ]);

            // Notification Push to User Profile updated
            $title      = "Profile Updated";
            $message    = "Your password has been changed";
            $action     = "changePassword";
            $admin      = User::where('role_id',User::ADMIN_ROLE_ID)->first();

            if(isset($admin) && !empty($admin)){
                PushNotification::createNotification($user,$admin->id,$title,$message,User::TYPE_PROFILE,$action,$user->id);
            }

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Password has been changed.';
        }

        return response()->json($this->response, $this->status);
    }

    /**
     * @Description Social Login and registration
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @Author Khuram Qadeer.
     */
    public function socialRegister(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'device_type' => 'required',
            'device_token' => 'required',
            'social_platform' => 'required',
            'social_platform_id' => 'required',
        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, $this->status);
        }

        $name = $request->name;
        $email = $request->email;
        $social_platform = $request->social_platform;
        $social_platform_id = $request->social_platform_id;
        $device_type = $request->device_type;
        $device_token = $request->device_token;

        if (User::where('social_platform_id', $social_platform_id)->where('social_platform', $social_platform)->exists()) {
            User::where('social_platform_id', $social_platform_id)->where('social_platform', $social_platform)
                ->update([
                    'name' => $name,
                    'device_type' => $device_type,
                    'device_token' => $device_token,
                    'social_platform' => $social_platform,
                    'social_platform_id' => $social_platform_id,
                ]);
            $user = User::where('social_platform_id', $social_platform_id)->where('social_platform', $social_platform)->first();
            $isNew =false;
        } else {
            $isNew =false;
            if (User::where('email', $email)->exists()) {
                $user = User::where('email', $email)->update([
                    'name' => $name,
                    'device_type' => $device_type,
                    'device_token' => $device_token,
                    'social_platform' => $social_platform,
                    'social_platform_id' => $social_platform_id,
                ]);
                $user = User::where('email', $email)->first();
            } else {
                $isNew =true;
                $user = User::Create([
                    'name' => $name,
                    'email' => $email,
                    'device_type' => $device_type,
                    'device_token' => $device_token,
                    'social_platform' => $social_platform,
                    'social_platform_id' => $social_platform_id,
                ]);
            }
        }
        if ($user) {
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['isNew'] = $isNew;
            $this->response['message'] = 'user has been logged in.';

            Auth::login($user);
            $user = Auth::user();
            $token = $user->createToken('TripsCon')->accessToken;
            $user->update([
                'api_token' => $token,
                'verified'=>1,
            ]);

            if ($files = $request->file('image')) {
                $image_full_name = pathinfo($files->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('/assets/uploads/users'); //Creating Sub directory in Public
                $files->move($destinationPath, $image_full_name);
                $user->update([
                    'image' => $image_full_name
                ]);
            }

            LoginLogs::createRecord($token, $request->device_type);
            $users = Auth::user();
            $this->response['data'] = $users->makeVisible('api_token');
        }
        return response()->json($this->response, $this->status);
    }

    public function loginWithPhone(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'phone' => 'required',
            'country_code' => 'required',
        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, $this->status);
        }

        $this->status = 401;
        $this->response['success'] = false;
        $this->response['message'] = 'invalid phone.';

        $user = User::where('phone', $request->phone)->where('country_code', $request->country_code)->first();

        if ($user) {
            $pin_code = rand(10000,99999);
            $user->update([
                'pin_code' => $pin_code
            ]);
            $this->OTPCreate($user, $pin_code);
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Code has been sent.';
        }

        return response()->json($this->response, $this->status);
    }

    public function OTPCreate($user, $pin_code){

        SmsController::send($user->country_code . $user->phone, "Your OTP is ".$pin_code);
    }

    public function sendPhoneCode(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'phone' => 'required',
            'country_code' => 'required',
        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, $this->status);
        }
        $already = User::where('is_phone_verified', 1)->where('id', '!=', $request->user()->id)
            ->where('phone', $request->phone)
            ->where('country_code', $request->country_code)->first();

        if ($already) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'phone already used.';
            return response()->json($this->response, $this->status);
        }

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Code has been sent.';
        //implement here global mobile services
        $user = $request->user();
        $pin_code = rand(10000,99999);
        $user->update([
            'pin_code' => $pin_code,
            'phone' => $request->phone,
            'country_code' => $request->country_code
        ]);
        $this->OTPCreate($user, $pin_code);
        return response()->json($this->response, $this->status);
    }

    public function verifyPhoneCode(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'pin_code' => 'required',
        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, $this->status);
        }

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Phone number has been verified.';
        $user =  $request->user();
        if ($user->pin_code == $request->pin_code) {
            $user->update([
                'is_phone_verified' => 1,
                'verified' => 1
            ]);
            //$user->is_phone_verified = 1;
            $this->response['data'] =  $user->makeVisible('api_token');
        } else {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Phone Code is Wrong, please enter correct one.';
        }
        return response()->json($this->response, $this->status);
    }

    public function verifyPhoneCodeWithPhone(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'phone' => 'required',
            'country_code' => 'required',
            'pin_code' => 'required',
            'device_type' => 'required',
        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, $this->status);
        }

        $this->status = 401;
        $this->response['success'] = false;
        $this->response['message'] = 'provide information not correct.';
        $user = User::where('is_phone_verified', 1)
            ->where('phone', $request->phone)
            ->where('pin_code', $request->pin_code)
            ->where('country_code', $request->country_code)->first();
        // print($user->id);exit;
        if ($user) {
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'user has been logged in.';
            $token = $user->createToken('TripsCon')->accessToken;
            $user->update([
                'api_token' => $token,
                'verified' => 1
            ]);
            LoginLogs::createRecord($token, $request->device_type);

            $this->response['data'] =  $user->makeVisible('api_token');
        }

        return response()->json($this->response, $this->status);
    }

    public function getTokenAndRefreshToken(OClient $oClient, $email, $password)
    {
        $oClient = OClient::where('password_client', 1)->first();
        $http = new Client;
        $response = $http->request('POST', 'http://mylemp-nginx/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $oClient->id,
                'client_secret' => $oClient->secret,
                'username' => $email,
                'password' => $password,
                'scope' => '*',
            ],
        ]);
        $result = json_decode((string) $response->getBody(), true);
        return response()->json($result, $this->successStatus);
    }

    public function deviceTokenRegister(Request $request)
    {
        try {
            $user = $request->user();
            $user->device_token = $request->device_token;
            $user->device_type = $request->device_type;
            $user->save();

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Device Token update';
            return response()->json($this->response, $this->status);
        }
        catch (\Exception $e)
        {
            $this->status = 401;
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }


    public function sendNotification($user)
    {
        try {
            $device_token = [];
            $receiver_id = $user->id;
            $deviceTokens = DeviceDetail::select('device_token')->where('user_id', $receiver_id)->get();
            if ($deviceTokens) {
                foreach ($deviceTokens as $key => $deviceToken) {
                    $device_token[$key] = $deviceToken->device_token;
                }
            }
            $notification = new Notification();
            $notification->user_id=$receiver_id;
            $notification->sender_id= 1;
            $notification->receiver_id=$receiver_id;
            $notification->message="User Register";
            $notification->body="User registered successfully. ";
            $notification->type=User::REGISTER_TYPE;
            $notification->actions= '/api/register';
            $notification->seen=0;
            $notification->status=User::STATUS;
            $notification->active=1;
            $notification->save();
            $badge = PushNotification::deviceBadgesUpdate($receiver_id,User::REGISTER_TYPE);
            PushNotification::sendNotification([
                'message'           => "User registered successfully. ",
                'title'             => "User Register",
                'device_tokens'     => $device_token,
                'user'              => $user,
                'payload' => [
                    'id'            =>  $user->id,
                    'type'          => User::REGISTER_TYPE,
                    'sender_id'     => 1,
                    'badge'         => $badge
                ]
            ]);
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Notification send successfully.';
            return response()->json($this->response, $this->status);
        }
        catch (\Exception $e)
        {
            $this->status = 401;
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }

    public static function deviceBadgesUpdate($user_id,$type = 'BOOKING')
    {
        try {
            $device_badges = DeviceBadge::where('user_id',$user_id)->where('type',$type)->first();
            if ($device_badges) {
                if ($device_badges->type == $type) {
                    $device_badges->count = $device_badges->count + 1;
                    $device_badges->update();
                }
            } else {
                $device_badges = new DeviceBadge();
                $device_badges->user_id = $user_id;
                $device_badges->type = $type;
                $device_badges->status = 'ACTIVE';
                $device_badges->count = 1;
                $device_badges->save();
            }
            return $device_badges->count;
        }
        catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function deviceBadgesUpdated($user_id){
        $device_badges = DeviceBadge::where('user_id',$user_id)->get();
        $type = 'BOOKING';
        try {
            foreach ($device_badges as $device_badge){
                if ($device_badge->type == $type) {
                    $device_badge->count = $device_badge->count + 1;
                }
                $device_badge->update();
            }
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Device Badges updated Successfully.';
            $this->response['data'] = $device_badges;
            return response()->json($this->response, $this->status);
        }
        catch (Exception $e){
            $this->status = 200;
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }
    public function redirectToFacebook(){

        try {
            return Socialite::driver('facebook')->stateless()->redirect();
        } catch (Exception $e) {
           return $e->getMessage();
            
        }
    }
    public function redirectToGoogle(){

  
        try {
            return Socialite::driver('google')->stateless()->redirect();
        } catch (Exception $e) {
           return $e->getMessage();
            
        }
    }
    public function getGoogleUserInfo(Request $request){
       
        if($request->plateform == 'facebook'){
            $user = Socialite::driver('facebook')->userFromToken($request->token);
        }else{
            $user = Socialite::driver('google')->userFromToken($request->token);
        }

        $name = $user->name;
        $email = $user->email;
        $social_platform = 'Google';
        $social_platform_id = $user->id;
        $device_type = 'web';
        $device_token = $request->token;
        $avatar=$user->avatar;
       
        if (User::where('social_platform_id', $social_platform_id)->where('social_platform', $social_platform)->exists()) {
            
                User::where('social_platform_id', $social_platform_id)->where('social_platform', $social_platform)
                    ->update([
                        'name' => $name,
                        'device_type' => $device_type,
                        // 'device_token' => $device_token,
                        'social_platform' => $social_platform,
                        'social_platform_id' => $social_platform_id,
                    ]);
                $user = User::where('social_platform_id', $social_platform_id)->where('social_platform', $social_platform)->first();
                $isNew =false;
            } else {
              
                $isNew =false;
                if (User::where('email', $email)->exists()) {
                   
                    $user = User::where('email', $email)->update([
                        'name' => $name,
                        'device_type' => $device_type,
                        // 'device_token' => $device_token,
                        'social_platform' => $social_platform,
                        'social_platform_id' => $social_platform_id,
                    ]);
                    $user = User::where('email', $email)->first();
                } else {
                   
                    $contents = file_get_contents($avatar);
                    // $Image_name = substr($avatar, strrpos($avatar, '/') + 1);
                    $Image_name =$name.'-'.$social_platform.'-avatar';
                    $full_name=$Image_name.'.jpg';
                  
                    Storage::disk('uploads')->put($full_name, $contents);
                  
                    $isNew =true;
                    $user = User::Create([
                        'name' => $name,
                        'email' => $email,
                        'device_type' => $device_type,
                        // 'device_token' => $device_token,
                        'social_platform' => $social_platform,
                        'social_platform_id' => $social_platform_id,
                        'type' => 0,
                        'switchProfile' => 0,
                        'image' => $full_name,
                    ]);
                }
            }
            if ($user) {
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['isNew'] = $isNew;
                $this->response['message'] = 'user has been logged in.';

                Auth::login($user);
                $user = Auth::user();
                $token = $user->createToken('TripsCon')->accessToken;
                $user->update([
                    'api_token' => $token,
                    'verified'=>1,
                ]);


                LoginLogs::createRecord($token, $device_type);
                $users = Auth::user();
                $this->response['data'] = $users->makeVisible('api_token');
            }
        
            return response()->json($this->response, $this->status);

    }
    public function handleGoogleCallback()
    {
        try {
           
            $user = Socialite::driver('google')->stateless()->user();

            return redirect(\config('app.FRONT_END_BASE_PATH').'/auth/?plateform=google&token='.$user->token);
      
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    public function handleFacebookCallback()
    {
        try {
           
            $user = Socialite::driver('facebook')->stateless()->user();

            return redirect(\config('app.FRONT_END_BASE_PATH').'/auth/?plateform=facebook&token='.$user->token);
      
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    // check auth
    public function checkAuthUser(Request $request)
    {
    
        if (!empty(auth()->user())) {

            $user = Auth::user();
            if($user->role_id == 2)
            {
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'User has been logged in.';
            if ($user->type == 1) {
                $user->ServiceProviderRates;
            }
            // return $user;
            // Auth::login($user);
            $token = $user->createToken('TripsCon')->accessToken;
            $user->update([
                'api_token' => $token
            ]);

            $user->makeVisible('api_token');

            LoginLogs::createRecord($token, $request->device_type);
            $users = Auth::user();
            $this->response['data'] = $users->makeVisible('api_token');
           }else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Unknown User';
            return response()->json($this->response, $this->status);
           }
        }
        return response()->json($this->response, $this->status);
    }
}
