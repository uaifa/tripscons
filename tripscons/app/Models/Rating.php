<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;


    protected $table = 'ratings';
    protected $primaryKey = 'id';

    protected $with = ['users'];

    protected $fillable = [

            'location_rating',
            'cleanliness_rating',
            'comfort_rating',
            'quality_rating',  
            'comments',
            'user_id',
            'package_id',
            'provider_id',
            'booking_id',
            'status', //'active', 'inactive') NULL,
            'type', //'profile', 'services') NULL,
            'module_name', //'accommodations', 'guides', 'experiences', 'meals', 'transports', 'guideprofile'
            'average_rating',

    ];

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
