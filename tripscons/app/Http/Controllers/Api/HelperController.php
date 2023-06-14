<?php

namespace App\Http\Controllers\Api;

use App\Models\Amenity;
use App\Models\City;
use App\Models\Country;
use App\Models\Facility;
use App\Models\Language;
use App\Models\Meal;
use App\Models\Guide;
use App\Models\TripFacility;
use App\Models\TripsProperties;
use App\Models\TripsProperty;
use App\Models\MealIngridiant;
use App\Models\State;
use App\Models\UserLanguage;
use App\Models\MealBookingDetail;
use App\Models\UserRole;
use App\Models\Activity;
use App\Models\UserActivity;
use App\Models\FacilityAccommodation;
use App\Models\TransportFeature;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libs\Image\Optimizer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\GeneralService;
use App\Models\InterestTrip;
use App\Models\Package;
use App\Models\UserAccommodation;
use App\Models\Accommodation;
use App\Models\AccommodationBookingDetail;
use App\Models\User;
use App\Models\UsersServices;
use App\Models\UserDocument;
use App\Models\PasswordReset;
use App\Models\Experience;
use App\Models\ExperienceBookingDetail;
//use App\Models\ExperienceFacility;
use App\Models\Slot;
use App\Models\Transport;
use App\Models\TransportFacility;
use App\Models\VehicleType;
use App\Models\ActivityType;
use App\Models\Booking;
use App\Models\BookingPaymentGatewayDetail;
use App\Models\Invoice;
use App\Models\Image;
use App\Models\VehicleBookingDetail;
use App\Models\Image as modelImage;
use App\Models\Company;
// use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Destination;
use App\Models\GuideActivity;
use App\Models\GuideService;
use App\Models\ActivitiesWeDo;
use App\Models\CancellationPolicy;
use App\Models\OurExpertise;
use App\Models\ServiceProviderRate;
use App\Models\Versions;
use App\Models\TransportCompanyFleet;
use App\Models\TransportCompanyService;



class HelperController extends Controller
{
    /**
     * @var array
     */
    protected $response = [];
    protected $status = 200;

    /**
     * @Description Get All Facilities
     * @return \Illuminate\Http\JsonResponse
     * @Author Khuram Qadeer.
     */
    public function getAllFacilities(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'module_name' =>  'required',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $this->response['success'] = true;
        $this->response['data']['facilities'] = Facility::select('id','name','image')
        ->where('user_module_type',$request->module_name)->orderBy('id', 'DESC')->get();
        return response()->json($this->response, $this->status);

    }
    // public function deleteService(Request $request){

    //     $user = Auth::user();
    //     $this->status = 422;
    //     $this->response['success'] = false;
    //     $this->response['message'] = 'Unauthenticated User';
            
    //     if($user){
    //         $this->status = 200;
    //         $this->response['success'] = true;
    //         $this->response['message'] = 'Service has been deleted successfully.'; 
    //         return response()->json($this->response, $this->status);
    //     }
    //     return response()->json($this->response, $this->status);
    // }
    public function deleteData($module)
    {

        $this->status = 422;
        $this->response['success'] = false;

        if($module =='accommodations'){

            Accommodation::truncate();
            AccommodationBookingDetail::truncate();
            FacilityAccommodation::truncate();

            $this->response['success'] = true;
            $this->status = 200;
        }
        else if($module =='all'){

            User::truncate();
            UsersServices::truncate();
            UserDocument::truncate();
            UserActivity::truncate();
            PasswordReset::truncate();

            //accommodations
            Accommodation::truncate();
            AccommodationBookingDetail::truncate();
            FacilityAccommodation::truncate();
            Guide::truncate();

            TripsProperty::truncate();
            TripsProperties::truncate();
            TripFacility::truncate();

            //meals
            Meal::truncate();
            MealBookingDetail::truncate();
            MealIngridiant::truncate();

            //experiences
            Experience::truncate();
            ExperienceBookingDetail::truncate();
            //ExperienceFacility::truncate();
            Slot::truncate();

            //transports
            Transport::truncate();
            TransportFacility::truncate();
            TransportFeature::truncate();
            VehicleBookingDetail::truncate();
            //bookings
            Booking::truncate();
            BookingPaymentGatewayDetail::truncate();
            Invoice::truncate();
            Image::truncate();
            $this->response['success'] = true;
            $this->status = 200;
        }
        else if ($module =='meals'){
            Meal::truncate();
            MealBookingDetail::truncate();
            MealIngridiant::truncate();
            $this->response['success'] = true;
            $this->status = 200;

        }
        else if ($module =='experiences'){
            Experience::truncate();
            ExperienceBookingDetail::truncate();
            //ExperienceFacility::truncate();
            Slot::truncate();
            $this->response['success'] = true;
            $this->status = 200;

        }
        else if ($module =='transports'){
            Transport::truncate();
            TransportFacility::truncate();
            TransportFeature::truncate();
            VehicleBookingDetail::truncate();
            $this->response['success'] = true;
            $this->status = 200;

        }
        else if ($module =='bookings'){
            Booking::truncate();
            BookingPaymentGatewayDetail::truncate();
            Invoice::truncate();

            VehicleBookingDetail::truncate();
            ExperienceBookingDetail::truncate();
            MealBookingDetail::truncate();
            AccommodationBookingDetail::truncate();

            $this->response['success'] = true;
            $this->status = 200;

        }

        return response()->json($this->response, $this->status);

    }


