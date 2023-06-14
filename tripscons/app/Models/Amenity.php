<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{

    /**
     * @Description Get All Amenities
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public static function getAll()
    {
        return self::orderBy('name', 'DESC')->get();
    }
}
