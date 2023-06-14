<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;
use App\Models\Accommodation;
use App\Models\CancellationPolicy;
use App\Models\UserActivity;
use App\Models\Host;
use App\Models\User;
use App\Models\Image as modelImage;
use App\Models\Transport;
use App\Models\Experience;
use App\Models\Meal;
use App\Models\FacilityAccommodation;
use App\Models\TransportFeature;
use App\Models\UserPaymentMethodDetail;

use App\Models\Rule;
use App\Models\Slot;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Room;
use App\Models\Country;
use App\Models\Guide;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image;
use DB;
use App\Models\RatingValues;
use App\Libs\Image\Optimizer;



class HostController extends Controller
{
    protected $status = 200;
    protected $response = [];
    protected $model;

    private $moduleBinding = [
        'accommodations' => Accommodation::class,
        'transports' => Transport::class,
        'meals' => Meal::class,
        'experiences' => Experience::class,
        'guides' => Guide::class,
        'undefined' => Guide::class,
        'trip_operators' => Guide::class,
        'photographers' => Guide::class,
        'travel_agency' => Guide::class,
        'user_profile' => Guide::class,
        'movie_makers' => Guide::class,
        'visa_consultants' => Guide::class,
        'home_cheff' => Guide::class,
    ];

    public function model()
    {
        return Host::class;
    }

