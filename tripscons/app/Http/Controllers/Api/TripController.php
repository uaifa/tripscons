<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;
use App\Models\Accommodation;
use App\Models\Host;
use App\Models\Image;
use App\Models\Facility;
use App\Models\Activity;
use App\Models\Transport;
use App\Models\FacilityAccommodation;
use App\Models\Trip;
use App\Models\User;

class TripController extends Controller{
    protected $status = 200;
    public function index(Request $request){
        $proRating =   $request->rating;
        $min =  $request->minValue ;
        $max =  $request->maxValue ;
        $country = $request->country;
        $city = $request->city;
        if(count(($request->all())) > 0){
            $data = Trip::with('images')->with('trip_activity_four')->where(function($query) use ($proRating, $min,$max,$country,$city) {
            if($proRating > 0){
                $query->where('stars',$proRating);
            }
            if($min > 0){
                $query->Where('price','>=', $min);
            }
            if($max > 0){
                $query->Where('price','<=', $max);
            }

        })->orderBy('id', 'DESC')->paginate(\Config::get('global.pagination_records'));

        }else{
             $data = Trip::with('images')->with('trip_activity_four')->orderBy('id', 'DESC')->paginate(\Config::get('global.pagination_records'));
        }
        return response()->json(['data'=>$data]);
    }


    public function detail($Id){
        $relatedData =   Trip::with('singleImage')->take(4)->get();
        $detail =  Trip::with('images')->with('trip_facility_included')->with('trip_activity')->with('trip_facility_excluded')->with('trip_itinerary')->where('id',$Id)->first();
        $userId  = $detail->user_id;
        $userObj =   User::where('id',$userId)->first();
        if($userObj->type =='2'){
            $accommodationCount = Accommodation::count();
            $activityCount = Activity::count();
            $transCount = Transport::count();
        }else{
            $accommodationCount=0;
            $activityCount =0;
            $transCount=0;
        }

        $detail->user = $userObj;
        $detail->relatedData = $relatedData;
        $detail->transportCount = $transCount;
        $detail->accommodationAccount = $accommodationCount;
        $detail->activityCount = $activityCount;

        return response()->json(['data'=>$detail]);

    }

    public function store(Request $request){

        if(count($request->all()) > 0){
            $data = new Trip;
            $data->user_id = $request->user_id;
            $data->title = $request->title;
            $data->trip_type = $request->trip_type;
            $data->group_size = $request->group_size;
            $data->location = $request->location;
            $data->about_trip  = $request->about_trip;
            $data->price  = $request->price;
            $data->stars = $request->stars;
            $data->no_of_reviews = $request->no_of_reviews;
            $data->min_members = $request->min_members;
            $data->trip_start_date = $request->trip_start_date;
            $data->trip_end_date = $request->trip_end_date	;
            $data->brand = $request->brand;
            $data->terms_rule = $request->terms_rule	;
            $data->cancellation_policy = $request->cancellation_policy;
            $data->payment_term = $request->payment_term	;
            $data->things_to_know = $request->things_to_know;

            $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();
            if($data->save()){
                $title      = "Trip Service";
                $message    = "Trip service created successfully";
                $action     = "api/create-trip";

                PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_TRIP,$action);

                $message = "New Trip service has been created.";
                PushNotification::createNotification($admin,auth()->user()->id,$title,$message,User::TYPE_ACTIVITY,$action,$experience->id);

                return response()->json($data);
            }
        }else{
            return "Please Input Data";
        }
    }
    public function update(Request $request,$tripId){

        if(count($request->all()) > 0){
            $data =  Trip::where('id',$tripId)->first();
            if(!empty($data)){
            $data->user_id = $request->user_id;
            $data->title = $request->title;
            $data->trip_type	   = $request->trip_type;
            $data->group_size   = $request->group_size;
            $data->location	   = $request->location;
            $data->about_trip	           = $request->about_trip;
            $data->price	           = $request->price;
            $data->stars      = $request->stars;
            $data->no_of_reviews	       = $request->no_of_reviews;
            $data->min_members      = $request->min_members;
            $data->trip_start_date	   = $request->trip_start_date;
            $data->trip_end_date  = $request->trip_end_date	;
            $data->brand	   = $request->brand;
            $data->terms_rule       = $request->terms_rule	;
            $data->cancellation_policy        = $request->cancellation_policy;
            $data->payment_term          = $request->payment_term	;
            $data->things_to_know	   = $request->things_to_know;

            if($data->save()){
                $title      = "Trip Service";
                $message    = "Trip service updated successfully";
                $action     = "api/update-trip";

                PushNotification::createNotification(auth()->user(),1,$title,$message,User::TYPE_TRIP,$action);

                $this->Imagestore($tripId,'trip',$request);
             return response()->json($data);
            }
        }else{
            return "Record Not Found!!" ;
        }
        }else{
            return "Please Input Data";
        }
    }


    public function Imagestore($module_id,$module,$request)
    {

        request()->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,NEF,nef,svg|max:2048',
        ]);
        if($files = $request->file('image')){
            $image_full_name = time().'.'.$files->getClientOriginalExtension();
            $destinationPath = '/assets/uploads/'; //Creating Sub directory in Public folder to put image
            $success = $files->move($destinationPath,$image_full_name);
            $data = new Image;
            $data->name = $image_full_name;
            $data->module_id = $module_id;
            $data->module = $module;
            $data->type = $request->type;
            $data->save();

     }
 }

}