    /**
     * @Description Get All Languages
     * @return \Illuminate\Http\JsonResponse
     * @Author Khuram Qadeer.
     */
    public function getAllLanguages()
    {
        // $this->response['success'] = true;
        // $this->response['data']['languages'] = Language::getAll();
        // return response()->json($this->response, $this->status);
        // ===========
        // ==========
        $languages = Language::select('id', 'name')->get()->toArray();

        $this->response['success'] = true;
        $this->response['data']['languages'] = array_column($languages, 'name');
        return response()->json($this->response, $this->status);
    }

    public function getActivityTypes($category)
    {
        $data = [];
        if(!empty($category)){
            $data = ActivityType::select('id','name')->where('category',$category)->get();
        }
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        return response()->json($this->response, $this->status);
    }
    public function getVehicleTypes($type)
    {
        $data = [];
        $data = VehicleType::select('id','name','type')->where('type',$type)->get();
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        return response()->json($this->response, $this->status);
    }

    /**
     * @Description Get All Amenities
     * @return \Illuminate\Http\JsonResponse
     * @Author Khuram Qadeer.
     */

    public function getAllActivities()
    {
        $data = [];
        $data['activities'] = Activity::select('id','name','image')->orderBy('id', 'DESC')->get();
        $this->response['success'] = true;
        $this->response['data'] = $data;
        return response()->json($this->response, $this->status);
    }


    public function getPackageAllActivities()
    {
        $data = [];
        $data['activities'] = Activity::select('id','name','image')->orderBy('id', 'DESC')->get();
        $this->response['success'] = true;
        $this->response['data'] = $data;
        return response()->json($this->response, $this->status);
    }
    public function getPackageAllServices()
    {
        $data = [];
        $data['services'] = GuideService::select('id','name','image')->orderBy('id', 'DESC')->get();
        $this->response['success'] = true;
        $this->response['data'] = $data;
        return response()->json($this->response, $this->status);
    }




    public function getUserActivities(Request $request){

        $activities = Activity::all();
        $userActivities =  UserActivity::select('id','name','image')->where('user_id',$request->user()->id)->orderBy('id', 'DESC')->get();
        $tempArray =[];
        $userActivityArray =[];
        foreach($userActivities as $userActivity){
            array_push($userActivityArray,$userActivity->name);
          }
        foreach($activities as $activity){
            $activity->ischeck = 0;
            if(in_array($activity->name, $userActivityArray)){
                $activity->ischeck =1;
            }

            $tempArray[] = $activity;
        }
       if(!empty($activity)){
       $this->response['success'] = true;
       $this->response['activities'] =  $tempArray;
       }else{
       $this->response['success'] = false;
       $this->response['message'] =  'Please Upload Activities Missing In DB';
       }

       return response()->json($this->response, $this->status);
    }

