<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Carbon\Carbon;

class Experience extends Model implements Auditable
{
    use HasFactory;

    protected $with = ['ratings', 'ratings_types', 'rating_values', 'singleImage', 'policies'];
    protected $withCount = ['ratings', 'rating_values', 'reservation', 'visitors'];
    use \OwenIt\Auditing\Auditable;
    const MESSAGE = 'Experience Service Booked Successfully';
    const TYPE = 'BOOKING';
    const ACTION = 'send/experience/notification';
    const STATUS = 'SENT';
    const TITLE = 'Experience Reservation';


    protected $casts = [
      'is_offer_promotion_discount' => 'integer',
      'payment_mode' => 'integer',
      'payment_partial_value' => 'integer'
    ];

    public function setPaymentModeAttribute($value){
      $this->attributes['payment_mode'] = ($value == 0) ? 2 : $value;
    }
    public function getPaymentModeAttribute($value){
       return ($value == 0) ? 2 : $value;
    }
    
    public function images()
    {
        return $this->hasMany(Image::class, 'module_id', 'id')->where('module', 'experiences')->orderBy('type','ASC');
        //->select(['name','type','module'])  check why not working soon
    }
    public function getIsOfferPromotionDiscount($value)
    {
      return (int)$value;
    }
    public function singleImage()
    {
        return $this->hasOne(Image::class, 'module_id', 'id')->where('type', 'main')->where('module', 'experiences');
    }

    public function two_images()
    {
        return $this->hasMany(Image::class, 'module_id', 'id')->where('module', 'experiences')->where('type', '!=', 'main');
        // ->take(3);
    }
    public function mainImage()
    {
        return $this->hasOne(Image::class, 'module_id', 'id')->where('module', 'experiences')->where('type', 'main');
    }

    public function slots()
    {
        return $this->hasMany(Slot::class, 'experience_id', 'id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'package_id', 'id')->where('module_name', 'experiences');
    }

    public function rules()
    {
        return $this->hasMany(Rule::class, 'module_id', 'id')->where('module_name', 'experiences');
    }
    public function exp_videos()
    {
        return $this->hasMany(PackageVideo::class, 'package_id', 'id')->where('module', 'experiences');
        //->select(['name','type','module'])  check why not working soon
    }

    public function ratings_types(){
        return $this->belongsTo(RatingsTypes::class, 'module_name', 'module_name');
    }

    public function rating_values(){

        $date_plug_14 = date_create(date('Y-m-d', strtotime('-14 days')))->format('Y-m-d');
        return $this->hasMany(RatingValues::class, 'package_id','id')->where('module_name', 'experiences')
                ->where(function($q) use ($date_plug_14){
                     $q->whereHas('vendor_ratings');
                     $q->orWhereDate('date_to', '<=', Carbon::create($date_plug_14));

                 })
                ->orderBy('created_at', 'DESC');
    }
    
    public function trips_vendor_ratings(){

        $date_plug_14 = date_create(date('Y-m-d', strtotime('-14 days')))->format('Y-m-d');
        return $this->hasMany(VendorRating::class, 'package_id','id')->where('module_name', 'experiences')
                ->where(function($q) use ($date_plug_14){
                     $q->whereHas('rating_values');
                     $q->orWhereDate('date_to', '<=', Carbon::create($date_plug_14));
                 })
                ->orderBy('created_at', 'DESC');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id','id');
    }
    public function policies()
    {
        return $this->hasMany(CancellationPolicy::class, 'bookable_id', 'id')->where('bookable', self::class);
    }

    public function reservation()
    {
        return $this->hasMany(Reservation::class, 'bookable_id', 'id')->where('bookable', self::class);
    }

    // visitor 
    public function visitors(){
      return $this->belongsTo(Visitor::class,'id', 'package_id')->where('module_name', 'experiences');
    }
}
