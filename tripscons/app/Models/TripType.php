<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripType extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @Description Get By category id
     * @param $categoryId
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public static function getByCategoryId($categoryId)
    {
        return self::where('category_id', $categoryId)->get();
    }
}
