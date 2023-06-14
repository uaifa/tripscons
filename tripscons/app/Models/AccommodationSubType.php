<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccommodationSubType extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'type_id'];

    /**
     * @Description Get All Sub Accommodation sub type
     * @param $typeId
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public static function getByTypeId($typeId)
    {
        return self::where('type_id', $typeId)->get();
    }
}