    public function getCancellationPolicy(Request $request, $accommodation_id)
    {
        $model = "App\\Models\\". $request->model;
        
        $policy = CancellationPolicy::where("bookable_id", $accommodation_id)->orderByDesc('cancellation_hour')->where('bookable', $model)->get();
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $policy;
        return response()->json($this->response, $this->status);
    }

    public function updateCancellationPolicy(Request $request, $bookable)
    {


        $request->validate([
            'record.cancellation_hour'=> 'required|max:300|integer',
            'record.refund_percentage'=> 'required|max:100|integer',
        ]);

        $model = "App\\Models\\". $request->model;
        $service = new $model;
        $service = $service->find($bookable);
        if($model != User::class){
            if($service->user_id != $request->user()->id) return response([
                'success' => false,
                'message' => 'You are not authorized to perform this action'
            ]);
        }
        else {
            if($service->id != $request->user()->id) return response([
                'success' => false,
                'message' => 'You are not authorized to perform this action'
            ]);
        }

        $policy = isset($request->record['id']) ? CancellationPolicy::find($request->record['id']) : new CancellationPolicy();
        $policy->cancellation_hour = $request->record['cancellation_hour'];
        $policy->refund_percentage = $request->record['refund_percentage'];
        //$policy->bookable_id = $bookable;

        $policy->updateOrCreate([
            'id' => $policy->id,
            'bookable_id' => $bookable,
            'module_name' => $request->module_name,
            'bookable' => $model
        ], [
            'bookable_id' => $bookable,
            'cancellation_hour' => $request->record['cancellation_hour'],
            'refund_percentage' => $request->record['refund_percentage'],
            'module_name' => $request->module_name,
            'bookable' => $model
        ]);
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $policy;
        return response()->json($this->response, $this->status);
    }

    public function updateCancellationPolicyApi(Request $request)
    {
        $request->validate([
            'cancellation_hour'=> 'required|max:300|integer',
            'refund_percentage'=> 'required|max:100|integer',
            'bookable_id' => 'required',
            'model' => 'required',
            'module_name' => 'required',
        ]);

        $model = "App\\Models\\". $request->model;
        $service = new $model;
        $service = $service->find($request->bookable_id);

        if($model != User::class){
            if($service->user_id != $request->user()->id) return response([
                'success' => false,
                'message' => 'You are not authorized to perform this action'
            ]);
        }
        else {
            if($service->id != $request->user()->id) return response([
                'success' => false,
                'message' => 'You are not authorized to perform this action'
            ]);
        }

        $policy = isset($request->id) ? CancellationPolicy::find($request->id) : new CancellationPolicy();
        $policy->cancellation_hour = $request->cancellation_hour;
        $policy->refund_percentage = $request->refund_percentage;
        $policy->bookable_id = $request->bookable_id;

        $policy = $policy->updateOrCreate([
            'id' => $policy->id,
            'bookable_id' => $request->bookable_id,
            'module_name' => $request->module_name,
            'bookable' => $model
        ], [
            'bookable_id' => $request->bookable_id,
            'cancellation_hour' => $request->cancellation_hour,
            'refund_percentage' => $request->refund_percentage,
            'module_name' => $request->module_name,
            'bookable' => $model
        ]);

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = CancellationPolicy::find($policy->id);
        return response()->json($this->response, $this->status);
    }


