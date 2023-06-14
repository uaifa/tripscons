<?php

namespace App\Http\Controllers\Api;

use App\Events\PendingBooking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HostServiceBookingTrait;
use App\Traits\SendEmailTrait;
use App\Traits\ServiceTrait;
use App\Models\Accommodation;
use App\Models\Image;
use App\Models\Facility;
use App\Models\AccommodationSubType;
use App\Models\FacilityAccommodation;
use App\Models\User;
use App\Models\Rule;
use App\Models\Place;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Experience;
use App\Models\Meal;
use App\Models\Transport;
use App\Models\Booking;
use App\Models\AccommodationBookingDetail;
use App\Models\Invoice;
use Illuminate\Support\Facades\Config;
use App\Traits\RadiusDistanceTrait;
use Exception;
use App\Models\Room;
use App\Models\RoomBooking;


//use config;


class AccommodationController extends Controller
{
    protected $status = 200;
    protected $response = [];
    protected $model;
    use HostServiceBookingTrait;
    use SendEmailTrait;
    use RadiusDistanceTrait;
    use ServiceTrait;
    public function model()
    {
        return Accommodation::class;
    }
    public function index(Request $request)
    {

        $ratingCustom =$request->ratingCustom;
        $noOfPeople =  (int)$request->adultGuest + (int)$request->childGuest;
        $min =  $request->minValue;
        $max =  $request->maxValue;
        $minCapacity =  $request->minCapacity;
        $maxCapacity =  $request->maxCapacity;
        $is_flexiable_check_in = $request->is_flexiable_check_in;

        $proType = $request->propertyType;
        $propertySubType = isset($request->propertySubType) ? $request->propertySubType : '';
        $propertyFacility = $request->selectedFacilities;
        $userId = $request->user_id;
        $country = $request->country;
        $city = $request->city;
        $searchTerm = $request->searchTerm;
        $lat = isset($request->lat) ? round($request->lat, 8) : 0;
        $lng = isset($request->lng) ? round($request->lng, 8) : 0;
        $date_from = '';
        $date_to = '';
        $user_id = isset($request->user_id) ? $request->user_id : '';
        $payment_mode = isset($request->payment_mode) ? $request->payment_mode : '';
        $payment_mode_value = isset($request->payment_mode_value) ? $request->payment_mode_value : '';
        $reviewRating = isset($request->reviewRating) ? $request->reviewRating : false;
        $type_id = isset($request->type_id) ? $request->type_id : '';
        $no_of_rooms = isset($request->no_of_rooms) ? $request->no_of_rooms : '';

        $no_of_beds = isset($request->no_of_beds) ? $request->no_of_beds : '';
        $no_of_bathrooms = isset($request->no_of_bathrooms) ? $request->no_of_bathrooms : '';
        $discount = isset($request->discount) ? $request->discount : '';

        $facilityAccommodationArray   = [];
        $is_free_cancellation = isset($request->is_free_cancellation) ? $request->is_free_cancellation : '';
        $is_free_cancellation_value = isset($request->is_free_cancellation_value) ? $request->is_free_cancellation_value : '';
        $row = FacilityAccommodation::select('name', 'accommodation_id')->where('name', $propertyFacility)
            ->orderBy('id', 'DESC')->get();
        foreach ($row as $response) {
            array_push($facilityAccommodationArray, $response->accommodation_id);
        }
        //rooms against accommodation fetch ....
        $noOfBedsAccommodationArray=[];
        if (!empty($no_of_beds)) {

            if($no_of_beds == 1){
                $noOfBedsAccommodationArray   = [];
                $row = Room::select('accommodation_id')->where('no_of_beds', $no_of_beds)->get();
                 foreach ($row as $response) {
                 array_push($noOfBedsAccommodationArray, $response->accommodation_id);
                 }
           }
            if($no_of_beds == 2){
                $noOfBedsAccommodationArray   = [];
                $row = Room::select('accommodation_id')->where('no_of_beds',$no_of_beds)->get();
                 foreach ($row as $response) {
                 array_push($noOfBedsAccommodationArray, $response->accommodation_id);
                 }
            }
            if($no_of_beds == 3){
                $noOfBedsAccommodationArray   = [];
                $row = Room::select('accommodation_id')->where('no_of_beds', $no_of_beds)->get();
                 foreach ($row as $response) {
                 array_push($noOfBedsAccommodationArray, $response->accommodation_id);
                 }
            }
            if($no_of_beds == 4){
                $noOfBedsAccommodationArray   = [];
                $row = Room::select('accommodation_id')->where('no_of_beds', $no_of_beds)->get();
                 foreach ($row as $response) {
                 array_push($noOfBedsAccommodationArray, $response->accommodation_id);
                 }
            }
            if($no_of_beds == 5){
                $noOfBedsAccommodationArray   = [];
                $row = Room::select('accommodation_id')->whereBetween('no_of_beds', [5,10000])->get();
                 foreach ($row as $response) {
                 array_push($noOfBedsAccommodationArray, $response->accommodation_id);
                 }
            }


        }


        $distance_result = '';
        $rad = 50;
        $lat = 0;
        $lng = 0;

            $lat = isset($request->lat) ? round($request->lat, 8) : 0;
            $lng = isset($request->lng) ? round($request->lng, 8) : 0;
            $rad = isset($request->radius) ? (int)$request->radius : 0;

            if($lat == 33.9259055 && $lng == 73.7810334) {
                $lat = 34.59850000;
                $lng = 73.90730000;
            }

            $rad = floor($rad / 1000);
            // $distance_result = "(3959 * acos(cos(radians($lat))
            //         * cos(radians(lat))
            //         * cos(radians(lng)
            //         - radians($lng))
            //         + sin(radians($lat))
            //         * sin(radians(lat))))";

            $distance_result = 'ROUND(DEGREES(ACOS(SIN(RADIANS('.$lat.'))
                    * SIN(RADIANS(lat))
                    + COS(RADIANS('.$lat.'))
                    * COS(RADIANS(lat))
                    * COS(RADIANS('.$lng.' - lng)))) * 69.09)';

        $serviceMessage = '';
        if(isset($request->lat) && isset($request->lng) && isset($request->search_by_filter) && $request->search_by_filter == 1){
            $serviceData = Accommodation::where('is_publish',1)->where('status',1)->where('lat',$lat)->where('lng',$lng)->get();
            if($serviceData->count() < 1){
                $serviceMessage = "This service is currently not available in this area but here are other nearby services";
            }
        }

        if (!empty($request)) {

            $accommodations = Accommodation::with(['images', 'booking'])
                    ->withAvg('rating_values', 'average_rating')
                    ->withAvg('trips_vendor_ratings', 'rating_value')
                    ->withAvg('ratings', 'average_rating')
                    ->where('is_publish',1)
                    ->where('status',1)

                    ->where(function ($query) use ($noOfPeople, $min, $max, $proType,$propertyFacility, $userId, $city, $searchTerm,  $distance_result, $rad, $date_from, $date_to, $type_id, $no_of_rooms, $no_of_beds, $no_of_bathrooms,$minCapacity,$maxCapacity,$ratingCustom,$is_flexiable_check_in,$facilityAccommodationArray,$discount,$noOfBedsAccommodationArray,$payment_mode,$payment_mode_value,$is_free_cancellation,$is_free_cancellation_value,$propertySubType,$user_id) {
            if($user_id){
                $query->Where('user_id', $user_id);
            }
            if ($ratingCustom > 0) {
                   $query->where('stars', $ratingCustom);
                }
                if ($facilityAccommodationArray) {
                    $query->WhereIn('id', $facilityAccommodationArray);
                }
                if ($noOfBedsAccommodationArray) {
                    $query->WhereIn('id', $noOfBedsAccommodationArray);
                }
                if ($payment_mode == 1 && $payment_mode_value >= 25 ) {

                    $query->Where('payment_mode', $payment_mode);
                    $query->Where('payment_partial_value', $payment_mode_value);
                }
                if ($payment_mode === '0') {

                 $query->Where('payment_mode', $payment_mode);
                }
                if ($is_flexiable_check_in) {

                    $query->Where('is_flexiable_check_in', $is_flexiable_check_in)->where('is_flexiable_check_in_value','>',0);
                }
                if ($discount) {
                    if($discount =="weekly"){
                        $query->Where('discount_for_one_week','>', 0);
                    }
                    if($discount =="fifteen"){
                        $query->Where('discount_for_two_week','>', 0);
                    }
                    if($discount =="monthly"){
                        $query->Where('discount_for_monthly','>', 0);
                    }
                }

                if ($noOfPeople > 0) {
                    $query->Where('no_of_people', '>=', $noOfPeople);
                }
                if ($min > 0) {
                    $query->Where('per_night', '>=', $min);
                }
                if ($max > 0) {
                    $query->Where('per_night', '<=', $max);
                }
                if ($minCapacity > 0) {
                    $query->Where('no_of_people', '>=', $minCapacity);
                }
                if ($maxCapacity > 0) {
                    $query->Where('no_of_people', '<=', $maxCapacity);
                }
                if (!empty($proType)) {
                    $query->Where('type_id', $proType);
                }
                if (!empty($propertySubType)) {
                    $query->Where('sub_type_name', $propertySubType);
                }

                if (!empty($type_id)) {
                    $query->Where('is_property', $type_id);
                }


                if (!empty($no_of_rooms)) {

                    if($no_of_rooms == 1){
                        $query->WhereBetween('no_of_rooms', [1,10]);
                    }
                    if($no_of_rooms == 2){
                        $query->WhereBetween('no_of_rooms', [10,20]);
                    }
                    if($no_of_rooms == 3){
                        $query->WhereBetween('no_of_rooms', [20,30]);
                    }
                    if($no_of_rooms == 4){
                        $query->WhereBetween('no_of_rooms', [30,40]);
                    }
                    if($no_of_rooms == 5){
                        $query->WhereBetween('no_of_rooms', [40,50]);
                    }
                    if($no_of_rooms == 6){
                        $query->WhereBetween('no_of_rooms', [50,10000]);
                    }

                }
               if (!empty($no_of_bathrooms)) {
                    $query->Where('no_of_attach_bath', $no_of_bathrooms);
                }
                 })

                ->when($lat && $lng, function ($q) use ($distance_result, $rad) {
                    if (!empty($distance_result)) {
                        $q->selectRaw("{$distance_result} AS distance")
                        // $q->addSelect(\DB::raw($distance_result . " as distance"))
                            // ->whereRaw("{$distance_result} < ?", [$rad])
                            ->orderBy('distance');

                    }

                    // if (!empty($distance_result)) {
                    //     $q->selectRaw("{$distance_result} AS distance")
                    //     // $q->addSelect(\DB::raw($distance_result . " as distance"))
                    //         ->whereRaw("{$distance_result} < ?", [$rad])->orderBy('distance');
                    // }

                    // $q->addSelect(\DB::raw($distance_result . " as distance"));
                    // $q->orderBy(\DB::raw($distance_result));
                })

                ->when(isset($request->isProvideBreakfast), function ($q) use ($request) {
                    if($request->isProvideBreakfast){
                        $q->where('isProvideBreakfast', $request->isProvideBreakfast);
                    }else{
                        $q->where('isProvideBreakfast', $request->isProvideBreakfast)->orWhereNull('isProvideBreakfast');
                    }
                })

                // ->when(!$lat || !$lng, function ($q)  use ($distance_result) {
                //     $q->addSelect(\DB::raw("0 as distance"));
                // })

                // ->when($reviewRating, function ($rating){
                //     $rating->having('rating_values_avg_average_rating', 5);

                // })->when($is_free_cancellation, function ($p) use ($is_free_cancellation_value){

                //     $p->whereHas('policies',function ($q) use ($is_free_cancellation_value){
                //        $q->where('cancellation_hour', $is_free_cancellation_value)->where('refund_percentage',100);
                //       });

                // })
            // ->orderByRaw('distance')
            ->paginate(Config::get('global.pagination_records'));

        }else {
            $accommodations = Accommodation::with('images')
                                            ->withAvg('rating_values', 'average_rating')
                                            ->withAvg('trips_vendor_ratings', 'rating_value')
                                            ->where('is_publish', 1)->where('status',1)->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
        }

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $accommodations;
        $this->response['serviceMessage'] = $serviceMessage;

        return response()->json($this->response, $this->status);
    }

    public function AccommodationDetail($accommodationId)
    {
        if(!empty($accommodationId)){
            addCounter('accommodations', $accommodationId);
        }

        $accommodation =  Accommodation::withAvg('ratings', 'location_rating')
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

            ->with('videos')->where('id', $accommodationId)->first();

        if (!$accommodation) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'invalid Id';
            return response()->json($this->response, $this->status);
        }

        $percentage_50  = percentage($accommodation->per_night, 50);
        $percentage_50_plus = $accommodation->per_night + $percentage_50;
        $percentage_50_minus = $accommodation->per_night - $percentage_50;

        // dd($percentage_50_plus, $percentage_50_minus);

            $lat = isset($accommodation->lat) ? (float)$accommodation->lat : 0;
            $lng = isset($accommodation->lng) ? (float)$accommodation->lng : 0;
            $rad = 1000;// isset($request->radius) ? (int)$request->radius : 50;

            $distance_result = "(6371 * acos(cos(radians($lat))
                    * cos(radians(lat))
                    * cos(radians(lng)
                    - radians($lng))
                    + sin(radians($lat))
                    * sin(radians(lat))))";


        $accomudations =  Accommodation::with('singleImage')
            ->withAvg('ratings', 'average_rating')
            ->withAvg('rating_values','average_rating')
            ->where('id','<>',$accommodation->id)
            ->where('is_publish',1)
            ->where('status',1)
            ->where(function($q) use($accommodation){
                $q->where('type_id', $accommodation->type_id)->where('sub_type_name','like','%'.$accommodation->sub_type_name.'%');
            })

            ->when(!empty($distance_result), function ($query) use ($distance_result, $rad){
                $query->selectRaw("{$distance_result} AS distance")->whereRaw("{$distance_result} < ?", [$rad]);
            })
            ->orderBy('id', 'DESC')
            ->get()->take(4);


        // $accomudations = $accomudations->take(4);

        // return $accomudations;
        $accommodation->facility;
        $accommodation->images;
        $accommodation->mainImage;
        $accommodation->two_images;
        $accommodation->rules = Rule::where('module_name', 'accommodations')->where('module_id', $accommodation->id)->orderBy('id', 'DESC')->get();
        $accommodation->places = Place::where('module_id', $accommodation->id)->orderBy('id', 'DESC')->get();


        $accommodationCount =   Accommodation::where('user_id', $accommodation->user_id)->where('is_publish', 1)->where('status',1)->count();
        if (empty($accommodationCount)) {
            $accommodationCount = 0;
        }
        $mealCount =        Meal::where('user_id', $accommodation->user_id)->where('is_publish', 1)->where('status',1)->count();
        if (empty($mealCount)) {
            $mealCount = 0;
        }
        $activityCount =    Experience::where('user_id', $accommodation->user_id)->where('is_publish', 1)->where('status',1)->count();
        if (empty($activityCount)) {
            $activityCount = 0;
        }

        $transCount =         Transport::where('user_id', $accommodation->user_id)->where('is_publish', 1)->where('status',1)->count();
        if (empty($transCount)) {
            $transCount = 0;
        }
        $userId  = $accommodation->user_id;
        $userObj = User::with(['ServiceProviderRates','trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])->withAvg('ratings', 'average_rating')->withAvg('rating_values','average_rating')->where('id', $userId)->first();
        if (!$userObj) {
            $this->status = 200;
            $this->response['success'] = false;
            $this->response['message'] = 'invalid userId';
            return response()->json($this->response, $this->status);
        }
        $places = Place::where('module_id',$accommodation->id)->get();
        $userObj->tripsCount = 100;
        $userObj->comments = 100;
        $userObj->tripFriends = 29;
        $userObj->feedbacks = 400;
        $accommodation->user = $userObj;
        $accommodation->places = $places;
        $accommodation->relatedData = $accomudations;
        $accommodation->mealCount = $mealCount;
        $accommodation->transportCount = $transCount;
        $accommodation->accommodationCount = $accommodationCount;
        $accommodation->activityCount = $activityCount;

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $accommodation;
        return response()->json($this->response, $this->status);
    }


    public function getAccommodationSubType($accommodationTypeId)
    {
        $subtype = AccommodationSubType::select('name', 'id')->where('type_id', $accommodationTypeId)->orderBy('id', 'DESC')->get();
        //$subtype = AccommodationSubType::getByTypeId($accommodationTypeId);
        return $subtype;
    }
    public function createBooking(Request $request)
    {

        $userObj = [
            'email' => $request->user()->email,
            'name' => $request->user()->name,
        ];

        if (count($request->all()) > 0) {
            $booking = new Booking;
            $booking_detail = new AccommodationBookingDetail;
            $invoice = new Invoice;
            $accommodation = Accommodation::with('User')->where('id', $request->module_id)->first();

            if(isset($request->rooms) &&  $accommodation->type_id == 2){
            $validator = Validator::make($request->all(), [
                'module_name' => 'required',
                'module_id' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'breakfast_included' => 'required',
                'lunch_included' => 'required',
                'dinner_included' => 'required',
                'no_of_adults' => 'required',
                'no_of_childs' => 'required',


            ]);
            if ($validator->fails()) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = $validator->messages()->first();
                return response()->json($this->response, $this->status);
            }
        }else{
            $validator = Validator::make($request->all(), [
                'module_name' => 'required',
                'module_id' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'breakfast_included' => 'required',
                'lunch_included' => 'required',
                'dinner_included' => 'required',
                'no_of_adults' => 'required',
                'no_of_childs' => 'required',
                'per_night' => 'required|gt:0'


            ]);
            if ($validator->fails()) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = $validator->messages()->first();
                return response()->json($this->response, $this->status);
            }
        }

            if($accommodation->type_id != 2){
            $response = $this->checkAccommodationAvailability($request);

                if ($response->original['data']['availability'] == false) {
                    return $this->checkAccommodationAvailability($request);
                }
            }
            //check it tomorrow
            $this->response['data'] = [];
            if ($accommodation->type_id == 2) {
                if (isset($request->rooms)) {
                    if (empty(json_decode($request->rooms))) {
                        $this->status = 422;
                        $this->response['success'] = false;
                        $this->response['message'] = 'Please first add rooms';
                        return response()->json($this->response, $this->status);
                    }
                }
            }

            if (!$accommodation) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = 'Invalid accommodation id';
                return response()->json($this->response, $this->status);
            }

            if ($request->no_of_childs < 0) {
                $request->no_of_childs = 0;
            }

            if ($request->no_of_adults + $request->no_of_childs > $accommodation->no_of_people) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = 'accommodation require maximum ' . $accommodation->no_of_people . ' no of people';
                return response()->json($this->response, $this->status);
            }

            $nights = $this->caluclateDaysorNights(date("Y-m-d", strtotime($request->start_date)), date("Y-m-d", strtotime($request->end_date)));


            if ($accommodation->type_id == 2) {
                $totalroomsPrice = 0;
                foreach (json_decode($request->rooms) as $roomObj) {
                    $room = Room::where('id', $roomObj->room_id)->first();
                    $totalroomsPrice  = $totalroomsPrice + $this->caluclateRoomPrice($room, $roomObj, $nights, $roomObj->per_room);
                }

                $priceDetail = $this->priceCalculate($accommodation, $nights, $request->breakfast_included, $request->lunch_included, $request->dinner_included, $totalroomsPrice, 0, $request->no_of_childs);
            } else {
                $priceDetail = $this->priceCalculate($accommodation, $nights, $request->breakfast_included, $request->lunch_included, $request->dinner_included, 0, $request->per_night, $request->no_of_childs);
            }
            $booking->provider_id           = $accommodation->user_id;
            $booking->module_name           = $request->module_name;


            $booking->module_id      = $request->module_id;
            $booking->user_id = $request->user()->id;
            $booking->no_of_nights       = $nights;
            if (isset($request->start_date)) {
                $booking->start_date       = date("Y-m-d", strtotime($request->start_date));
            }
            if (isset($request->end_date)) {
                $booking->end_date       = date("Y-m-d", strtotime($request->end_date));
            }
            if ($accommodation->type_id == 2) {
                $booking->price       = '0.00';
            } else {
                $booking->price       = $request->per_night;
            }
            $booking->sub_total       = $priceDetail['sub_total'];
            $booking->discount       = $priceDetail['discount'];
            $booking->total       = $priceDetail['total'];
            $booking->grand_total       = $priceDetail['grand_total'];
            $booking->partial_amt       = $priceDetail['partial_amount'];
            $booking->partial_amt_in_percentage       = $priceDetail['partial_amount_percentage'];
            $booking->booking_type       = 'Per day';
            $booking->provider_name       = 'host';
            //later change it place dynamic id of status 0 means pending
            $booking->booking_number       = rand(100000, 999999);
            $booking->status       = 0;  //its means pending booking
            $booking->payment_status       = 0;
            $booking->bookable = Accommodation::class;
            if ($booking->save()) {
                if (isset($request->no_of_adults)) {
                    $booking_detail->no_of_adults       = $request->no_of_adults;
                }
                if (isset($request->no_of_childs)) {
                    $booking_detail->no_of_childs       = $request->no_of_childs;
                }
                $booking_detail->breakfast_price        =    $priceDetail['breakfast_price'];
                $booking_detail->lunch_price            =    $priceDetail['lunch_price'];
                $booking_detail->dinner_price           =    $priceDetail['dinner_price'];
                $booking_detail->service_fee            =    $priceDetail['service_fee'];
                $booking_detail->cleaning_fee           =    $priceDetail['cleaning_fee'];
                $booking_detail->module_id              =    $request->module_id;
                $booking_detail->booking_id             =    $booking->id;
                $booking_detail->save();
                //insert data into roombooking table
                if ($accommodation->type_id == 2) {
                    $roomBooking = new RoomBooking;
                    $totalroomsPrice = 0;
                    $roomFinalarray = [];
                    foreach (json_decode($request->rooms) as $roomObj) {
                        $room = Room::where('id', $roomObj->room_id)->first();

                        $singleRoomSub =  $this->caluclateRoomPrice($room, $roomObj, $nights, $roomObj->per_room);
                        $totalroomsPrice  = $totalroomsPrice + $singleRoomSub; //move to main booking table

                        $room->booked_room   = $room->booked_room + $roomObj->no_of_rooms;
                        $room->save();
                        $roomData =

                            ['booking_id'=>$booking->id, 'no_of_rooms'=> $roomObj->no_of_rooms,'start_date'=>date("Y-m-d", strtotime($request->start_date)),'end_date'=>date("Y-m-d", strtotime($request->end_date)),'room_id' =>$roomObj->room_id,'subtotal'=>$singleRoomSub /$nights,'no_of_extra_guest'=>$roomObj->no_of_extra_guest];
                            array_push($roomFinalarray, $roomData);

                        }

                        RoomBooking::insert($roomFinalarray);
                        $booking->price       = $totalroomsPrice;
                        $booking->save();

                }
                //invoice detail created...
                $invoice->booking_id = $booking->id;
                $invoice->number = rand(100000, 999999);
                $invoice->status = 0; //used for unpaid
                $invoice->save();

                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'Booking Created Successfully!';
                $this->response['data']['booking_id'] = $booking->id;
            }

            // PendingBooking::dispatch($booking);

        } else {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Some thing went wrong!.';
        }
        return response()->json($this->response, $this->status);
    }


    public function checkAccommodationAvailability(Request $request)
    {
        $accommodation = Accommodation::where('id', $request->module_id)->first();
        if(isset($request->rooms) &&  $accommodation->type_id == 2){
       $validator = Validator::make($request->all(), [
            'module_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'breakfast_included' => 'required',
            'lunch_included' => 'required',
            'dinner_included' => 'required',
            'module_name' => 'required',

        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }
    }else{
        $validator = Validator::make($request->all(), [
            'module_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'breakfast_included' => 'required',
            'lunch_included' => 'required',
            'dinner_included' => 'required',
            'module_name' => 'required',
            'per_night' =>'required|gt:0'
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }
    }


        $nights =  $this->caluclateDaysorNights(date("Y-m-d", strtotime($request->start_date)), date("Y-m-d", strtotime($request->end_date)));


        if(isset($request->rooms) &&  $accommodation->type_id == 2){

            $totalroomsPrice = 0;


            $totalroomsPrice = 0;

            foreach (json_decode($request->rooms) as $roomObj) {
                $room = Room::where('id', $roomObj->room_id)->first();
                $totalroomsPrice  = $totalroomsPrice + $this->caluclateRoomPrice($room, $roomObj, $nights, $roomObj->per_room);
            }

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $this->priceCalculate($accommodation, $nights, $request->breakfast_included, $request->lunch_included, $request->dinner_included, $totalroomsPrice, 0, $request->no_of_childs);
            $this->response['data']['availability'] = true;
            return response()->json($this->response, $this->status);
        }

        $booking = Booking::where('module_id', $request->module_id)->where('module_name', 'accommodations')->where('status', 0)->where(function ($q) use ($request) {
            $q->whereBetween(
                'start_date',
                [$request->start_date, $request->end_date]
            )->orWhereBetween('end_date', [date("Y-m-d", strtotime($request->start_date)), date("Y-m-d", strtotime($request->end_date))]);
        })->first();
        if ($booking) {
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'In these days that accommodation is already booked sorry for that';
            // $this->response['availability'] = false;
            $this->response['data']['availability'] = false;
        } else {

            if ($nights  <= 0) {
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'please select valid date';
                $this->response['data']['availability'] = false;
                return response()->json($this->response, $this->status);
            }

            if (!$accommodation) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = 'Invalid accommodation id';
                $this->response['data']['availability'] = false;
                return response()->json($this->response, $this->status);
            }
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $this->priceCalculate($accommodation, $nights, $request->breakfast_included, $request->lunch_included, $request->dinner_included, 0, $request->per_night, $request->no_of_childs);

            $this->response['data']['availability'] = true;
        }
        return response()->json($this->response, $this->status);
    }

    public function checkRoomAvailability(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'start_date' => 'required',
            'end_date' => 'required',
            'qty' => 'required',
            'room_id' => 'required',
            'room_price' => 'required|gt:0',


        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }
        $RoomBooking = RoomBooking::where('room_id', $request->room_id)->where(function ($q) use ($request) {
            $q->whereBetween(
                'start_date',
                [date("Y-m-d", strtotime($request->start_date)), date("Y-m-d", strtotime($request->end_date))]
            )->orWhereBetween('end_date', [date("Y-m-d", strtotime($request->start_date)), date("Y-m-d", strtotime($request->end_date))]);
        })->first();

        if ($RoomBooking) {

            $room = Room::where('id', $request->room_id)->first();

            if (($room->qty - $room->booked_room) >= $request->qty) {
                $nights =  $this->caluclateDaysorNights(date("Y-m-d", strtotime($request->start_date)), date("Y-m-d", strtotime($request->end_date)));
                $this->response['data'] = $this->roomPriceCaluclate($request, $nights, $room, $request->room_price);
            } else {
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'In these days that room is already booked sorry for that';
                $this->response['data']['availability'] = false;
            }
        } else {
            $nights =  $this->caluclateDaysorNights(date("Y-m-d", strtotime($request->start_date)), date("Y-m-d", strtotime($request->end_date)));
            if ($nights  <= 0) {
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'please select valid date';
                $this->response['data']['availability'] = false;
                return response()->json($this->response, $this->status);
            }
            $room = Room::where('id', $request->room_id)->first();
            if (!$room) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = 'Invalid room id';
                $this->response['data']['availability'] = false;
                return response()->json($this->response, $this->status);
            }
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $this->roomPriceCaluclate($request, $nights, $room, $request->room_price);
            $this->response['data']['availability'] = true;
        }

        return response()->json($this->response, $this->status);
    }
    public function HotelAvailability($request)
    {
        $room_errors = [];
        $booking = Booking::where('module_id', $request->module_id)->where('module_name', 'accommodationrooms')->where('status', 0)->where(function ($q) use ($request) {
            $q->whereBetween(
                'start_date',
                [date("Y-m-d", strtotime($request->start_date)), date("Y-m-d", strtotime($request->end_date))]
            )->orWhereBetween('end_date', [date("Y-m-d", strtotime($request->start_date)), date("Y-m-d", strtotime($request->end_date))]);
        })->first();
        if ($booking) {
            foreach ($request->rooms as $singleroom) {
                $RoomBooking = RoomBooking::where('room_id', $singleroom)->where(function ($q) use ($request) {
                    $q->whereBetween(
                        'start_date',
                        [date("Y-m-d", strtotime($request->start_date)), date("Y-m-d", strtotime($request->end_date))]
                    )->orWhereBetween('end_date', [date("Y-m-d", strtotime($request->start_date)), date("Y-m-d", strtotime($request->end_date))]);
                })->first();
                if ($RoomBooking) {
                    $room = Room::where('id', $singleroom)->first();
                    if (($room->qty - $room->booked_room) >= $request->room_qty) {
                        echo 'we can book room , please caluclate its price';
                    } else {
                        array_push($room_errors, $room->title . "room already already book some others");
                    }
                }
            }
            if (empty($room_errors)) {
            }
        }
    }
    public function deleteAccomodationService($id)
    {
        try {
            $accommodation = Accommodation::where('id', $id)
                ->first();
            if ($accommodation) {
                $accommodation->images()->delete();
                $accommodation->places()->delete();
                $accommodation->rules()->delete();
                $accommodation->ratings()->delete();
                $accommodation->delete();
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'Service Deleted Successfully';
                return response()->json($this->response, $this->status);
            } else {
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = "Service Does't Exist";
                return response()->json($this->response, $this->status);
            }
        } catch (Exception $e) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $e;
            return response()->json($this->response, $this->status);
        }
    }
    public function deleteService($module, $id)
    {
        try {
            $data = $this->deleteServices($module, $id);
            if ($data == true) {
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'Service Deleted Successfully';
                return response()->json($this->response, $this->status);
            } else {
                $this->status = 200;
                $this->response['success'] = false;
                $this->response['message'] = "Service Doesn't Exist";
                return response()->json($this->response, $this->status);
            }
        } catch (Exception $e) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $e;
            return response()->json($this->response, $this->status);
        }
    }
}
