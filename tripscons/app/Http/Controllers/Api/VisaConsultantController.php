<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notifications\PushNotification;
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
use App\Models\VisaConsultant;
use Illuminate\Support\Facades\Config;

class VisaConsultantController extends Controller
{
    protected $status = 200;
    public function index(Request $request){


        $proRating =   $request->rating;
        $min =  $request->minValue ;
        $max =  $request->maxValue ;
        $country = $request->country;
        $city = $request->city;
        $userId = $request->userId;
        if(!empty($request)){
            $data = VisaConsultant::with('images')->where(function($query) use ($proRating, $min,$max,$country,$city,$userId) {


                if($proRating > 0){
                    $query->where('rating',$proRating);
                }
                if($min > 0){
                    $query->Where('price','>=', $min);

                }
                if($max > 0){
                    $query->Where('price','<=', $max);

                }

                if(!empty($userId)){
                    $query->Where('user_id', $userId);
                }

            })->paginate(Config::get('global.pagination_records'));

        }else{
            $data = VisaConsultant::with('images')->paginate(Config::get('global.pagination_records'));
        }
        $status = 200;
        if($data->count() <= 0){
            $data ="No result Found";
            $status = 403;
        }
        return response()->json(['visaConsultants'=>$data,'status'=>$status]);

    }
    public function store(Request $request)
    {

        if(count($request->all()) > 0){
            $data = new VisaConsultant;
            $data->user_id = $request->user_id;
            $data->title = $request->title;
            $data->about	   = $request->about;
            $data->price	   = $request->price;
            $data->experties	           = $request->experties;

            $data->status      = $request->status;

            $data->rating      = $request->stars;
            $data->no_of_reviews	   = $request->no_of_reviews;

            $title      = "Visa Service";
            $message    = "Visa service create successfully";
            $admin = User::where('role_id',User::ADMIN_ID)->first();

            if($data->save()){
                if(isset($data) && !empty($data) && isset($data->id)){
                    $action     = "user/setting/".$data->id;

                    if(isset($admin) && !empty($admin)){
                        PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_VISA,$action,$data->id);
                        $message    = "New Visa service has been created.";
                        PushNotification::createNotification($admin,auth()->user()->id,$title,$message,User::TYPE_VISA,$action,$data->id);
                    }
                }

                return response()->json($data);
            }
        }else{
            return "Please Input Data";
        }

    }
    public function update(Request $request,$mealId){


        if(count($request->all()) > 0){
            $data =  VisaConsultant::where('id',$mealId)->first();
            if(!empty($data)){
                $data->user_id = $request->user_id;
                $data->title = $request->title;
                $data->about	   = $request->about;
                $data->price	   = $request->price;
                $data->experties	           = $request->experties;

                $data->status      = $request->status;

                $data->rating      = $request->rating;
                $data->no_of_reviews	   = $request->no_of_reviews;

                $title      = "Visa Service";
                $message    = "Visa service updated successfully";
                $admin = User::where('id',User::ADMIN_ID)->first();
                if($data->save()){
                    if(isset($data) && !empty($data) && isset($data->id)){
                        $action     = "user/setting/".$data->id;

                        if(isset($admin) && !empty($admin)){
                            PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_VISA,$action,$data->id);
                        }
                    }

                    $this->Imagestore($mealId,'meal',$request);
                    return response()->json($data);
                }
            }else{
                return "Record Not Found!!" ;
            }
        }else{
            return "Please Input Data";
        }
    }

    public function detail($Id){

        $relatedData = VisaConsultant::with('singleImage')->where('id','!=',$Id)->take(4)->get();
        $detail =  VisaConsultant::with('images')->with('video')->with('general_service')->with('general_country')->where('id',$Id)->first();
        $userId  = $detail->user_id;
        $userObj =   User::where('id',$userId)->first();
        return response()->json(['detail'=>$detail,'relatedData'=>$relatedData,'userObj'=>$userObj]);

    }


    public function Imagestore($module_id,$module,$request)
    {

        request()->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,NEF,nef,svg|max:2048',
        ]);
        if($files = $request->file('image')){
            $image_full_name = time().'.'.$files->getClientOriginalExtension();
            $destinationPath = '/assets/uploads/'; //Creating Sub directory in Public folder to put image
            //$image_url = $destinationPath.$image_full_name;
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
