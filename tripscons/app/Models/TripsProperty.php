<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripsProperty extends Model
{
    use HasFactory;


    protected $table = 'trips_properties';
    protected $primaryKey = 'id';

    protected $with = [];

    protected $fillable = [
            
            'trip_type',
            'group_size',
            'activity_level',
            'suitable_age',
            'group_discount',
            'couple_discount',
            'child_discount',  
            'package_id',
            'group_discount_members',

    ];

}
