<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienceBookingDetail extends Model
{
    use HasFactory;
    public function Slot(){
        return $this->hasOne(Slot::class,'id', 'slot_id');      
    }
    
}

