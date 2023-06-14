<?php


namespace App\Tripscon\Services\SearchFilter;


use App\Models\ActivityLink;
use App\Tripscon\Interfaces\iSearchFilter;
use App\Models\User;
use App\Models\UserLanguage;
use Illuminate\Http\Request;

class VisaConsultant implements iSearchFilter
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

        $visaConsultants = User::where('role_id', 6)->get();
        // Gender Filter
        if ($visaConsultants && ($gender == 'male' || $gender == 'female')) {
            foreach ($visaConsultants as $visaConsultant) {
                if ($visaConsultant->gender == $gender) {
                    array_push($filteredUsers, $visaConsultant);
                }
            }
        } elseif ($visaConsultants && $gender == 'no') {
            $filteredUsers = $visaConsultants;
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
