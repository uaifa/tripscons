<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripOperator extends Model
{
    use HasFactory;
    public function images(){
        return $this->hasMany(Image::class,'module_id', 'id');
        //->select(['name','type','module'])  check why not working soon
        }
        public function singleImage(){
           return $this->hasOne(Image::class,'module_id', 'id');      
        }
       public function facility(){
       return $this->hasMany(FacilityAccommodation::class,'accommodation_id', 'id');
}
}
