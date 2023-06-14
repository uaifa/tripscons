<?php


namespace App\Tripscon\Services\Search;


use App\Models\Activity;
use App\Models\PlannedTrip;
use App\Tripscon\Interfaces\iSearch;
use App\Models\User;
use Illuminate\Http\Request;

class Mate implements iSearch
{

    /**
     * @Description Searching of Traveller and Mates
     * @inheritDoc
     * @Author Khuram Qadeer.
     */
    public function find(Request $request)
    {
        $searchedUsers = $userIds = [];
        $request = json_decode($request->findForm);

        $country = $request->country ?? null;
        $state = $request->state ?? null;
        $city = $request->city ?? null;
        $lat = round($request->lat, 8);
        $long = round($request->long, 8);
        $mateOptions = $request->guideOptions;
        $gender = $mateOptions->gender;

        $query = User::whereIs_mate(1);
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

        $genderWiseUsers = $query->get();
        if ($genderWiseUsers) {
            $plannedUsers = [];
            foreach ($genderWiseUsers as $genderWiseUser) {
                $plannedTrips = PlannedTrip::getByUserId($genderWiseUser->id);
                if ($plannedTrips) {
                    foreach ($plannedTrips as $plannedTrip) {
                        if (strcasecmp($plannedTrip->city, $city) == 0 && !in_array($genderWiseUser, $plannedUsers)) {
                            array_push($plannedUsers, $genderWiseUser);
                        }
                    }
                }
            }
            $searchedUsers = $plannedUsers;
        }

        return view('basic.guides.search', [
            'users' => $searchedUsers,
            'type' => 'mate',
            'country' => $country,
        ]);
    }
}
