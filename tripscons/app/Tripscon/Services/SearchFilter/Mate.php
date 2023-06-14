<?php


namespace App\Tripscon\Services\SearchFilter;


use App\Models\ActivityLink;
use App\Tripscon\Interfaces\iSearchFilter;
use App\Models\User;
use App\Models\UserLanguage;
use Illuminate\Http\Request;

class Mate implements iSearchFilter
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
        $mates = User::where('is_mate', 1)->get();
        // Gender Filter
        if ($mates && ($gender == 'male' || $gender == 'female')) {
            foreach ($mates as $mate) {
                if ($mate->gender == $gender) {
                    array_push($filteredUsers, $mate);
                }
            }
        } elseif ($mates && $gender == 'no') {
            $filteredUsers = $mates;
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

        $users = $filteredUsers;

        return response()->json(['users' => $users], 200);
    }
}
