<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityAccommodation extends Model
{
    use HasFactory;
    public function facilityAccommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }
    //for multiple accommodation fetch 
    public function multipleAcc(){
        return $this->hasMany(Accommodation::class,'accommodation_id', 'id');
        
        }
}
