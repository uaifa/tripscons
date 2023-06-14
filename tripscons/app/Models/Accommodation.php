<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\Place;
use App\Models\Rule;
use OwenIt\Auditing\Contracts\Auditable;
use Carbon\Carbon;


class Accommodation extends Model implements Auditable
{
   use SoftDeletes;
   use \OwenIt\Auditing\Auditable;
   
   /**
    * @var array
    */
   protected $fillable = [
      'title',
      'no_of_rooms',
      'no_of_people',
      'description',
      'lat',
      'lng',
      'per_night',
      'type_id',
      'type_name',
      'sub_type_id',
      'sub_type_name',
      'min_stay',
      'max_stay',
      'dicount',
      'phone',
      'taxes_fees',
      'location',
      'stars',
      'rating',
      'status'
   ];
   protected $casts = [
      'no_of_rooms' => 'integer',
      'no_of_rooms_created' => 'integer',
      'is_offer_promotion_discount' => 'integer',
      'payment_mode' => 'integer',
      'payment_partial_value' => 'integer'
      ];
    const MESSAGE = 'Accommodation Service Booked Successfully';
    const TYPE = 'BOOKING';
    const ACTION = 'send/accommodation/notification';
    const STATUS = 'SENT';
    const TITLE = 'Accommodation Reservation';
    const TYPE_BOOKING = 'BOOKING';

   protected $with = ['ratings', 'ratings_types', 'rating_values', 'singleImage', 'policies', 'User'];
   protected $withCount = ['ratings', 'rating_values', 'reservation', 'visitors'];

   protected $appends = ['is_bookable'];


   public function setPaymentModeAttribute($value){
      $this->attributes['payment_mode'] = ($value == 0) ? 2 : $value;
   }
   public function getPaymentModeAttribute($value){
       return ($value == 0) ? 2 : $value;
   }

   public function getIsOfferPromotionDiscount($value)
   {
      return (int)$value;
   }
    
   public function images()
   {
      return $this->hasMany(Image::class, 'module_id', 'id')->where('module', 'accommodations')->orderBy('type','ASC');
      //->select(['name','type','module'])  check why not working soon
   }
   public function singleImage()
   {
      return $this->hasOne(Image::class, 'module_id', 'id')->where('type', 'main')->where('module', 'accommodations');
   }
   public function two_images()
   {
      return $this->hasMany(Image::class, 'module_id', 'id')->where('module', 'accommodations')->where('type', '!=', 'main');
      // ->take(3);
   }
   public function mainImage()
   {
      return $this->hasOne(Image::class, 'module_id', 'id')->where('module', 'accommodations')->where('type', 'main');
   }
   public function facility()
   {
      return $this->hasMany(FacilityAccommodation::class, 'accommodation_id', 'id');
   }
   public function User()
   {
      return $this->hasOne(User::class, 'id', 'user_id');
   }

   public function ratings()
   {
      return $this->hasMany(Rating::class, 'package_id', 'id')->where('module_name', 'accommodations');
   }

   public function places()
   {
      return $this->hasMany(Place::class, 'module_id', 'id');
   }
   public function rules()
   {
      return $this->hasMany(Rule::class, 'module_id', 'id')->where('module_name', 'accommodations');
   }

   public function booking()
   {
      return $this->belongsTo(Reservation::class, 'id', 'bookable_id')->where('bookable', self::class);
   }

   public function getIsBookableAttribute()
   {
      if(request()->date_to && request()->date_from){
         $service = new \App\Http\Controllers\Api\HostController();
         if($this->type_id == 2){
            request()->request->add(['accommodation_id' => $this->id]);

            if(count($service->getAvailableRooms(request())->original['data'])) {
               return true;
            }
            else {
               return false;
            }
         }
         else {

            return !Reservation::where('bookable', self::class)
           ->whereDate('date_from', '<=', request()->date_to)
           ->whereDate('date_to', '>=', request()->date_from)
           ->where('status', 7)
           ->where('bookable_id', $this->id)
          ->exists();
         }
      }
   }


   public function ratings_types(){
        return $this->belongsTo(RatingsTypes::class, 'module_name', 'module_name');
    }

    public function rating_values(){

         $date_plug_14 = date_create(date('Y-m-d', strtotime('-14 days')))->format('Y-m-d');

        return $this->hasMany(RatingValues::class, 'package_id','id')->where('module_name', 'accommodations')
         ->where(function($q) use ($date_plug_14){
             $q->whereHas('vendor_ratings');
             $q->orWhereDate('date_to', '<=', Carbon::create($date_plug_14));

         })
         ->orderBy('created_at', 'DESC');
    }

    public function trips_vendor_ratings(){

      $date_plug_14 = date_create(date('Y-m-d', strtotime('-14 days')))->format('Y-m-d');

      return $this->hasMany(VendorRating::class, 'package_id','id')->where('module_name', 'accommodations')
         ->where(function($q) use ($date_plug_14){
             $q->whereHas('rating_values');
             $q->orWhereDate('date_to', '<=', Carbon::create($date_plug_14));

         })
         ->orderBy('created_at', 'DESC');
    }

    public function policies()
    {
        return $this->hasMany(CancellationPolicy::class, 'bookable_id', 'id')->where('bookable', self::class);
    }

    public function videos()
    {
        return $this->hasMany(PackageVideo::class, 'package_id', 'id')->where('module', 'accommodations');
    }
    public function cancellation_policy()
    {
        return $this->hasMany(CancellationPolicy::class, 'bookable_id', 'id')->where('bookable', self::class);
    }

    public function reservation()
    {
        return $this->hasMany(Reservation::class, 'bookable_id', 'id')->where('bookable', self::class);
    }

    // visitor 
    public function visitors(){
      return $this->belongsTo(Visitor::class,'id', 'package_id')->where('module_name', 'accommodations');
    }

}
