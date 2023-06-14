<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TripMateInvitation extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'trip_id',
        'request_user_id',
        'to_user_id',
        'status',
    ];


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/trip-mate-invitations/'.$this->getKey());
    }

    public function trip_mate(){
        return $this->hasOne(TripMate::class, 'id', 'trip_id');
    }

    public function users(){
        return $this->hasOne(User::class, 'id', 'request_user_id');
    }


}
