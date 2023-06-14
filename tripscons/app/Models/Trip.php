<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    
    public function images(){
        return $this->hasMany(Image::class,'module_id', 'id')->where('module','trip');;
        //->select(['name','type','module'])  check why not working soon
        }
        public function singleImage(){
           return $this->hasOne(Image::class,'module_id', 'id')->where('module','trip');      
        }
       public function trip_facility_included(){
       return $this->hasMany(TripFacility::class,'trip_id', 'id')->where('is_included','1');
       }
       public function trip_facility_excluded(){
        return $this->hasMany(TripFacility::class,'trip_id', 'id')->where('is_included','0');
        }
       public function trip_activity(){
        return $this->hasMany(TripActivity::class,'trip_id', 'id');
        }
        public function trip_itinerary(){
            return $this->hasMany(TripItinerary::class,'trip_id', 'id');
            }

            public function trip_activity_four(){
                return $this->hasMany(TripActivity::class,'trip_id', 'id')->take(4);
                }
        
}