    //get all host facilities private
    public function getAccommodationFacilities($accommodation_id){

        $facilities = Facility::where('user_module_type','accommodations')->get();
        $accommodationFacilities =  FacilityAccommodation::where('accommodation_id',$accommodation_id)->where('facilityType','accommodations')->orderBy('id', 'DESC')->get();

        $tempArray =[];
        $accommodationFacilityArray =[];
        foreach($accommodationFacilities as $accommodationFacility){
            array_push($accommodationFacilityArray,$accommodationFacility->name);
        }

        foreach($facilities as $activity){
            $activity->ischeck = 0;
            if(in_array($activity->name, $accommodationFacilityArray)){
                $activity->ischeck =1;
            }
            $tempArray[] = $activity;
        }
        if(!empty($activity)){
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $tempArray;
        }else{
        $this->status = 422;
        $this->response['success'] = false;
        $this->response['message'] = 'Please Upload Activities Missing In DB';

       }

       return response()->json($this->response, $this->status);
    }
   public function removeTransportFeatures(Request $request){
    TransportFeature::where('transport_id', $request->transport_id)->delete();
   }
    //get all transport features private
    public function getTransportFeature(Request $request){

        if(isset($request->category) && !empty($request->category)){
            $facilities = Facility::where('user_module_type','transports')->where('category',$request->category)->orderBy('id', 'DESC')->get();
        }else{
            $facilities = Facility::where('user_module_type','transports')
                    // ->where('category',$request->category)
                    ->orderBy('id', 'DESC')->get();
        }
        $transportFeatures =  TransportFeature::where('transport_id',$request->transport_id)->orderBy('id', 'DESC')->get();

        $tempArray =[];
        $transportFeaturesArray =[];
        foreach($transportFeatures as $feature){
            //print_r($feature->title);exit;
            array_push($transportFeaturesArray,$feature->title);
        }
        //print_r($transportFeaturesArray);exit;
        foreach($facilities as $activity){
            $activity->ischeck = 0;
            if(in_array($activity->name, $transportFeaturesArray)){
                $activity->ischeck =1;
            }
            $tempArray[] = $activity;
        }
        if(!empty($activity)){
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $tempArray;
        }else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Please Upload Features Missing In DB';
       }

       return response()->json($this->response, $this->status);
    }

    /**
     * @Description Get All Countries
     * @return \Illuminate\Http\JsonResponse
     * @Author Khuram Qadeer.
     */
    public function getAllCountries()
    {
        $this->response['success'] = true;
        $this->response['data'] = Country::all();
        return response()->json($this->response, $this->status);
    }
    public function getExchangeCurrency(){
        $this->response['success'] = true;
        $this->response['data'] = Country::select('currency', 'exchange_rate','name')->Where('is_publish',1)->get();
        return response()->json($this->response, $this->status);
    }
    public function getCountries(){

        $this->response['success'] = true;
        $this->response['data'] = Country::select('id', 'name')->get();
        return response()->json($this->response, $this->status);
    }

    /**
     * @Description Get All Photographer skills
     *
     * @return \Illuminate\Http\JsonResponse
     * @Author Khuram Qadeer.
     */
    public function getAllPhotographerSkills()
    {
        $this->response['success'] = true;
        $this->response['data']['skills'] = PhotographerSkill::all();
        return response()->json($this->response, $this->status);
    }

    /**
     * @Description Get All Photographer types
     * @return \Illuminate\Http\JsonResponse
     * @Author Khuram Qadeer.
     */
    public function getAllPhotographerTypes()
    {
        $this->response['success'] = true;
        $this->response['data']['types'] = PhotographerType::all();
        return response()->json($this->response, $this->status);
    }

