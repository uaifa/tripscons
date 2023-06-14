<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    /**
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function getAll()
    {
        return self::orderBy('name', 'DESC')->get();
    }
}
