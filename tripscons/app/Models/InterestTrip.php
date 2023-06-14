<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InterestTrip extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'location', 'is_mate', 'mate_gender',
        'description', 'country_id', 'state_id', 'city_id', 'country', 'state', 'city', 'status', 'active',
        'longitude','latitude','category_id','trip_type_id','images'
    ];

    /**
     * @Description Get Interest Trips By Username
     *
     * @param $username
     * @return string
     *
     * @Author Khuram Qadeer.
     */
    public static function getByUsername($username)
    {
        $res = '';
        $user = User::getUserByUsername($username);
        if ($user) {
            $res = self::where([['user_id', $user->id], ['active', 1]])->orderByDESC('id')->get();
        }
        return $res;
    }

    /**
     * @Description Get All Trips
     * @param $userId
     * @return array
     * @Author Khuram Qadeer.
     */
    public static function getAllTripDataByUserId($userId)
    {
        $res = [];
        $trips = self::where([['user_id', $userId], ['active', 1]])->orderByDESC('id')->get();
        if ($trips){
            foreach ($trips as $trip) {
                $data = $trip;
                $data['activities'] = ActivityLink::getByRefIdAndType($trip->id,'trip:interest');
                array_push($res,$data);
            }
        }
        return $res;
    }
}
