<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacilityLink extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'facility_id', 'ref_id', 'ref_type', 'status', 'active'];

    /**
     * @Description Delete Record
     *
     * @param $userId
     * @param $refId
     * @param $refType
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function deleteByRef($userId, $refId, $refType)
    {
        return self::where([['user_id', $userId], ['ref_id', $refId], ['ref_type', $refType]])->delete();
    }
}
