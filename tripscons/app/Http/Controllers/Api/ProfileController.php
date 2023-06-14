<?php

namespace App\Http\Controllers\Api;

use App\Models\ActivityLink;
use App\Models\City;
use App\Models\Country;
use App\Models\KnowledgeCity;
use App\Models\PhotographerSkillLink;
use App\Models\PhotographerTypeLink;
use App\Models\State;
use App\Models\User;
use App\Models\UserCountry;
use App\Models\UserLanguage;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{

    /**
     * @var array
     */
    protected $response = [];
    protected $status = 200;

    /**
     * @Description Account Info/Basic Account info save
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @Author Khuram Qadeer.
     */
    public function accountInfoUpdate(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'username' => 'required|unique:users,username,' . $request->user()->id,
            'name' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'postal_code' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'date_of_birth' => 'required|date|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, $this->status);
        }

        $user = $request->user();
        $country = Country::find((int)$request->country_id);
        $state = State::find((int)$request->state_id);
        $city = City::find((int)$request->city_id);

        $this->status = 422;
        $this->response['success'] = false;
        if (!$country) {
            $this->response['message'] = 'country does not exists.';
            return response()->json($this->response, $this->status);
        } elseif (!$state) {
            $this->response['message'] = 'state does not exists.';
            return response()->json($this->response, $this->status);
        } elseif (!$city) {
            $this->response['message'] = 'city does not exists.';
            return response()->json($this->response, $this->status);
        }

        User::whereId($user->id)->update([
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'additional_address' => $request->additional_address ?? '',
            'country_id' => $country->id,
            'state_id' => $state->id,
            'city_id' => $city->id,
            'country' => $country->name,
            'state' => $state->name,
            'city' => $city->name,
            'country_short_name' => $country->sortname,
            'date_of_birth' => date("Y-m-d", strtotime($request->date_of_birth)),
        ]);
        $title      = "Profile Updated";
        $message    = "Profile updated successfully";
        $action     = "account_info";
        $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();
        if(isset($admin) && !empty($admin)){
            PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_PROFILE,$action,$request->user()->id);
        }

        $userId = $request->user()->id;
        $dirPath = 'basic/images/uploads/';
        $filename = Str::random(40) . '.png';
        $file = $request->file;

        if (User::whereId($userId)->exists() && $file) {
            $validator = \Validator::make($request->all(), [
                'file' => 'image',
            ]);

            if ($validator->fails()) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = $validator->errors()->first();
                return response()->json($this->response, $this->status);
            }

            Image::make($file)->save(public_path($dirPath . $filename));
            User::removeUserImage($userId);
            User::whereId($userId)->update([
                'avatar' => json_encode([
                    'fileName' => $filename,
                    'path' => $dirPath,
                    'url' => getDomainName() . '/' . $dirPath . $filename,
                    'mimeType' => 'png'
                ])
            ]);
        }
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'account has been updated.';
        $this->response['data']['user'] = User::find($user->id);

        return response()->json($this->response, $this->status);
    }

    /**
     * @Description Update profile image
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @Author Khuram Qadeer.
     */
    public function updateProfileImage(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'file' => 'required|image',
        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, $this->status);
        }

        $userId = $request->user()->id;
        $dirPath = 'basic/images/uploads/';
        $filename = Str::random(40) . '.png';
        $file = $request->file;

        if ($file) {
            Image::make($file)->save(public_path($dirPath . $filename));
        }
        if (User::whereId($userId)->exists()) {
            if ($file) {
                User::removeUserImage($userId);
                User::whereId($userId)->update([
                    'avatar' => json_encode([
                        'fileName' => $filename,
                        'path' => $dirPath,
                        'url' => getDomainName() . '/' . $dirPath . $filename,
                        'mimeType' => 'png'
                    ])
                ]);
            }
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'profile image updated.';
            $this->response['data']['user'] = User::find($userId);
        }
        return response()->json($this->response, $this->status);
    }
    /**
     * @Description Update Professional Information of user account
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @Author Khuram Qadeer.
     */
    public function updateProfessionalInfo(Request $request)
    {
        $user = $request->user();
        $userId = $user->id;

        $validator = \Validator::make($request->all(), [
            'tag_line' => 'required',
            'about' => 'required|max:2450',
            'selected_activities' => 'required',
            'selected_languages' => 'required'
        ]);

//        transporter and guide
        if (($user->role_id == 8 || $user->role_id == 4)) {
            $validator = \Validator::make($request->all(), [
                'hourly_rate' => 'required',
            ]);
        }
//        transporter
        if ($user->role_id == 8) {
            $validator = \Validator::make($request->all(), [
                'per_day_rate' => 'required',
            ]);
        }
//        Trip Visa Consultant
        if ($user->role_id == 6) {
            $validator = \Validator::make($request->all(), [
                'selected_countries' => 'required',
            ]);
        }

//        guide
        if ($user->role_id == 4) {
            $validator = \Validator::make($request->all(), [
                'selected_knowledge_cities' => 'required',
            ], [
                'selected_knowledge_cities.required' => 'Please, Select knowledge of cities.'
            ]);
        }

        // photographer and movie maker
        if ($user->role_id == 5 || $user->role_id == 9) {
            $validator = \Validator::make($request->all(), [
                'selected_skills' => 'required',
                'selected_types' => 'required',
                'selected_knowledge_cities' => 'required',
            ], [
                'selected_knowledge_cities.required' => 'Please, Select knowledge of cities.'
            ]);
        }

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, $this->status);
        }

        $tag_line = $request->tag_line;
        $about = $request->about;
        $selected_activities = $request->selected_activities;
        $selected_languages = $request->selected_languages;
        $selected_skills = $request->selected_skills;
        $selected_types = $request->selected_types;
        $selected_countries = $request->selected_countries;
        $selected_knowledge_cities = $request->selected_knowledge_cities;

