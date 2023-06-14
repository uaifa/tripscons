<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccommodationBookingDetail extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'accommodations_booking_detail';
}
