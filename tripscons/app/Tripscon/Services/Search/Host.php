<?php


namespace App\Tripscon\Services\Search;


use App\Tripscon\Interfaces\iSearch;
use App\Models\User;
use App\Models\UserAccommodation;
use App\Models\UserMeal;
use App\Models\UserTransport;
use Illuminate\Http\Request;

class Host implements iSearch
{

    /**
     * @inheritDoc
     */
    public function find(Request $request)
    {

        $searchedUsers = [];
        $request = json_decode($request->findForm);
        $country = $request->country ?? null;
        $state = $request->state ?? null;
        $city = $request->city ?? null;
        $lat = round($request->lat, 8);
        $long = round($request->long, 8);
        $hostOptions = $request->hostOptions;
        $gender = $hostOptions->gender;
        $selectedServices = $hostOptions->selectServices;

        $query = User::where('is_host', 1)->get();
        if ($country) {
            $query =  collect($query)->where('country','=', $country);
        }
        if ($state) {
            $query =  collect($query)->where('state','=', $state);
        }
        if ($city) {
            $query =  collect($query)->where('city','=', $city);
        }
        if ($gender && $gender != 'no') {
            $query =  collect($query)->where('gender','=', $gender);
        }
//print_r($query);exit;
        $userGenderCountryFiltered = $query;

        if ($userGenderCountryFiltered) {
            foreach ($userGenderCountryFiltered as $countryGenderFilterUser) {
                if ($selectedServices) {
                    foreach ($selectedServices as $selectedService) {
                        if (!in_array($countryGenderFilterUser, $searchedUsers)) {
                            if ($selectedService->name == 'Accommodation') {//echo $city;exit;
                                if (UserAccommodation::whereUser_id($countryGenderFilterUser->id)->exists()) {
                                    if (UserAccommodation::locationExistInAccommodation($countryGenderFilterUser->id,$city)){
                                        array_push($searchedUsers, $countryGenderFilterUser);
                                    }
                                }
                            } elseif ($selectedService->name == 'Meal') {
                                if (UserMeal::whereUser_id($countryGenderFilterUser->id)->exists()) {
                                    array_push($searchedUsers, $countryGenderFilterUser);
                                }
                            } elseif ($selectedService->name == 'Transport') {
                                if (UserTransport::whereUser_id($countryGenderFilterUser->id)->exists()) {
                                    array_push($searchedUsers, $countryGenderFilterUser);
                                }
                            }
                        }
                    }
                }
            }
        }

        return view('basic.guides.search', [
            'users' => $searchedUsers,
            'type' => 'host',
            'country' => $country,
        ]);

    }
}