//        selected Activities
        if ($selected_activities) {
            foreach ($selected_activities as $i => $selectedActivity) {
                if ($i == 0) {
                    ActivityLink::where([['ref_id', $userId], ['type', 'users']])->delete();
                }
                if (!ActivityLink::where([['ref_id', $userId], ['activity_id', (int)$selectedActivity['id']]])->exists()) {
                    ActivityLink::create([
                        'active' => 1,
                        'type' => 'users',
                        'ref_id' => $userId,
                        'activity_id' => (int)$selectedActivity['id']
                    ]);
                }
            }
        }
//        selected Languages
        if ($selected_languages) {
            foreach ($selected_languages as $i => $selectedLanguage) {
                if ($i == 0) {
                    UserLanguage::where([['user_id', $userId]])->delete();
                }
                if (!UserLanguage::where([['user_id', $userId], ['language_id', (int)$selectedLanguage['id']]])->exists()) {
                    UserLanguage::create([
                        'active' => 1,
                        'user_id' => $userId,
                        'ref_type' => 'users',
                        'language_id' => (int)$selectedLanguage['id']
                    ]);
                }
            }
        }

        // skills and type for photographer and movie maker
        if ($user->role_id == 5 || $user->role_id == 9) {
            PhotographerSkillLink::deleteByUserId($userId);
            if ($selected_skills) {
                foreach ($selected_skills as $selectedSkill) {
                    PhotographerSkillLink::create([
                        'active' => 1,
                        'user_id' => $userId,
                        'skill_id' => (int)$selectedSkill['id']
                    ]);
                }
            }
            PhotographerTypeLink::deleteByUserId($userId);
            if ($selected_types) {
                foreach ($selected_types as $selectedType) {
                    PhotographerTypeLink::create([
                        'active' => 1,
                        'user_id' => $userId,
                        'type_id' => (int)$selectedType['id']
                    ]);
                }
            }

//            Knowledge of city
            KnowledgeCity::deleteByUserId($userId);
            if ($selected_knowledge_cities) {
                foreach ($selected_knowledge_cities as $selectKnowledgeCity) {
                    KnowledgeCity::create([
                        'user_id' => $userId,
                        'city_id' => (int)$selectKnowledgeCity['id'],
                    ]);
                }
            }


        }
        // Visa consultancy service for countries
        if ($user->role_id == 6) {
            UserCountry::deleteByUserId($userId);
            if ($selected_countries) {
                foreach ($selected_countries as $selectedCountry) {
                    UserCountry::create([
                        'user_id' => $userId,
                        'country_id' => (int)$selectedCountry['id'],
                        'ref_type' => 'visa_consultant',
                    ]);
                }
            }
        }

        User::whereId($userId)->update([
            'about' => $about,
            'tag_line' => $tag_line,
            'per_day_rate' => $request->per_day_rate ? (int)$request->per_day_rate : 0,
            'hourly_rate' => $request->hourly_rate ? (int)$request->hourly_rate : 0,
//            'currency_id' => $request->currency_id ? (int)$request->currency_id : 0,
        ]);

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Record has been updated.';
        $this->response['data']['user'] = User::find($userId);

        return response($this->response, $this->status);
    }

    /**
     * @Description Update User Roles
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @Author Khuram Qadeer.
     */
    public function updateUserRole(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'role_id' => 'required',
        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, $this->status);
        }

        // update role of
        User::whereId($request->user()->id)->update([
            'role_id' => $request->role_id,
            'role_status' => 1,
            'is_host' => 0
        ]);

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'user role has been updated.';
        $this->response['data']['user'] = User::find($request->user()->id);
        return response()->json($this->response, $this->status);
    }

}
