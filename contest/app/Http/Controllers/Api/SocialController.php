<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    public function login(Request $request) {
        $isUser = 0;
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
        $device_type = $request->device_type;
        $device_token = $request->device_token;

        if (User::FACEBOOK == $social_platform){
            $fb_id = $request->social_platform_id;
            $user = User::where('fb_id', $fb_id)->first();
            if (!$user){
                $user = new User();
            }
            $user->fb_id = $fb_id;
            $user->name = $name;
            $user->device_type = $device_type;
            $user->device_token = $device_token;
            $user->email = $email;
            $user->password = 11111;
            $user->save();
        } else {
            $user = User::where('email', $email)->first();
            if (!$user){
                $user = new User();
            }
            $user->google_id = $request->social_platform_id;
            $user->name = $name;
            $user->device_type = $device_type;
            $user->device_token = $device_token;
            $user->email = $email;
            $user->password = 11111;
            $user->save();
        }

        auth()->login($user, true);
        $user = Auth::user();
        $token = $user->createToken('TripsConContest')->accessToken;
        $user->update([
            'api_token' => $token,
        ]);

        $this->status = 200;
        $this->response['success'] = true;

        $users = Auth::user();
        $this->response['data'] = $users->makeVisible('api_token');

        return response()->json($this->response, $this->status);
    }

}
