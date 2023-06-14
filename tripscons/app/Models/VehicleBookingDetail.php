<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleBookingDetail extends Model
{
    use HasFactory;
    protected $table = 'vehiclebookingdetails';
    protected $fillable = [
        'airport_pick_drop_charges',
        'booking_type',
        'module_id',
        'booking_id',

    ];

   
}
