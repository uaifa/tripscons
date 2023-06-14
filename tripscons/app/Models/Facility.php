<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'status', 'active'];

    /**
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public static function getAll()
    {
        return self::where('status', 1)->get();
    }

    /**
     * @Description  Get By name facility
     *
     * @param $name
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function getByName($name)
    {
        return self::where('name', $name)->first();
    }

    /**
     * @Description Get Facilities By user id and ref id and ref type;
     *
     * @param $userId
     * @param $refId
     * @param $refType
     * @return array
     *
     * @Author Khuram Qadeer.
     */
    public static function getFacilitiesByRef($userId, $refId, $refType)
    {
        $facilities = [];
        $facilitiesLinks = FacilityLink::where([['user_id', $userId], ['ref_id', $refId], ['ref_type', $refType]])->get();
        if ($facilitiesLinks) {
            foreach ($facilitiesLinks as $facilitiesLink) {
                $facility = Facility::find($facilitiesLink->facility_id);
                if ($facility) {
                    array_push($facilities, $facility);
                }
            }
        }
        return $facilities;
    }

}