public function stripeListen(){
$payload = @file_get_contents('php://input');
$event = null;

try {
    $event = \Stripe\Event::constructFrom(
        json_decode($payload, true)
    );
    //print_r($event);
} catch(\UnexpectedValueException $e) {
    // Invalid payload
    http_response_code(400);
    exit();
}

// Handle the event
switch ($event->type) {
    case 'payment_intent.succeeded':
        $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
        // Then define and call a method to handle the successful payment intent.
        // handlePaymentIntentSucceeded($paymentIntent);
        break;
    case 'payment_method.attached':
        $paymentMethod = $event->data->object; // contains a \Stripe\PaymentMethod
        // Then define and call a method to handle the successful attachment of a PaymentMethod.
        // handlePaymentMethodAttached($paymentMethod);
        break;
    // ... handle other event types
    default:
        echo 'Received unknown event type ' . $event->type;
}

http_response_code(200);
}
    /**
     * @Description Get All Vehicles
     * @return \Illuminate\Http\JsonResponse
     * @Author Khuram Qadeer.
     */
    public function getAllVehicles()
    {
        $this->response['success'] = true;
        $this->response['data']['vehicles'] = Vehicle::getAll();
        return response()->json($this->response, $this->status);
    }

    /**
     * @Description Get All States by country id
     * @param $countryId
     * @return \Illuminate\Http\JsonResponse
     * @Author Khuram Qadeer.
     */
    public function getStatesByCountryId($countryId)
    {
        $this->response['success'] = true;
        $this->response['data']['states'] = State::getStates($countryId);
        return response()->json($this->response, $this->status);
    }

    /**
     * @Description Get all cities by state id
     * @param $stateId
     * @return \Illuminate\Http\JsonResponse
     * @Author Khuram Qadeer.
     */
    public function getCitiesByStateId($stateId)
    {
        $this->response['success'] = true;
        $this->response['data']['cities'] = City::getCities($stateId);
        return response()->json($this->response, $this->status);
    }

    /**
     * @Description Get All meals
     * @return \Illuminate\Http\JsonResponse
     * @Author Khuram Qadeer.
     */
    public function getAllMeals()
    {
        $this->response['success'] = true;
        $this->response['data']['meals'] = Meal::getAll();
        return response()->json($this->response, $this->status);
    }

    /**
     * @Description Get All User Roles
     * @return \Illuminate\Http\JsonResponse
     * @Author Khuram Qadeer.
     */
    public function getRoles()
    {
        $this->response['success'] = true;
        $this->response['data']['roles'] = UserRole::all();
        return response()->json($this->response, $this->status);
    }

    /**
     * @Description Get Current User Data
     * @param Request $request
     * @return array
     * @Author Khuram Qadeer.
     */
    public function getCurrentUserData(Request $request)
    {
        $user = $request->user();
        $this->response['success'] = true;
        if ($user) {
            $this->response['data']['user'] = $user;
            $this->response['data']['user_activities'] = ActivityLink::getUserActivities($user->id);
            $this->response['data']['user_languages'] = UserLanguage::getUserLanguages($user->id);
            $this->response['data']['user_previous_trips'] = PreviousTrip::getAllUserPreviousTripsData($user->id);
            $this->response['data']['user_packages'] = Package::getAllUserPackages($user->id);
            $this->response['data']['user_planned_trips'] = PlannedTrip::getByUsername($user->username);
            $this->response['data']['user_interest_trips'] = InterestTrip::getByUsername($user->username);
            // photographer and movie maker
            if ($user->role_id == 9 || $user->role_id == 5) {
                $this->response['data']['photographer_skills'] = PhotographerSkillLink::getByUsedId($user->id);
                $this->response['data']['photographer_types'] = PhotographerTypeLink::getByUserId($user->id);
            } // Visa consultant
            elseif ($user->role_id == 6) {
                $this->response['data']['visa_consultant_countries'] = UserCountry::getByUserId($user->id, 'visa_consultant');
            } // Host Services
            elseif ($user->is_host == 1) {
                $this->response['data']['host_accommodations'] = UserAccommodation::getByUserId($user->id);
                $this->response['data']['host_transports'] = UserTransport::getByUserId($user->id);
                $this->response['data']['host_meals'] = UserMeal::getByUserId($user->id);
                $this->response['data']['host_activities'] = UserHostTrip::getByUserId($user->id);
            }
        }
        return response()->json($this->response, $this->status);
    }

    /**
     * @Description Get All Cities of Current user country
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @Author Khuram Qadeer.
     */
    public function getAllKnowledgeCities(Request $request)
    {
        $this->response['success'] = true;
        $this->response['data']['cities'] = KnowledgeCity::getByUserId($request->user()->id);
        return response()->json($this->response, $this->status);
    }

    /**
     * @Description Get All Host Services Name
     * @return \Illuminate\Http\JsonResponse
     * @Author Khuram Qadeer.
     */
    public function getHostServices()
    {
        $this->response['success'] = true;
        $this->response['data']['host_services'] = [
            ['id' => 1, 'name' => 'Accommodations'],
            ['id' => 2, 'name' => 'Transports'],
            ['id' => 3, 'name' => 'Meals'],
            ['id' => 4, 'name' => 'Activities'],
        ];
        return response()->json($this->response, $this->status);
    }

    /**
     * @Description Get Listing data
     * @return \Illuminate\Http\JsonResponse
     * @Author Khuram Qadeer.
     */
    public function getListData()
    {
        $this->response['success'] = true;
        $this->response['data'][]['category'] = ['id' => 1, 'name' => 'facilities', 'options' => Facility::getAll()];
        $this->response['data'][]['category'] = ['id' => 2, 'name' => 'languages', 'options' => Language::getAll()];
        $this->response['data'][]['category'] = ['id' => 3, 'name' => 'amenities', 'options' => Amenity::getAll()];
        $this->response['data'][]['category'] = ['id' => 4, 'name' => 'photographer_skills', 'options' => PhotographerSkill::all()];
        $this->response['data'][]['category'] = ['id' => 5, 'name' => 'photographer_type', 'options' => PhotographerType::all()];
        $this->response['data'][]['category'] = ['id' => 6, 'name' => 'vehicles', 'options' => Vehicle::getAll()];
        $this->response['data'][]['category'] = ['id' => 7, 'name' => 'meals', 'options' => Meal::getAll()];

        return response()->json($this->response, $this->status);
    }

    // get general services
    public function getGeneralServices(){
        $general_services = GeneralService::select('id', 'name', 'module', 'image', 'user_module_type')->where('status', 1)->where('type', '1')->orderBy('sort_order','DESC')->get();

        $this->response['success'] = true;
        $this->response['data']['general_services'] = $general_services;
         return response()->json($this->response, $this->status);
    }
    public function destinationsLanguages(){
        $destinations = Destination::select('id', 'name')->get()->toArray();
        $languages = Language::select('id', 'name')->get()->toArray();
        $transport_company_fleet = TransportCompanyFleet::select('id', 'name')->get()->toArray();
        $transport_company_services = TransportCompanyService::select('id', 'name')->get()->toArray();
        $this->response['success'] = true;
        $this->response['data']['destinations'] = array_column($destinations, 'name');
        $this->response['data']['languages'] = array_column($languages, 'name');
        $this->response['data']['transport_company_fleet'] = $transport_company_fleet;
        $this->response['data']['transport_company_services'] = $transport_company_services;
        
         return response()->json($this->response, $this->status);
    }
    public function getPaymentGateWayDetails()
    {
        $stripe_detail = array(
            'name'=>'stripe',
            'client_key'=>config('services.stripe.key'),
        );
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $stripe_detail;
        return response()->json($this->response, $this->status);
    }

    public function ourExpertiseActivitiesWeDo(){

        $data['activites_we_do'] = ActivitiesWeDo::select('id', 'name', 'image')->get()->toArray();
        $data['our_expertise'] = OurExpertise::select('id', 'name', 'image')->get()->toArray();

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        return response()->json($this->response, $this->status);

    }

    public function addCountries(){

        $users = User::find(auth()->user()->id);
        if(isset(request()->countries) && !empty(request()->countries)){
            $countries = json_decode(request()->countries, true);
            if(!empty($countries) && !empty($users)){
                $users->countries()->sync($countries);
            }
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Countries add successfully';
            $this->response['data'] = $users;
        }else{
            $this->status = 422;
            $this->response['success'] = true;
            $this->response['message'] = 'Something went wrong';
        }
        return response()->json($this->response, $this->status);
    }

    public function uploadImageBase64(Request $request)
    {
        $request->validate([
            'imageFile' => 'image|nullable'
        ]);

        if(request()->module == 'restaurants'){
            if(auth()->user() && auth()->user()->user_module_type != 'restaurants'){
                $this->status = 422;
                $this->response['success'] = true;
                $this->response['message'] = 'Something went wrong, login with reataurant module';
                return response()->json($this->response, $this->status);
            }
        }

        $folderPath = '/assets/uploads/' . request()->module.'/';
        $file_name = uniqid().strtotime("now"). '.jpg';
        if($request->file('imageFile')){

            $file = $request->file('imageFile');
            $file = $file->move(public_path($folderPath), $file_name);
            Optimizer::optimize($file);
            // Optimizer::optimize(public_path().$file);

        } else {
            $image_parts = explode(";base64,", request()->image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $imageFile = base64_decode($image_parts[1]);
            $file = $folderPath.$file_name;
            \File::put(public_path().$file, $imageFile);
            Optimizer::optimize(public_path().$file);
        }



        if (!file_exists(public_path().$folderPath)) {
            mkdir(public_path().$folderPath, 0777, true);
        }


        if(request()->module == 'users' || request()->module == 'companies' || request()->module == 'restaurants'){
            if(request()->module == 'companies'){
                $users = Company::firstOrNew(array('user_id' => auth()->user()->id));
                // $users = Company::where('user_id',auth()->user()->id)->first();
                $users->image = $file_name;
            }else if(request()->module == 'restaurants'){
                $service_provider_rates = [];

                $service_provider_rates['restaurant_image'] = $file_name;
                $service_provider_rates['user_id'] = auth()->user()->id;
                ServiceProviderRate::updateOrCreate(['user_id'=>auth()->user()->id],$service_provider_rates);
                $users = auth()->user();
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'Updated Successfully';
                $this->response['imagePath'] = $file_name;
                $this->response['data'] = $users;

                return response()->json($this->response, $this->status);

            }
            else{
                $users = User::find(auth()->user()->id);
                $users->image = $file_name;
            }

            if ($users->save()) {
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'Updated Successfully';
                $this->response['imagePath'] = $file_name;
                $this->response['data'] = $users;
            } else {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = 'SomeThing Went Wrong!.';
            }
            return response()->json($this->response, $this->status);

        }else{
            $alreadyExist = modelImage::where('module_id', $request->module_id)->where('module', $request->module)->where('type', 'main')->first();
            if ($alreadyExist) {
                $data = new modelImage;
                $data->name = $file_name;
                $data->type = 'normal';
                $data->module = $request->module;
                $data->module_id = $request->module_id;
                if ($data->save()) {
                    $this->status = 200;
                    $this->response['success'] = true;
                    $this->response['message'] = 'Updated Successfully';
                    $this->response['imagePath'] = $file_name;
                    $this->response['data'] = $data;
                } else {
                    $this->status = 422;
                    $this->response['success'] = false;
                    $this->response['message'] = 'SomeThing Went Wrong!.';
                }
                return response()->json($this->response, $this->status);
            } else {
                $data = new modelImage;
                $data->name = $file_name;
                $data->type = 'main';
                $data->module = $request->module;
                $data->module_id = $request->module_id;
                if ($data->save()) {
                    $this->status = 200;
                    $this->response['success'] = true;
                    $this->response['message'] = 'Updated Successfully';
                    $this->response['imagePath'] = $file_name;
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
        return $file.'+=== '.$file_name;

    }

    public function updateFeaturedImage(Request $request){
        $model = '\\App\\Models\\' . $request->moduleclass;
        $service = new $model;
        $service = $service->find($request->module_id);

        if($service){
            modelImage::where('module_id', $service->id)->update(['type' => 'normal']);
        }

        $image = modelImage::find($request->image_id)->update(['type' => 'main']);

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Updated Successfully';
        $this->response['data'] = modelImage::where('module_id', $service->id)->where('module', modelImage::find($request->image_id)->module)->get();
        return response()->json($this->response, $this->status);



        $images = modelImage::where('module_id', request()->module_id)->get();
        if(!empty($images)){
            foreach ($images as $key => $value) {
                if($value->type == 'main'){
                    $image = modelImage::find($value->id);
                    $image->type = 'normal';
                    $image->save();
                }
            }
            if($image = modelImage::find(request()->image_id)){
                $image->type = 'main';

                if ($image->save()) {
                    $this->status = 200;
                    $this->response['success'] = true;
                    $this->response['message'] = 'Updated Successfully';
                    $this->response['data'] = $image;
                } else {
                    $this->status = 422;
                    $this->response['success'] = false;
                    $this->response['message'] = 'SomeThing Went Wrong!.';
                }
            }
        }
        return response()->json($this->response, $this->status);
    }

    public function uploadDocument(Request $request){


        $profileImage = $request->file('document');
        $profileImageSaveAsName = time() . Auth::id() . "-document." . $profileImage->getClientOriginalExtension();
        $upload_path = 'assets/uploads/documents/';
        $resumes= $upload_path . $profileImageSaveAsName;
        $success = $profileImage->move($upload_path, $profileImageSaveAsName);


        $data = new modelImage;
        $data->name = $profileImageSaveAsName;
        $data->type = 'document';
        $data->module = $request->module;
        $data->module_id = $request->module_id;
        if ($data->save()) {
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Updated Successfully';
            $this->response['imagePath'] = $profileImageSaveAsName;
            $this->response['data'] = $data;
        } else {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'SomeThing Went Wrong!.';
        }
        return response()->json($this->response, $this->status);



    }

    public function setExchangeRates(){

    $url = "https://api.exchangerate.host/latest?base=PKR";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    curl_close($curl);
    $decodeResponse =  json_decode($resp);

    $countries =  Country::all();
    foreach($decodeResponse->rates as $key=> $value){
        foreach($countries as $country)
        if($country->currency == $key) {
            $country->exchange_rate = $value;
            $country->save();
        }
    }
  }

  public function getVersion(){

    $getVersions = Versions::take(1)->first();

    $this->status = 200;
    $this->response['success'] = true;
    $this->response['message'] = '';
    $this->response['data'] = $getVersions;

    return response()->json($this->response, $this->status);

  }

  // check image exit or not 
  public function copyImageToThumb($user_module_type=null){
    if(isset($user_module_type) && !empty($user_module_type)){
        $users = User::with('company')
                        // ->where('user_module_type', $user_module_type)
                        ->get();

        if(!empty($users)){
            foreach ($users as $key => $value) {
                if($value->company && $value->company->image){
                    $path = public_path('/assets/uploads/companies');
                    $check_file = $path.'/'.$value->company->image;
                    if(file_exists($check_file)){
                        if(!file_exists($path.'/'.$value->company->image.'_thumb.jpg')){
                            Optimizer::optimize($check_file);
                        }
                    }
                }

                if($value->company && $value->image){
                    $path = public_path('/assets/uploads/users');
                    $check_file = $path.'/'.$value->image;
                    if(file_exists($check_file)){
                        if(!file_exists($path.'/'.$value->image.'_thumb.jpg')){
                            Optimizer::optimize($check_file);
                        }
                    }
                }

            }
        }
    }
    return 'image copy successfully';
  }
  // check image exit or not 
  public function copyPackagesImageToThumb($module_type){

    if(isset($module_type) && !empty($module_type)){

        $images = modelImage::where('module', $module_type)->get();
        
        if(isset($images) && !empty($images)){
            foreach ($images as $key => $value) {
                if($value && $value->name){
                    $path = public_path('/assets/uploads/'.$module_type);
                    $check_file = $path.'/'.$value->name;
                    // dd($check_file);
                    if(file_exists($check_file)){
                        if(!file_exists($path.'/'.$value->name.'_thumb.jpg')){
                            Optimizer::optimize($check_file);
                        }
                    }
                }
            }
        }
    }
    return 'image copy successfully';
  }

    public function fixedFeatureImage($module_type){

        $images = modelImage::select('module_id')->where('module', $module_type)->whereIn('type', ['main','normal'])
                                    ->whereNotNull('module_id')
                                    ->orderBy('module_id', 'ASC')
                                    // ->orderBy('type', 'ASC')
                                    ->groupBy('module_id')->get();
        
        $array_data = [];

        if(isset($images) && !empty($images)){
            $module_id = 0;
            
            foreach ($images as $key => $value) {

                
                $fetch_images = modelImage::where('module_id', $value->module_id)->where('module', $module_type)->orderBy('type', 'ASC')
                                            ->get();
                                            // ->toSql();
                // dd($fetch_images, );
                $is_featured_image = 1;
                // dd($fetch_images->toArray());
                foreach ($fetch_images as $key => $val) {
                    
                    if($module_id != $val->module_id){
                        $module_id = $val->module_id;
                        
                        if($val->name && $val->type == 'main'){
                            $is_featured_image = 0;
                        }
                    }else{
                        $module_id = $val->module_id;
                        if($val->name && $val->type == 'main'){
                            $is_featured_image = 0;
                        }
                    }
                }

                // dd($value->module_id, $is_featured_image);

                if($is_featured_image){
                    // dd($value->module_id);
                    array_push($array_data, ['module_id' => $value->module_id, 'is_featured_image' => $is_featured_image]);
                    // dd($value->module_id, $is_featured_image);
                    $imag = modelImage::where('module_id', $value->module_id)->where('module', $module_type)->first();
                    $imag->type = 'main';
                    $imag->save();
                }
            }

            dd($array_data);
        }

    }
}
