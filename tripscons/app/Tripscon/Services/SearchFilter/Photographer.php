<?php


namespace App\Tripscon\Services\SearchFilter;


use App\Models\ActivityLink;
use App\Models\PhotographerTypeLink;
use App\Tripscon\Interfaces\iSearchFilter;
use App\Models\User;
use App\Models\UserLanguage;
use Illuminate\Http\Request;

class Photographer implements iSearchFilter
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
        $photographers = User::where('role_id', 5)->get();
        // Gender Filter
        if ($photographers && ($gender == 'male' || $gender == 'female')) {
            foreach ($photographers as $photographer) {
                if ($photographer->gender == $gender) {
                    array_push($filteredUsers, $photographer);
                }
            }
        } elseif ($photographers && $gender == 'no') {
            $filteredUsers = $photographers;
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
        if ($selectedLanguages && $filteredUsers) {
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

        // Photography Type Filter
        $selectedPhotographerType = $request->selectedPhotographerType;
        if ($selectedPhotographerType && $filteredUsers) {
            $typeWiseFilter = [];
            foreach ($filteredUsers as $filteredUser) {
                foreach ($selectedPhotographerType as $selectedType) {
                    if (!in_array($filteredUser, $typeWiseFilter)) {
                        if (PhotographerTypeLink::where([['user_id', $filteredUser->id], ['type_id', $selectedType['id']]])->exists()) {
                            array_push($typeWiseFilter, $filteredUser);
                        }
                    }
                }
            }
            $filteredUsers = $typeWiseFilter;
        }
        $users = $filteredUsers;

        return response()->json(['users' => $users], 200);
    }
}
