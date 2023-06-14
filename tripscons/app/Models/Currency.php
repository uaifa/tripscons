<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['code', 'prefix', 'postfix', 'rate', 'is_base'];

    /**
     * @Description Get Currencies
     *
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public static function getAll()
    {
        return self::orderBy('code', 'ASC')->get();
    }
}
