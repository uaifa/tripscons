<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomBooking extends Model
{
    use HasFactory;
    public function roomDetail()
    {
        return $this->hasOne(Room::class, 'id', 'room_id');
    }
}
