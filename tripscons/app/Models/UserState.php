<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserState extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['ref_id', 'ref_type', 'state_id', 'user_id'];

    /**
     * @Description Delete Record
     *
     * @param $refId
     * @param $refType
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function getDelete($refType, $refId = null)
    {
        $res = null;
        if ($refId == null) {
            $res = self::where([['user_id', Auth::id()], ['ref_type', $refType]])->delete();
        } else if ($refId) {
            $res = self::where([['user_id', Auth::id()], ['ref_id', $refId], ['ref_type', $refType]])->delete();
        }
        return $res;
    }

    /**
     * @Description Get All states of user by reference type
     *
     * @param $userId
     * @param $refType
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function getAll($userId, $refType,$refId=null)
    {
        $res = [];
        if ($refId!=null){
            $statesData =  self::where([['user_id', $userId],['ref_id',$refId], ['ref_type', $refType]])->get();
        }else{
            $statesData = self::where([['user_id', $userId], ['ref_type', $refType]])->get();
        }

        if ($statesData){
            foreach ($statesData as $state) {
                array_push($res,State::find($state->state_id));
            }
        }
        return $res;
    }
}
