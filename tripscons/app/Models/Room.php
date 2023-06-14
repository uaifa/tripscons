<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory;
    public function facilities(){
        return $this->hasMany(FacilityAccommodation::class,'room_id', 'id')->where('facilityType','Room');
        }
        public function images()
        {
            return $this->hasMany(Image::class, 'module_id', 'id')->where('module', 'accommodationrooms');
            //->select(['name','type','module'])  check why not working soon
        }
        public function singleImage()
        {
            return $this->hasOne(Image::class, 'module_id', 'id')->where('module', 'accommodationrooms');
        }
        protected $fillable = [


            'title',
            'room_type',
            'group_discount',
            'room_facilities',
            'qty',
            'price',
            'extra_guest_price',
            'guest_limit',
            'staying_capacity',
            'description',
            'is_attach_bath',
            'accommodation_id',
            'bed_types',
            'room_size',
            'no_of_beds',
        ];

    const MESSAGE = 'Room Service Booked Successfully';
    const TYPE = 'BOOKING';
    const ACTION = 'send/room/notification';
    const STATUS = 'SENT';
    const TITLE = 'Room Reservation';
}
