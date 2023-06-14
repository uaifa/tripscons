<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * @var string
     */
    protected $table = 'states';

    /**
     * @Description  Get States by country id
     *
     * @param $countryId
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function getStates($countryId)
    {
        return self::whereCountry_id($countryId)->orderBy('name', 'ASC')->get();
    }

    /**
     * @Description Get By State Name
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
     * @Description Get Logged in user State that user saved country in profile
     *
     * @param $userId
     * @return mixed|string
     *
     * @Author Khuram Qadeer.
     */
    public static function getLoggedInUserStatesOfCountry($userId)
    {
        $res = '';
        $user = User::find($userId);
        if ($user) {
            if ($user->country_id) {
                $res = self::getStates($user->country_id);
            }
        }
        return $res;
    }
}
