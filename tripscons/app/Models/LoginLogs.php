<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLogs extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['api_token', 'device_type'];

    /**
     * @Description Create Record
     * @param $token
     * @param $deviceType
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function createRecord($token, $deviceType)
    {
        return self::create([
            'api_token' => $token,
            'device_type' => $deviceType
        ]);
    }

    /**
     * @Description Delete By token
     * @param $token
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public static function deleteByToken($token)
    {
        return self::where('api_token', $token)->delete();
    }

}
