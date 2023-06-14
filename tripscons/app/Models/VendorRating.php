<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorRating extends Model
{
    use HasFactory;



    protected $table = 'vendor_ratings';
    protected $primaryKey = 'id';

    protected $with = ['users'];
    // protected $withCount = ['rating_values'];


    protected $fillable = [
            'rating_value',
            'module_name',
            'user_id',
            'comments',
            'bookable',
            'bookable_id',
            'booking_id',
            'status',
            'vendor_id',
            'package_id',
            'provider_id',
            'type',
            'rating_type',
            'package_name',
            'rated_by_name',
            'date_to',
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'rating_value' => 'float'
    ];

    public function users(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function rating_values(){
        return $this->hasOne(RatingValues::class, 'booking_id', 'booking_id');
    }

}
