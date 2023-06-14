<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    use HasFactory;
    //use SoftDeletes;
    protected $table = 'users';
    protected $fillable = [
        
        'email', 'status', 'postal_code', 'address', 'additional_address', 'email_verified_at', 'provider_id', 'provider', 'type', 'avatar', 'gender', 'phone', 'phone_verified_at', 'country_id', 'state_id', 'city_id', 'country', 'state', 'city', 'country_short_name', 'state_short_name', 'city_short_name', 'longitude', 'latitude', 'password', 'token', 'about', 'tag_line', 'name', 'role_status', 'role_id', 'username', 'hourly_rate', 'is_host', 'currency_id', 'verified', 'date_of_birth', 'per_day_rate', 'is_mate', 'host_out_of_city', 'api_token', 'phone_code', 'is_company', 'company_profile_id', 'skip_for_now', 'is_profile_complete', 'role_profile_id'
    ];

        public function activity(){
            return $this->hasMany(UserActivity::class,'user_id', 'id');      
         }
}
