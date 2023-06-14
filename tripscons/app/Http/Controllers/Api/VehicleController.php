<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\JsonResponse;
use App\Traits\HostServiceBookingTrait;
use App\Models\Booking;
use App\Models\Accommodation;
use App\Models\Meal;
use App\Models\Image;
use App\Models\Facility;
use App\Models\User;
use App\Models\FacilityAccommodation;
use App\Models\Transport;
use App\Models\Activity;
use App\Models\TransportFeature;
use App\Models\Rule;
use App\Models\VehicleBookingDetail;
use Illuminate\Support\Facades\Config;
use App\Models\Invoice;
use Carbon\Carbon;
use App\Traits\RadiusDistanceTrait;
use App\Models\Experience;

class VehicleController extends Controller
{
    use RadiusDistanceTrait;
    protected $status = 200;
    protected $response = [];
    protected $model;
    use HostServiceBookingTrait;
    public function model()
    {
        return Transport::class;
    }
    public function index(Request $request)
    {


        if (count($request->all()) > 0) {

            $reviewRating =   $request->reviewRating;
            $min =  $request->minValue;
            $max =  $request->maxValue;
            $brands = $request->brands;
            $model = $request->model;

            $isDayOrHour = isset($request->isDayOrHour) ? $request->isDayOrHour : '';
            $category = isset($request->category) ? $request->category : '';
            $vechile_type = isset($request->vechile_type) ? $request->vechile_type : '';
            $is_insure = isset($request->is_insure) ? $request->is_insure : '';
            $is_self_drive = isset($request->is_self_drive) ? $request->is_self_drive : '';
            $sitting_capacity = isset($request->sitting_capacity) ? $request->sitting_capacity : '';
            $transmission = isset($request->transmission) ? $request->transmission : '';
            $payment_mode = isset($request->payment_mode) ? $request->payment_mode : '';
            $payment_mode_value = isset($request->payment_mode_value) ? $request->payment_mode_value : '';
            $is_free_cancellation = isset($request->is_free_cancellation) ? $request->is_free_cancellation : '';
            $is_free_cancellation_value = isset($request->is_free_cancellation_value) ? $request->is_free_cancellation_value : '';
            $facilityVehicleArray =  json_decode($request->selectedFacilities);

            $userId = $request->user_id;
            $searchTerm = $request->searchTerm;
            $country = $request->country;
            $city = $request->city;

            $user_id = isset($request->user_id) ? $request->user_id : '';
            $distance_result = '';
            $rad = 500000;


            $lat = isset($request->lat) ? round($request->lat, 8) : 0;
            $lng = isset($request->lng) ? round($request->lng, 8) : 0;
            $rad = isset($request->radius) ? (int)$request->radius : 0;

            $rad = floor($rad / 1000);

            // $distance_result = "(6371 * acos(cos(radians($lat))
            //             * cos(radians(lat))
            //             * cos(radians(lng)
            //             - radians($lng))
            //             + sin(radians($lat))
            //             * sin(radians(lat))))";
            $distance_result = 'ROUND(DEGREES(ACOS(SIN(RADIANS('.$lat.')) 
                    * SIN(RADIANS(lat)) 
                    + COS(RADIANS('.$lat.'))  
                    * COS(RADIANS(lat))
                    * COS(RADIANS('.$lng.' - lng)))) * 69.09)';

            $serviceMessage = '';
            if($request->lat && $request->lng && isset($request->search_by_filter) && $request->search_by_filter == 1){
                $serviceData = Transport::where('is_publish',1)->where('status',1)->where('lat',$lat)->where('lng',$lng)->get();

                if($serviceData->count() < 1){
                    $serviceMessage = "This service is currently not available in this area but here are other nearby services";
                }
            }
            $data = Transport::with([
                'images'
            ])
                ->withAvg('ratings', 'average_rating')->withAvg('rating_values','average_rating')->where('is_publish',1)->where('status',1)->where(function ($query) use ($lat, $lng, $min, $max, $brands, $model, $country, $city, $userId, $searchTerm, $distance_result, $rad,$category,$vechile_type,$is_insure,$is_self_drive,$sitting_capacity,$transmission,$payment_mode,$payment_mode_value,$facilityVehicleArray,$is_free_cancellation,$is_free_cancellation_value,$isDayOrHour,$user_id) {

                    if($user_id){
                        $query->Where('user_id', $user_id);
                    }
                    if($isDayOrHour == 1){
                        if ($min > 0) {
                            $query->Where('intercity_per_day_price', '>=', $min)->orWhere('intercity_multiple_day_price', '>=', $min)->orWhere('outofcity_per_day_price', '>=', $min)->orWhere('outofcity_multiple_day_price', '>=', $min);
                        }
                        if ($max > 0) {
                            $query->Where('intercity_per_day_price', '<=', $max)->orWhere('intercity_multiple_day_price', '<=', $max)->orWhere('outofcity_per_day_price', '<=', $max)->orWhere('outofcity_multiple_day_price', '<=', $max);
                        }
                    }
                    else if($isDayOrHour == '0'){
                        //means per hour only
                        if ($min > 0) {
                            $query->Where('hourly_price', '>=', $min);
                        }
                        if ($max > 0) {
                            $query->Where('hourly_price', '<=', $max);
                        }
                    }

                    if (!empty($brands)) {
                        $query->Where('brand', 'LIKE', "%{$brands}%");
                    }

                    if (!empty($model)) {
                        $query->Where('model', $model);
                    }
                    if (!empty($category)) {
                        $query->Where('category', $category);
                    }
                    if (!empty($vechile_type)) {
                        $query->Where('vechile_type', $vechile_type);
                    }
                    if (!empty($is_insure)) {
                        $query->Where('insured', $is_insure);
                    }
                    if (!empty($is_self_drive)) {
                        $query->Where('provide_self_drive', $is_self_drive);
                    }
                    if (!empty($sitting_capacity)) {
                        $query->Where('no_of_people', $sitting_capacity);
                    }
                    if (!empty($transmission)) {
                        $query->Where('transmission', $transmission);
                    }

                    if ($payment_mode == 1 && $payment_mode_value >= 25 ) {

                        $query->Where('payment_mode', $payment_mode);
                        $query->Where('payment_partial_value', $payment_mode_value);
                    }
                    if ($payment_mode === '0') {

                        $query->Where('payment_mode', $payment_mode);
                    }
                    if (!empty($searchTerm)) {
                        $query->orWhere('title', 'LIKE', "%{$searchTerm}%")->orWhere('description', 'LIKE', "%{$searchTerm}%")->orWhere('location', 'LIKE', "%{$searchTerm}%")->orWhere('city', 'LIKE', "%{$searchTerm}%");
                    }
                })->when(!empty($distance_result), function ($q) use ($distance_result, $rad) {
                    if(!empty($rad)){
                        $q->selectRaw("{$distance_result} AS distance")->whereRaw("{$distance_result} < ?", [$rad])->orderBy('distance');
                    }else{
                        $q->addSelect(\DB::raw($distance_result . " as distance"));
                        $q->orderBy(\DB::raw($distance_result));
                    }
                })
                ->when(!$lat || !$lng, function ($q)  use ($distance_result) {
                    $q->addSelect(\DB::raw("0 as distance"));
                })->when($reviewRating, function ($rating){
                    $rating->having('rating_values_avg_average_rating', 5);
                })->when($is_free_cancellation, function ($p) use ($is_free_cancellation_value){

                    $p->whereHas('policies',function ($q) use ($is_free_cancellation_value){
                        $q->where('cancellation_hour', $is_free_cancellation_value)->where('refund_percentage',100);
                    });

                })
                ->when($facilityVehicleArray, function ($p) use ($facilityVehicleArray){

                    $p->whereHas('transport_feature',function ($q) use ($facilityVehicleArray){
                        $q->whereIn('title', $facilityVehicleArray);
                    });

                })
            
                ->paginate(Config::get('global.pagination_records'));

        } else {

            $data = Transport::with('images')->withAvg('ratings', 'average_rating')->withAvg('rating_values','average_rating')->where('is_publish',1)->where('status',1)->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
        }
        $status = 200;

        if ($data->count() < 0) {
            $this->response['data'] = "No result Found";
            $this->status = 403;
            $this->response['success'] = false;
            return response()->json($this->response, $this->status);
        }
        $this->status = $status;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        $this->response['serviceMessage'] = $serviceMessage;


        return response()->json($this->response, $this->status);
    }

    public function detail($Id)
    {   
        if(!empty($Id)){
            addCounter('transports', $Id);
        }

        $detail =  Transport::with('images')
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

            ->with(['videos','two_images','mainImage','transport_feature'])->where('id', $Id)->first();
        if (!$detail) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'invalid Id';
            return response()->json($this->response, $this->status);
        }
        $detail->rules = Rule::where('module_name', 'transports')->where('module_id', $Id)->get();

        $userId  = $detail->user_id;

        $userObj =   User::withAvg('ratings', 'average_rating')->withAvg('rating_values','average_rating')->where('id', $userId)->first();
        if (!empty($userObj)) {
            $detail->userObj = $userObj;

            $lat = isset($detail->lat) ? (float)$detail->lat : 0;
            $lng = isset($detail->lng) ? (float)$detail->lng : 0;
            $rad = 10000;// isset($request->radius) ? (int)$request->radius : 50;

            $distance_result = "(6371 * acos(cos(radians($lat))
                    * cos(radians(lat))
                    * cos(radians(lng)
                    - radians($lng))
                    + sin(radians($lat))
                    * sin(radians(lat))))";

            $per_day_price_percentage_50  = percentage($detail->per_day_price, 50);
            $per_day_price_percentage_50_plus = $detail->per_day_price + $per_day_price_percentage_50;
            $per_day_price_percentage_50_minus = $detail->per_day_price - $per_day_price_percentage_50;

            $hourly_price_percentage_50  = percentage($detail->hourly_price, 50);
            $hourly_price_percentage_50_plus = $detail->hourly_price + $hourly_price_percentage_50;
            $hourly_price_percentage_50_minus = $detail->hourly_price - $hourly_price_percentage_50;

            // dd($detail->per_day_price,$detail->hourly_price,$per_day_price_percentage_50_plus,$per_day_price_percentage_50_minus,$hourly_price_percentage_50_plus,$hourly_price_percentage_50_minus);
            $detail->relatedData = Transport::with('singleImage')
                ->where('id', '<>', $detail->id)
                ->where('category', $detail->category)
                ->where('is_publish',1)
                ->where('status',1)
                ->withAvg('ratings', 'average_rating')
                ->withAvg('rating_values','average_rating')
                ->where('vechile_type', $detail->vechile_type)
                ->when(!empty($distance_result), function ($query) use ($distance_result, $rad){
                    $query->selectRaw("{$distance_result} AS distance")->whereRaw("{$distance_result} < ?", [$rad]);
                })
                // ->when((isset($detail->per_day_price) && !empty($detail->per_day_price)), function($query) use($per_day_price_percentage_50_plus,$per_day_price_percentage_50_minus){
                //         $query->wherebetween('per_day_price', [$per_day_price_percentage_50_minus, $per_day_price_percentage_50_plus]);
                // })
                // ->when((isset($detail->hourly_price) && !empty($detail->hourly_price)), function($query) use($hourly_price_percentage_50_plus,$hourly_price_percentage_50_minus){
                //         $query->orWherebetween('hourly_price', [$hourly_price_percentage_50_minus, $hourly_price_percentage_50_plus]);
                // })

                // ->when(isset($detail), function($query) use ($detail){
                //     $query->where('detail_location','like', '%'.$detail->detail_location.'%')->orWhere('location','like', '%'.$detail->location.'%');
                // })
                // ->when(isset($detail), function($query) use ($detail){
                //     $query->where('user_id', $detail->user_id);
                // })
                ->orderBy('id', 'DESC')
                ->get();
            foreach ($detail->relatedData as $transport) {

                $distance = $this->point2point_distance($transport->lat, $transport->lng, $detail->lat, $detail->lng);
                if ($distance < 50) {
                    $transport->distance = $distance;
                } else {
                    $transport->distance = 0;
                }
            }
            $detail->relatedData = $detail->relatedData->take(4);
            if ($userObj->type == 2) {
                $detail->accommodationCount =   Accommodation::where('user_id', $detail->user_id)->where('is_publish', 1)->where('status',1)->count();
                $detail->mealCount =        Meal::where('user_id', $detail->user_id)->where('is_publish', 1)->where('status',1)->count();
                $detail->activityCount =    Experience::where('user_id', $detail->user_id)->where('is_publish', 1)->where('status',1)->count();
                $detail->transportCount =         Transport::where('user_id', $detail->user_id)->where('is_publish', 1)->where('status',1)->count();
            } else {
                $detail->accommodationCount =   0;
                $detail->mealCount =       0;
                $detail->activityCount =    0;
                $detail->transportCount =   0;
            }

        }

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $detail;
        return response()->json($this->response, $this->status);

    }

    public function facilities()
    {
        $data = Facility::where('user_module_type', 'transport')->get();
        return response()->json(['facilities' => $data]);
    }

    public function checkAvailability(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'module_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'booking_type' => 'required',
            'module_name' => 'required',
            'pick_up_obj' => 'required',
            'drop_off_obj' => 'required'


        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }


        if ($request->booking_type == 'Hourly') {

            $st = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_date)->format('Y-m-d');
            $et = Carbon::createFromFormat('Y-m-d H:i:s', $request->end_date)->format('Y-m-d');
            $booking = Booking::where('module_id', $request->module_id)->where('module_name', $request->module_name)->where('status', 0)->where(function ($query) use ($st, $et) {
                $query->wherebetween('start_date', [$st, $et])
                    ->orwherebetween('end_date', [$st, $et]);
            })->first();
            if ($booking) {
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'In this duration that Vehicle is already booked sorry for that';
                $this->response['data']['availability'] = false;
                return response()->json($this->response, $this->status);
            }
        }
        $booking = Booking::where('module_id', $request->module_id)->where('module_name', $request->module_name)->where('status', 0)->where(function ($query) use ($request) {
            $query->wherebetween('start_date', [$request->start_date, $request->end_date])
                ->orwherebetween('end_date', [$request->start_date, $request->end_date]);
        })->first();


        if ($booking) {
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'In this duration that Vehicle is already booked sorry for that';
            $this->response['data']['availability'] = false;
        } else {


            if ($request->booking_type == 'Hourly') {
                $nights =  $this->caluclateTime($request->start_date, $request->end_date);
                if ($nights == 1) {
                    $this->status = 422;
                    $this->response['success'] = false;
                    $this->response['message'] = 'Atleast one hour you need to book';
                    $this->response['data']['availability'] = false;
                    return response()->json($this->response, $this->status);
                }
            } else {
                $nights =  $this->caluclateDaysorNights($request->start_date, $request->end_date);
            }
            $transport = Transport::where('id', $request->module_id)->first();
            if (!$transport) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = 'Invalid Vehicle id';
                $this->response['data']['availability'] = false;
                return response()->json($this->response, $this->status);
            }


            if ($nights  <= 0) {
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'please select valid date';
                $this->response['data']['availability'] = false;
                return response()->json($this->response, $this->status);
            }
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $this->vehiclePriceCalculate($transport, $nights, $request->booking_type,$request->pick_up_obj,$request->drop_off_obj,$request->in_city_or_not);
            $this->response['data']['availability'] = true;
        }
        // dd($this->response);
        return response()->json($this->response, $this->status);
    }

    public function createBooking(Request $request)
    {
        if (count($request->all()) > 0) {


            $validator = Validator::make($request->all(), [
                'module_name' => 'required',
                'module_id' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'booking_type' => 'required',
                'pick_up_obj' => 'required',
                'drop_off_obj' => 'required'
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


            $booking = new Booking;
            $booking_detail = new VehicleBookingDetail;
            $invoice = new Invoice;
            $transport = Transport::where('id', $request->module_id)->first();
            if (!$transport) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = 'Invalid vehicle id';
                return response()->json($this->response, $this->status);
            }
            if ($request->booking_type == 'Hourly') {
                $nights =  $this->caluclateTime($request->start_date, $request->end_date);
            } else {
                $nights = $this->caluclateDaysorNights($request->start_date, $request->end_date);
            }
            $this->response['data'] = [];
            $priceDetail = $this->vehiclePriceCalculate($transport, $nights, $request->booking_type,$request->pick_up_obj,$request->drop_off_obj,$request->in_city_or_not);

            $booking->provider_id           = $transport->user_id;
            $booking->module_name           = $request->module_name;
            $booking->module_id      = $request->module_id;
            $booking->user_id = $request->user()->id;
            $booking->no_of_nights       = $nights;
            if (isset($request->start_date)) {
                $booking->start_date       = $request->start_date;
            }
            if (isset($request->end_date)) {
                $booking->end_date       = $request->end_date;
            }
            if ($request->booking_type == 'Hourly') {
                $booking->price       = $priceDetail['hourly_price'];
            } else {
                $booking->price       = $priceDetail['price'];
            }

            $booking->sub_total       = $priceDetail['sub_total'];
            $booking->discount       = '0.00';
            $booking->total       = $priceDetail['total'];
            $booking->grand_total       = $priceDetail['grand_total'];
            $booking->booking_type       = $request->booking_type;
            $booking->provider_name       = 'host';
            $booking->booking_number       = rand(100000, 999999);
            $booking->status       = 0;  //its means pending booking

            $booking->payment_status       = 0;  //later change it place dynamic id of status 0 means pending
            if ($booking->save()) {

                $booking_detail->airport_pick_drop_charges       =  0;
                $booking_detail->booking_type       =     $request['booking_type'];
                $booking_detail->module_id       =         $request->module_id;
                $booking_detail->booking_id       =     $booking->id;

                $booking_detail->pick_up_obj  = $request-> pick_up_obj;
                $booking_detail->drop_off_obj  = $request-> drop_off_obj;
                if($request-> in_city_or_not){
                    $booking_detail->in_city_or_not  = $request-> in_city_or_not;
                    $booking_detail->extra_milage  = $request-> extra_milage;
                    $booking_detail->extra_milage_price  = $request-> extra_milage_price;
                }




                $booking_detail->save();
                //invoice detail created...
                $invoice->booking_id = $booking->id;
                $invoice->number = rand(100000, 999999);
                $invoice->status = 0; //used for unpaid
                $invoice->save();


// Notification Push to Vendor vehicle Booking request
                $title      = "Booking Request";
                $message    = "You have 1 new booking request. To view booking details";
                $action     = "service/bookings/".$booking->id;
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
                $this->response['message'] = 'Booking Created Successfully!';
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