    public function index(Request $request)
    {

        $reviewRating = isset($request->reviewRating) ? $request->reviewRating : '';
        $verify = isset($request->verify) ? $request->verify : '';
        $gender = isset($request->gender) ? ucwords($request->gender) : '';

        $distance_result = '';
        $rad = 50;
        $lat = 0;
        $lng = 0;
        if (isset($request->lat) && !empty($request->lat) && isset($request->lng) && !empty($request->lng)) {
            $lat = round($request->lat, 8);
            $lng = round($request->lng, 8);
            $rad = isset($request->radius) ? (int)$request->radius : 0;

            $rad = floor($rad / 1000);

            $distance_result = 'ROUND(DEGREES(ACOS(SIN(RADIANS('.$lat.'))
                    * SIN(RADIANS(lat))
                    + COS(RADIANS('.$lat.'))
                    * COS(RADIANS(lat))
                    * COS(RADIANS('.$lng.' - lng)))) * 69.09)';
        }

        if (!empty($request)) {
            $data = User::with(['ServiceProviderRates','trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])->withAvg('rating_values', 'average_rating')->where('type', 2)->where(function ($query) use ($reviewRating, $verify, $gender, $rad,$distance_result) {

                if($gender){
                    $query->where('gender', $gender);
                }
                if (!empty($verify)) {
                    $query->Where('verified', $verify);
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
                ->when(!$lat || !$lng, function ($q)  use ($distance_result) {
                    $q->addSelect(\DB::raw("0 as distance"));
                })

                ->when($reviewRating, function ($rating){

                    $rating->having('rating_values_avg_average_rating', 5);

                })

                ->orderBy('ratings_count', 'DESC')->paginate(Config::get('global.pagination_records'));
        }  else {
            $data = User::with(['ServiceProviderRates','trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])->withAvg('rating_values', 'average_rating')->where('type', 2)->orderBy('ratings_count', 'DESC')->paginate(Config::get('global.pagination_records'));
        }


        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        return response()->json($this->response, $this->status);

    }

    public function detail($Id)
    {   
        if(!empty($Id) && $user = User::find($Id)){
            request()->type = $user->type;
        }

        $detail =  User::with(['ServiceProviderRates','trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])->with('activity')
                    ->withAvg('rating_values', 'average_rating')
                    ->withAvg('trips_vendor_ratings', 'rating_value')
                    ->where('id', $Id)->first();

        if (!$detail) {
            $this->status = 200;
            $this->response['success'] = false;
            $this->response['message'] = 'invalid Id';
            return response()->json($this->response, $this->status);
        }

        $relatedData =   User::with(['ServiceProviderRates','trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])->withAvg('rating_values', 'average_rating')->take(4)->orderBy('id', 'DESC')->get();
        $accCount = Accommodation::where('user_id', $Id)->where('is_publish', 1)->where('status', 1)->count();

        $activityCount = Experience::where('user_id', $Id)->where('is_publish', 1)->where('status', 1)->count();
        //pass user id and change table
        $transportCount = Transport::where('user_id', $Id)->where('is_publish', 1)->where('status', 1)->count();
        //pass user id and change table
        $mealCount = Meal::where('user_id', $Id)->where('is_publish', 1)->where('status', 1)->count();


        $accoRatingCount = RatingValues::where('provider_id', $Id)->where('module_name', 'accommodations')->count();
        $accoAvegRatingCount = RatingValues::where('provider_id', $Id)->where('module_name', 'accommodations')->avg('average_rating');
        $activityRatingCount = RatingValues::where('provider_id', $Id)->where('module_name', 'experiences')->count();
        $activityAvegRatingCount = RatingValues::where('provider_id', $Id)->where('module_name', 'experiences')->avg('average_rating');
        $transportRatingCount = RatingValues::where('provider_id', $Id)->where('module_name', 'transports')->count();
        $transportAvegRatingCount = RatingValues::where('provider_id', $Id)->where('module_name', 'transports')->avg('average_rating');
        $mealRatingCount = RatingValues::where('provider_id', $Id)->where('module_name', 'meals')->count();
        $mealAvegRatingCount = RatingValues::where('provider_id', $Id)->where('module_name', 'meals')->avg('average_rating');

        $accommodations = [];
        if ($accCount > 0) {
            $accommodations = Accommodation::withAvg('rating_values', 'average_rating')->with('images')->where('user_id', $Id)->take(5)->get();
        }
        $activities = [];
        if ($activityCount > 0) {
            $activities = Experience::with('images')->where('user_id', $Id)->take(5)->get();
        }
        $transports = [];
        if ($transportCount > 0) {
            $transports = Transport::with('images')->where('user_id', $Id)->take(5)->get();
        }
        $meals = [];
        if ($mealCount > 0) {
            $meals = Meal::with('images')->where('user_id', $Id)->take(5)->get();
        }
        //print_r($detail);exit;
        $detail->relatedData =  $relatedData;

        $detail->accommodationAccount =  $accCount;
        $detail->activityCount =  $activityCount;
        $detail->mealCount =  $mealCount;
        $detail->transportCount =  $transportCount;
        $detail->accommodations = $accommodations;
        $detail->experiences = $activities;
        $detail->meals = $meals;
        $detail->transports = $transports;
        $detail->accoRatingCount = $accoRatingCount;
        $detail->accoAvegRatingCount = $accoAvegRatingCount;
        $detail->activityRatingCount = $activityRatingCount;
        $detail->activityAvegRatingCount = $activityAvegRatingCount;
        $detail->transportRatingCount = $transportRatingCount;
        $detail->transportAvegRatingCount = $transportAvegRatingCount;
        $detail->mealRatingCount = $mealRatingCount;
        $detail->mealAvegRatingCount = $mealAvegRatingCount;


        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $detail;
        return response()->json($this->response, $this->status);
    }

    public function host_dashboard(Request $request)
    {
        $detail =  User::with(['ServiceProviderRates','trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])->with('activity')->where('id', $request->user()->id)->first();
        if ($detail->country == null) {
            $detail->country = '';
        }
        if ($detail->city == null) {
            $detail->country = '';
        }
        $detail->tripsCount = 100;
        $detail->comments = 100;
        $detail->tripFriends = 29;
        $detail->feedbacks = 400;
        $accommodationCount =  Accommodation::where('user_id', $request->user()->id)->count();
        $activityCount = Experience::where('user_id', $request->user()->id)->count(); //pass user id and change table
        $vechileCount = Transport::where('user_id', $request->user()->id)->count(); //pass user id and change table
        $mealCount = Meal::where('user_id', $request->user()->id)->count();
        $detail->accommodationCount = $accommodationCount;
        $detail->activityCount = $activityCount;
        $detail->vechileCount = $vechileCount;
        $detail->mealCount = $mealCount;
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $detail;

        return response()->json($this->response, $this->status);
    }

    public function host_accommodation(Request $request)

    {

        if(isset($request->page_type) && $request->page_type == "public_profile"){
            $accommodations = Accommodation::with('singleImage')
                ->withAvg('rating_values', 'average_rating')
                ->withAvg('trips_vendor_ratings', 'rating_value')
                ->where('user_id', $request->id)->where('is_publish',1)->where('status', 1)->orderBy('id', 'DESC')->paginate(14);
        }else{
            $accommodations = Accommodation::with('singleImage')
                ->withAvg('rating_values', 'average_rating')
                ->withAvg('trips_vendor_ratings', 'rating_value')
                ->where('user_id', $request->id)->orderBy('id', 'DESC')->paginate(14);
        }



        if ($accommodations->count() <= 0) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Result Not Found.';
        }
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = array('accommodations' => $accommodations);
        return response()->json($this->response, $this->status);
    }

    public function addAccommodation(Request $request)
    {
        $accommodation = new Accommodation;
        // $validator = Validator::make($request->all(), [
        //     'title' => 'required|max:255',
        //     'propertyType' => 'required',
        //     'subType' => 'required',
        //     'isProperty' => 'required',
        //     'noOfGuest' => 'required|integer',
        //     'checkInTime' => 'required',
        //     'checkOutTime' => 'required',
        //     'location' => 'required',
        // ]);
        // if ($validator->fails()) {
        //     $this->status = 422;
        //     $this->response['success'] = false;
        //     $this->response['message'] = $validator->messages()->first();
        //     return response()->json($this->response, $this->status);
        // }
        if (isset($request->title)) {
            $accommodation->title           = $request->title;
        }
        if(auth()->user() && !empty(auth()->user()->user_module_type) && auth()->user()->user_module_type == 'hotels'){
            $request->type_id = 2;
            $accommodation->type_id = 2;
        }
        if (isset($request->type_id)) {
            $accommodation->type_id = $request->type_id;
        }
        if (isset($request->propertyType)) {
            $accommodation->type_name      = $request->propertyType;
        }
        if (isset($request->sub_type_id)) {
            $accommodation->sub_type_id       = $request->sub_type_id;
        }
        if (isset($request->subType)) {
            $accommodation->sub_type_name  = $request->subType;
        }
        if (isset($request->noOfGuest)) {
            $accommodation->no_of_people   = $request->noOfGuest;
        }
        if (isset($request->isProperty)) {
            $accommodation->is_property  =  $request->isProperty;
        }
        $accommodation->user_id = $request->user()->id;

        //$accommodation->check_in_time = $request->checkInTime;

        if (isset($request->checkInTime) && strlen($request->checkInTime) == 5) {
            $accommodation->check_in_time       = $request->checkInTime . ':00';
        } elseif (isset($request->opening_time)) {
            $accommodation->check_in_time       = $request->checkInTime;
        }

        if (isset($request->checkOutTime) && strlen($request->checkOutTime) == 5) {
            $accommodation->check_out_time = $request->checkOutTime . ':00';
        } elseif (isset($request->checkOutTime)) {
            $accommodation->check_out_time = $request->checkOutTime;
        }
        if (isset($request->isFlexiableCheckIn)) {
            $accommodation->is_flexiable_check_in       = $request->isFlexiableCheckIn;
            if (isset($request->isFlexiableCheckInValue)) {
                $accommodation->is_flexiable_check_in_value               = $request->isFlexiableCheckInValue;
            }
        }
        if (isset($request->isEnquiry)) {
            $accommodation->is_enquiry_before_reservation               = $request->isEnquiry;
            if (isset($request->isEnquiryValue)) {
                $accommodation->is_enquiry_before_reservation_value      = $request->isEnquiryValue;
            }
        }

        if (isset($request->latitude)) {
            $accommodation->lat       = round($request->latitude, 8);
        }
        if (isset($request->longitude)) {
            $accommodation->lng       = round($request->longitude, 8);
        }
        if (isset($request->location)) {
            $accommodation->location        = $request->location;
        }
        if (isset($request->city)) {
            $accommodation->city           = $request->city;
        }
        if (isset($request->country)) {
            $accommodation->country           = $request->country;
        }


        if ($accommodation->save()) {

            // Create Accomodation Notification push.
            $title = "Accommodation";
            $message = "Accommodation service created successfully";
            $action = "/host/accommodations/detail/".$accommodation->id;
            $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();
            
            if(isset($admin) && !empty($admin)){

                PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_ACCOMMODATION,$action,$accommodation->id);

                $message = "New Accommodation service has been created";
                PushNotification::createNotification($admin,auth()->user()->id,$title,$message,User::TYPE_ACCOMMODATION,$action,$accommodation->id);

            }

            CancellationPolicy::forceCreate([
                'bookable_id' => $accommodation->id,
                'cancellation_hour' => '96',
                'refund_percentage' => '100',
                'module_name' => 'accommodations',
                'bookable' => Accommodation::class
            ]);

            CancellationPolicy::forceCreate([
                'bookable_id' => $accommodation->id,
                'cancellation_hour' => '72',
                'refund_percentage' => '75',
                'module_name' => 'accommodations',
                'bookable' => Accommodation::class
            ]);

            CancellationPolicy::forceCreate([
                'bookable_id' => $accommodation->id,
                'cancellation_hour' => '48',
                'refund_percentage' => '50',
                'module_name' => 'accommodations',
                'bookable' => Accommodation::class
            ]);



            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $accommodation;
        }

        return response()->json($this->response, $this->status);
    }

    public function updateAccommodation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'accommodation_id' => 'required',
            'noOfGuest' => 'integer'
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $accommodation = Accommodation::with('images')->where('user_id', $request->user()->id)->where('id', $request->accommodation_id)->first();
        if (!$accommodation) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid accommodation id';
            return response()->json($this->response, $this->status);
        }
        // Create Accomodation Notification push.
        $title = "Accommodation";
        $message = "Accommodation service updated successfully.To view detail";
        $action = "/host/accommodations/detail/".$accommodation->id;
        $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();


        if (isset($request->is_publish)) {

            $validator = Validator::make($accommodation->toArray(), [
                'type_id' => 'required',
                'sub_type_name' => 'required',
                'title' => 'required',
                'no_of_rooms' => 'required',
                'location' => 'required',
                'detail_location' => 'required',
                'no_of_people' => 'required',
                'check_in_time' => 'required',
                'check_out_time' => 'required',
                'age_limit_for_child_free' => 'required',
                'description' => 'required'
            ]);
            if ($validator->fails()) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = $validator->messages()->first();
                return response()->json($this->response, $this->status);
            }
            //new validation added server side for specially mobile end
            $accommodation->is_publish    = $request->is_publish;
            $accommodation->status =1;
            $title = "Accommodation";
            $message = "Accommodation service published successfully.To view detail";
            $action = "/host/accommodations/detail/".$accommodation->id;
            $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();


            if(isset($admin) && !empty($admin)){
                PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_ACCOMMODATION,$action,$accommodation->id);
                PushNotification::createNotification($admin,auth()->user()->id,$title,$message,User::TYPE_ACCOMMODATION,$action,$accommodation->id);
            }


        }
        if (isset($request->status)) {
            $accommodation->status    = $request->status;

        }
        if (isset($request->detail_location)) {
            $accommodation->detail_location    = $request->detail_location;

        }

        if (isset($request->type_id)) {
            $accommodation->type_id           = $request->type_id;
        }
        if (isset($request->propertyType)) {
            $accommodation->type_name      = $request->propertyType;
        }
        if (isset($request->sub_type_id)) {
            $accommodation->sub_type_id       = $request->sub_type_id;
        }
        if (isset($request->subType)) {
            $accommodation->sub_type_name  = $request->subType;
        }
        if (isset($request->noOfGuest)) {
            $accommodation->no_of_people   = $request->noOfGuest;
        }
        if (isset($request->isProperty)) {
            $accommodation->is_property  =  $request->isProperty;
        }
        if (isset($request->rating)) {
            $accommodation->rating  =  $request->rating;
        }
        if (isset($request->guest_limit_price)) {
            $accommodation->guest_limit_price  =  $request->guest_limit_price;
        }
        if (isset($request->checkInTime) && strlen($request->checkInTime) == 5) {

            $accommodation->check_in_time       = $request->checkInTime . ':00';
        } elseif (isset($request->checkInTime)) {
            $accommodation->check_in_time       = $request->checkInTime;
        }

        if (isset($request->checkOutTime) && strlen($request->checkOutTime) == 5) {
            $accommodation->check_out_time = $request->checkOutTime . ':00';
        } elseif (isset($request->checkOutTime)) {
            $accommodation->check_out_time = $request->checkOutTime;
        }


        if (isset($request->isFlexiableCheckIn)) {
            $accommodation->is_flexiable_check_in       = $request->isFlexiableCheckIn;
        }
        if (isset($request->isFlexiableCheckInValue)) {
            $accommodation->is_flexiable_check_in_value = $request->isFlexiableCheckInValue;
        }
        if (isset($request->isEnquiry)) {
            $accommodation->is_enquiry_before_reservation = $request->isEnquiry;
        }
        if (isset($request->isEnquiryValue)) {
            $accommodation->is_enquiry_before_reservation_value = $request->isEnquiryValue;
        }
        if (isset($request->latitude)) {
            $accommodation->lat     = round($request->latitude, 8);
        }
        if (isset($request->longitude)) {
            $accommodation->lng  = round($request->longitude, 8);
        }
        if (isset($request->location)) {
            $accommodation->location        = $request->location;
        }
        if (isset($request->city)) {
            $accommodation->city           = $request->city;
        }
        if (isset($request->country)) {
            $accommodation->country           = $request->country;
        }
        if (isset($request->checkedFacilities)) {
            $data = [];
            FacilityAccommodation::where('accommodation_id', $request->accommodation_id)->delete();
            $response = explode(',', $request->checkedFacilities);
            foreach ($response as $row) {
                $facility_explode = explode('|', $row);
                array_push($data, ['name' => $facility_explode[0], 'accommodation_id' => $request->accommodation_id, 'icon' => $facility_explode[1], 'facilityType' => 'Accommodation']);
            }
            FacilityAccommodation::insert($data);
        }
        if (isset($request->title)) {
            $accommodation->title = $request->title;
        }
        if (isset($request->no_of_rooms)) {
            $accommodation->no_of_rooms = $request->no_of_rooms;
        }
        if (isset($request->description)) {
            $accommodation->description  = $request->description;
        }
        if (isset($request->per_night)) {
            $accommodation->per_night = $request->per_night;
        }
        if (isset($request->min_stay)) {
            $accommodation->min_stay = $request->min_stay;
        }
        if (isset($request->max_stay)) {
            $accommodation->max_stay = $request->max_stay;
        }
        if (isset($request->phone)) {
            $accommodation->phone = $request->phone;
        }
        if (isset($request->stars)) {
            $accommodation->stars = $request->stars;
        }
        if (isset($request->rating)) {
            $accommodation->rating = $request->rating;
        }
        if (isset($request->status)) {
            $accommodation->status = $request->status;
        }
        if (isset($request->main_features)) {
            $accommodation->main_features = $request->main_features;
        }
        if (isset($request->entire_accomodation)) {
            $accommodation->entire_accomodation    = $request->entire_accomodation;
        }
        if (isset($request->cancellation_policy)) {
            $accommodation->cancellation_policy    = $request->cancellation_policy;
        }
        if (isset($request->important_info)) {
            $accommodation->important_info = $request->important_info;
        }
        if (isset($request->is_pre_arrival_notice_value)) {
            $accommodation->is_pre_arrival_notice_value    = $request->is_pre_arrival_notice_value;
        }
        if (isset($request->no_of_attach_bath)) {
            $accommodation->no_of_attach_bath = $request->no_of_attach_bath;
        }
        if (isset($request->no_of_share_bath)) {
            $accommodation->no_of_share_bath = $request->no_of_share_bath;
        }
        if (isset($request->cleaning_fee)) {
            $accommodation->cleaning_fee = $request->cleaning_fee;
        }
        if (isset($request->service_fee)) {
            $accommodation->service_fee     = $request->service_fee;
        }
        if (isset($request->personal_belongings_assets)) {
            $accommodation->personal_belongings_assets = $request->personal_belongings_assets;
        }
        if (isset($request->rules)) {
            $data = [];
            Rule::where('module_id', $request->accommodation_id)->where('module_name', 'accommodations')->delete();
            $response = explode(',', $request->rules);
            foreach ($response as $row) {
                array_push($data, ['name' => $row, 'module_id' => $request->accommodation_id, 'module_name' => 'accommodations']);
            }
            Rule::insert($data);
        }
        if (isset($request->places_allow_for_use_guest)) {
            $accommodation->places_allow_for_use_guest = $request->places_allow_for_use_guest;
        }
        if (isset($request->payment_mode)) {
            $accommodation->payment_mode = $request->payment_mode;
        }
        if (isset($request->payment_partial_value)) {
            $accommodation->payment_partial_value = $request->payment_partial_value;
        }

        if (isset($request->weeklyDiscount)) {
            $accommodation->discount_for_one_week = $request->weeklyDiscount;
        }
        if (isset($request->fifteenDayDiscount)) {
            $accommodation->discount_for_two_week = $request->fifteenDayDiscount;
        }
        if (isset($request->monthlyDiscount)) {
            $accommodation->discount_for_monthly     = $request->monthlyDiscount;
        }


        if (isset($request->is_offer_promotion_discount)) {
            $accommodation->is_offer_promotion_discount     = $request->is_offer_promotion_discount;
            $accommodation->promotion_discount     = $request->promotion_discount;
        }

        if (isset($request->isProvideBreakfast)) {
            $accommodation->isProvideBreakfast     = $request->isProvideBreakfast;
        }
        if (isset($request->breakfast_included)) {
            $accommodation->breakfast_included     = $request->breakfast_included;
        }
        if (isset($request->breakfast_price)) {
            $accommodation->breakfast_price     = $request->breakfast_price;
        }
        if (isset($request->breakfast_description)) {
            $accommodation->breakfast_description     = $request->breakfast_description;
        }
        if (isset($request->isProvideLunch)) {
            $accommodation->isProvideLunch     = $request->isProvideLunch;
        }
        if (isset($request->lunch_included)) {
            $accommodation->lunch_included     = $request->lunch_included;
        }
        if (isset($request->lunch_price)) {
            $accommodation->lunch_price     = $request->lunch_price;
        }
        if (isset($request->lunch_description)) {
            $accommodation->lunch_description     = $request->lunch_description;
        }
        if (isset($request->isProvideDinner)) {
            $accommodation->isProvideDinner     = $request->isProvideDinner;
        }
        if (isset($request->dinner_included)) {
            $accommodation->dinner_included     = $request->dinner_included;
        }
        if (isset($request->dinner_price)) {
            $accommodation->dinner_price     = $request->dinner_price;
        }
        if (isset($request->dinner_description)) {
            $accommodation->dinner_description     = $request->dinner_description;
        }

        if (isset($request->ageLimitForChild)) {
            $accommodation->age_limit_for_child    = $request->ageLimitForChild;
        }
        if (isset($request->ageLimitFreeChild)) {
            $accommodation->age_limit_for_child_free = $request->ageLimitFreeChild;
        }
        if (isset($request->childDiscount)) {
            $accommodation->child_discount    = $request->childDiscount;
        }
        if (isset($request->paymentMode)) {
            $accommodation->payment_mode    = $request->paymentMode;
        }
        if (isset($request->partialAmountVal)) {
            $accommodation->payment_partial_value    = $request->partialAmountVal;
        }
        // update Accomodation Notification push.
        // if(isset($admin) && !empty($admin)){
        //     PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_ACCOMMODATION,$action,$accommodation->id);

        //     $message = "Accommodation service updated.";

        //     PushNotification::createNotification($admin,auth()->user()->id,$title,$message,User::TYPE_ACCOMMODATION,$action,$accommodation->id);
        // }

        if ($accommodation->save()) {


            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Updated Successfully';
            $this->response['data'] = $accommodation;
        } else {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'SomeThing Went Wrong!.';
        }
        return response()->json($this->response, $this->status);
    }

    public function uploadImages(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,NEF,nef,svg|max:5120',
            'module_id' => 'required',
            'module' => 'required',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }
        try {
            if ($files = $request->file('image')) {
                $image_full_name = pathinfo($files->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('/assets/uploads/' . $request->module); //Creating Sub directory in Public
                $img = \Image::make($files->getRealPath());
                $width = getimagesize($files)[0];
                $height = getimagesize($files)[1];
                if ($width > 3000) {
                    $width = $width / 4;
                    $height = $height / 4;
                }
                if ($width > 2000) {
                    $width = $width / 3;
                    $height = $height / 3;
                }
                if ($width > 1000) {
                    $width = $width / 2;
                    $height = $height / 2;
                }

                $img->resize($width, $height, function ($constraint) {
                    // $img->resize(400, 150, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $image_full_name);


                $file = $destinationPath . '/' . $image_full_name;
                if(file_exists($file)){
                    Optimizer::optimize($file);
                }


                $alreadyExist = modelImage::where('module_id', $request->module_id)->where('module', $request->module)->where('type', 'main')->first();
                if ($alreadyExist) {
                    $data = new modelImage;
                    $data->name = $image_full_name;
                    $data->type = 'normal';
                    $data->module = $request->module;
                    $data->module_id = $request->module_id;
                    if ($data->save()) {
                        $this->status = 200;
                        $this->response['success'] = true;
                        $this->response['message'] = 'Updated Successfully';
                        $this->response['imagePath'] = $image_full_name;
                        $this->response['data'] = $data;
                    } else {
                        $this->status = 422;
                        $this->response['success'] = false;
                        $this->response['message'] = 'SomeThing Went Wrong!.';
                    }
                    return response()->json($this->response, $this->status);
                } else {
                    $data = new modelImage;
                    $data->name = $image_full_name;
                    $data->type = 'main';
                    $data->module = $request->module;
                    $data->module_id = $request->module_id;
                    if ($data->save()) {
                        $this->status = 200;
                        $this->response['success'] = true;
                        $this->response['message'] = 'Updated Successfully';
                        $this->response['imagePath'] = $image_full_name;
                        $this->response['data'] = $data;
                    } else {
                        $this->status = 422;
                        $this->response['success'] = false;
                        $this->response['message'] = 'SomeThing Went Wrong!.';
                    }
                    return response()->json($this->response, $this->status);
                    //,array('Content-Type'=>'charset=utf-8' )
                }
            }
        } catch (Exception $e) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = "Image Size is greater than 2 MB";
            return response()->json($this->response, $this->status);
        }
    }

    public function getPaymentMethodDetails(){

        $user = Auth::user();
        if($user){
            $paymentDetail = UserPaymentMethodDetail::where('user_id', $user->id)->first();
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Payment detail fetched successfully';
            $this->response['data'] = $paymentDetail;
            return response()->json($this->response, $this->status);
        }else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Unauthenticated';
            return response()->json($this->response, $this->status);
        }
    }

    public function paymentMethodsCreateUpdate(Request $request){
        $user = Auth::user();
        if($user){
            $bank_name = isset($request->bank_name) ? $request->bank_name : '';
            $bank_account_title = isset($request->bank_account_title) ? $request->bank_account_title : '';
            $bank_account_number = isset($request->bank_account_number) ? $request->bank_account_number : '';

            $jazzcash_holder_title = isset($request->jazzcash_holder_title) ? $request->jazzcash_holder_title : '';
            $jazz_cash_number = isset($request->jazz_cash_number) ? $request->jazz_cash_number : '';


            $easy_paisa_holder_title = isset($request->easy_paisa_holder_title) ? $request->easy_paisa_holder_title : '';
            $easy_paisa_number = isset($request->easy_paisa_number) ? $request->easy_paisa_number : '';

            $sada_pay_holder_title = isset($request->sada_pay_holder_title) ? $request->sada_pay_holder_title : '';
            $sada_pay_number = isset($request->sada_pay_number) ? $request->sada_pay_number : '';


            $paymentMethod = UserPaymentMethodDetail::updateOrCreate(
                [ 'id' => $request->id ],
                [ 'bank_name' => $bank_name,
                    'bank_account_title' => $bank_account_title,
                    'bank_account_number' => $bank_account_number,
                    'jazzcash_holder_title' => $jazzcash_holder_title,
                    'jazz_cash_number' => $jazz_cash_number,
                    'easy_paisa_holder_title' => $easy_paisa_holder_title,
                    'easy_paisa_number' => $easy_paisa_number,
                    'sada_pay_holder_title' => $sada_pay_holder_title,
                    'sada_pay_number' => $sada_pay_number,
                    'user_id' => $user->id,
                ]
            );

            if($request->id){
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'updated successfully.';
                $this->response['data'] = $paymentMethod;

                return response()->json($this->response, $this->status);
            }

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Created successfully.';
            $this->response['data'] = $paymentMethod;
        }else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'unauthenticated';
        }

        return response()->json($this->response, $this->status);
    }

    public function updateOrCreateRoom(Request $request)
    {

        if (count($request->all()) > 0) {
            $validator = Validator::make($request->all(), [
                'accommodation_id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = $validator->messages()->first();
                return response()->json($this->response, $this->status);
            }
            $accommodation = Accommodation::where('id', $request->accommodation_id)->first();

            $room = Room::updateOrCreate(
                [ 'id' => $request->room_id ],
                [ 'title' => $request->title,
                    'room_type' => $request->room_type,
                    'room_facilities' => $request->room_facilities,
                    'price' => $request->price,
                    'extra_guest_price' => $request->extra_guest_price,
                    'guest_limit' => $request->guest_limit,
                    'staying_capacity' => $request->staying_capacity,
                    'description' => $request->description,
                    'is_attach_bath' => $request->is_attach_bath,
                    'accommodation_id' => $request->accommodation_id,
                    'bed_types' => $request->bed_types,
                    'room_size' => $request->room_size,
                    'no_of_beds' => $request->no_of_beds,
                    'status' => 1,
                    'qty'=>$request->qty,
                ]
            );

            if($request->room_id){
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'Room updated successfully.';
                $this->response['data'] = $room;
                if($accommodation->type_id == 2){
                    $accommodation->per_night  = DB::table('rooms')->where('accommodation_id',$accommodation->id)->min('price');
                    $accommodation->save();
                }
                return response()->json($this->response, $this->status);
            }
            if($accommodation->type_id == 2){
                $accommodation->per_night  = DB::table('rooms')->where('accommodation_id',$accommodation->id)->min('price');
                $accommodation->save();
            }
            $title = "Rooms";
            $message = "New rooms added successfully";
            $action = "user/setting";
            $admin = User::where('id',User::ADMIN_ID)->first();

            if(isset($admin) && !empty($admin)){
                PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_ACCOMMODATION,$action);
            }

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Room added successfully.';
            $this->response['data'] = $room;
            $accommodation->no_of_rooms_created = $accommodation->no_of_rooms_created + 1;
            $accommodation->save();
        } else {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Please Input Data Properly.';
        }

        return response()->json($this->response, $this->status);
    }

    public function getRooms($accommodation_id)
    {

        $this->response['success'] = true;
        $this->response['data'] = Room::with(['images','singleImage','facilities'])->where('accommodation_id', $accommodation_id)->get();
        return response()->json($this->response, $this->status);
    }

    public function getAvailableRooms(Request $request)
    {
        $request->date_to = (isset($request->date_to) && $request->date_to != 'Invalid date') ? $request->date_to : '';
        $request->date_from = (isset($request->date_from) && $request->date_from != 'Invalid date') ? $request->date_from : '';

        $accommodation = Accommodation::find($request->accommodation_id);
        if($accommodation->type_id != 2){
            $this->response['success'] = true;
            $this->response['data'] = Room::with(['images','singleImage','facilities'])->where('accommodation_id', $request->accommodation_id)->get();
            return response()->json($this->response, $this->status);
        }else {
            $unavailableRoomIds = [];
            $rooms = Room::where('accommodation_id', $request->accommodation_id)->get();

            $quantityAvailable = [];
            foreach($rooms as $room){

                $reservation = Reservation::whereJsonContains('booking_detail->data->rooms', [['id' => $room->id]])
                    ->where('date_from', '<=', $request->date_to . ' 12:00:00' ?? \Carbon\Carbon::now()->addDays(1))
                    ->where(\DB::raw("CAST(DATE_FORMAT(date_to, '%Y-%m-%d 12:00:00') as datetime)"), '>', \Carbon\Carbon::create($request->date_from)->addDays(1) ?? \Carbon\Carbon::now())->where('status', 7)->get();

                // $reservation = Reservation::whereJsonContains('booking_detail->data->rooms', [['id' => $room->id]])
                //     ->where('date_from', '<=', $request->date_to . ' 23:59:59' ?? \Carbon\Carbon::now()->addDays(1))
                //     ->where(\DB::raw("CAST(DATE_FORMAT(date_to, '%Y-%m-%d 23:59:59') as datetime)"), '>', \Carbon\Carbon::create($request->date_from)->addDays(1) ?? \Carbon\Carbon::now())->where('status', 7)->get();
                $totalReserved = 0;
                foreach($reservation as $item) {
                    $r = collect($item->booking_detail['data']['rooms']);
                    $totalReserved += $r->where('id', $room->id)->sum('roomQuantity');
                }
                if($room->qty <= $totalReserved){
                    $unavailableRoomIds[] = $room->id;
                }
                $quantityAvailable[$room->id] = $room->qty - $totalReserved;
            }

            $this->response['success'] = true;
            $this->response['data'] = Room::with(['images','singleImage','facilities'])
                ->where('accommodation_id', $request->accommodation_id)

                // ->whereNotIn('id', $unavailableRoomIds)
                // ->select("*")
                // ->when($unavailableRoomIds, function($q){
                //     $q->addSelect(\DB::raw("(case when 1=0 then 1 else 0 end) as available"));
                // })->select("*")
                // ->when(!$unavailableRoomIds, function($q){
                //     $q->addSelect(\DB::raw("(case when 1=0 then 1 else 0 end) as available"));
                // })
                ->get()->each(function($item) use($quantityAvailable) {
                    if($quantityAvailable[$item->id] ?? false){
                        $item->quantityAvailable = $quantityAvailable[$item->id];
                    }
                    else {
                        $item->quantityAvailable = 0;
                    }
                });
            return response()->json($this->response, $this->status);
        }
    }

    public function getRoomDetail($room_id){

        $room = Room::with(['images','singleImage','facilities'])->where('id', $room_id)->first();

        $this->status = 200;
        $this->response['success'] = false;
        $this->response['message'] = 'Room fetched successfully';
        $this->response['data'] = $room;
        return response()->json($this->response, $this->status);

    }

    public function deleteRoom($room_id)
    {
        $user = Auth::user();
        $this->status = 422;
        $this->response['success'] = false;
        $this->response['message'] = 'Unauthenticated User';

        if($user){
        $room = Room::where('id', $room_id)->first();

        if($room){
            $roomExist = Accommodation::where('id', $room->accommodation_id)->where('user_id',$user->id)->first();
            if($roomExist){
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'Room Deleted Successfully.';
                Room::where('id', $room_id)->delete();
                FacilityAccommodation::where('room_id', $room_id)->delete();
                 return response()->json($this->response, $this->status);
            }
        }
        $this->status = 422;
        $this->response['success'] = false;
        $this->response['message'] = 'invalid room id';
        return response()->json($this->response, $this->status);

        }
        return response()->json($this->response, $this->status);

    }

    public function deleteImage($image_id)
    {
        $modelImage = modelImage::where('id', $image_id)->first();
        if(!empty($modelImage)){
            $moduleId = $modelImage->module_id;
            $module = $modelImage->module;

            $image_path = public_path() . '/assets/uploads/' . $modelImage->module . '/' . $modelImage->name;
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            if($modelImage){
                $modelImage->delete();
            }
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = modelImage::where('module_id', $moduleId)->where('module', $module)->get() ?? [];
            $this->response['message'] = 'Image Deleted Successfully';
            return response()->json($this->response, $this->status);
        }
        $this->status = 422;
        $this->response['success'] = false;
        $this->response['message'] = 'image id/module missing';
        return response()->json($this->response, $this->status);

    }

    public function addRule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rule' => 'required',
            'module_id' => 'required|integer',
            'module_name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        // $bookable = (new $this->moduleBinding[$request->module_name])->where('user_id', $request->user()->id)->where('id', $request->module_id)->first();

        // if($request->module_name == null){
        //     $bookable = Guide::where('user_id', $request->user()->id)->where('id', $request->module_id)->first();
        // }

        // if(!$bookable) {
        //     $this->status = 422;
        //     $this->response['success'] = false;
        //     $this->response['message'] = 'Invalid bookable';
        //     return response()->json($this->response,$this->status);
        // }

        $rule = Rule::where('name', $request->rule)->where('module_id', $request->module_id)->where('module_name', $request->module_name)->first();

        if ($rule != null) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Rule already existed.';
            return response()->json($this->response, $this->status);
        }
        if ($request->rule_id) {
            return $this->updateRule($request);
        }

        $rule = new Rule;
        $rule->name = $request->rule;
        $rule->module_id = $request->module_id;
        $rule->module_name = $request->module_name;
        if ($rule->save()) {

            $rules = Rule::where('module_id', $request->module_id)->where('module_name', $request->module_name)->get();

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $rules;
            $this->response['message'] = 'Rule added successfully';
        }
        return response()->json($this->response, $this->status);
    }

    public function updateRule($request)
    {
        $rule = Rule::where('id', $request->rule_id)->where('module_id', $request->module_id)->where('module_name', $request->module_name)->first();
        if (!$rule) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'invalid Id';
            return response()->json($this->response, $this->status);
        }
        $bookable = (new $this->moduleBinding[$rule->module_name])->where('user_id', request()->user()->id)->where('id', $rule->module_id)->first();

        if($rule->module_name == null){
            $bookable = Guide::where('user_id', request()->user()->id)->where('id', $rule->module_id)->first();
        }

        if(!$bookable){
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid rule';
            return response()->json($this->response, $this->status);
        }
        $rule->name = $request->rule;
        if ($rule->save()) {
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Rule update successfully';
        }
        return response()->json($this->response, $this->status);
    }

    public function getRules(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'module_name' => 'required',
            'module_id' =>  'required|integer',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }
        $module = $request->module_name;
        $module_id = $request->module_id;
        $rules = Rule::where('module_name', $module)->where('module_id', $module_id)->get();
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Rules Fetched Successfully';
        $this->response['data'] = $rules;
        if (empty($rules)) {
            $this->response['message'] = 'Rules Not Found';
        }

        return response()->json($this->response, $this->status);
    }

    public function deleteRule($rule_id)
    {
        $rule = Rule::find($rule_id);
        if(!$rule){
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid rule';
            return response()->json($this->response, $this->status);
        }

        // $bookable = (new $this->moduleBinding[$rule->module_name])->where('user_id', request()->user()->id)->where('id', $rule->module_id)->first();

        // if($rule->module_name == null){
        //     $bookable = Guide::where('user_id', request()->user()->id)->where('id', $rule->module_id)->first();
        // }

        // if(!$bookable){
        //     $this->status = 422;
        //     $this->response['success'] = false;
        //     $this->response['message'] = 'Invalid rule';
        //     return response()->json($this->response, $this->status);
        // }

        $rule->delete();

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Rule Deleted Successfully';
        return response()->json($this->response, $this->status);
    }

    public function accommodationFacilityAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checkedFacilities' => 'required',
            'accommodation_id' =>  'required',
        ]);

        $accommodation = Accommodation::where('id', $request->accommodation_id)->where('user_id', $request->user()->id)->first();

        if(!$accommodation){
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = "Invalid accommodation";
            return response()->json($this->response, $this->status);
        }

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }
        if (isset($request->checkedFacilities)) {
            $data = [];
            FacilityAccommodation::where('accommodation_id', $request->accommodation_id)->delete();
            $response = explode(',', $request->checkedFacilities);
            foreach ($response as $row) {
                $facility_explode = explode('|', $row);
                array_push($data, ['name' => $facility_explode[0], 'accommodation_id' => $request->accommodation_id, 'icon' => $facility_explode[1], 'facilityType' => 'accommodations']);
            }
            FacilityAccommodation::insert($data);

            if(isset($data) && !empty($data) && isset($data->id)){
                $title = "Facilities added ";
                $message = "Facilities added successfully";
                $action = "user/setting/". $data->id;

                if(isset($data) && !empty($data) && isset($data->id)){
                    PushNotification::createNotification(auth()->user(),1,$title,$message,User::TYPE_ACCOMMODATION,$action,$data->id);
                }
            }

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Facilities Added Successfully';
        }
        return response()->json($this->response, $this->status);
    }

    ///////////////////////////meals///////////////////////////////
    public function meals(Request $request)
    {

        if(isset($request->page_type) && $request->page_type == "public_profile"){
            $meal = Meal::withAvg('rating_values', 'average_rating')->with('singleImage')->where('user_id', $request->id)->where('is_publish',1)->where('status', 1)->orderBy('id', 'DESC')->paginate(14);
        }else{
            $meal = Meal::withAvg('rating_values', 'average_rating')->with('singleImage')->where('user_id', $request->id)->orderBy('id', 'DESC')->paginate(14);
        }
        if ($meal->count() <= 0) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Result Not Found.';
        }
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = array('meal' => $meal);
        return response()->json($this->response, $this->status);
    }

    public function addMeal(Request $request)
    {
        $meal = new Meal;

        $meal->title           = $request->title;
        $meal->meal_type      = $request->meal_type;
        $meal->price       = $request->price;
        $meal->persons  = $request->persons;
        $meal->brand   = $request->brand;

        if (isset($request->opening_time) && strlen($request->opening_time) == 5) {
            $meal->opening_time       = $request->opening_time . ':00';
        } elseif (isset($request->opening_time)) {
            $meal->opening_time       = $request->opening_time;
        }

        if (isset($request->closing_time) && strlen($request->closing_time) == 5) {
            $meal->closing_time       = $request->closing_time . ':00';
        } elseif (isset($request->closing_time)) {
            $meal->closing_time       = $request->closing_time;
        }

        $meal->user_id = $request->user()->id;
        $meal->lat       = round($request->latitude, 8);
        $meal->lng       = round($request->longitude, 8);
        $meal->location        = $request->location;
        $meal->city           = $request->city;
        $meal->country           = $request->country;

        if(auth()->user() && !is_null(auth()->user()->user_module_type) && !empty(auth()->user()->user_module_type)){
            if(auth()->user()->user_module_type == 'home_cheff' || auth()->user()->user_module_type == 'restaurants'){
                $meal->user_module_type = auth()->user()->user_module_type;
                $meal->module_name = auth()->user()->user_module_type;
            }
        }

        if ($meal->save()) {
            $title = "Meal";
            $message = "Meal Service created successfully.To view detail.";
            if ($meal->user_module_type == 'home_cheff' || $meal->user_module_type == 'restaurants') {
                $action = "packages/detail/" . $meal->id;
            } else {
                $action='/host/meals/detail/'.$meal->id;
            }
            $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();
            if(isset($admin) && !empty($admin)){
                PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_MEAL,$action,$meal->id);

                $message = "New Meal Service has been created";
                PushNotification::createNotification($admin,auth()->user()->id,$title,$message,User::TYPE_MEAL,$action,$meal->id);
            }

            CancellationPolicy::forceCreate([
                'bookable_id' => $meal->id,
                'cancellation_hour' => '96',
                'refund_percentage' => '100',
                'module_name' => 'meals',
                'bookable' => Meal::class
            ]);
            CancellationPolicy::forceCreate([
                'bookable_id' => $meal->id,
                'cancellation_hour' => '72',
                'refund_percentage' => '75',
                'module_name' => 'meals',
                'bookable' => Meal::class
            ]);

            CancellationPolicy::forceCreate([
                'bookable_id' => $meal->id,
                'cancellation_hour' => '48',
                'refund_percentage' => '50',
                'module_name' => 'meals',
                'bookable' => Meal::class
            ]);

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $meal;
        }

        return response()->json($this->response, $this->status);
    }

    public function updateMeal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meal_id' => 'required'
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $meal = Meal::with('images')->where('user_id', $request->user()->id)->where('id', $request->meal_id)->first();
        if (!$meal) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid meal id';
            return response()->json($this->response, $this->status);
        }
        $title = "Meal Service";
        $message = "Meal Service Updated successfully.";
        $action = "packages/detail/". $meal->id;
        $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();

        if (isset($request->is_publish)) {

            $validator = Validator::make($meal->toArray(), [
                'meal_type' => 'required',
                'title' => 'required',
                'location' => 'required',
                'detail_location' => 'required',
                'price' => 'required',
                'unit' => 'required',
                'persons' => 'required',
                'opening_time' => 'required',
                'closing_time' => 'required',
                'delivery_time' => 'required',
                'description' => 'required'
            ]);
            if ($validator->fails()) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = $validator->messages()->first();
                return response()->json($this->response, $this->status);
            }
            $meal->is_publish      = $request->is_publish;
            $meal->status =1;
            $title = "Meal Service";
            $message = "Meal Service Published successfully.";
            $action = "packages/detail/". $meal->id;


            if(isset($admin) && !empty($admin)){
                PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_MEAL,$action,$meal->id);
                // $message = "Meal service has been updated.";
                PushNotification::createNotification($admin,auth()->user()->id,$title,$message,User::TYPE_MEAL,$action,$meal->id);
            }

        }
        //return $request->is_offer_promotion_discount;
        if (isset($request->is_offer_promotion_discount)) {
            $meal->is_offer_promotion_discount = $request->is_offer_promotion_discount;
            $meal->promotion_discount = $request->promotion_discount;
        }

        if (isset($request->meal_type)) {
            $meal->meal_type = $request->meal_type;
        }

        if (isset($request->title)) {
            $meal->title      = $request->title;
        }

        if (isset($request->status)) {
            $meal->status    = $request->status;
        }
        if (isset($request->brand)) {
            $meal->brand = $request->brand;
        }
        if (isset($request->delivery_time)) {
            $meal->delivery_time  = $request->delivery_time;
        }
        if (isset($request->delivery_charges)) {
            $meal->delivery_charges   = $request->delivery_charges;
        }
        if (isset($request->free_delivery)) {
            $meal->free_delivery  =  $request->free_delivery;
        }
        if (isset($request->free_delivery_value)) {
            $meal->free_delivery_value = $request->free_delivery_value;
        }
        if (isset($request->discount)) {
            $meal->discount       = $request->discount;
        }
        if (isset($request->payment_mode)) {
            $meal->payment_mode    = $request->payment_mode;
        }
        if (isset($request->payment_partial_value)) {
            $meal->payment_partial_value    = $request->payment_partial_value;
        }
        if (isset($request->opening_time) && strlen($request->opening_time) == 5) {
            $meal->opening_time       = $request->opening_time . ':00';
        } elseif (isset($request->opening_time)) {
            $meal->opening_time       = $request->opening_time;
        }

        if (isset($request->closing_time) && strlen($request->closing_time) == 5) {
            $meal->closing_time       = $request->closing_time . ':00';
        } elseif (isset($request->closing_time)) {
            $meal->closing_time       = $request->closing_time;
        }

        if (isset($request->food_preparation)) {
            $meal->food_preparation = $request->food_preparation;
        }

        if (isset($request->lat)) {
            $meal->lat     = round($request->lat, 8);
        }
        if (isset($request->lng)) {
            $meal->lng  = round($request->lng, 8);
        }
        if (isset($request->location)) {
            $meal->location  = $request->location;
        }
        if (isset($request->detail_location)) {
            $meal->detail_location  = $request->detail_location;
        }
        if (isset($request->city)) {
            $meal->city   = $request->city;
        }
        if (isset($request->country)) {
            $meal->country = $request->country;
        }
        if (isset($request->description)) {
            $meal->description  = $request->description;
        }
        if (isset($request->price)) {
            $meal->price = $request->price;
        }
        if (isset($request->persons)) {
            $meal->persons = $request->persons;
        }
        if (isset($request->unit)) {
            $meal->unit = $request->unit;
        }
        if (isset($request->phone)) {
            $meal->phone = $request->phone;
        }
        if (isset($request->specialities)) {
            $meal->specialities = $request->specialities;
        }
        if (isset($request->ingredients)) {
            $meal->ingredients = $request->ingredients;
        }
        if (isset($request->status)) {
            $meal->status = $request->status;
        }

        if (isset($request->cancellation_policy)) {
            $meal->cancellation_policy    = $request->cancellation_policy;
        }
        if (isset($request->important_info)) {
            $meal->important_info = $request->important_info;
        }

        if(isset($request->is_offer_promotion_discount)){
            $meal->is_offer_promotion_discount = $request->is_offer_promotion_discount;
            if(isset($request->promotion_discount)){
                $meal->promotion_discount = $request->promotion_discount;
            }
        }

        // if(isset($admin) && !empty($admin)){
        //     PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_MEAL,$action,$meal->id);

        //     $message = "Meal service has been updated.";

        //     PushNotification::createNotification($admin,auth()->user()->id,$title,$message,User::TYPE_MEAL,$action,$meal->id);
        // }

        if ($meal->save()) {

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Updated Successfully';
            $this->response['data'] = $meal;
        } else {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'SomeThing Went Wrong!.';
        }
        return response()->json($this->response, $this->status);
    }

    ///////////////////////////vehicle///////////////////////////////
    public function transports(Request $request)
    {


        if(isset($request->page_type) && $request->page_type == "public_profile"){
            $transport = Transport::withAvg('rating_values', 'average_rating')->with('singleImage')->where('user_id', $request->id)->where('is_publish',1)->where('status', 1)->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
        }else{
            $transport = Transport::withAvg('rating_values', 'average_rating')->with('singleImage')->where('user_id', $request->id)->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
        }


        if ($transport->count() <= 0) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Result Not Found.';
        }
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = array('transport' => $transport);
        return response()->json($this->response, $this->status);
    }

    public function addTransport(Request $request)
    {
        $transport = new Transport;
        $transport->title           = $request->title;
        $transport->vechile_type      = $request->vechile_type;
        $transport->per_day_price       = $request->per_day_price;
        $transport->no_of_people  = $request->no_of_people;
        $transport->transmission   = $request->transmission;
        if (isset($request->cc)) {
            $transport->cc    = $request->cc;
        }

        $transport->assembly   = $request->assembly;
        $transport->user_id = $request->user()->id;
        $transport->lat       = round($request->lat, 8);
        $transport->lng       = round($request->lng, 8);
        $transport->location        = $request->location;
        $transport->city           = $request->city;
        $transport->country           = $request->country;
        $transport->category           = $request->category;

        if(isset(auth()->user()->user_module_type) && auth()->user()->user_module_type == 'transport_company'){
            $transport->user_module_type =  'transport_company';
            $transport->module_name =  'transport_company';
        }else{
            $transport->user_module_type =  'transports';
            $transport->module_name =  'transports';
        }

        if ($transport->save()) {

            $title = "Vehicle";
            $message = "Vehicle service added successfully.To view detail";
            $action = "host/transports/detail/".$transport->id;
            $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();
            if(isset($admin) && !empty($admin)){
                PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_VEHICLE,$action,$transport->id);
                $message = "New Vehicle service has been created";
                PushNotification::createNotification($admin,auth()->user()->id,$title,$message,User::TYPE_VEHICLE,$action,$transport->id);
            }

            $transport =  Transport::with('images')->with('two_images')->with('mainImage')->with('transport_feature')->where('id', $transport->id)->first();

            CancellationPolicy::forceCreate([
                'bookable_id' => $transport->id,
                'cancellation_hour' => '96',
                'refund_percentage' => '100',
                'module_name' => 'transports',
                'bookable' => Transport::class
            ]);

            CancellationPolicy::forceCreate([
                'bookable_id' => $transport->id,
                'cancellation_hour' => '72',
                'refund_percentage' => '75',
                'module_name' => 'transports',
                'bookable' => Transport::class
            ]);

            CancellationPolicy::forceCreate([
                'bookable_id' => $transport->id,
                'cancellation_hour' => '48',
                'refund_percentage' => '50',
                'module_name' => 'transports',
                'bookable' => Transport::class
            ]);

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $transport;
        }

        return response()->json($this->response, $this->status);
    }

    public function updateTransport(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'transport_id' => 'required'
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $transport = Transport::with('images')->where('user_id', $request->user()->id)->where('id', $request->transport_id)->first();
        if (!$transport) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid transport id';
            return response()->json($this->response, $this->status);
        }

        $title = "Vehicle";
        $message = "Vehicle service updated successfully.To view detail";
        $action = "host/transports/detail/".$transport->id;
        $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();


        if (isset($request->is_publish)) {

            $validator = Validator::make($transport->toArray(), [
                'category' => 'required',
                'vechile_type' => 'required',
                'list_for' => 'required',
                'cc' => 'required',
                'location' => 'required',
                'detail_location' => 'required',
                'brand' => 'required',
                'model' => 'required',
                'hourly_price' => 'required',
                'transmission' => 'required',
                'engine' => 'required',

                'no_of_people' => 'required',
                'description' => 'required'
            ]);
            if ($validator->fails()) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = $validator->messages()->first();
                return response()->json($this->response, $this->status);
            }
            //new validation added server side for specially mobile end
            $transport->is_publish    = $request->is_publish;
            $transport->status =1;
            $message = "Vehicle service published successfully.To view detail";


            if(isset($admin) && !empty($admin)){
                PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_VEHICLE,$action,$transport->id);
                // $message = "Vehicle service has been updated.";
                PushNotification::createNotification($admin,auth()->user()->id,$title,$message,User::TYPE_VEHICLE,$action,$transport->id);
            }

        }
        if (isset($request->is_offer_promotion_discount)) {

            $transport->is_offer_promotion_discount = $request->is_offer_promotion_discount;
            $transport->promotion_discount = $request->promotion_discount;
        }
        if (isset($request->vechile_type)) {
            $transport->vechile_type = $request->vechile_type;
        }
        if (isset($request->title)) {
            $transport->title      = $request->title;
        }
        if (isset($request->brand)) {
            $transport->brand = $request->brand;
        }
        if (isset($request->no_of_people)) {
            $transport->no_of_people  = $request->no_of_people;
        }
        if (isset($request->per_day_price)) {
            $transport->per_day_price   = $request->per_day_price;
        }
        if (isset($request->airport_pick_drop)) {
            $transport->airport_pick_drop  =  $request->airport_pick_drop;
        }
        if (isset($request->airport_pick_and_drop_charges)) {
            $transport->airport_pick_and_drop_charges = $request->airport_pick_and_drop_charges;
        }
        if (isset($request->out_of_city)) {
            $transport->out_of_city = $request->out_of_city;
        }

        if (isset($request->free_km)) {
            $transport->free_km = $request->free_km;
        }
        if (isset($request->extra_km_rate)) {
            $transport->extra_km_rate = $request->extra_km_rate;
        }
        // if (isset($request->lat)) {
        //     $transport->lat     = round($request->lat, 8);
        // }
        // if (isset($request->lng)) {
        //     $transport->lng  = round($request->lng, 8);
        // }
        
        if (isset($request->lat)) {
            $lat = (float)$request->lat;
            $transport->lat     = round($lat, 8);
        }
        if (isset($request->lng)) {
            $lng = (float)$request->lng;
            $transport->lng  = round($lng, 8);
        }
        
        if (isset($request->location)) {
            $transport->location  = $request->location;
        }
        if (isset($request->detail_location)) {
            $transport->detail_location  = $request->detail_location;
        }
        if (isset($request->city)) {
            $transport->city   = $request->city;
        }
        if (isset($request->country)) {
            $transport->country = $request->country;
        }
        if (isset($request->description)) {
            $transport->description  = $request->description;
        }
        if (isset($request->hourly_price)) {
            $transport->hourly_price = $request->hourly_price;
        }

        if (isset($request->transmission)) {
            $transport->transmission = $request->transmission;
        }
        if (isset($request->assembly)) {
            $transport->assembly = $request->assembly;
        }
        if (isset($request->phone)) {
            $transport->phone = $request->phone;
        }
        if (isset($request->engine)) {
            $transport->engine = $request->engine;
        }
        if (isset($request->with_my_diver)) {
            $transport->with_my_diver = $request->with_my_diver;
        }
        if (isset($request->provide_self_drive)) {
            $transport->provide_self_drive = $request->provide_self_drive;
        }
        if (isset($request->self_drive_rules)) {
            $transport->self_drive_rules = $request->self_drive_rules;
        }
        if (isset($request->list_for)) {
            $transport->list_for = $request->list_for;
        }


        if (isset($request->cancellation_policy)) {
            $transport->cancellation_policy    = $request->cancellation_policy;
        }
        if (isset($request->important_info)) {
            $transport->important_info = $request->important_info;
        }

        if (isset($request->insured)) {
            $transport->insured    = $request->insured;
        }
        if (isset($request->tracker)) {
            $transport->tracker = $request->tracker;
        }

        if (isset($request->registration_no)) {
            $transport->registration_no    = $request->registration_no;
        }
        if (isset($request->category)) {
            $transport->category = $request->category;
        }
        if (isset($request->cc)) {
            $transport->cc    = $request->cc;
        }
        if (isset($request->tracker)) {
            $transport->tracker = $request->tracker;
        }

        if (isset($request->accessories)) {
            $transport->accessories    = $request->accessories;
        }
        if (isset($request->video_url)) {
            $transport->video_url = $request->video_url;
        }
        if (isset($request->model)) {
            $transport->model = $request->model;
        }

        if (isset($request->insurance_expire_date)) {
            $transport->insurance_expire_date = date("Y-m-d", strtotime($request->insurance_expire_date));
        }
        if (isset($request->insurance_document)) {
            $transport->insurance_document = $request->insurance_document;
        }

        if (isset($request->minimum_hours)) {
            $transport->minimum_hours = $request->minimum_hours;
        }

        if ($transport->vechile_type == 'Jeep 4x4') {
            $transport->minimum_price = (isset($request->minimum_price) && !empty($request->minimum_price)) ? $request->minimum_price : 0;
            $transport->maximum_price = (isset($request->maximum_price) && !empty($request->maximum_price)) ? $request->maximum_price : 0;
        }

        if (isset($request->is_intercity_allow)) {

            if(empty($request->is_intercity_allow) OR $request->is_intercity_allow == null OR $request->is_intercity_allow =='undefined'){
                $transport->is_intercity_allow    = 0;
            }else{
                $transport->is_intercity_allow    = (int)$request->is_intercity_allow;
            }
        }


        if (isset($request->status)) {
            $transport->status = !empty($request->status) ? 1 : 0;

        }
        if (isset($request->intercity_per_day_price)) {
            $transport->intercity_per_day_price    = $request->intercity_per_day_price;
        }
        if (isset($request->payment_mode)) {
            $transport->payment_mode    = $request->payment_mode;
        }
        if (isset($request->payment_partial_value)) {
            $transport->payment_partial_value    = $request->payment_partial_value;
        }

        if (isset($request->intercity_per_day_milage)) {
            $transport->intercity_per_day_milage = $request->intercity_per_day_milage;
        }

        if (isset($request->intercity_per_day_extra_milage)) {
            $transport->intercity_per_day_extra_milage    = $request->intercity_per_day_extra_milage;
        }
        if (isset($request->intercity_per_day_extra_milage_price)) {
            $transport->intercity_per_day_extra_milage_price = $request->intercity_per_day_extra_milage_price;
        }

        if (isset($request->intercity_multiple_day_price)) {
            $transport->intercity_multiple_day_price    = $request->intercity_multiple_day_price;
        }
        if (isset($request->intercity_multiple_day_milage)) {
            $transport->intercity_multiple_day_milage = $request->intercity_multiple_day_milage;
        }
        if (isset($request->intercity_multiple_day_extra_milage)) {
            $transport->intercity_multiple_day_extra_milage    = $request->intercity_multiple_day_extra_milage;
        }
        if (isset($request->intercity_multiple_day_extra_milage_price)) {
            $transport->intercity_multiple_day_extra_milage_price = $request->intercity_multiple_day_extra_milage_price;
        }

        if (isset($request->is_outofcity_allow)) {
            if(empty($request->is_outofcity_allow) OR $request->is_outofcity_allow == null OR $request->is_outofcity_allow =='undefined'){
                $transport->is_outofcity_allow    = 0;
            }else{
                $transport->is_outofcity_allow    = (int)$request->is_outofcity_allow;
            }

        }
        if (isset($request->outofcity_per_day_price)) {
            $transport->outofcity_per_day_price = $request->outofcity_per_day_price;
        }
        if (isset($request->outofcity_per_day_milage)) {
            $transport->outofcity_per_day_milage = $request->outofcity_per_day_milage;
        }

        if (isset($request->outofcity_per_day_extra_milage)) {
            $transport->outofcity_per_day_extra_milage = $request->outofcity_per_day_extra_milage;
        }
        if (isset($request->outofcity_per_day_extra_milage_price)) {
            $transport->outofcity_per_day_extra_milage_price = $request->outofcity_per_day_extra_milage_price;
        }

        if (isset($request->outofcity_multiple_day_price)) {
            $transport->outofcity_multiple_day_price = $request->outofcity_multiple_day_price;
        }
        if (isset($request->outofcity_multiple_day_milage)) {
            $transport->outofcity_multiple_day_milage = $request->outofcity_multiple_day_milage;
        }
        if (isset($request->outofcity_multiple_day_extra_milage)) {
            $transport->outofcity_multiple_day_extra_milage = $request->outofcity_multiple_day_extra_milage;
        }
        if (isset($request->outofcity_multiple_day_extra_milage_price)) {
            $transport->outofcity_multiple_day_extra_milage_price = $request->outofcity_multiple_day_extra_milage_price;
        }
        // if(isset($admin) && !empty($admin)){
        //     PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_VEHICLE,$action,$transport->id);

        //     $message = "Vehicle service has been updated.";

        //     PushNotification::createNotification($admin,auth()->user()->id,$title,$message,User::TYPE_VEHICLE,$action,$transport->id);
        // }

        if ($transport->save()) {

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Updated Successfully';
            $this->response['data'] = $transport;
        } else {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'SomeThing Went Wrong!.';
        }
        return response()->json($this->response, $this->status);
    }

    public function addTransportAccessories(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checkedAccessories' => 'required',
            'transport_id' =>  'required|integer',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }
        if (isset($request->checkedAccessories) && !empty($request->checkedAccessories)) {
            $data = [];
            TransportFeature::where('transport_id', $request->transport_id)->delete();
            //echo  $request->checkedAccessories;exit;
            $response = explode(',', $request->checkedAccessories);
            // print_r($response);exit;
            foreach ($response as $row) {
                $facility_explode = explode('|', $row);
                array_push($data, ['title' => $facility_explode[0], 'transport_id' => $request->transport_id, 'image' => $facility_explode[1]]);
            }
            TransportFeature::insert($data);
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Accessories Added Successfully';
        }
        return response()->json($this->response, $this->status);
    }

    ///////////////////////////Activity///////////////////////////////
    public function experiencies(Request $request)
    {
        if(isset($request->page_type) && $request->page_type == "public_profile"){
            $experiencies = Experience::withAvg('rating_values','average_rating')->with(['singleImage','exp_videos'])->where('user_id', $request->id)->where('is_publish',1)->where('status', 1)->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
        }else{
            $experiencies = Experience::withAvg('rating_values','average_rating')->with(['singleImage','exp_videos'])->where('user_id', $request->id)->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
        }

        if ($experiencies->count() <= 0) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Result Not Found.';
        }
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = array('experiencies' => $experiencies);
        return response()->json($this->response, $this->status);
    }

    public function addExperience(Request $request)
    {
        // if (count($request->all()) > 0) {
        $experience = new Experience;
        // $validator = Validator::make($request->all(), [
        //     'title' => 'required|max:255',
        //     'type' => 'required',
        //     'suitable_age' => 'required',
        //     'about' => 'required',
        // ]);
        // if ($validator->fails()) {
        //     $this->status = 422;
        //     $this->response['success'] = false;
        //     $this->response['message'] = $validator->messages()->first();
        //     return response()->json($this->response, $this->status);
        // }
        // $experience->title           = $request->title;
        // $experience->type      = $request->type;
        // $experience->suitable_age   = $request->suitable_age;
        $experience->user_id = $request->user()->id;
        // $experience->about       = $request->about;

        if ($experience->save()) {

            $title = "Activity";
            $message = "Activity created successfully.To view detail";
            $action = "host/experiences/detail/".$experience->id;
            $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();

            if(isset($admin) && !empty($admin)){

                PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_ACTIVITY,$action,$experience->id);

                $message = "New Activity has been created.";
                PushNotification::createNotification($admin,auth()->user()->id,$title,$message,User::TYPE_ACTIVITY,$action,$experience->id);
            }

            CancellationPolicy::forceCreate([
                'bookable_id' => $experience->id,
                'cancellation_hour' => '96',
                'refund_percentage' => '100',
                'module_name' => 'experiences',
                'bookable' => Experience::class
            ]);
            CancellationPolicy::forceCreate([
                'bookable_id' => $experience->id,
                'cancellation_hour' => '72',
                'refund_percentage' => '75',
                'module_name' => 'experiences',
                'bookable' => Experience::class
            ]);

            CancellationPolicy::forceCreate([
                'bookable_id' => $experience->id,
                'cancellation_hour' => '48',
                'refund_percentage' => '50',
                'module_name' => 'experiences',
                'bookable' => Experience::class
            ]);


            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $experience;
        }

        return response()->json($this->response, $this->status);
    }

    public function updateExperience(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'experience_id' => 'required'
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $experience = Experience::with('images')->where('user_id', $request->user()->id)->where('id', $request->experience_id)->first();
        if (!$experience) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid experience id';
            return response()->json($this->response, $this->status);
        }
        $title = "Activity";
        $message = "Activity updated successfully.To view detail";
        $action = "host/experiences/detail/".$experience->id;
        $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();

        if (isset($request->is_publish)) {

            $validator = Validator::make($experience->toArray(), [

                'category' => 'required',
                'type' => 'required',
                'title' => 'required',
                'language' => 'required',
                'location' => 'required',
                'detail_location' => 'required',
                'lat' => 'required',
                'lng' => 'required',
                'duration' => 'required',
                'price' => 'required',
                'about' => 'required',
                'suitable_age' => 'required',

            ]);
            if ($validator->fails()) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = $validator->messages()->first();
                return response()->json($this->response, $this->status);
            }
            if($experience->is_individual == 0 && $experience->is_group == 0){
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = "Atleaset select one checkbox between individual or group";
                return response()->json($this->response, $this->status);
            }
            if($experience->is_group == 1 && $experience->min_no_of_guest =='' || $experience->is_group == 1 && $experience->min_no_of_guest < 1) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = "please enter minimum group size ";
                return response()->json($this->response, $this->status);
            }
            if($experience->is_group == 1 && $experience->max_no_of_guest =='' || $experience->is_group == 1 && $experience->max_no_of_guest < 1) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = "please enter maximum group size ";
                return response()->json($this->response, $this->status);
            }

            if($experience->is_offer_promotion_discount == 1 && ($experience->promotion_discount =='')){
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = "please enter promotional discount value";
                return response()->json($this->response, $this->status);
            }
            $experience->is_publish = $request->is_publish;
            $experience->status =1;
            $message = "Activity Published successfully.To view detail";

            if(isset($admin) && !empty($admin)){
                PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_ACTIVITY,$action,$experience->id);
                // $message = "Activity service has been updated.";
                PushNotification::createNotification($admin,auth()->user()->id,$title,$message,User::TYPE_ACTIVITY,$action,$experience->id);
            }

        }
        if(isset($request->age_limit_for_child_free)){
            $experience->age_limit_for_child_free      = $request->age_limit_for_child_free;
          }
        if(isset($request->age_limit_for_child)){
                $experience->age_limit_for_child      = $request->age_limit_for_child;
              }
        if(isset($request->child_discount)){
                $experience->child_discount      = $request->child_discount;
              }

        if(isset($request->term_conditions)){
                $experience->term_conditions = $request->term_conditions;
        }

        if (isset($request->is_offer_promotion_discount)) {
            $experience->is_offer_promotion_discount = $request->is_offer_promotion_discount;
            $experience->promotion_discount = $request->promotion_discount;
        }

        if (isset($request->status)) {
            $experience->status      = $request->status;

        }
        if (isset($request->category)) {
            $experience->category = $request->category;
        }
        if (isset($request->facilities)) {
            $experience->facilities = $request->facilities;
        }

        if (isset($request->type)) {
            $experience->type = $request->type;
        }
        if (isset($request->title)) {
            $experience->title      = $request->title;
        }
        if (isset($request->payment_mode)) {
            $experience->payment_mode = $request->payment_mode;
        }
        if (isset($request->payment_partial_value)) {
            $experience->payment_partial_value = $request->payment_partial_value;
        }

        if (isset($request->suitable_age)) {
            $experience->suitable_age   = $request->suitable_age;
        }
        if (isset($request->enquiry_response)) {
            $experience->enquiry_response  =  $request->enquiry_response;
        }
         if (isset($request->language)) {
            $experience->language = $request->language;
        }

        if (isset($request->about)) {
            $experience->about  = $request->about;
        }
        if (isset($request->payment_term)) {
            $experience->payment_term    = $request->payment_term;
        }
        if (isset($request->price)) {
            $experience->price    = $request->price;
        }
        if (isset($request->min_no_of_guest)) {
            $experience->min_no_of_guest    = $request->min_no_of_guest;
        }
        if (isset($request->max_no_of_guest)) {
            $experience->max_no_of_guest    = $request->max_no_of_guest;
        }
        if (isset($request->duration)) {
            $experience->duration    = $request->duration;
        }
        if (isset($request->location)) {
            $experience->location    = $request->location;
        }
        if (isset($request->detail_location)) {
            $experience->detail_location    = $request->detail_location;
        }

        if (isset($request->country)) {
            $experience->country    = $request->country;
        }
        if (isset($request->city)) {
            $experience->city    = $request->city;
        }
        if (isset($request->lat)) {
            $experience->lat    = round($request->lat, 8);
        }
        if (isset($request->lng)) {
            $experience->lng    = round($request->lng, 8);
        }
        if (isset($request->is_individual)) {
            $experience->is_individual    = $request->is_individual;
        }
        if (isset($request->is_group)) {
            $experience->is_group    = $request->is_group;
        }
        // if(isset($admin) && !empty($admin)){
        //     PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_ACTIVITY,$action,$experience->id);

        //     $message = "Activity service has been updated.";

        //     PushNotification::createNotification($admin,auth()->user()->id,$title,$message,User::TYPE_ACTIVITY,$action,$experience->id);
        // }

        if ($experience->save()) {


            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Updated Successfully';
            $this->response['data'] = $experience;
        } else {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'SomeThing Went Wrong!.';
        }
        return response()->json($this->response, $this->status);
    }

    public function addSlot(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'experience_id' => 'required|integer',
            'date' => 'required',
            'start_time' => 'required',
            'class_size' => 'required',
            'price' => 'required',
            'duration' => 'required',
            'location' => 'required',
            'detail_location' => 'required',
            'lat' => 'required',

        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $experience = Experience::where('id', $request->experience_id)->where('user_id', request()->user()->id)->first();

        if(!$experience){
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid slot';
            return response()->json($this->response, $this->status);
        }

        if ($request->slot_id) {
            return $this->updateSlot($request);
        }

        $rule = Slot::where('date', date("Y-m-d", strtotime($request->date)))->where('start_time', $request->start_time)->where('lat',$request->lat)->where('type',$request->type)->where('experience_id', $request->experience_id)->first();


        if ($rule) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Slot Already Existed.';
            return response()->json($this->response, $this->status);
        }

        $slot = new Slot;
        $slot->experience_id = $request->experience_id;
        $slot->date = date("Y-m-d", strtotime($request->date));
        // $slot->start_time = $request->start_time;
        if (isset($request->start_time) && strlen($request->start_time) == 5) {
            $slot->start_time       = $request->start_time . ':00';
        } elseif (isset($request->start_time)) {
            $slot->start_time       = $request->start_time;
        }
        $slot->class_size = $request->class_size;
        $slot->price = $request->price;
        $slot->duration = $request->duration;
        $slot->lat       = round($request->lat, 8);
        $slot->lng       = round($request->lng, 8);
        $slot->location        = $request->location;
        $slot->detail_location        = $request->detail_location;

        $slot->city           = $request->city;
        $slot->country           = $request->country;
        $slot->type           = $request->type;

        if ($slot->save()) {
            $experience->price  = DB::table('slots')->where('experience_id',$experience->id)->min('price');
            $experience->save();
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Slot Added Successfully';
        }
        return response()->json($this->response, $this->status);
    }

    public function updateSlot($request)
    {
        $experience = Experience::where('id', $request->experience_id)->first();
        $slot = Slot::where('id', $request->slot_id)->first();
        if (!$slot) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'invalid  slot id';
            return response()->json($this->response, $this->status);
        }
        if (isset($request->start_time) && strlen($request->start_time) == 5) {
            $slot->start_time       = $request->start_time . ':00';
        } elseif (isset($request->start_time)) {
            $slot->start_time       = $request->start_time;
        }
        if (isset($request->class_size)) {
            $slot->class_size = $request->class_size;
        }
        if (isset($request->duration)) {
            $slot->duration = $request->duration;
        }
        if (isset($request->latitude)) {
            $slot->lat       = round($request->latitude, 8);
        }
        if (isset($request->longitude)) {
            $slot->lng       = round($request->longitude, 8);
        }
        if (isset($request->location)) {
            $slot->location        = $request->location;
        }
        if (isset($request->city)) {
            $slot->city           = $request->city;
        }
        if (isset($request->country)) {
            $slot->country           = $request->country;
        }

        if ($slot->save()) {
            $experience->price  = DB::table('slots')->where('experience_id',$experience->id)->min('price');
            $experience->save();
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Slot update successfully';
        }
        return response()->json($this->response, $this->status);
    }

    public function getSlots(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'experience_id' =>  'required',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }
        $slots = Slot::where('experience_id', $request->experience_id)->get();
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Slot Fetched Successfully';
        $this->response['data'] = $slots;
        if (empty($slots)) {
            $this->response['message'] = 'Slot Not Found';
        }

        return response()->json($this->response, $this->status);
    }

    public function deleteSlot($slot_id)
    {
        $slot = Slot::find($slot_id);
        if(!$slot){
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Slot not found';
            return response()->json($this->response, $this->status);
        }

        $experience = Experience::where('id', $slot->experience_id)->where('user_id', request()->user()->id)->first();

        if(!$experience){
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid slot';
            return response()->json($this->response, $this->status);
        }

        $slot->delete();
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Slot deleted successfully';
        return response()->json($this->response, $this->status);

    }

    public function switchProfile(Request $request)
    {

        $user = User::where('id', $request->user()->id)->first();

        if($request->switchProfile == 'true' && $user->type == 0 && $request->isSwitchUserFlag == "host"){
            $user->type = 2;
            $user->switchProfile = 2;
        }elseif($request->switchProfile == 'true' && $user->type == 0 && $request->isSwitchUserFlag == "sp"){
            $user->type = 1;
            $user->switchProfile = 1;
        }
        elseif($request->switchProfile == 'false' && $user->switchProfile == 1){
            $user->switchProfile = 0;
        }
        elseif($request->switchProfile == 'false' && $user->switchProfile == 2){
            $user->switchProfile = 0;
        }
        elseif($request->switchProfile == 'true' && $user->switchProfile == 0 && $user->type == 1){
            $user->switchProfile = 1;
        }
        elseif($request->switchProfile == 'true' && $user->switchProfile == 0 && $user->type == 2){
            $user->switchProfile = 2;
        }
        // elseif($request->switchProfile == 'true' && $user->type == 0 && $request->isSwitchUserFlag == "host"){
        //     $user->type = 2;
        //     //  $user->switchProfile = 0;
        // }
        // elseif($request->switchProfile == 'false' && $user->switchProfile == 0 && $request->isSwitchUserFlag == "host"){
        //     $user->type = 0;
        //     $user->switchProfile = 2;
        // }
        // elseif($request->switchProfile == 'true' && $user->type == 0 && $request->isSwitchUserFlag == "sp"){
        //     $user->type = 1;
        //     //$user->switchProfile = 0;
        // }
        // elseif($request->switchProfile == 'false' && $user->switchProfile == 0 && $request->isSwitchUserFlag == "sp"){
        //     $user->type = 0;
        //     $user->switchProfile = 1;
        // }
        $data['type'] = $user->type;
        $data['switchProfile'] = $user->switchProfile;
        //$data['switchProfile'] = $user->switchProfile;

        //swich 2 when changed to host else 1 as user traveller
        $user->save();
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        $this->response['message'] = 'profile switch successfully';
        return response()->json($this->response, $this->status);
    }

    public function updateExcchangePrices(Request $request)
    {
        $country = new Country;

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        $this->response['message'] = 'Countries Exchange Prices Updated Successfully';
        return response()->json($this->response, $this->status);
    }
}
