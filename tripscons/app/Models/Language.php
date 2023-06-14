<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    /**
     * @var array
     * @Author Khuram Qadeer.
     */
    protected $fillable = ['name', 'status', 'active'];

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
