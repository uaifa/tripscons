<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Guide extends Model
{
    use HasFactory;

    const MESSAGE = 'Guide Service Booked Successfully';
    const TYPE = 'BOOKING';
    const ACTION = 'send/guide/notification';
    const STATUS = 'SENT';
    const TITLE = 'Guide Reservation';

    protected $table = 'guides';
    protected $primaryKey = 'id';
    protected $fillable = [

            'user_id',
            'title',
            'about',
            'price',
            'created_at',
            'updated_at',
            'status',
            'country',
            'city',
            'rating',
            'no_of_reviews',
            'terms_rule',
            'cancellation_policy',
            'payment_terms',
            'things_to_know',
            'skills',
            'languages',
            'expert',
            'location',
            'lng',
            'lat',
            'is_free_guide',
            'price_per_hour_rate',
            'price_per_day_rate',
            'user_module_type',
            'start_date',
            'end_date',
            'duration',
            'package_type',
            'estimated_no_days',
            'is_copy_document',
            'document_note',
            'no_copies',
            'documents_filled_by_applicant',
            'location_to',
            'country_to',
            'city_to',
            'latitude_to',
            'longitude_to',
            'number_of_days',
            'is_day_wise_trip',
            'child_discount',
            'movie_making_equipment',
            'video_length_minutes',
            'no_of_videos',
            'no_of_days',
            'video_quality',
            'coverage_hours',
            'trip_category',
            'no_of_photography',
            'resolution',
            'photo_size',
            'final_collection_usb',
            'photo_book',
            'is_published',
            'payment_mode',
            'payment_partial_value',
            'photographer_equipment',
            'is_offer_promotion_discount',
            'promotion_discount',
            'detail_location',
            'latitude_detail_location',
            'longitude_detail_location',
    ];

    public $with = ['policies', 'images', 'destination', 'activities', 'services', 'rules', 'package_facilities', 'package_itinerary', 'tripsProperties', 'packageVideos', 'packagesCoveredEvents', 'ratings', 'ratingsProfile', 'singleImage', 'documents', 'package_facilities_excluded', 'guide_user', 'ratings_types', 'rating_values', 'cancellation_policy'];

    protected $withCount = ['ratings', 'ratingsProfile', 'rating_values', 'reservation', 'visitors'];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'start_date' => 'date:d-m-Y',
        // 'end_date'  => 'date:d-m-Y',
        'is_day_wise_trip' => 'integer',
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


    public function getIsOfferPromotionDiscount($value)
    {
        return (int)$value;
    }

    public function getTitleAttribute($value)
    {
        return $value != null ? $value : '';
    }
    public function getLocationAttribute($value)
    {
        return $value != null ? $value : '';
    }
    public function getLocationToAttribute($value)
    {
        return $value != null ? $value : '';
    }
    public function getDocumentsFilledByApplicantAttribute($value)
    {
        return $value != null ? $value : '';
    }

    public function images(){
        return $this->hasMany(Image::class,'module_id', 'id')->where('module','guides')->where('type','<>','document')->orderBy('type', 'ASC');
    }
    public function documents(){
        return $this->hasMany(Image::class,'module_id', 'id')->whereIn('module',['guides','movie_makers','trips','visa_consultants','photographers','trip_mates','trip_operators','travel_agency'])->where('type','document');
    }
    public function singleImage(){
       return $this->hasOne(Image::class,'module_id', 'id')->where('module','guides')->where('type','main');
    }
    public function guide_user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function destination(){
        return $this->hasMany(GuideDestination::class,'guide_id', 'id');
    }
    public function activities(){
        return $this->hasMany(GuideActivity::class,'guide_id', 'id')->where('type', 'activities');
    }
    public function services(){
        return $this->hasMany(GuideActivity::class,'guide_id', 'id')->where('type', 'services');
    }

    public function scopeGuideByUsers($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }
    public function rules(){
        return $this->hasMany(Rule::class, 'module_id', 'id')->where('module_name','guides');
    }

    public function package_facilities(){
        return $this->hasMany(PackageFacility::class, 'package_id', 'id');
    }
    public function package_facilities_excluded(){
        return $this->hasOne(PackageFacility::class, 'package_id', 'id')->where('type', 'excluded');
    }

    public function package_itinerary(){
        return $this->hasMany(PackageItinerary::class, 'package_id', 'id')->orderBy('package_itinerary.date', 'ASC');
    }

    public function tripsProperties(){
        return $this->hasOne(TripsProperty::class, 'package_id');
    }
    public function packageVideos(){
        return $this->hasMany(PackageVideo::class, 'package_id', 'id')->whereNotIn('module', ['experiences', 'accommodations', 'meals', 'transports']);
    }

    public function packagesCoveredEvents(){
        return $this->hasMany(PackagesCoveredEvents::class, 'package_id', 'id');
    }

    public function ratings(){
      return $this->hasMany(Rating::class, 'package_id', 'id')->whereIn('module_name', ['guides','movie_makers','trips','visa_consultants','photographers','trip_mates','trip_operators']);
   }

   public function ratingsProfile(){
      return $this->hasMany(Rating::class, 'package_id', 'id')->where('module_name', 'guideprofile');
   }

    public function ratings_types(){
        return $this->belongsTo(RatingsTypes::class, 'user_module_type', 'module_name');
    }

    public function rating_values(){

        $date_plug_14 = date_create(date('Y-m-d', strtotime('-14 days')))->format('Y-m-d');

        return $this->hasMany(RatingValues::class, 'package_id','id')->whereIn('module_name', ['guides','movie_makers','trips','visa_consultants','photographers','trip_mates','trip_operators','travel_agency','user_profile'])

            ->where(function($q) use ($date_plug_14){
                $q->whereHas('vendor_ratings');
                $q->orWhereDate('date_to', '<=', Carbon::create($date_plug_14));
            })->orderBy('created_at', 'DESC');
    }

    public function trips_vendor_ratings(){

        $date_plug_14 = date_create(date('Y-m-d', strtotime('-14 days')))->format('Y-m-d');

        return $this->hasMany(VendorRating::class, 'package_id','id')->whereIn('module_name', ['guides','movie_makers','trips','visa_consultants','photographers','trip_mates','trip_operators','travel_agency','user_profile'])

            ->where(function($q) use ($date_plug_14){
                $q->whereHas('rating_values');
                $q->orWhereDate('date_to', '<=', Carbon::create($date_plug_14));

            })
            ->orderBy('created_at', 'DESC');
    }

    public function cancellation_policy(){
        $model = "App\\Models\\Guide";
        return $this->belongsTo('App\Models\CancellationPolicy','id','bookable_id')->where('bookable', self::class);
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
      return $this->belongsTo(Visitor::class,'id', 'package_id')->where('module_name', 'guides');
    }
}



