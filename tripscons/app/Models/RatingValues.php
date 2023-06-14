<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingValues extends Model
{
    use HasFactory;



    protected $table = 'rating_values';
    protected $primaryKey = 'id';

    // protected $with = ['users'];

    // protected $withCount = ['vendor_ratings'];


    protected $fillable = [
            'rating_value_1',
            'rating_value_2',
            'rating_value_3',
            'rating_value_4',
            'rating_value_5',
            'average_rating',
            'user_id',
            'package_id',
            'provider_id',
            'booking_id',
            'comments',
            'module_name',
            'status',
            'type',
            'rating_type',
            'date_to',

    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'rating_value_1' => 'float',
        'rating_value_2' => 'float',
        'rating_value_3' => 'float',
        'rating_value_4' => 'float',
        'rating_value_5' => 'float',
        'average_rating' => 'float',
    ];

    public function users(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function ratingTypes(){
        return $this->belongsTo(RatingsTypes::class, 'module_name', 'module_name');
    }
    
    public function vendor_ratings(){
        return $this->hasOne(VendorRating::class, 'booking_id', 'booking_id');
    }
}
