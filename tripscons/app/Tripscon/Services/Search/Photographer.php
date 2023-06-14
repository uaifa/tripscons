<?php


namespace App\Tripscon\Services\Search;


use App\Tripscon\Interfaces\iSearch;
use App\Models\User;
use Illuminate\Http\Request;

class Photographer implements iSearch
{

    /**
     * @Description Search
     *
     * @param Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function find(Request $request)
    {
        $res = $userIds = [];
        $request = json_decode($request->findForm);

        $country = $request->country ?? null;
        $state = $request->state ?? null;
        $city = $request->city ?? null;
        $lat = round($request->lat, 8);
        $long = round($request->long, 8);
        $photographerOptions = $request->photographerOptions;
        $gender = $photographerOptions->gender;

        $query = User::whereRole_id(5);
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
        $res = $query->get();
        return view('basic.guides.search', [
            'users' => $res,
            'type' => 'photographer',
            'country' => $country,
        ]);
    }
}
