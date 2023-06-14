<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Carbon\Carbon;


class Meal extends Model implements Auditable
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'status', 'active', 'user_module_type', 'module_name', 'is_offer_promotion_discount', 'promotion_discount'];
    use \OwenIt\Auditing\Auditable;
    const MESSAGE = 'Meal Service Booked Successfully';
    const TYPE = 'BOOKING';
    const ACTION = 'send/meal/notification';
    const STATUS = 'SENT';
    const TITLE = 'Meal Reservation';

    protected $with = ['ratings_types', 'rating_values', 'singleImage', 'policies'];
    protected $withCount = ['ratings', 'rating_values', 'reservation', 'visitors'];

    // public function newQuery()
    // {
    //     $query = parent::newQuery();

    //     return $query->orderBy('id', 'DESC');
    // }

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
    

    public function getIsOfferPromotionDiscount($value)
    {
      return (int)$value;
    }

    /**
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public static function getAll()
    {
        return self::where('active', 1)->orderBy('id', 'ASC')->get();
    }

    /**
     * @Description  Get By name $meal
     *
     * @param $name
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function getByName($name)
    {
        return self::where('name', $name)->first();
    }

    /**
     * @Description Get meals By user id and ref id and ref type;
     *
     * @param $userId
     * @param $refId
     * @param $refType
     * @return array
     *
     * @Author Khuram Qadeer.
     */
    public static function getMealsByRef($userId, $refId, $refType)
    {
        $meals = [];
        $mealsLinks = MealLink::where([['user_id', $userId], ['ref_id', $refId], ['ref_type', $refType]])->get();
        if ($mealsLinks) {
            foreach ($mealsLinks as $mealsLink) {
                $meal = Meal::find($mealsLink->meal_id);
                if ($meal) {
                    array_push($meals, $meal);
                }
            }
        }
        return $meals;
    }
    public function images()
    {
        return $this->hasMany(Image::class, 'module_id', 'id')->where('module', 'meals')->orderBy('type','ASC');
        //->select(['name','type','module'])  check why not working soon
    }
    public function singleImage()
    {
        return $this->hasOne(Image::class, 'module_id', 'id')->where('type', 'main')->where('module', 'meals');
    }
    public function meal_ingrediant()
    {
        return $this->hasMany(MealIngridiant::class, 'meal_id', 'id');
    }
    public function two_images()
    {
        return $this->hasMany(Image::class, 'module_id', 'id')->where('module', 'meals')->where('type', '!=', 'main');
        // ->take(3);
    }
    public function mainImage()
    {
        return $this->hasOne(Image::class, 'module_id', 'id')->where('module', 'meals')->where('type', 'main');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'package_id', 'id')->where('ratings.module_name', 'meals');
    }

    public function rules()
    {
        return $this->hasMany(Rule::class, 'module_id', 'id')->where('module_name', 'meals');
    }

    public function ratings_types(){
        return $this->belongsTo(RatingsTypes::class, 'module_name', 'module_name');
    }

    public function rating_values(){

        $date_plug_14 = date_create(date('Y-m-d', strtotime('-14 days')))->format('Y-m-d');
        return $this->hasMany(RatingValues::class, 'package_id','id')->whereIn('module_name', ['meals','home_cheff', 'restaurants'])
            ->where(function($q) use ($date_plug_14){
                 $q->whereHas('vendor_ratings');
                 $q->orWhereDate('date_to', '<=', Carbon::create($date_plug_14));

             })
            ->orderBy('created_at', 'DESC');
    }
    public function trips_vendor_ratings(){

        $date_plug_14 = date_create(date('Y-m-d', strtotime('-14 days')))->format('Y-m-d');
        return $this->hasMany(VendorRating::class, 'package_id','id')->whereIn('module_name', ['meals','home_cheff', 'restaurants'])
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
        return $this->hasMany(PackageVideo::class, 'package_id', 'id')->where('module', 'meals');

    }
    public function reservation()
    {
        return $this->hasMany(Reservation::class, 'bookable_id', 'id')->where('bookable', self::class);
    }

    // visitor 
    public function visitors(){
      return $this->belongsTo(Visitor::class,'id', 'package_id')->whereIn('module_name', ['meals','home_cheff', 'restaurants']);
    }
}
