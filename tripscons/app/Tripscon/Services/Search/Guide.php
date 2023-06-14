<?php


namespace App\Tripscon\Services\Search;


use App\Models\Activity;
use App\Tripscon\Interfaces\iSearch;
use App\Models\User;
use Illuminate\Http\Request;

class Guide implements iSearch
{

    /**
     * @Description Searching Guides
     * @inheritDoc
     * @Author Khuram Qadeer.
     */
    public function find(Request $request)
    {
        $res = $userIds = [];
        $request = json_decode($request->findForm);
        $role_id = 4;
        $country = $request->country ?? null;
        $state = $request->state ?? null;
        $city = $request->city ?? null;
        $lat = round($request->lat, 8);
        $long = round($request->long, 8);
        $guideOptions = $request->guideOptions;
        $gender = $guideOptions->gender;
        $service = $guideOptions->service;
        $selectedActivities = $guideOptions->selectedActivities;
        $query = User::whereRole_id($role_id);
        if ($country) {
            $query->where('country', 'LIKE', "%{$country}%");
        }
        if ($state) {
            $query->where('state', 'LIKE', "%{$state}%");
        }
        if ($city) {
            $query->where('city', 'LIKE', "%{$city}%");
        }
        if ($gender && $gender != 'no') {
            $query->where('gender', $gender);
        }
        $searchedUsers = $query->get();
        if ($searchedUsers) {
            foreach ($searchedUsers as $searchedUser) {
                if ($selectedActivities) {
                    foreach ($selectedActivities as $selectedActivity) {
                        if (Activity::checkUserExistInActivity($searchedUser->id, $selectedActivity->name)) {
                            if (!in_array($searchedUser->id, $userIds)) {
                                array_push($userIds, $searchedUser->id);
                                array_push($res, $searchedUser);
                            }
                        }
                    }
                } else {
                    if (!in_array($searchedUser->id, $userIds)) {
                        array_push($userIds, $searchedUser->id);
                        array_push($res, $searchedUser);
                    }
                }
            }
        }

        return view('basic.guides.search', [
            'users' => $res,
            'type' => 'guide',
            'country' => $country,
        ]);
    }
}
