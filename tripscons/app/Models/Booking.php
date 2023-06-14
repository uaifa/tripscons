<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{

    //use SoftDeletes;
    use HasFactory;
    // protected $fillable = [
    //    'module_name'
    // ];
    protected $fillable = ["*"];

    protected $with = ['ratings', 'Guide', 'User', 'Provider', 'ratings_types', 'rating_values'];

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function Provider()
    {
        return $this->hasOne(User::class, 'id', 'provider_id');
    }

    public function Accommodation()
    {
        // if($this->attributes['module_name'] == 'accommodations'){
        //   echo 'askakfas';die;
        //     return $this->hasOne(Accommodation::class,'id', 'module_id')->with('singleImage');   
        // }
        // return null; 
        return $this->hasOne(Accommodation::class, 'id', 'module_id')->with('singleImage');
    }
    // public function scopeAccommodation($query)
    // {
    // return $query->where('module_name', '=','accommodations');
    // }
    // public function scopeThat($query)
    // {
    // return $query->where('that', '=', 1);
    //  }
    public function Transport()
    {
        return $this->hasOne(Transport::class, 'id', 'module_id')->with('singleImage');
    }
    public function Invoice()
    {
        return $this->hasOne(Invoice::class, 'booking_id', 'id');
    }
    public function VehicleBookingDetail()
    {

        return $this->hasOne(VehicleBookingDetail::class, 'booking_id', 'id');
        ///$this->hasOne(VehicleBookingDetail::class);
    }
    public function slot()
    {

        return $this->hasOne(Slot::class, 'booking_id', 'id');
        ///$this->hasOne(VehicleBookingDetail::class);
    }
    public function AccommodationBookingDetail()
    {

        return $this->hasOne(AccommodationBookingDetail::class, 'booking_id', 'id');
        ///$this->hasOne(VehicleBookingDetail::class);
    }
    public function MealBookingDetail()
    {
        return $this->hasOne(MealBookingDetail::class, 'booking_id', 'id');
    }
    public function Meal()
    {
        return $this->hasOne(Meal::class, 'id', 'module_id')->with('singleImage');
    }
    public function Experience()
    {
        return $this->hasOne(Experience::class, 'id', 'module_id')->with('singleImage');
    }
    public function ExperienceBookingDetail()
    {

        return $this->hasOne(ExperienceBookingDetail::class, 'booking_id', 'id');
    }
    public function slotBook()
    {
        return $this->hasOne(ExperienceBookingDetail::class, 'booking_id', 'id');
    }
    public function GuideBookingDetail()
    {

        return $this->hasOne(GuideBookingDetail::class, 'booking_id', 'id');
    }
    public function Guide()
    {
        return $this->hasOne(Guide::class, 'id', 'module_id');
    }
    public function rooms()
    {
        return $this->hasMany(RoomBooking::class, 'booking_id', 'id')->with('roomDetail');
    }
    public static function getOrderByRefIdAndRefType($refId, $refType)
    {
        /*
        $res = [];
        $bookings = self::where([['ref_id', $refId], ['type', $refType]])->get();
        if ($orders) {
            foreach ($bookings as $booking) {
                $data = [];
                $data['order'] = $booking;
               // $data['order_items'] = OrderItem::getByOrderId($order->id);
                array_push($res, $data);
            }
        }
        return $res;
        */
    }
    public function ratings()
    {
        return $this->hasOne(Rating::class, 'booking_id');
    }
    public function ratings_types(){
        return $this->belongsTo(RatingsTypes::class, 'module_name', 'module_name');
    }

    public function rating_values(){
        return $this->belongsTo(RatingValues::class, 'id', 'booking_id');
    }
}
