<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Facility;
use App\Models\Guide;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\GuideActivity;
use App\Models\Host;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Models\ActivitiesWeDo;
use App\Models\CancellationPolicy;
use App\Models\OurExpertise;
use App\Models\PackageFacility;
use App\Models\PackageItinerary;
use App\Models\PackagesCoveredEvents;
use App\Models\TripsProperty;
use App\Models\PackageVideo;
use Illuminate\Support\Facades\File;
use App\Models\Meal;
use App\Models\Rule;
use App\Models\Transport;



class GuideController extends Controller{

    protected $status = 200;
    protected $response = [];

    public function index(Request $request){

        $serviceMessage = '';

        $data = [];

        $user_module_type = (isset($request->user_module_type) && !empty($request->user_module_type)) ? $request->user_module_type : '';
        $locations = (isset($request->locations) && !empty($request->locations)) ? $request->locations : '';


        if(count($request->all()) > 0){

            $proRating =   $request->rating;
            $min =  $request->minValue ;
            $max =  $request->maxValue ;
            $country = $request->country;
            $city = $request->city;

            $distance_result = '';
            $rad = 50;
            $lat = 0;
            $lng = 0;

            // if (isset($request->lat) && !empty($request->lat) && isset($request->lng) && !empty($request->lng)) {
            $lat = isset($request->lat) ? round((float)$request->lat, 8) : 0;
            $lng = isset($request->lng) ? round((float)$request->lng, 8) : 0;
            $rad = isset($request->radius) ? (int)$request->radius : 0;

            $rad = floor($rad / 1000);

                // $distance_result = "(6371 * acos(cos(radians($lat))
                //     * cos(radians(lat))
                //     * cos(radians(lng)
                //     - radians($lng))
                //     + sin(radians($lat))
                //     * sin(radians(lat))))";

                $distance_result = 'ROUND(DEGREES(ACOS(SIN(RADIANS('.$lat.')) 
                    * SIN(RADIANS(lat)) 
                    + COS(RADIANS('.$lat.'))  
                    * COS(RADIANS(lat))
                    * COS(RADIANS('.$lng.' - lng)))) * 69.09)';


            // }

            $data = Guide::withAvg('ratings','average_rating')
                ->withAvg('ratingsProfile', 'average_rating')
                ->withAvg('rating_values', 'average_rating')
                ->where(function($query) use ($proRating,$min,$max,$country,$city, $distance_result, $rad) {
                    // if (!empty($distance_result) && !empty($rad)) {
                    //     $query->selectRaw("{$distance_result} AS distance")
                    //         ->whereRaw("{$distance_result} < ?", [$rad]);
                    // }
                    if (!empty($distance_result) && !empty($rad)) {
                        $query->selectRaw("{$distance_result} AS distance")->whereRaw("{$distance_result} < ?", [$rad])->orderBy('distance');
                    }else{
                        $query->addSelect(\DB::raw($distance_result . " as distance"));
                        $query->orderBy(\DB::raw($distance_result));
                    }

                    if($proRating > 0){
                        $query->where('rating',$proRating);
                    }
                    if($min > 0){
                        $query->Where('price','>=', $min);
                    }
                    if($max > 0){
                        $query->Where('price','<=', $max);
                    }
                    if(!empty($country)){
                        $query->Where('country', $country);
                    }
                    if(!empty($city)){
                        $query->Where('city', $city);
                    }
                })
                ->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
            // dd($data);
        }else{

            $data = Guide::withAvg('ratings','average_rating')
                ->withAvg('ratingsProfile', 'average_rating')
                ->withAvg('rating_values', 'average_rating')
                ->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));

        }

        if(empty($data)){
            $data='Record Not Found';
        }

        if(!empty($user_module_type) && $user_module_type == 'restaurants'){

                $distance_result = "(6371 * acos(cos(radians($lat))
                    * cos(radians(restaurant_lat))
                    * cos(radians(restaurant_lng)
                    - radians($lng))
                    + sin(radians($lat))
                    * sin(radians(restaurant_lat))))";

            }else{
                $distance_result = "(6371 * acos(cos(radians($lat))
                    * cos(radians(lat))
                    * cos(radians(lng)
                    - radians($lng))
                    + sin(radians($lat))
                    * sin(radians(lat))))";
            }

        if(!empty($lat) && !empty($lng) && isset($request->search_by_filter) && $request->search_by_filter == 1){
            $serviceData = User::with(['ServiceProviderRates','trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])->where('lat','like',$lat.'%')->where('lng','like',$lng.'%')->get();

            if($serviceData->count() < 1){
                $serviceMessage = "This service is currently not available in this area but here are other nearby services";
            }
        }

        if($request->user()){

            $host =  User::with(['ServiceProviderRates','trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])->withAvg('ratings', 'average_rating')->withAvg('rating_values', 'average_rating')->where('id',$request->user()->id)->first();

            // $service_providers = User::withAvg('ratings', 'average_rating')->with(['ServiceProviderRates','userServices' => function($q){
            //   return $q->where('module', 'Guide')->first();
            // }])
            // ->when((isset(request()->user_module_type) && !empty(request()->user_module_type)),function($q){
            //   $q->where('user_module_type', request()->user_module_type);
            // })->where('type', 1)->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));

            $service_providers = User::with(['ServiceProviderRates','trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])->withAvg('ratings', 'average_rating')->withAvg('rating_values', 'average_rating')->with(['ServiceProviderRates','userServices'])
                ->when(!empty($distance_result), function ($query) use ($distance_result, $rad, $user_module_type, $locations){
                    if(!empty($rad)){
                        $q->selectRaw("{$distance_result} AS distance")->whereRaw("{$distance_result} < ?", [$rad])->orderBy('distance');
                    }else{
                        $q->addSelect(\DB::raw($distance_result . " as distance"));
                        $q->orderBy(\DB::raw($distance_result));
                    }

                })
                ->when((isset($request->verified)), function($query) use($request){
                    $query->where('verified', $request->verified);
                })
                ->when((isset($request->gender) && !empty($request->gender) && $request->gender != 'no'), function($query) use ($request){
                    $query->where('gender', $request->gender);
                })
                ->when((isset(request()->user_module_type) && !empty(request()->user_module_type)),function($q){
                    $q->where('user_module_type', request()->user_module_type);
                })->where('type', 1)->orderBy('distance', 'ASC')
                ->paginate(Config::get('global.pagination_records'));


            $data = $service_providers;

        }else{

            $service_providers = User::with(['ServiceProviderRates','trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])->withAvg('ratings', 'average_rating')->withAvg('rating_values', 'average_rating')->with(['ServiceProviderRates','userServices' => function($q){
                return $q->where('module', 'Guide')->first();
            }])
                // ->when((isset(request()->user_module_type) && !empty(request()->user_module_type)),function($q){
                //   $q->where('user_module_type', request()->user_module_type);
                ->when(!empty($distance_result), function ($query) use ($distance_result, $rad, $user_module_type, $locations){
                    if (!empty($rad)) {
                        $query->selectRaw("{$distance_result} AS distance")->whereRaw("{$distance_result} < ?", [$rad])->orderBy('distance');
                    }else{
                        $query->addSelect(\DB::raw($distance_result . " as distance"));
                        $query->orderBy(\DB::raw($distance_result));
                    }
                })
                ->when((isset($request->gender) && !empty($request->gender) && !is_null($request->gender) && $request->gender != 'no'), function($query) use ($request){
                    $query->where('gender', $request->gender);

                })
                ->when((isset($request->price_rate) && !empty($request->price_rate)), function($query) use ($request){
                    $request->minValue = $request->minValue ? $request->minValue : 0;

                    $query->whereHas('ServiceProviderRates', function($q) use($request){
                        if($request->price_rate == 'price_per_hour_rate'){
                            if(isset($request->maxValue) && !empty($request->maxValue)){
                                $q->where('price_per_hour_rate', '>=', $request->minValue)
                                    ->where('price_per_hour_rate', '<=', $request->maxValue)
                                    ->where('is_free_service', 0);
                            }
                        }else if($request->price_rate == 'price_per_day_rate'){
                            if(isset($request->maxValue) && !empty($request->maxValue)){
                                $q->where('price_per_day_rate', '>=', $request->minValue)
                                    ->where('price_per_day_rate', '<=', $request->maxValue)
                                    ->where('is_free_service', 0);
                            }

                        }else if($request->price_rate == 'is_free_service'){
                            return $q->where('is_free_service',1);
                        }
                    });


                })
                ->when((isset($request->trip_type) && !empty($request->trip_type)), function($query) use ($request) {
                    $query->whereHas('ourExpertise', function($q) use($request){
                        $trip_type = json_decode($request->trip_type, true);
                        if(!empty($trip_type)){
                            $trip_type = array_column($trip_type, 'id');
                            if(!empty($trip_type)){
                                // $trip_type = [1,2,3];
                                $q->whereIn('our_expertise_id', $trip_type);
                            }
                        }
                    });


                })
                ->when((isset($request->activities) && !empty($request->activities)), function($query) use ($request) {

                    $query->whereHas('activitiesWeDo', function($q) use($request){
                        $activities = json_decode($request->activities, true);
                        if(!empty($activities)){
                            $activities = array_column($activities, 'id');
                            if(!empty($activities)){
                                // $activities = [1,2,3];
                                $q->whereIn('activities_we_do_id', $activities);
                            }
                        }
                    });

                })
                ->when((isset($request->payment_mode)), function($query) use ($request){
                    $query->where(function($q) use ($request) {
                        if($request->payment_mode == 1){
                            $q->whereRelation('ServiceProviderRates','payment_mode', 1)
                                ->whereRelation('ServiceProviderRates','payment_partial_value', $request->payment_partial_value);
                        }else if($request->payment_mode == 0){
                            $q->whereRelation('ServiceProviderRates','payment_mode', 0);
                        }
                    });

                })
                ->when((isset($request->verified)), function($query) use($request){
                    $query->where('verified', $request->verified);
                })
                ->when((isset($request->expert_consultancy) && !empty($request->expert_consultancy)), function($query) use ($request){
                    $expert_consultancy = json_decode($request->expert_consultancy, true);
                    if(!empty($expert_consultancy)){
                        foreach ($expert_consultancy as $key => $value) {
                            $query->whereJsonContains('expert_consultancy', $value);
                        }

                        // $query->whereRaw("find_in_set('".$request->expert_consultancy."',users.expert_consultancy)");
                    }
                })
                ->when((isset($request->meal_type) && !empty($request->meal_type)), function($query) use ($request){
                    $meal_type = json_decode($request->meal_type, true);
                    if(!empty($meal_type)){
                        $query->whereHas('meals_types', function($q) use($request, $meal_type){
                            $q->whereIn('name', $meal_type);
                            // $q->whereJsonContains('meals', $meal_type);
                        });
                    }
                })

                ->when((isset($request->service_type) && !empty($request->service_type)), function($query) use ($request){
                    $service_type = json_decode($request->service_type, true);
                    if(!empty($service_type)){
                        $query->whereHas('ServiceProviderRates', function($q) use($request){
                            $q->whereJsonContains('experties', json_decode($request->service_type));
                            // $q->whereRaw("find_in_set('".$request->service_type."',service_provider_rates.experties)");
                        });
                    }
                })
                ->when((isset($request->cancellation) && isset($request->cancellation_hours) && !empty($request->cancellation_hours)), function($query) use($request){
                    $query->where(function($q) use ($request) {
                        $q->whereRelation('cancellation_policy','cancellation_hour',$request->cancellation_hours);
                    });
                })

                ->when((isset(request()->user_module_type) && !empty(request()->user_module_type)),function($q){
                    $q->where('user_module_type', request()->user_module_type);
                })
                ->where('type', 1)

                // ->when($user_module_type !== 'restaurants', function($query){
                //     $query->orderBy('distance');
                // })
                // ->orderBy('distance')
                ->orderBy('distance', 'ASC')
                // ->toSql();
                ->paginate(Config::get('global.pagination_records'));
            // return $service_providers;
            $data = $service_providers;
        }

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        $this->response['serviceMessage'] = $serviceMessage;
        $this->response['message'] = 'List Fetch Successfully';

        return response()->json($this->response,$this->status);

    }

    public function detail($Id){

        if(!empty($Id)){
            addCounter('guides', $Id);
        }

        $detail =  Guide::withAvg('rating_values','average_rating')
            ->withAvg('rating_values','rating_value_1')
            ->withAvg('rating_values','rating_value_2')
            ->withAvg('rating_values','rating_value_3')
            ->withAvg('rating_values','rating_value_4')
            ->withAvg('rating_values','rating_value_5')
            ->withSum('rating_values','rating_value_1')
            ->withSum('rating_values','rating_value_2')
            ->withSum('rating_values','rating_value_3')
            ->withSum('rating_values','rating_value_4')
            ->withSum('rating_values','rating_value_5')
            ->withSum('rating_values','average_rating')
            ->withAvg('trips_vendor_ratings', 'rating_value')

            ->where('id',$Id)->first();
        if(!$detail){
            $this->status = 200;
            $this->response['success'] = false;
            $this->response['message'] = 'invalid Id';
            return response()->json($this->response,$this->status);
        }

        $percentage_50  = percentage($detail->price, 50);
        $percentage_50_plus = $detail->price + $percentage_50;
        $percentage_50_minus = $detail->price - $percentage_50;

        $lat = isset($detail->lat) ? (float)$detail->lat : 0;
        $lng = isset($detail->lng) ? (float)$detail->lng : 0;
        $rad = 10000;// isset($request->radius) ? (int)$request->radius : 50;

        $distance_result = "(6371 * acos(cos(radians($lat))
                * cos(radians(lat))
                * cos(radians(lng)
                - radians($lng))
                + sin(radians($lat))
                * sin(radians(lat))))";

        $relatedData =   Guide::withAvg('ratings','average_rating')
            ->withAvg('rating_values','average_rating')
            ->where('is_published', 1)
            ->withAvg('ratingsProfile', 'average_rating')
            ->with('singleImage')
            ->with('guide_user')
            ->where('id', '<>', $detail->id)
            // ->whereBetween('price', [$percentage_50_minus, $percentage_50_plus])
            ->when(!empty($distance_result), function ($query) use ($distance_result, $rad){
                $query->selectRaw("{$distance_result} AS distance")->whereRaw("{$distance_result} < ?", [$rad]);
            })
            ->where(function($query) use($detail){
                $query->where('package_type', $detail->package_type);
            })
            // ->where(function($query) use($detail){
            //     $query->where('user_id', $detail->user_id);
            // })
            ->take(6)
            ->get();

        $pastTripData = Trip::with('singleImage')->where('guide_id',$Id)->groupBy('location')->select('location', DB::raw('count(*) as total'))->take(1)->get();
        $pastTripCounter = Trip::where('guide_id',$Id)->count();
        $userId  = $detail->user_id;
        $totalTrips = Trip::where('user_id',$userId)->count();
        $userObj =   User::with(['ServiceProviderRates','trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])->where('id',$userId)->first();

        $data['detail'] = $detail;
        $data['relatedData'] = $relatedData;
        $data['userObj'] = $userObj;
        $data['tripData'] = $pastTripData;
        $data['pastTripCount'] = $pastTripCounter;
        $data['totalTrips'] = $totalTrips;

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        $this->response['message'] = 'Guide package detail';
        return response()->json($this->response,$this->status);

//        return response()->json(['detail'=>$detail,'relatedData'=>$relatedData,'userObj'=>$userObj,'tripData'=>$pastTripData,'pastTripCount'=>$pastTripCounter,'totalTrips'=>$totalTrips]);
    }

    public function addGuide(Request $request){
        if(count($request->all()) > 0){
            $guides = new Guide();
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255',
                // 'location' => 'required',
                // 'country' => 'required',
                // 'city' => 'required',
                'is_free_guide' => 'numeric',
                'price' => 'numeric',


            ]);
            if ($validator->fails()) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = $validator->messages()->first();
                return response()->json($this->response, $this->status);
            }
            $guides->title = $request->title;
            $guides->location = $request->location;
            $guides->city = $request->city;
            $guides->country = $request->country;
            $guides->user_id = $request->user()->id;
            $guides->lng = $request->lng ? round($request->lng,8) : 0;
            $guides->lat = $request->lat ? round($request->lat, 8) : 0;

            if(isset($request->start_date) && !empty($request->start_date)){

                $guides->start_date = date("Y-m-d", strtotime($request->start_date));
            }
            if(isset($request->end_date) && !empty($request->end_date)){
                $guides->end_date = date("Y-m-d", strtotime($request->end_date));
            }

            //dd(auth()->user()->user_module_type);
            if(auth()->user() && !is_null(auth()->user()->user_module_type))
                $guides->user_module_type = auth()->user()->user_module_type;


            if(isset($request->duration) && !empty($request->duration)){
                $guides->duration = $request->duration;
            }

            if(isset($request->location_to) && !empty($request->location_to)){
                $guides->location_to = $request->location_to;
            }
            if(isset($request->country_to) && !empty($request->country_to)){
                $guides->country_to = $request->country_to;
            }
            if(isset($request->city_to) && !empty($request->city_to)){
                $guides->city_to = $request->city_to;
            }
            if(isset($request->latitude_to) && !empty($request->latitude_to)){
                $guides->latitude_to = round($request->latitude_to,8);
            }
            if(isset($request->longitude_to) && !empty($request->longitude_to)){
                $guides->longitude_to = round($request->longitude_to,8);
            }

            if(isset($request->number_of_days) && !empty($request->number_of_days)){
                $guides->number_of_days = $request->number_of_days ? $request->number_of_days : 0;
            }else{
                $guides->number_of_days = 0;
            }
            if(isset($request->is_day_wise_trip)){
                $guides->is_day_wise_trip = $request->is_day_wise_trip ? 1 : 0;
            }else{
                $guides->is_day_wise_trip = 1;
            }

            if(isset($request->is_free_guide)){
                if($request->is_free_guide == "false" || $request->is_free_guide == 0){
                    $guides->is_free_guide = 0;
                    $guides->price = $request->price;

                }else{
                    $guides->is_free_guide = 1;
                }
            }

            if($guides->save()){
                CancellationPolicy::forceCreate([
                    'bookable_id' => $guides->id,
                    'cancellation_hour' => '96',
                    'refund_percentage' => '100',
                    'module_name' => 'packages',
                    'bookable' => Guide::class
                ]);
    
                CancellationPolicy::forceCreate([
                    'bookable_id' => $guides->id,
                    'cancellation_hour' => '72',
                    'refund_percentage' => '75',
                    'module_name' => 'packages',
                    'bookable' => Guide::class
                ]);
    
                CancellationPolicy::forceCreate([
                    'bookable_id' => $guides->id,
                    'cancellation_hour' => '48',
                    'refund_percentage' => '50',
                    'module_name' => 'packages',
                    'bookable' => Guide::class
                ]);
                $title      = "Package";
                $message    = "Guide Package status updated successfully.To view detail";
                $action     = "packages/detail/".$guides->id;
                $admin      = User::where('role_id',User::ADMIN_ROLE_ID)->first();

                if(isset($admin) && !empty($admin)){
                    PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_GUIDE,$action,$guides->id);
                }

                $this->status = 200;
                $this->response['success'] = true;
                $this->response['data'] = $guides;
            }
        }else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Please Input Data Properly.';
        }
        return response()->json($this->response, $this->status);
    }

    public function addPackage(Request $request){

        $guides = new Guide();
        $guides->user_id = auth()->user()->id;
        if(auth()->user() && !is_null(auth()->user()->user_module_type)){
            $guides->user_module_type = auth()->user()->user_module_type;
        }

        if($guides->save()){

            CancellationPolicy::forceCreate([
                'bookable_id' => $guides->id,
                'cancellation_hour' => '96',
                'refund_percentage' => '100',
                'module_name' => 'packages',
                'bookable' => Guide::class
            ]);

            CancellationPolicy::forceCreate([
                'bookable_id' => $guides->id,
                'cancellation_hour' => '72',
                'refund_percentage' => '75',
                'module_name' => 'packages',
                'bookable' => Guide::class
            ]);

            CancellationPolicy::forceCreate([
                'bookable_id' => $guides->id,
                'cancellation_hour' => '48',
                'refund_percentage' => '50',
                'module_name' => 'packages',
                'bookable' => Guide::class
            ]);
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $guides;
        }
        $title      = "Package";
        $message    = $guides->user_module_type. " Package created successfully. To view detail";
        $action     = "/packages/detail/".$guides->id;
        $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();
        if(isset($admin) && !empty($admin)){
            PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_PACKAGE,$action,$guides->id);

            $message    = $guides->user_module_type. " Package created has been created.";
            
            PushNotification::createNotification($admin,auth()->user()->id,$title,$message,User::TYPE_PACKAGE,$action,$guides->id);
        }

        return response()->json($this->response, $this->status);
    }

    public function updateGuide(Request $request, $guide_id = 0){

        // return $request->all();

        if(!isset($request->price)){
            $request['price'] = 0;
        }

        $validator = Validator::make($request->all(), [
            // 'package_id' => 'required',
            'is_free_guide' => 'numeric',
            'price' => 'required|numeric',
            'status' => 'numeric',

        ]);

        if($guide_id == 0){
            $guide_id = $request->package_id;
            $validator = Validator::make($request->all(), [
                'package_id' => 'required'

            ]);

            if ($validator->fails()) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = $validator->messages()->first();
                return response()->json($this->response, $this->status);
            }

        }

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $guide = Guide::where('user_id',$request->user()->id)->where('id',$guide_id)->first();
        if(!$guide){
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid guide id';
            return response()->json($this->response, $this->status);
        }

        if(!empty($guide)){
            if(isset($request->end_date) && !empty($request->end_date)){

                if(isset($guide->end_date) && !empty($guide->end_date)){

                    $new_date_length = $this->getDatesFromRange($request->start_date, $request->end_date);
                    $old_date_length = $this->getDatesFromRange($guide->start_date, $guide->end_date);
                    if(count($new_date_length) != count($old_date_length)){
                        $array_package_itinerary = [];
                        foreach ($new_date_length as $key => $item) {
                            array_push($array_package_itinerary, ['time' => '', 'activity' => '', 'destination' => '', 'date' => date("Y-m-d", strtotime($item)),  'package_id' => $guide->id]);
                        }

                        if(!empty($array_package_itinerary)){
                            PackageItinerary::where('package_id', $guide->id)->delete();
                            PackageItinerary::insert($array_package_itinerary);
                        }
                    }

                }else{
                    $new_date_length = $this->getDatesFromRange($request->start_date, $request->end_date);
                    $package_itinerary = PackageItinerary::where('package_id', $guide->id)->first();
                    if(empty($package_itinerary)){
                        $array_package_itinerary = [];
                        foreach ($new_date_length as $key => $item) {
                            array_push($array_package_itinerary, ['time' => '', 'activity' => '', 'destination' => '', 'date' => date("Y-m-d", strtotime($item)),  'package_id' => $guide->id]);
                        }

                        if(!empty($array_package_itinerary)){
                            PackageItinerary::where('package_id', $guide->id)->delete();
                            PackageItinerary::insert($array_package_itinerary);
                        }

                    }
                }

            }
            // return count($new_date_length)."==".count($old_date_length);
        }

        if(isset($request->title)){
            $guide->title      = $request->title;
        }
        if(isset($request->languages)){
            $guide->languages = $request->languages;
        }
        if(isset($request->skills)){
            $guide->skills = $request->skills;
        }
        if(isset($request->about)){
            $guide->about  = $request->about;
        }
        if(isset($request->terms_rule)){
            $guide->terms_rule	= $request->terms_rule;
        }
        if(isset($request->cancellation_policy)){
            $guide->cancellation_policy	= $request->cancellation_policy;
        }
        if(isset($request->payment_terms)){
            $guide->payment_terms	= $request->payment_terms;
        }
        if(isset($request->things_to_know)){
            $guide->things_to_know = $request->things_to_know;
        }
        if(isset($request->location)){
            $guide->location	= $request->location;
        }
        if(isset($request->city)){
            $guide->city = $request->city;
        }
        if(isset($request->country)){
            $guide->country = $request->country;
        }
        if(isset($request->status)){
            $guide->status = $request->status;
        }

        if(isset($request->lng)){
            $guide->lng = $request->lng;
        }
        if(isset($request->lat)){
            $guide->lat = round($request->lat,8);
        }
        if(isset($request->duration) && !empty($request->duration)){
            $guide->duration = $request->duration;
        }

        if(isset($request->child_discount) && !empty($request->child_discount)){
            $guide->child_discount = $request->child_discount;
        }

        if(isset($request->start_date) && !empty($request->start_date)){
            $guide->start_date = date("Y-m-d", strtotime($request->start_date));
        }
        if(isset($request->end_date) && !empty($request->end_date)){

            $guide->end_date = date("Y-m-d", strtotime($request->end_date));
        }

        if(isset($request->price) && !empty($request->price)){
            $guide->price = $request->price;
        }

        if(isset($request->is_free_guide)){
            if($request->is_free_guide == 0){
                $guide->is_free_guide = $request->is_free_guide;
                $guide->price = $request->price;
            }else{
                $guide->is_free_guide = $request->is_free_guide;
            }
        }

        if(isset($request->package_type)){
            $guide->package_type = $request->package_type;
        }
        if(isset($request->estimated_no_days)){
            $guide->estimated_no_days = $request->estimated_no_days;
        }
        if(isset($request->is_copy_document)){
            $guide->is_copy_document = $request->is_copy_document ? 1 : 0;
        }
        if(isset($request->document_note)){
            $guide->document_note = $request->document_note;
        }
        if(isset($request->no_copies)){
            $guide->no_copies = $request->no_copies;
        }
        if(isset($request->documents_filled_by_applicant)){
            $guide->documents_filled_by_applicant = $request->documents_filled_by_applicant;
        }

        if(isset($request->location_to) && !empty($request->location_to)){
            $guide->location_to = $request->location_to;
        }
        if(isset($request->country_to) && !empty($request->country_to)){
            $guide->country_to = $request->country_to;
        }
        if(isset($request->city_to) && !empty($request->city_to)){
            $guide->city_to = $request->city_to;
        }
        if(isset($request->latitude_to) && !empty($request->latitude_to)){
            $guide->latitude_to = round($request->latitude_to,8);
        }
        if(isset($request->longitude_to) && !empty($request->longitude_to)){
            $guide->longitude_to = round($request->longitude_to,8);
        }

        if(isset($request->number_of_days) && !empty($request->number_of_days) && $request->number_of_days != 'null'){
            $guide->number_of_days = !is_null($request->number_of_days) ? $request->number_of_days : 0;
        }

        if(isset($request->is_day_wise_trip)){
            $guide->is_day_wise_trip = $request->is_day_wise_trip;
        }

        if(isset($request->movie_making_equipment)){
            $guide->movie_making_equipment = $request->movie_making_equipment;
        }
        if(isset($request->video_length_minutes)){
            $guide->video_length_minutes = $request->video_length_minutes;
        }
        if(isset($request->no_of_videos)){
            $guide->no_of_videos = $request->no_of_videos;
        }
        if(isset($request->no_of_days)){
            $guide->no_of_days = $request->no_of_days;
        }
        if(isset($request->video_quality)){
            $guide->video_quality = $request->video_quality;
        }
        if(isset($request->coverage_hours)){
            $guide->coverage_hours = $request->coverage_hours;
        }
        if(isset($request->trip_category)){
            $guide->trip_category = $request->trip_category;
        }

        if(isset($request->no_of_photography)){
            $guide->no_of_photography = $request->no_of_photography;
        }
        if(isset($request->resolution)){
            $guide->resolution = $request->resolution;
        }
        if(isset($request->photo_size)){
            $guide->photo_size = $request->photo_size;
        }
        if(isset($request->final_collection_usb)){
            $guide->final_collection_usb = $request->final_collection_usb;
        }
        if(isset($request->photo_book)){
            $guide->photo_book = $request->photo_book;
        }


        if(isset($request->payment_mode)){
            $guide->payment_mode = $request->payment_mode;
        }
        if(isset($request->payment_partial_value)){
            $guide->payment_partial_value = $request->payment_partial_value;
        }

        if(isset($request->photographer_equipment)){
            $guide->photographer_equipment = $request->photographer_equipment;
        }

        if(isset($request->is_offer_promotion_discount)){
            $guide->is_offer_promotion_discount = $request->is_offer_promotion_discount;
            if(isset($request->promotion_discount)){
                $guide->promotion_discount = $request->promotion_discount;
            }
        }

        if(isset($request->detail_location) && !empty($request->detail_location)){
            $guide->detail_location = $request->detail_location;
        }

        if(isset($request->latitude_detail_location) && !empty($request->latitude_detail_location)){
            $guide->latitude_detail_location = $request->latitude_detail_location;
        }
        if(isset($request->longitude_detail_location) && !empty($request->longitude_detail_location)){
            $guide->longitude_detail_location = $request->longitude_detail_location;
        }
        $title      = "Package";
        $message    = $guide->user_module_type. " Package updated successfully. To view detail";
        $action     = "/packages/detail/".$guide->id;
        $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();
        if(isset($admin) && !empty($admin)){
            PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_PACKAGE,$action,$guide->id);

            $message    = $guide->user_module_type. " Package has been updated.";

            PushNotification::createNotification($admin,auth()->user()->id,$title,$message,User::TYPE_PACKAGE,$action,$guide->id);
        }
        if($guide->save()){
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Updated Successfully';
            $this->response['data'] = $guide;
        }else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'SomeThing Went Wrong!.';
        }
        return response()->json($this->response, $this->status);
    }

    public function addActivity(){
        dd(request()->all());
    }

    public function updateActivity(Request $request, $id = null){

        $validator = Validator::make(request()->all(), [
            'activities' => 'required',
            'guide_id' => 'required|numeric',
            'type' => 'required',

        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $bookable = Guide::where('id', request()->guide_id)->where('user_id', request()->user()->id)->first();

        if(!$bookable) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid bookable';
            return response()->json($this->response, $this->status);
        }

        $activities = json_decode(request()->activities, true);

        if(!empty($activities)){
            $data = [];
            foreach ($activities as $key => $value) {

                $data[$key]['name'] = $value['name'];
                $data[$key]['image'] = $value['image'];
                $data[$key]['guide_id'] = request()->guide_id;
                $data[$key]['type'] = request()->type;
            }
            GuideActivity::where('guide_id',request()->guide_id)->where('type', request()->type)->delete();

            if(GuideActivity::insert($data)){
                if(isset($data) && !empty($data) && isset($data->id)){
                    $title      = "Activity";
                    $message    = "Activity added successfully.To view detail";
                    $action     = "packages/detail/".$data->id;
                    $admin      = User::where('role_id',User::ADMIN_ROLE_ID)->first();

                    if(isset($admin) && !empty($admin)){
                        PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_GUIDE,$action,$data->id);

                        $message    = "New Activity has been added";

                        PushNotification::createNotification($admin,auth()->user()->id,$title,$message,User::TYPE_GUIDE,$action,$data->id);
                    }
                }


                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'Updated Successfully';
                $this->response['data'] = $data;
            }else{
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = 'SomeThing Went Wrong!.';
            }


        }else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'SomeThing Went Wrong!.';
        }

        return response()->json($this->response, $this->status);

    }
    //  getGuidesForServiceProvider
    public function getGuidesForServiceProvider(Request $request){

        $user_module_type = auth()->user() ? auth()->user()->user_module_type : null;
        // return $user_module_type;

        $ldate = date('Y-m-d');

        if(count($request->all()) > 0){
            $proRating =   $request->rating;
            $min =  $request->minValue ;
            $max =  $request->maxValue ;
            $country = $request->country;
            $city = $request->city;
            // where('status',1)->
            $data = Guide::withAvg('rating_values','average_rating')
                ->where(function($query) use ($proRating,$min,$max,$country,$city) {
                    if($proRating > 0){
                        $query->where('rating',$proRating);
                    }
                    if($min > 0){
                        $query->Where('price','>=', $min);
                    }
                    if($max > 0){
                        $query->Where('price','<=', $max);
                    }
                    if(!empty($country)){
                        $query->Where('country', $country);
                    }
                    if(!empty($city)){
                        $query->Where('city', $city);
                    }
                })
                ->when((isset($user_module_type) && !is_null($user_module_type)), function($q) use ($user_module_type){
                    return $q->where('user_module_type', $user_module_type);
                })
                ->when((auth()->user()->user_module_type == 'guides' || auth()->user()->user_module_type == 'trip_operators' || auth()->user()->user_module_type == 'travel_agency'),function($query) use ($ldate){
                    $query->where(function($q) use ($ldate){
                        $q->where('is_day_wise_trip', 0)->whereDate('end_date', '>=', $ldate)->orWhereNull('end_date')->orWhere('is_day_wise_trip', 1);
                    });
                })
                // ->when((auth()->user()->user_module_type == 'guides' || auth()->user()->user_module_type == 'trip_operators' || auth()->user()->user_module_type == 'travel_agency'),function($query) use ($ldate){
                // $query->where('is_day_wise_trip', 1);
                //  })
                ->where('user_module_type', auth()->user()->user_module_type)
                ->where('user_id', auth()->user()->id)
                ->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
        }else{

            $data = Guide::withAvg('rating_values','average_rating')

                ->when((isset($user_module_type) && !is_null($user_module_type)), function($q) use ($user_module_type){
                    return $q->where('user_module_type', $user_module_type);
                })
                ->when((auth()->user()->user_module_type == 'guides' || auth()->user()->user_module_type == 'trip_operators' || auth()->user()->user_module_type == 'travel_agency'),function($query) use ($ldate){
                    $query->where(function($q) use ($ldate){
                        $q->where('is_day_wise_trip', 0)->whereDate('end_date', '>=', $ldate)->orWhereNull('end_date')->orWhere('is_day_wise_trip', 1);;
                    });
                })
                // ->when((auth()->user()->user_module_type == 'guides' || auth()->user()->user_module_type == 'trip_operators' || auth()->user()->user_module_type == 'travel_agency'),function($query) use ($ldate){
                //      $query->where('is_day_wise_trip', 1);
                //   })
                ->where('user_module_type', auth()->user()->user_module_type)
                ->where('user_id', auth()->user()->id)
                ->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
        }
        if(empty($data)){
            $data='Record Not Found';
        }
        if($request->user()){
            $host =  User::with(['ServiceProviderRates','trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])->where('id',$request->user()->id)->withAvg('rating_values','average_rating')->first();
            return response()->json(array('host'=>$host,'guides'=>$data));
        }else{
            return response()->json(['guides'=>$data]);
        }
    }

    // getPastPackages
    public function getPastPackages(Request $request){
        $ldate = date('Y-m-d');

        $user_module_type = auth()->user()->user_module_type;

        $data = Guide::withAvg('rating_values','average_rating')
            ->where('user_id', $request->user()->id)
            ->when((isset($user_module_type) && !is_null($user_module_type)), function($q) use ($user_module_type){
                return $q->where('user_module_type', $user_module_type);
            })
            ->when((auth()->user()->user_module_type == 'guides' || auth()->user()->user_module_type == 'trip_operators' || auth()->user()->user_module_type == 'travel_agency'),function($query) use ($ldate){
                $query->where('is_day_wise_trip', 0)->whereDate('end_date', '<=', $ldate);
            })
            ->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
        return response()->json(['guides'=>$data]);

    }

    public function guiderDetail($user_id = 0){

        $users = User::where('id', $user_id)->first();
        if (!$users) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'invalid Id';
            return response()->json($this->response, $this->status);
        }

        $package_type = null;
        if(isset(request()->package_type) && !empty(request()->package_type)){
            $package_type = request()->package_type;
        }
        $user_module_type = (isset(request()->user_module_type) && !empty(request()->user_module_type)) ? request()->user_module_type : null;;
        if($user_id == 0 && is_null($user_module_type)){
            $user_id = auth()->user() ? auth()->user()->id : 0;
            $user_module_type = auth()->user() ? auth()->user()->user_module_type : null;
        }else{
            if(is_null($user_module_type)){
                $user_module_type = User::where('id', $user_id)->first()->user_module_type;
            }
        }

        $data = [];
        $ldate = date('Y-m-d');
        if(isset($user_module_type) && !empty($user_module_type) && $user_module_type == 'transport_company'){
            $data['vehicle_types'] = Transport::select('id', 'vechile_type')->where('user_id', $user_id)->distinct('vechile_type')->get();
        }
        $data['activites_we_do'] = ActivitiesWeDo::all();
        $data['our_expertise'] = OurExpertise::all();
        $data['service_provider'] = User::with(['ServiceProviderRates','trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService', 'our_teams'])
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
            ->withAvg('trips_vendor_ratings', 'rating_value')
            ->where('id', $user_id)->first();

        if($user_module_type == 'home_cheff' || $user_module_type == 'restaurants'){

            $data['packages'] =  Meal::with('images')
                ->withAvg('ratings', 'average_rating')
                ->withAvg('rating_values', 'average_rating')
                ->where('user_id', $user_id)
                ->where('is_publish', 1)
                ->where('status', 1)
                ->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));

        }else if($user_module_type == 'transport_company'){
            $data['packages'] =  Transport::with('images')
                ->withAvg('ratings', 'average_rating')
                ->withAvg('rating_values', 'average_rating')
                ->where('user_id', $user_id)
                ->where('is_publish', 1)
                ->where('status', 1)
                ->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
        }else{

            if(isset(request()->package_type) && !empty(request()->package_type)){

                if(request()->package_type == 'active'){
                    $data['packages'] = Guide::where('is_published', 1)

                        ->withAvg('rating_values', 'average_rating')


                        ->when(($user_module_type == 'guides' || $user_module_type == 'trip_operators' || $user_module_type == 'travel_agency'),function($query) use ($ldate){
                            $query->where(function($q) use ($ldate){
                                $q->where('is_day_wise_trip', 0)->whereDate('end_date', '>=', $ldate)->orWhereNull('end_date')->orWhere('is_day_wise_trip', 1);
                            });
                            // $query->where('is_day_wise_trip', 0)->whereDate('end_date', '>=', $ldate);
                        })
                        // ->when(($user_module_type == 'guides' || $user_module_type == 'trip_operators' || $user_module_type == 'travel_agency'),function($query) use ($ldate){
                        //      $query->orWhere('is_day_wise_trip', 1);
                        //  })
                        ->where('status', 1)
                        ->withAvg('ratings','average_rating')
                        ->withAvg('ratingsProfile', 'average_rating')
                        // ->whereDate('created_at','<>', (date('Y-m-d').' 00:00:00'))

                        ->when((isset($user_module_type) && !is_null($user_module_type)), function($q) use($user_module_type){
                            $q->where('user_module_type', $user_module_type);
                        })
                        ->where('user_id', $user_id)
                        ->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
                }else if(request()->package_type == 'past'){
                    $data['packages'] = Guide::where('is_published', 1)
                        ->withAvg('rating_values', 'average_rating')
                        ->when(($user_module_type == 'guides' || $user_module_type == 'trip_operators' || $user_module_type == 'travel_agency'),function($query) use ($ldate){
                            $query->where('is_day_wise_trip', 0)->whereDate('end_date', '<=', $ldate);
                        })
                        ->where('status', 1)
                        ->withAvg('ratings','average_rating')
                        ->withAvg('ratingsProfile', 'average_rating')
                        // ->whereDate('created_at','<>', (date('Y-m-d').' 00:00:00'))
                        ->where('user_id', $user_id)
                        ->when((isset($user_module_type) && !is_null($user_module_type)), function($q) use($user_module_type){
                            $q->where('user_module_type', $user_module_type);
                        })->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
                }
            }else{



                $data['packages'] = Guide::where('is_published', 1)

                    ->withAvg('rating_values', 'average_rating')


                    ->when(($user_module_type == 'guides' || $user_module_type == 'trip_operators' || $user_module_type == 'travel_agency'),function($query) use ($ldate){
                        $query->where(function($q) use ($ldate){
                            $q->where('is_day_wise_trip', 0)->whereDate('end_date', '>=', $ldate)->orWhereNull('end_date')->orWhere('is_day_wise_trip', 1);
                        });
                        // $query->where('is_day_wise_trip', 0)->whereDate('end_date', '>=', $ldate);
                    })
                    // ->when(($user_module_type == 'guides' || $user_module_type == 'trip_operators' || $user_module_type == 'travel_agency'),function($query) use ($ldate){
                    //      $query->orWhere('is_day_wise_trip', 1);
                    //  })
                    ->where('status', 1)
                    ->withAvg('ratings','average_rating')
                    ->withAvg('ratingsProfile', 'average_rating')
                    // ->whereDate('created_at','<>', (date('Y-m-d').' 00:00:00'))

                    ->when((isset($user_module_type) && !is_null($user_module_type)), function($q) use($user_module_type){
                        $q->where('user_module_type', $user_module_type);
                    })
                    ->where('user_id', $user_id)
                    ->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));

                $data['past_packages'] = Guide::where('is_published', 1)
                    ->withAvg('rating_values', 'average_rating')
                    ->when(($user_module_type == 'guides' || $user_module_type == 'trip_operators' || $user_module_type == 'travel_agency'),function($query) use ($ldate){
                        $query->where('is_day_wise_trip', 0)->whereDate('end_date', '<=', $ldate);
                    })
                    ->where('status', 1)
                    ->withAvg('ratings','average_rating')
                    ->withAvg('ratingsProfile', 'average_rating')
                    // ->whereDate('created_at','<>', (date('Y-m-d').' 00:00:00'))
                    ->where('user_id', $user_id)
                    ->when((isset($user_module_type) && !is_null($user_module_type)), function($q) use($user_module_type){
                        $q->where('user_module_type', $user_module_type);
                    })->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
            }


            $data['our_upcoming_packages'] = Guide::where('is_published', 1)

                ->withAvg('rating_values', 'average_rating')

                // ->where('is_day_wise_trip', '<>', 1)
                //  ->orWhere(function($query) use ($ldate){
                //      $query->where('is_day_wise_trip', 1);
                //      $query->whereDate('end_date', '>=', $ldate);
                //  })

                ->withAvg('ratings','average_rating')
                ->withAvg('ratingsProfile', 'average_rating')
                ->where('user_id', $user_id)->when((isset($user_module_type) && !is_null($user_module_type)), function($q) use($user_module_type){
                    $q->where('user_module_type', $user_module_type);
                })->whereDate('created_at', (date('Y-m-d').' 00:00:00'))->orderBy('id', 'DESC')->get();
        }

        $data['other_service_providers'] = User::with(['ServiceProviderRates','trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])->withAvg('ratings','average_rating')->withAvg('rating_values', 'average_rating')->when(!empty($user_id), function($q) use ($user_id){
            $q->where('id', '<>', $user_id);
        })
            ->where(function($query) use($data){
                if(isset($data['service_provider']->user_module_type) && $data['service_provider']->user_module_type == 'restaurants' && $data['service_provider']->service_provider_rates && $data['service_provider']->service_provider_rates->restaurant_location){
                    $query->whereRelation('ServiceProviderRates','restaurant_location', $data['service_provider']->service_provider_rates->restaurant_location);
                }else if(isset($data['service_provider']->address) && $data['service_provider']->address){
                    $query->where('address','like','%'.$data['service_provider']->address);
                }else if(isset($data['service_provider']->detail_address)){
                    $query->where('detail_address','like','%'.$data['service_provider']->detail_address);
                }
            })
            ->where('user_module_type', $user_module_type)->orderBy('id', 'DESC')->take(4)->get();

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = '';
        $this->response['data'] = $data;
        return response()->json($this->response, $this->status);
        //dd($user_id);
    }

    public function getGuideDetail($user_id = 0){

        $package_type = null;
        if(isset(request()->package_type) && !empty(request()->package_type)){
            $package_type = request()->package_type;
        }
        $user_module_type = (isset(request()->user_module_type) && !empty(request()->user_module_type)) ? request()->user_module_type : null;;
        if($user_id == 0 && is_null($user_module_type)){
            $user_id = auth()->user() ? auth()->user()->id : 0;
            $user_module_type = auth()->user() ? auth()->user()->user_module_type : null;
        }else{
            if(is_null($user_module_type)){
                $user_module_type = User::where('id', $user_id)->first()->user_module_type;
            }
        }

        $data = [];
        $ldate = date('Y-m-d');

        $data['activites_we_do'] = ActivitiesWeDo::all();
        $data['our_expertise'] = OurExpertise::all();
        $data['service_provider'] = User::with(['ServiceProviderRates','trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService', 'our_teams'])
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
            ->withAvg('trips_vendor_ratings', 'rating_value')
            ->where('id', $user_id)->first();



        $data['other_service_providers'] = User::with(['ServiceProviderRates','trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])->withAvg('ratings','average_rating')->withAvg('rating_values', 'average_rating')->when(!empty($user_id), function($q) use ($user_id){
            $q->where('id', '<>', $user_id);
        })
            ->where(function($query) use($data){
                if($data['service_provider']->user_module_type == 'restaurants' && $data['service_provider']->service_provider_rates && $data['service_provider']->service_provider_rates->restaurant_location){
                    $query->whereRelation('ServiceProviderRates','restaurant_location', $data['service_provider']->service_provider_rates->restaurant_location);
                }else if($data['service_provider']->address){
                    $query->where('address','like','%'.$data['service_provider']->address);
                }else{
                    $query->where('detail_address','like','%'.$data['service_provider']->detail_address);
                }
            })
            ->where('user_module_type', $user_module_type)->orderBy('id', 'DESC')->take(4)->get();

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = '';
        $this->response['data'] = $data;
        return response()->json($this->response, $this->status);
        //dd($user_id);
    }

    public function getActivePastPackages($user_id = 0){

        $package_type = null;
        if(isset(request()->package_type) && !empty(request()->package_type)){
            $package_type = request()->package_type;
        }
        $user_module_type = (isset(request()->user_module_type) && !empty(request()->user_module_type)) ? request()->user_module_type : null;;
        if($user_id == 0 && is_null($user_module_type)){
            $user_id = auth()->user() ? auth()->user()->id : 0;
            $user_module_type = auth()->user() ? auth()->user()->user_module_type : null;
        }else{
            if(is_null($user_module_type)){
                $user_module_type = User::where('id', $user_id)->first()->user_module_type;
            }
        }

        $data = [];
        $ldate = date('Y-m-d');


        if($user_module_type == 'home_cheff' || $user_module_type == 'restaurants'){

            $data['packages'] =  Meal::with('images')
                ->withAvg('ratings', 'average_rating')
                ->withAvg('rating_values', 'average_rating')
                ->where('user_id', $user_id)
                ->where('is_publish', 1)
                ->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));

        }else{

            if(isset(request()->package_type) && !empty(request()->package_type)){

                if(request()->package_type == 'active'){
                    $data['packages'] = Guide::where('is_published', 1)

                        ->withAvg('rating_values', 'average_rating')


                        ->when(($user_module_type == 'guides' || $user_module_type == 'trip_operators' || $user_module_type == 'travel_agency'),function($query) use ($ldate){
                            $query->where(function($q) use ($ldate){
                                $q->where('is_day_wise_trip', 0)->whereDate('end_date', '>=', $ldate)->orWhereNull('end_date')->orWhere('is_day_wise_trip', 1);
                            });
                            // $query->where('is_day_wise_trip', 0)->whereDate('end_date', '>=', $ldate);
                        })
                        // ->when(($user_module_type == 'guides' || $user_module_type == 'trip_operators' || $user_module_type == 'travel_agency'),function($query) use ($ldate){
                        //      $query->orWhere('is_day_wise_trip', 1);
                        //  })
                        ->where('status', 1)
                        ->withAvg('ratings','average_rating')
                        ->withAvg('ratingsProfile', 'average_rating')
                        // ->whereDate('created_at','<>', (date('Y-m-d').' 00:00:00'))

                        ->when((isset($user_module_type) && !is_null($user_module_type)), function($q) use($user_module_type){
                            $q->where('user_module_type', $user_module_type);
                        })
                        ->where('user_id', $user_id)
                        ->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
                }else if(request()->package_type == 'past'){

                    $data['packages'] = Guide::where('is_published', 1)
                        ->withAvg('rating_values', 'average_rating')
                        ->when(($user_module_type == 'guides' || $user_module_type == 'trip_operators' || $user_module_type == 'travel_agency'),function($query) use ($ldate){
                            $query->where('is_day_wise_trip', 0)->whereDate('end_date', '<=', $ldate);
                        })
                        ->where('status', 1)
                        ->withAvg('ratings','average_rating')
                        ->withAvg('ratingsProfile', 'average_rating')
                        // ->whereDate('created_at','<>', (date('Y-m-d').' 00:00:00'))
                        ->where('user_id', $user_id)
                        ->when((isset($user_module_type) && !is_null($user_module_type)), function($q) use($user_module_type){
                            $q->where('user_module_type', $user_module_type);
                        })->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
                }
            }

        }


        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = '';
        $this->response['data'] = $data;
        return response()->json($this->response, $this->status);
        //dd($user_id);
    }

    public function getMyGuidePackages($user_id = 0){

        $user_module_type = (isset(request()->user_module_type) && !empty(request()->user_module_type)) ? request()->user_module_type : null;;
        if($user_id == 0 && is_null($user_module_type)){
            $user_id = auth()->user() ? auth()->user()->id : 0;
            $user_module_type = auth()->user() ? auth()->user()->user_module_type : null;
        }else{
            if(is_null($user_module_type)){
                $user_module_type = User::where('id', $user_id)->first()->user_module_type;
            }
        }
        // dd($user_module_type);
        $data = [];
        $ldate = date('Y-m-d');

        // $data['activites_we_do'] = ActivitiesWeDo::all();
        // $data['our_expertise'] = OurExpertise::all();
        // $data['service_provider'] = User::with(['activitiesWeDo', 'ourExpertise', 'our_teams'])
        //     ->withAvg('ratings','location_rating')
        //     ->withAvg('ratings','cleanliness_rating')
        //     ->withAvg('ratings','comfort_rating')
        //     ->withAvg('ratings','quality_rating')
        //     ->withAvg('ratings','average_rating')
        //     ->withSum('ratings','location_rating')
        //     ->withSum('ratings','cleanliness_rating')
        //     ->withSum('ratings','comfort_rating')
        //     ->withSum('ratings','quality_rating')

        //     ->withAvg('rating_values','rating_value_1')
        //     ->withAvg('rating_values','rating_value_2')
        //     ->withAvg('rating_values','rating_value_3')
        //     ->withAvg('rating_values','rating_value_4')
        //     ->withAvg('rating_values','rating_value_5')
        //     ->withAvg('rating_values','average_rating')
        //     ->withSum('rating_values','rating_value_1')
        //     ->withSum('rating_values','rating_value_2')
        //     ->withSum('rating_values','rating_value_3')
        //     ->withSum('rating_values','rating_value_4')
        //     ->withSum('rating_values','rating_value_5')
        //     ->withSum('rating_values','average_rating')
        //     ->withAvg('trips_vendor_ratings', 'rating_value')
        //     ->where('id', $user_id)->first();



        if($user_module_type == 'home_cheff' || $user_module_type == 'restaurants'){

            $data['packages'] =  Meal::with('images')
                ->withAvg('ratings', 'average_rating')
                ->withAvg('rating_values', 'average_rating')
                ->where('user_id', $user_id)
                // ->where('is_publish', 1)
                // ->where('status', 1)
                ->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));

        }else if($user_module_type == 'transport_company'){
            $data['packages'] =  Transport::with('images')
                ->withAvg('ratings', 'average_rating')
                ->withAvg('rating_values', 'average_rating')
                ->where('user_id', $user_id)
                // ->where('is_publish', 1)
                // ->where('status', 1)
                ->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
        }else{

            if(isset(request()->package_type) && !empty(request()->package_type)){

                if(request()->package_type == 'active'){
                    $data['packages'] = Guide::
                        // where('is_published', 1)
                        withAvg('rating_values', 'average_rating')


                        ->when(($user_module_type == 'guides' || $user_module_type == 'trip_operators' || $user_module_type == 'travel_agency'),function($query) use ($ldate){
                            $query->where(function($q) use ($ldate){
                                $q->where('is_day_wise_trip', 0)->whereDate('end_date', '>=', $ldate)->orWhereNull('end_date')->orWhere('is_day_wise_trip', 1);
                            });
                            // $query->where('is_day_wise_trip', 0)->whereDate('end_date', '>=', $ldate);
                        })
                        // ->when(($user_module_type == 'guides' || $user_module_type == 'trip_operators' || $user_module_type == 'travel_agency'),function($query) use ($ldate){
                        //      $query->orWhere('is_day_wise_trip', 1);
                        //  })
                        // ->where('status', 1)
                        ->withAvg('ratings','average_rating')
                        ->withAvg('ratingsProfile', 'average_rating')
                        // ->whereDate('created_at','<>', (date('Y-m-d').' 00:00:00'))

                        ->when((isset($user_module_type) && !is_null($user_module_type)), function($q) use($user_module_type){
                            $q->where('user_module_type', $user_module_type);
                        })
                        ->where('user_id', $user_id)
                        ->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
                }else if(request()->package_type == 'past'){
                    $data['packages'] = Guide::
                        // where('is_published', 1)
                        withAvg('rating_values', 'average_rating')
                        ->when(($user_module_type == 'guides' || $user_module_type == 'trip_operators' || $user_module_type == 'travel_agency'),function($query) use ($ldate){
                            $query->where('is_day_wise_trip', 0)->whereDate('end_date', '<=', $ldate);
                        })
                        // ->where('status', 1)
                        ->withAvg('ratings','average_rating')
                        ->withAvg('ratingsProfile', 'average_rating')
                        // ->whereDate('created_at','<>', (date('Y-m-d').' 00:00:00'))
                        ->where('user_id', $user_id)
                        ->when((isset($user_module_type) && !is_null($user_module_type)), function($q) use($user_module_type){
                            $q->where('user_module_type', $user_module_type);
                        })->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
                }
            }else{



                $data['packages'] = Guide::
                    // where('is_published', 1)

                    withAvg('rating_values', 'average_rating')


                    ->when(($user_module_type == 'guides' || $user_module_type == 'trip_operators' || $user_module_type == 'travel_agency'),function($query) use ($ldate){
                        $query->where(function($q) use ($ldate){
                            $q->where('is_day_wise_trip', 0)->whereDate('end_date', '>=', $ldate)->orWhereNull('end_date')->orWhere('is_day_wise_trip', 1);
                        });
                        // $query->where('is_day_wise_trip', 0)->whereDate('end_date', '>=', $ldate);
                    })
                    // ->when(($user_module_type == 'guides' || $user_module_type == 'trip_operators' || $user_module_type == 'travel_agency'),function($query) use ($ldate){
                    //      $query->orWhere('is_day_wise_trip', 1);
                    //  })
                    // ->where('status', 1)
                    ->withAvg('ratings','average_rating')
                    ->withAvg('ratingsProfile', 'average_rating')
                    // ->whereDate('created_at','<>', (date('Y-m-d').' 00:00:00'))

                    ->when((isset($user_module_type) && !is_null($user_module_type)), function($q) use($user_module_type){
                        $q->where('user_module_type', $user_module_type);
                    })
                    ->where('user_id', $user_id)
                    ->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));

                $data['past_packages'] = Guide::where('is_published', 1)
                    ->withAvg('rating_values', 'average_rating')
                    ->when(($user_module_type == 'guides' || $user_module_type == 'trip_operators' || $user_module_type == 'travel_agency'),function($query) use ($ldate){
                        $query->where('is_day_wise_trip', 0)->whereDate('end_date', '<=', $ldate);
                    })
                    ->where('status', 1)
                    ->withAvg('ratings','average_rating')
                    ->withAvg('ratingsProfile', 'average_rating')
                    // ->whereDate('created_at','<>', (date('Y-m-d').' 00:00:00'))
                    ->where('user_id', $user_id)
                    ->when((isset($user_module_type) && !is_null($user_module_type)), function($q) use($user_module_type){
                        $q->where('user_module_type', $user_module_type);
                    })->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
            }


            $data['our_upcoming_packages'] = Guide::where('is_published', 1)

                ->withAvg('rating_values', 'average_rating')

                // ->where('is_day_wise_trip', '<>', 1)
                //  ->orWhere(function($query) use ($ldate){
                //      $query->where('is_day_wise_trip', 1);
                //      $query->whereDate('end_date', '>=', $ldate);
                //  })

                ->withAvg('ratings','average_rating')
                ->withAvg('ratingsProfile', 'average_rating')
                ->where('user_id', $user_id)->when((isset($user_module_type) && !is_null($user_module_type)), function($q) use($user_module_type){
                    $q->where('user_module_type', $user_module_type);
                })->whereDate('created_at', (date('Y-m-d').' 00:00:00'))->orderBy('id', 'DESC')->get();
        }

        $data['other_service_providers'] = User::with(['ServiceProviderRates','trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])->withAvg('ratings','average_rating')->withAvg('rating_values', 'average_rating')->when(!empty($user_id), function($q) use ($user_id){
            $q->where('id', '<>', $user_id);
        })
            ->where(function($query) use($data){
                if(isset($data['service_provider']->user_module_type) && $data['service_provider']->user_module_type == 'restaurants' && $data['service_provider']->service_provider_rates && $data['service_provider']->service_provider_rates->restaurant_location){
                    $query->whereRelation('ServiceProviderRates','restaurant_location', $data['service_provider']->service_provider_rates->restaurant_location);
                }else if(isset($data['service_provider']->address) && $data['service_provider']->address){
                    $query->where('address','like','%'.$data['service_provider']->address);
                }else if(isset($data['service_provider']->detail_address)){
                    $query->where('detail_address','like','%'.$data['service_provider']->detail_address);
                }
            })
            ->where('user_module_type', $user_module_type)->orderBy('id', 'DESC')->take(4)->get();


        // $data['packages'] = Guide::withAvg('ratings','average_rating')
        //     ->withAvg('ratingsProfile', 'average_rating')
        //     // ->whereDate('created_at','<>', (date('Y-m-d').' 00:00:00'))
        //     ->where('user_id', $user_id)
        //     ->when((isset($user_module_type) && !is_null($user_module_type)), function($q) use($user_module_type){
        //         $q->where('user_module_type', $user_module_type);
        //     })->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));

        // $data['our_upcoming_packages'] = Guide::withAvg('ratings','average_rating')
        //     ->withAvg('ratingsProfile', 'average_rating')
        //     ->where('user_id', $user_id)->when((isset($user_module_type) && !is_null($user_module_type)), function($q) use($user_module_type){
        //         $q->where('user_module_type', $user_module_type);
        //     })->whereDate('created_at', (date('Y-m-d').' 00:00:00'))->orderBy('id', 'DESC')->get();
        // $data['other_service_providers'] = User::withAvg('ratings','average_rating')->when(!empty($user_id), function($q) use ($user_id){
        //     $q->where('id', '<>', $user_id);
        // })->where('user_module_type', $user_module_type)->orderBy('id', 'DESC')->take(4)->get();
        
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = '';
        $this->response['data'] = $data;
        return response()->json($this->response, $this->status);
        //dd($user_id);
    }

    public function getTripPackages(Request $request){

        $ldate = date('Y-m-d');

        $distance_result = '';
        $rad = 50;
        $lat = 0;
        $lng = 0;

        // if (isset($request->lat) && !empty($request->lat) && isset($request->lng) && !empty($request->lng)) {
        $lat = isset($request->lat) ? round($request->lat, 8) : 0;
        $lng = isset($request->lng) ? round($request->lng, 8) : 0;
        $rad = 10000; // isset($request->radius) ? (int)$request->radius : 50;

        $distance_result = "(6371 * acos(cos(radians($lat))
                    * cos(radians(lat))
                    * cos(radians(lng)
                    - radians($lng))
                    + sin(radians($lat))
                    * sin(radians(lat))))";

        $distance_result_to = "(6371 * acos(cos(radians($lat))
                    * cos(radians(latitude_to))
                    * cos(radians(longitude_to)
                    - radians($lng))
                    + sin(radians($lat))
                    * sin(radians(latitude_to))))";
        // }


        $serviceMessage = '';

        // if(!empty($lat) && !empty($lng) && isset($request->search_by_filter) && $request->search_by_filter == 1){
        //     $serviceData = Guide::where('is_published',1)->where('status',1)->where('lat',$lat)->where('lng',$lng)->get();
        //     $serviceMessage = '';
        //     if($serviceData->count() < 1){
        //         $serviceMessage = "This service is currently not available in this area but here are other nearby services";
        //     }
        // }

        $data = Guide::withAvg('ratings','average_rating')
            ->withAvg('ratingsProfile', 'average_rating')
            ->withAvg('rating_values','average_rating')
            ->whereIn('user_module_type', ['trip_operators', 'trips', 'guides', 'travel_agency'])
            ->when(!empty($distance_result), function ($query) use ($distance_result, $rad, $distance_result_to){
                $query->selectRaw("{$distance_result_to} AS distance")->whereRaw("{$distance_result_to} < ?", [$rad]);
                // ->orWhereRaw("{$distance_result_to} < ?", [$rad]);
            })
            ->where(function($query){
                $query->where(function($q){
                    $q->where('is_day_wise_trip', 0)->whereDate('end_date', '>=', date('Y-m-d'));
                })->orWhere('is_day_wise_trip', 1);
            })
            ->when((isset($request->location) && !empty($request->location)),function($query) use ($request){
                $query->where('location_to', $request->location);
                // ->orWhere('location_to', $request->location);
            })
            ->when((isset($request->minValue) && !empty($request->minValue)), function($query) use ($request){
                $query->where('price', '>=', $request->minValue);
            })
            ->when((isset($request->maxValue) && !empty($request->maxValue)), function($query) use ($request){
                $query->where('price', '<=', $request->maxValue);
            })
            ->when((isset($request->trip_category) && !empty($request->trip_category)), function($query) use ($request){
                $query->where('trip_category',$request->trip_category);
            })
            ->when((isset($request->group_size)), function($query) use ($request){
                $query->whereRelation('tripsProperties','group_size',$request->group_size);
            })
            ->when((isset($request->is_day_wise_trip)), function($query) use ($request, $ldate){
                if($request->is_day_wise_trip == 0){
                    $query->where('is_day_wise_trip',$request->is_day_wise_trip)->whereDate('end_date', '>=', $ldate);
                }else{
                    $query->where('is_day_wise_trip',$request->is_day_wise_trip);
                }
            })
            ->when((isset($request->payment_mode)), function($query) use ($request){

                if($request->payment_mode == 1){
                    $query->where('payment_mode', 1)
                        ->where('payment_partial_value', $request->payment_partial_value);
                }else if($request->payment_mode == 0){
                    $query->where('payment_mode', 0);
                }

            })
            ->when((isset($request->cancellation) && isset($request->cancellation_hours) && !empty($request->cancellation_hours)), function($query) use($request){
                $query->whereRelation('cancellation_policy','cancellation_hour','==',$request->cancellation_hours);
            })
            ->where('is_published',1)
            ->where('status',1)
            // ->orderByRaw('distance_to')
            ->orderBy('distance')
            ->paginate(Config::get('global.pagination_records'));

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = '';
        $this->response['data'] = $data;
        $this->response['serviceMessage'] = $serviceMessage;
        return response()->json($this->response, $this->status);

    }

    public function copyPackageRecord(Request $request){

        $validator = Validator::make(request()->all(), [
            'package_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $guide = Guide::select('*')->where('id',$request->package_id)->first();
        $new = $guide->replicate();
        $new->is_published = 0;
        $new->status = 0;
        $new->save();
        $newID = $new->id;

        $guide_activities = GuideActivity::where('guide_id',request()->package_id)->get();
        if(!empty($guide_activities)){
            foreach ($guide_activities as $key => $value) {
                $value->guide_id = $newID;
                $new_value = $value->replicate();
                $new_value->save();
            }
        }

        $package_facility = PackageFacility::where('package_id', request()->package_id)->get();
        if(!empty($package_facility)){
            foreach ($package_facility as $key => $value) {
                $value->package_id = $newID;
                $new_value = $value->replicate();
                $new_value->save();
            }
        }

        $package_itinerary = PackageItinerary::where('package_id', request()->package_id)->get();
        if(!empty($package_itinerary)){
            foreach ($package_itinerary as $key => $value) {
                $value->package_id = $newID;
                $new_value = $value->replicate();
                $new_value->save();
            }
        }

        $packages_covered_events = PackagesCoveredEvents::where('package_id', request()->package_id)->get();

        if(!empty($packages_covered_events)){
            foreach ($packages_covered_events as $key => $value) {
                $value->package_id = $newID;
                $new_value = $value->replicate();
                $new_value->save();
            }
        }

        $trips_property = TripsProperty::where('package_id', request()->package_id)->get();
        if(!empty($trips_property)){
            foreach ($trips_property as $key => $value) {
                $value->package_id = $newID;
                $new_value = $value->replicate();
                $new_value->save();
            }
        }

        $package_videos = PackageVideo::where('package_id', request()->package_id)->get();
        if(!empty($package_videos)){
            foreach ($package_videos as $key => $value) {
                $value->package_id = $newID;
                $new_value = $value->replicate();
                $new_value->save();
            }
        }


        $package_rules = Rule::where('module_id', request()->package_id)->whereIn('module_name', ['guides','movie_makers','trips','visa_consultants','photographers','restaurants','trip_mates','trip_operators','home_cheff','travel_agency'])->get();

        if(!empty($package_rules)){
            foreach ($package_rules as $key => $value) {
                $value->module_id = $newID;
                $new_value = $value->replicate();
                $new_value->save();
            }
        }

        $cancellation_policy = CancellationPolicy::where('bookable_id', request()->package_id)->where('bookable', 'App\\Models\\Guide')->get();

        if(!empty($cancellation_policy)){
            foreach ($cancellation_policy as $key => $value) {
                $value->bookable_id = $newID;
                $new_value = $value->replicate();
                $new_value->save();
            }
        }


        $package_images = Image::where('module_id', $request->package_id)->get();
        if(!empty($package_images)){
            foreach ($package_images as $key => $value) {
                if(!empty($value->name) && !empty($value->module)){
                    $ext = pathinfo($value->name, PATHINFO_EXTENSION);
                    $date = new \DateTime();
                    $string = $date->format(DATE_RFC2822);

                    $image_full_name = $this->intCodeRandom(). '_' . strtotime($string) . '.' . $ext;
                    // $image_full_name = pathinfo($value->name, PATHINFO_FILENAME) . '_' . strtotime($string) . '.' . $ext;
                    $path = public_path('/assets/uploads/' . $value->module);
                    $check_file = $path.'/'.$value->name;
                    if(file_exists($check_file)){
                        File::copy($check_file, $path.'/'.$image_full_name);

                        if(file_exists($path.'/'.$value->name.'_thumb.jpg')){
                            File::copy($check_file, $path.'/'.$image_full_name.'_thumb.jpg');
                        }
                        $value->name = $image_full_name;
                        $value->module_id = $newID;
                        $new_value = $value->replicate();
                        $new_value->save();
                    }

                }
            }
        }

        $data = Guide::find($newID);
        $title      = "Package";
        $message    = "Package Copied created successfully.To view detail";
        $action     = "packages/detail/".$newID;
        $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();
        if(isset($admin) && !empty($admin)){
            PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_PACKAGE,$action,$newID);
        }
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Package copy successfull ';
        $this->response['data'] = $data;
        return response()->json($this->response, $this->status);

    }

    public function is_published(Request $request){

        $user_module_type = auth()->user()->user_module_type;

        $validator = Validator::make(request()->all(), [
            'package_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            // 'message' => 'Provide some mandatory details, please review the package information and fill up requested fields before publishing',
            return response()->json($this->response, $this->status);
        }

        $package_id = $request->package_id;

        $package_detail = Guide::find($package_id);

        if($package_detail->user_id != request()->user()->id){
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = "Invalid id";
            return response()->json($this->response, $this->status);
        }

        if($user_module_type == 'guides' || $user_module_type == 'trip_operators' || $user_module_type == 'travel_agency'){

            if(!empty($package_detail)){

                $validator = Validator::make($package_detail->toArray(), [
                    'title' => 'required',
                    'price' => 'required',
                    'trip_category' => 'required',
                    'about' => 'required',
                    'is_day_wise_trip' => 'required',
                    'location' => 'required',
                    'location_to' => 'required',
                ]);
                if ($validator->fails()) {
                    $this->status = 422;
                    $this->response['success'] = false;
                    $this->response['message'] = $validator->messages()->first();
                    return response()->json($this->response, $this->status);
                }

                $messages = [];
                // $guide_activity_count = GuideActivity::where('guide_id', $package_id)->get()->count();
                // if($guide_activity_count == 0){
                //     // array_push($messages, 'Activities you will be offering atleast one selected');
                //     $message = 'Activities you will be offering atleast one selected';
                //     $this->status = 422;
                //     $this->response['success'] = false;
                //     $this->response['message'] = $message;
                //     return response()->json($this->response, $this->status);
                // }

                $package_itinerary = PackageItinerary::where('package_id', $package_id)->get();
                $package_itinerary_count = count($package_itinerary->toArray());
                if(!empty($package_itinerary) && $package_itinerary_count > 0){
                    if($package_itinerary_count > 1){
                        $destination_value = 0;
                        foreach ($package_itinerary as $key => $value) {

                            if(!empty($value) && isset($value->destination) && !empty($value->destination)){
                                $destination_value = 1;
                            }
                        }
                        if($destination_value == 0){
                            // array_push($messages, 'The package itinerary destination atleast one filed is required');
                            $message = 'The package itinerary destination atleast one filed is required';
                            $this->status = 422;
                            $this->response['success'] = false;
                            $this->response['message'] = $message;
                            return response()->json($this->response, $this->status);
                        }
                    }else{
                        if(!empty($package_itinerary) && isset($package_itinerary->destination) && !$package_itinerary->destination){
                            // array_push($messages, 'The package itinerary destination atleast one filed is required');
                            $message = 'The package itinerary destination atleast one filed is required';
                            $this->status = 422;
                            $this->response['success'] = false;
                            $this->response['message'] = $message;
                            return response()->json($this->response, $this->status);
                        }
                    }
                }else{
                    // array_push($messages, 'The package itinerary filed is required');
                    $message = 'The package itinerary filed is required';
                    $this->status = 422;
                    $this->response['success'] = false;
                    $this->response['message'] = $message;
                    return response()->json($this->response, $this->status);
                }

                $package_facility_included = PackageFacility::where('package_id', $package_id)->where('type', 'included')->get();
                $package_facility_included_count = count($package_facility_included->toArray());
                if($package_facility_included_count == 0){
                    // array_push($messages, `Add Description of "what's included" in trip facilities.`);
                    $message = `Add Description of "what's included" in trip facilities.`;
                    $this->status = 422;
                    $this->response['success'] = false;
                    $this->response['message'] = $message;
                    return response()->json($this->response, $this->status);
                }else{
                    if($package_facility_included_count > 0){
                        $include_value = 0;
                        foreach ($package_facility_included as $key => $value) {
                            if($value->description){
                                $include_value = 1;
                            }
                        }
                        if($include_value == 0){
                            // array_push($messages, `Add Description of "what's included" in trip facilities.`);
                            $message = `Add Description of "what's included" in trip facilities.`;
                            $this->status = 422;
                            $this->response['success'] = false;
                            $this->response['message'] = $message;
                            return response()->json($this->response, $this->status);
                        }
                    }
                }
                $package_facility_excluded = PackageFacility::where('package_id', $package_id)->where('type', 'excluded')->first();
                if(!empty($package_facility_excluded)){
                    if(!$package_facility_excluded->description){
                        if(!$package_facility_excluded->everything_considered){
                            // array_push($messages, 'The excluded field is required');
                            $message = 'The excluded field is required';
                            $this->status = 422;
                            $this->response['success'] = false;
                            $this->response['message'] = $message;
                            return response()->json($this->response, $this->status);
                        }
                    }else if(!$package_facility_excluded->everything_considered){
                        if(!$package_facility_excluded->description){
                            // array_push($messages, 'The excluded field is required');
                            $message = 'The excluded field is required';
                            $this->status = 422;
                            $this->response['success'] = false;
                            $this->response['message'] = $message;
                            return response()->json($this->response, $this->status);
                        }
                    }
                }else{
                    // array_push($messages, 'The excluded field is required');
                    $message = 'The excluded field is requird';
                    $this->status = 422;
                    $this->response['success'] = false;
                    $this->response['message'] = $message;
                    return response()->json($this->response, $this->status);
                }

                // if (!empty($messages)) {
                //     $this->status = 422;
                //     $this->response['success'] = false;
                //     $this->response['message'] = $messages;
                //     return response()->json($this->response, $this->status);
                // }
            }
        }else{
            $validator = Validator::make($package_detail->toArray(), [
                'title' => 'required',
                'price' => 'required',
                'about' => 'required',
            ]);
            if ($validator->fails()) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = $validator->messages()->first();
                return response()->json($this->response, $this->status);
            }
        }


        $data = Guide::find($request->package_id);
        if(!empty($data)){
            $this->response['message'] =  "Your listing has been added to our system successfully. We'll notify you once it gets approved for users by our support team."; //'Package is published successfully';
            if(isset($request->is_published)){
                if($request->is_published == 0){
                    $data->is_published = 0;
                    $this->response['message'] = 'Package is unpublished successfully';
                }else{
                    $data->is_published = 1;
                    $data->status = 1;
                }
            }else{
                $data->is_published = 1;
                $data->status = 1;
            }
            $data->save();

            if(isset($data) && !empty($data) && isset($data->id)){
                $title      = "Package";
                $message    = "Package published successfully.To view detail";
                $action     = "packages/detail/".$data->id;
                $admin      = User::where('role_id',User::ADMIN_ROLE_ID)->first();

                // if(isset($admin) && !empty($admin)){
                //     PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_PACKAGE,$action,$data->id);
                // }
            }
            if($package_detail->user_module_type == 'guides' || $package_detail->user_module_type == 'trip_operators' || $package_detail->user_module_type == 'travel_agency'){
                $lat = (float)$package_detail->latitude_to;
                $lng = (float)$package_detail->longitude_to;
                
                $lat = round($lat, 8);
                $lng = round($lng, 8);
                $rad = 50000;
                $rad = floor($rad / 1000);
                // dd($rad);
                $distance_result = 'ROUND(DEGREES(ACOS(SIN(RADIANS('.$lat.')) 
                    * SIN(RADIANS(lat)) 
                    + COS(RADIANS('.$lat.'))  
                    * COS(RADIANS(lat))
                    * COS(RADIANS('.$lng.' - lng)))) * 69.09)';
                $users = User::without(['policies', 'userServices', 'countries', 'galleries', 'company', 'rules', 'ratings_types', 'cancellation_policy', 'activity', 'participants', 'activitiesWeDo'])
                                ->select('id', 'name','email','user_module_type','type')->when(!empty($distance_result), function ($query) use ($distance_result, $rad, $user_module_type){
                    if(!empty($rad)){
                        $query->selectRaw("{$distance_result} AS distance")->whereRaw("{$distance_result} < ?", [$rad])->orderBy('distance');
                    }else{
                        $query->addSelect(\DB::raw($distance_result . " as distance"));
                        $query->orderBy(\DB::raw($distance_result));
                    }

                })->get()->toArray();
                if(!empty($users)){
                    $user_ids = array_column($users,'id');
                }
                dd($lat, $lng, $distance_result, );
            }

        }
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        return response()->json($this->response, $this->status);


    }

    public function set_validations_on_packages($package_id){

        if(auth()->user()->user_module_type == 'guides' || auth()->user()->user_module_type == 'trip_operators' || auth()->user()->user_module_type == 'travel_agency'){
            $package_detail = Guide::find($package_id);
            if(!empty($package_detail)){

                $validator = Validator::make($package_detail->toArray(), [
                    'title' => 'required',
                    'price' => 'required',
                    'trip_category' => 'required',
                    'about' => 'required',
                    'is_day_wise_trip' => 'required',
                    'location' => 'required',
                    'location_to' => 'required',
                ]);
                if ($validator->fails()) {
                    $this->status = 422;
                    $this->response['success'] = false;
                    $this->response['message'] = $validator->messages()->first();
                    return response()->json($this->response, $this->status);
                }

                $messages = [];
                // $guide_activity_count = GuideActivity::where('guide_id', $package_id)->get()->count();
                // if($guide_activity_count == 0){
                //     array_push($messages, 'Activities you will be offering atleast one selected');
                // }

                $package_itinerary = PackageItinerary::where('package_id', $package_id)->get();
                $package_itinerary_count = count($package_itinerary->toArray());
                if(!empty($package_itinerary) && $package_itinerary_count > 0){
                    if($package_itinerary_count > 1){
                        $destination_value = 0;
                        foreach ($package_itinerary as $key => $value) {
                            if(!empty($value) && isset($value->destination) && !empty($value->destination)){
                                $destination_value = 1;
                            }
                        }
                        if($destination_value == 0){
                            array_push($messages, 'The package itinerary destination atleast one filed is required');
                        }
                    }else{
                        if(!empty($package_itinerary) && isset($package_itinerary->destination) && !$package_itinerary->destination){
                            array_push($messages, 'The package itinerary destination atleast one filed is required');
                        }
                    }
                }else{
                    array_push($messages, 'The package itinerary filed is required');
                }

                $package_facility_included = PackageFacility::where('package_id', $package_id)->where('type', 'included')->get();
                $package_facility_included_count = count($package_facility_included->toArray());
                if($package_facility_included_count == 0){
                    array_push($messages, `Add Description of "what's included" in trip facilities.`);
                }else{
                    if($package_facility_included_count > 0){
                        $include_value = 0;
                        foreach ($package_facility_included as $key => $value) {
                            if($value->description){
                                $include_value = 1;
                            }
                        }
                        if($include_value == 0){
                            array_push($messages, `Add Description of "what's included" in trip facilities.`);
                        }
                    }
                }
                $package_facility_excluded = PackageFacility::where('package_id', $package_id)->where('type', 'excluded')->first();
                if(!empty($package_facility_excluded)){
                    if(!$package_facility_excluded->description || !$package_facility_excluded->everything_considered){
                        array_push($messages, 'The excluded field is required');
                    }
                }else{
                    array_push($messages, 'The excluded field is required');
                }


                if (!empty($messages)) {
                    $this->status = 422;
                    $this->response['success'] = false;
                    $this->response['message'] = $messages;
                    return response()->json($this->response, $this->status);
                }
            }
        }

    }

    public function updatePackageStatus(Request $request){

        $validator = Validator::make(request()->all(), [
            'package_id' => 'required|numeric',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $data = Guide::where('id', $request->package_id)->where('user_id', request()->user()->id)->first();
        if(!empty($data)){
            $this->response['message'] = 'Package status update successfully';
            if(isset($request->status)){
                if($request->status == 0){
                    $data->status = 0;
                    $this->response['message'] = 'Package status update successfully';
                }else{
                    $data->status = 1;
                }
            }else{
                $data->status = 1;
            }
            $data->save();

            if(isset($data) && !empty($data) && isset($data->id)){
                $title      = "Package";
                $message    = "Package status updated successfully.To view detail";
                $action     = "packages/detail/".$data->id;
                $admin      = User::where('role_id',User::ADMIN_ROLE_ID)->first();

                if(isset($admin) && !empty($admin)){
                    PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_PACKAGE,$action,$data->id);

                    $message    = $data->title." Package status has been updated.";
                   
                    PushNotification::createNotification($admin,auth()->user()->id,$title,$message,User::TYPE_PACKAGE,$action,$data->id);
                }
            }

        }
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        return response()->json($this->response, $this->status);


    }

    function getDatesFromRange($start, $end, $format = 'Y-m-d') {

        $array = [];
        if(isset($start) && isset($end) && !empty($start) && !empty($end)){
            $interval = new \DateInterval('P1D');

            $realEnd = new \DateTime($end);
            $realEnd->add($interval);

            $period = new \DatePeriod(new \DateTime($start), $interval, $realEnd);

            foreach($period as $date) {
                $array[] = $date->format($format);
            }
        }

        return $array;
    }
    public function intCodeRandom($length = 8){
      $intMin = (10 ** $length) / 10; // 100...
      $intMax = (10 ** $length) - 1;  // 999...

      $codeRandom = mt_rand($intMin, $intMax);

      return $codeRandom;
    }


}
