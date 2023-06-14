<?php


namespace App\Tripscon\Services\Search;


use App\Tripscon\Interfaces\iSearch;
use App\Models\User;
use App\Models\UserCountry;
use Illuminate\Http\Request;

class VisaConsultant implements iSearch
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
        $visaConsultantOptions = $request->visaConsultantOptions;
        $selectTypes = $visaConsultantOptions->selectTypes;

        $users = User::where('role_id', 6)->get();
        $countryFilterUsers = [];
        if ($users) {
            foreach ($users as $user) {
                $userData = User::getAllUserData($user->id);
                if ($userData) {
                    $knowledgeCities = $userData['visa_consultant_profile']['knowledge_cities'];
                    if ($knowledgeCities) {
                        foreach ($knowledgeCities as $knowledgeCity) {
                            foreach ($selectTypes as $selectType) {
                                if ($selectType->id == $knowledgeCity->ref_id) {
                                    if (!in_array($user, $countryFilterUsers)) {
                                        array_push($countryFilterUsers, $user);
                                    }
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }

        $res = $countryFilterUsers;

        return view('basic.guides.search', [
            'users' => $res,
            'type' => 'visa_consultant',
            'country' => $country,
        ]);
    }
}
