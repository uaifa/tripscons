<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TripMateDestination extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'trip_id',
        'destination',
        'lat',
        'lng',
        'city',
        'country',
        'type',
    
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
        return url('/admin/trip-mate-destinations/'.$this->getKey());
    }
}
