<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notifications\PushNotification;
use App\Traits\HostServiceBookingTrait;
use Illuminate\Http\Request;
use App\Models\Accommodation;
use App\Models\Meal;
use App\Models\Image;
use App\Models\Facility;
use App\Models\AccommodationSubType;
use App\Models\FacilityAccommodation;
use App\Models\User;
use App\Models\Activity;
use App\Models\Transport;
use App\Models\Rule;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Booking;
use App\Models\MealBookingDetail;
use DateTime;
use App\Models\Invoice;
use App\Traits\RadiusDistanceTrait;
use App\Models\Experience;

class MealController extends Controller
{
    protected $status = 200;
    protected $response = [];
    use HostServiceBookingTrait;
    use RadiusDistanceTrait;

    public function index(Request $request)
    {


        $proRating =   $request->rating;
        $min =  $request->minValue;
        $max =  $request->maxValue;
        $country = $request->country;
        $city = $request->city;

        $searchTerm = $request->searchTerm;
        $distance_result = '';
        $lat = round($request->lat, 8);
        $lng = round($request->lng, 8);
        $user_module_type = isset($request->user_module_type) ? $request->user_module_type : '';
        $meal_type = isset($request->meal_type) ? $request->meal_type : '';
        $is_free_home_delivery = isset($request->is_free_home_delivery) ? $request->is_free_home_delivery : '';

        $reviewRating = isset($request->reviewRating) ? $request->reviewRating : '';
        $is_free_cancellation = isset($request->is_free_cancellation) ? $request->is_free_cancellation : '';
        $is_free_cancellation_value = isset($request->is_free_cancellation_value) ? $request->is_free_cancellation_value : '';
        $payment_mode = isset($request->payment_mode) ? $request->payment_mode : '';
        $payment_mode_value = isset($request->payment_mode_value) ? $request->payment_mode_value : '';
        $user_id = isset($request->user_id) ? $request->user_id : '';
        $distance_result = '';
        $rad = 1000;
        $lat = 0;
        $lng = 0;
        
            $lat = isset($request->lat) ? round($request->lat, 8) : 0;
            $lng = isset($request->lng) ? round($request->lng, 8) : 0;
            $rad = isset($request->radius) ? (int)$request->radius : 0;

            $rad = floor($rad / 1000);

            $distance_result = 'ROUND(DEGREES(ACOS(SIN(RADIANS('.$lat.')) 
                    * SIN(RADIANS(lat)) 
                    + COS(RADIANS('.$lat.'))  
                    * COS(RADIANS(lat))
                    * COS(RADIANS('.$lng.' - lng)))) * 69.09)';

         $serviceMessage = '';
        if(isset($request->lat) && isset($request->lng) && isset($request->search_by_filter) && $request->search_by_filter == 1){
            $serviceData = Meal::where('is_publish',1)->where('status',1)->where('lat',$lat)->where('lng',$lng)->get();

            if($serviceData->count() < 1){
                $serviceMessage = "This service is currently not available in this area but here are other nearby services";
            }
        }

        if (!empty($request)) {
            $data = Meal::with('images')->withAvg('ratings', 'average_rating')->where('is_publish',1)->where('status',1)->withAvg('rating_values','average_rating')->where(function ($query) use ($proRating, $min, $max, $country, $city, $distance_result, $rad, $searchTerm,$user_module_type,$meal_type,$is_free_home_delivery,$reviewRating,$lat,$lng,$payment_mode,$payment_mode_value,$is_free_cancellation,$is_free_cancellation_value,$user_id) {

                if($user_id){
                    $query->Where('user_id', $user_id);
                }
                if ($min > 0) {
                    $query->Where('price', '>=', $min);
                }
                if ($max > 0) {
                    $query->Where('price', '<=', $max);
                }
                if ($payment_mode == 1 && $payment_mode_value >= 25 ) {

                    $query->Where('payment_mode', $payment_mode);
                    $query->Where('payment_partial_value', $payment_mode_value);
                }
                if ($payment_mode === '0') {

                 $query->Where('payment_mode', $payment_mode);
                }
                if (!empty($user_module_type)) {
                    $query->Where('user_module_type', $user_module_type);
                }
                if (!empty($meal_type)) {
                    $query->Where('meal_type','LIKE', "%{$meal_type}%");
                }
                if (!empty($is_free_home_delivery)) {
                    $query->Where('free_delivery', $is_free_home_delivery);
                }


                if (!empty($searchTerm)) {
                    $query->orWhere('title', 'LIKE', "%{$searchTerm}%")->orWhere('description', 'LIKE', "%{$searchTerm}%")->orWhere('location', 'LIKE', "%{$searchTerm}%")->orWhere('city', 'LIKE', "%{$searchTerm}%");
                }
                })

                ->when(!empty($distance_result), function ($q) use ($distance_result, $rad) {
                    if(!empty($rad)){
                        $q->selectRaw("{$distance_result} AS distance")->whereRaw("{$distance_result} < ?", [$rad])->orderBy('distance');
                    }else{
                        $q->addSelect(\DB::raw($distance_result . " as distance"));
                        $q->orderBy(\DB::raw($distance_result));
                    }
                })
                // ->when(!$lat || !$lng, function ($q)  use ($distance_result) {
                //     $q->addSelect(\DB::raw("0 as distance"));
                // })

            //     ->when(!empty($distance_result),function($query) use ($distance_result, $rad) {
            //     if (!empty($distance_result)) {
            //         $query->selectRaw("{$distance_result} AS distance")
            //             ->whereRaw("{$distance_result} < ?", [$rad]);
            //         }
            //  })
            ->when($reviewRating, function ($rating){

                $rating->having('rating_values_avg_average_rating', 5);

            })
            ->when($is_free_cancellation, function ($p) use ($is_free_cancellation_value){

                $p->whereHas('policies',function ($q) use ($is_free_cancellation_value){
                   $q->where('cancellation_hour', $is_free_cancellation_value)->where('refund_percentage',100);
                  });

               })  
               ->where('lat', '!=', NULL)
               ->where('lng', '!=', NULL)
               ->paginate(Config::get('global.pagination_records'));
        } else {
            $data = Meal::with('images')->withAvg('ratings', 'average_rating')
                ->withAvg('rating_values','average_rating')
                ->where('is_publish',1)->where('status',1)
                ->orderBy('id', 'DESC')
            ->paginate(Config::get('global.pagination_records'));
        }
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        $this->response['serviceMessage'] = $serviceMessage;
        $this->response['message'] = 'Meal List Fetch Successfully';

        return response()->json($this->response, $this->status);
    }

    public function detail($Id)
    {   
        if(!empty($Id)){
            addCounter('meals', $Id);
        }

        $detail =  Meal::with('images')
            ->withAvg('ratings', 'location_rating')
            ->withAvg('ratings', 'cleanliness_rating')
            ->withAvg('ratings', 'comfort_rating')
            ->withAvg('ratings', 'quality_rating')
            ->withAvg('ratings', 'average_rating')
            ->withSum('ratings', 'location_rating')
            ->withSum('ratings', 'cleanliness_rating')
            ->withSum('ratings', 'comfort_rating')
            ->withSum('ratings', 'quality_rating')

            ->withAvg('rating_values','rating_value_1')
            ->withAvg('rating_values','rating_value_2')
            ->withAvg('rating_values','rating_value_3')
            ->withAvg('rating_values','rating_value_4')
            ->withAvg('rating_values','rating_value_5')
            ->withAvg('rating_values','average_rating')
            ->withSum('rating_values','rating_value_1')
            ->withSum('rating_values','rating_value_2')
            ->withSum('rating_values','rating_value_3')
            ->withSum('rating_values','rating_value_4')
            ->withSum('rating_values','rating_value_5')
            ->withSum('rating_values','average_rating')


            ->with(['videos','two_images','mainImage'])->where('id', $Id)->first();
        if (!$detail) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'invalid Id';
            return response()->json($this->response, $this->status);
        }
        $detail->rules = Rule::where('module_name', 'meals')->where('module_id', $Id)->orderBy('id', 'DESC')->get();


        $userObj = User::with(['ServiceProviderRates','trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])->withAvg('ratings', 'average_rating')->withAvg('rating_values','average_rating')->where('id', $detail->user_id)->first();
        if ($userObj && $userObj->type == '2') {
            $accommodationCount =     Accommodation::where('user_id', $detail->user_id)->where('is_publish', 1)->where('status',1)->count();
            $activityCount =          Experience::where('user_id', $detail->user_id)->where('is_publish', 1)->where('status',1)->count();
            $transportCount =         Transport::where('user_id', $detail->user_id)->where('is_publish', 1)->where('status',1)->count();
            $mealCount =              Meal::where('user_id', $detail->user_id)->where('is_publish', 1)->where('status',1)->count();
        } else {
            $accommodationCount = 0;
            $activityCount = 0;
            $transportCount = 0;
            $mealCount  = 0;
        }
        $detail->user = $userObj;

        $lat = isset($detail->lat) ? (float)$detail->lat : 0;
        $lng = isset($detail->lng) ? (float)$detail->lng : 0;
        $rad = 10000;// isset($request->radius) ? (int)$request->radius : 50;

        $percentage_50  = percentage($detail->price, 50);
        $percentage_50_plus = $detail->price + $percentage_50;
        $percentage_50_minus = $detail->price - $percentage_50;


        $distance_result = "(6371 * acos(cos(radians($lat))
                * cos(radians(lat))
                * cos(radians(lng)
                - radians($lng))
                + sin(radians($lat))
                * sin(radians(lat))))";

        if(!empty($detail) && !is_null($detail->module_name) && !empty($detail->module_name) && ($detail->module_name == 'home_cheff' || $detail->module_name == 'restaurants')){
            if($detail->module_name == 'home_cheff'){

                $detail->relatedData  = Meal::with('singleImage')
                    ->withAvg('ratings', 'average_rating')
                    ->withAvg('rating_values','average_rating')
                    ->where('id', '<>', $detail->id)
                    ->where('module_name' , 'home_cheff')
                    // ->whereBetween('price', [$percentage_50_minus, $percentage_50_plus])
                    ->when(!empty($distance_result), function ($query) use ($distance_result, $rad){
                        $query->selectRaw("{$distance_result} AS distance")->whereRaw("{$distance_result} < ?", [$rad]);
                    })
                    // ->when(isset($detail), function($query) use ($detail){
                    //     $query->where('detail_location','like', '%'.$detail->detail_location.'%')->orWhere('location','like', '%'.$detail->location.'%');
                    // })
                    // ->when(isset($detail), function($query) use ($detail){
                    //     $query->where('user_id', $detail->user_id);
                    // })
                    ->orderBy('id', 'DESC')
                    ->get();

            }else if($detail->module_name == 'restaurants'){

                $detail->relatedData  = Meal::with('singleImage')
                    ->withAvg('ratings', 'average_rating')
                    ->withAvg('rating_values','average_rating')
                    ->where('id', '<>', $detail->id)
                    ->where('module_name' , 'restaurants')
                    // ->whereBetween('price', [$percentage_50_minus, $percentage_50_plus])
                    ->when(!empty($distance_result), function ($query) use ($distance_result, $rad){
                        $query->selectRaw("{$distance_result} AS distance")->whereRaw("{$distance_result} < ?", [$rad]);
                    })
                    // ->when(isset($detail), function($query) use ($detail){
                    //     $query->where('detail_location','like', '%'.$detail->detail_location.'%')->orWhere('location','like', '%'.$detail->location.'%');
                    // })
                    // ->when(isset($detail), function($query) use ($detail){
                    //     $query->where('user_id', $detail->user_id);
                    // })
                    ->orderBy('id', 'DESC')
                    ->get();
            }

        }else{

            // dd($percentage_50_minus, $percentage_50_plus);

            $detail->relatedData  = Meal::with('singleImage')
                ->withAvg('ratings', 'average_rating')
                ->withAvg('rating_values','average_rating')
                ->where('id', '<>', $detail->id)
                // ->whereBetween('price', [$percentage_50_minus, $percentage_50_plus])
                ->when(!empty($distance_result), function ($query) use ($distance_result, $rad){
                    $query->selectRaw("{$distance_result} AS distance")->whereRaw("{$distance_result} < ?", [$rad]);
                })
                // ->when(isset($detail), function($query) use ($detail){
                //     $query->where('detail_location','like', '%'.$detail->detail_location.'%')->orWhere('location','like', '%'.$detail->location.'%');
                // })
                // ->when(isset($detail), function($query) use ($detail){
                //     $query->where('user_id', $detail->user_id);
                // })
                ->orderBy('id', 'DESC')
                ->get();

        }

        foreach ($detail->relatedData as $meal) {
            $distance = $this->point2point_distance($meal->lat, $meal->lng, $detail->lat, $detail->lng);
            if ($distance < 50) {
                $meal->distance = $distance;
            } else {
                $meal->distance = null;
            }
        }
        $detail->relatedData = $detail->relatedData->take(4);
        // dd($detail->relatedData);
        $detail->accommodationCount = $accommodationCount;
        $detail->activityCount = $activityCount;
        $detail->transportCount = $transportCount;
        $detail->mealCount = $mealCount;

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Detail Fetch Successfully';
        $this->response['data'] = $detail;
        return response()->json($this->response, $this->status);
    }
    public function checkAvailability(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'module_id' => 'required',
            'module_name' => 'required',
            'qty' => 'required',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }
        $meal = Meal::where('id', $request->module_id)->first();
        if (!$meal) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid Meal id';
            $this->response['data']['availability'] = false;
            return response()->json($this->response, $this->status);
        } else {
            $outstock = Meal::where('status', 0)->where('id', $request->module_id)->first();
            if ($outstock) {
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'out of stock';
                $this->response['data']['availability'] = false;
            }

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $this->mealPriceCalculate($meal, $request->qty);
            $this->response['data']['availability'] = true;
        }
        return response()->json($this->response, $this->status);
    }
    public function createBooking(Request $request)
    {


        if (count($request->all()) > 0) {
            $booking = new Booking;
            $booking_detail = new Mealbookingdetail;
            $invoice = new Invoice;
            $validator = Validator::make($request->all(), [
                'module_name' => 'required',
                'module_id' => 'required',
                'qty' => 'required',
                'require_date' => 'required',
                'require_time' => 'required',

            ]);
            if ($validator->fails()) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = $validator->messages()->first();
                return response()->json($this->response, $this->status);
            }
            $response = $this->checkAvailability($request);
            if ($response->original['data']['availability'] == false) {
                return $this->checkAvailability($request);
            }
            $meal = Meal::where('id', $request->module_id)->first();
            if (!$meal) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = 'Invalid Meal id';
                return response()->json($this->response, $this->status);
            }
            $this->response['data'] = [];
            $priceDetail = $this->mealPriceCalculate($meal, $request->qty);
            $booking->provider_id           = $meal->user_id;
            if(!empty($meal) && !is_null($meal->user_module_type) && !empty($meal->user_module_type)){
                $booking->module_name = $meal->user_module_type;
                $booking->provider_name = 'service provider';
            }else{
                $booking->module_name           = $request->module_name;
                $booking->provider_name       = 'host';
            }
            $booking->module_id      = $request->module_id;
            $booking->user_id = $request->user()->id;
            $booking->no_of_nights       = $request->qty;      //nights is also equl to qty
            $booking->start_date       =  date("Y-m-d", strtotime($request->require_date)); //$request->require_date;
            $booking->end_date       =     date("Y-m-d", strtotime($request->require_date)); //$request->require_date;

            $booking->price       = $priceDetail['per_item'];
            $booking->sub_total       = $priceDetail['sub_total'];
            $booking->discount       = $priceDetail['discount'];
            $booking->total       = $priceDetail['total'];
            $booking->grand_total       = $priceDetail['grand_total'];
            $booking->booking_type       = 'Per day';

            $booking->booking_number       = rand(100000, 999999);
            $booking->status       = 0;  //its means pending booking
            $booking->payment_status       = 0;  //later change it place dynamic id of status 0 means pending
            if ($booking->save()) {

                $booking_detail->unit       = $meal->unit;
                $booking_detail->module_id       =         $request->module_id;
                $booking_detail->booking_id       =         $booking->id;
                $booking_detail->require_date       =         $request->require_date;
                $booking_detail->require_time       =         $request->require_time;
                $booking_detail->delivery_charges  =  $priceDetail['delivery_charges'];
                $booking_detail->save();
                //invoice detail created...
                $invoice->booking_id = $booking->id;
                $invoice->number = rand(100000, 999999);
                $invoice->status = 0; //used for unpaid
                $invoice->save();


// Notification Push to Vendor vehicle Booking request
                $title      = "Booking Request";
                $message    = "You have 1 new booking request. To view booking details";
                $action     = "user/setting";
                $vendor = User::where('id',$booking->provider_id)->first();
                if(isset($vendor) && !empty($vendor)){
                    PushNotification::createNotification($vendor,$booking->user_id,$title,$message,User::TYPE_BOOKING,$action,$booking->id);
                }


// Notification Push to Admin vehicle Booking request
                $admin = User::where('id',User::ADMIN_ID)->first();
                $adminMessage    = "1 new booking request by ". $request->user()->name." for ". $vendor->name;
                if(isset($admin) && !empty($admin)){
                    PushNotification::createNotification($admin,$booking->user_id,$title,$adminMessage,User::TYPE_BOOKING,$action,$booking->id);
                }



                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'Meal Booked Successfully!';
                $this->response['data']['booking_id'] = $booking->id;
            }
        } else {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Some thing went wrong!.';
        }
        return response()->json($this->response, $this->status);
    }
}
