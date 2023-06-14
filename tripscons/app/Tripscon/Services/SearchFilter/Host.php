<?php


namespace App\Tripscon\Services\SearchFilter;


use App\ActivityLink;
use App\Tripscon\Interfaces\iSearchFilter;
use App\Models\User;
use App\Models\UserAccommodation;
use App\Models\UserLanguage;
use App\Models\UserMeal;
use App\Models\UserTransport;
use Illuminate\Http\Request;

class Host implements iSearchFilter
{

    /**
     * @Description Search Filter
     * @param Request $request
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public function filter(Request $request)
    {
        $users = $filteredUsers = [];
        $gender = $request->gender;
        $selectedServices = $request->hostServices;

        $hosts = User::where('is_host', 1)->get();
        // Gender Filter
        if ($hosts && ($gender == 'male' || $gender == 'female')) {
            foreach ($hosts as $host) {
                if ($host->gender == $gender) {
                    array_push($filteredUsers, $host);
                }
            }
        } elseif ($hosts && $gender == 'no') {
            $filteredUsers = $hosts;
        }
        // Activities Filter
        $selectedActivities = $request->selectedActivities;
        if ($selectedActivities && $filteredUsers) {
            $activityWiseUsers = [];
            foreach ($filteredUsers as $filteredUser) {
                foreach ($selectedActivities as $selectedActivity) {
                    if (!in_array($filteredUser, $activityWiseUsers)) {
                        if (ActivityLink::where([['ref_id', $filteredUser->id], ['type', 'users'], ['activity_id', $selectedActivity['id']]])->exists()) {
                            array_push($activityWiseUsers, $filteredUser);
                        }
                    }
                }
            }
            $filteredUsers = $activityWiseUsers;
        }
        // Language Filter
        $selectedLanguages = $request->selectedLanguages;
        if ($selectedLanguages && $filteredUsers){
            $languageWiseFilter = [];
            foreach ($filteredUsers as $filteredUser) {
                foreach ($selectedLanguages as $selectedLanguage) {
                    if (!in_array($filteredUser, $languageWiseFilter)) {
                        if (UserLanguage::where([['user_id', $filteredUser->id], ['ref_type', 'users'], ['language_id', $selectedLanguage['id']]])->exists()) {
                            array_push($languageWiseFilter, $filteredUser);
                        }
                    }
                }
            }
            $filteredUsers = $languageWiseFilter;
        }
        // Host Services Filter
        if ($filteredUsers) {
            foreach ($filteredUsers as $countryGenderFilterUser) {
                if ($selectedServices['accommodation'] == 1 || $selectedServices['meal'] == 1 || $selectedServices['transport'] == 1) {
                    if ($selectedServices['accommodation'] == 1) {
                        if (UserAccommodation::whereUser_id($countryGenderFilterUser->id)->exists()) {
                            if (!in_array($countryGenderFilterUser, $users)) {
                                array_push($users, $countryGenderFilterUser);
                            }
                        }
                    }
                    if ($selectedServices['meal'] == 1) {
                        if (UserMeal::whereUser_id($countryGenderFilterUser->id)->exists()) {
                            if (!in_array($countryGenderFilterUser, $users)) {
                                array_push($users, $countryGenderFilterUser);
                            }
                        }
                    }
                    if ($selectedServices['transport'] == 1) {
                        if (UserTransport::whereUser_id($countryGenderFilterUser->id)->exists()) {
                            if (!in_array($countryGenderFilterUser, $users)) {
                                array_push($users, $countryGenderFilterUser);
                            }
                        }
                    }

                } else {
                    $users = $filteredUsers;
                }
            }
        }

        return response()->json(['users' => $users], 200);
    }
}
