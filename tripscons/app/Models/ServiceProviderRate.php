<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProviderRate extends Model
{
    use HasFactory;

    protected $table = 'service_provider_rates';
    protected $primaryKey = 'id';

    protected $fillable = [

        'price_per_hour_rate',
        'price_per_day_rate',
        'group_discount',
        'destinations',
        'languages',
        'user_id',
        'start_time',
        'end_time',
        'skills',
        'domestic_trip',
        'international_trip',
        'is_free_service',
        'cuisines',
        'special_diets',
        'meals',
        'restaurant_location',
        'restaurant_name',
        'restaurant_image',
        'experties',
        'payment_mode',
        'payment_partial_value',
        'terms_rule',
        'movie_photo_equipments',
        'number_of_persons', 
        'extra_price_per_person',
        'extra_price_per_hours_per_person',

    ];



    public function getDestinationsAttribute($value)
    {
        return $value != null ? $value : '';
    }
    public function getLanguagesAttribute($value)
    {
        return $value != null ? $value : '';
    }
    public function getCuisinesAttribute($value)
    {
        return $value != null ? $value : '';
    }
    public function getSpecialDietsAttribute($value)
    {
        return $value != null ? $value : '';
    }
    public function getMealsAttribute($value)
    {
        return $value != null ? $value : '';
    }
    public function getRestaurantLocationAttribute($value)
    {
        return $value != null ? $value : '';
    }
    public function getRestaurantNameAttribute($value)
    {
        return $value != null ? $value : '';
    }
    public function getExpertiesAttribute($value)
    {
        return $value != null ? $value : '';
    }
    public function getTermsRuleAttribute($value)
    {
        return $value != null ? $value : '';
    }
    public function getMoviePhotoEquipmentsAttribute($value)
    {
        return $value != null ? $value : '';
    }
    public function getSkillsAttribute($value)
    {
        return $value != null ? $value : '';
    }

    
}
