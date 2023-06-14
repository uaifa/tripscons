<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * @var string
     */
    protected $table = 'cities';

    protected $casts = [
        'options' => 'array'
    ];

    /**
     * @Description Get Cities By state id
     *
     * @param $stateId
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function getCities($stateId)
    {
        $res = '';
        if ($stateId) {
            $res = self::whereState_id($stateId)->orderBy('name', 'ASC')->get();
        }
        return $res;
    }

    /**
     * @Description Get By City Name
     *
     * @param $name
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function getByName($name)
    {
        return self::whereName($name)->first();
    }

    /**
     * @Description Get Cities of user country
     * @param $userId
     * @return array
     * @Author Khuram Qadeer.
     */
    public static function getCitiesOfUserCountry($userId)
    {
        $res = [];
        $user = User::find($userId);
        if ($user) {
            if ($user->country_id) {
                $states = State::getStates($user->country_id);
                if ($states) {
                    foreach ($states as $state) {
                        $cities = City::getCities($state->id);
                        if ($cities) {
                            foreach ($cities as $city) {
                                array_push($res, $city);
                            }
                        }
                    }
                }
            }
        }
        return $res;
    }
}
