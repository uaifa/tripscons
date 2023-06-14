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
use App\Models\Media;
use Illuminate\Support\Facades\Config;

class MediaController extends Controller
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
           $data = Media::with('images')->where(function($query) use ($proRating, $min,$max,$country,$city,$userId) {


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
                if(!empty($userId)){
                    $query->Where('user_id', $userId);
                   }

        })->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));

        }else{
             $data = Media::with('images')->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
        }
        $status = 200;
        if($data->count() <= 0){
            $data ="No result Found";
            $status = 403;
        }
        return response()->json(['moviemakers'=>$data,'status'=>$status]);

    }
    public function store(Request $request)
    {

        if(count($request->all()) > 0){
        $data = new Media;
        $data->user_id = $request->user_id;
        $data->title = $request->title;
        $data->about	   = $request->about;
        $data->rating      = $request->rating;
        $data->no_of_reviews	   = $request->no_of_reviews;
        $data->price	   = $request->price;
        $data->status      = $request->status;
        if($data->save()){

            $title      = "Media Created";
            $message    = "Media Created successfully";
            $action     = "api/updateMedia";

            PushNotification::createNotification(auth()->user(),1,$title,$message,User::TYPE_MEDIA,$action);

            return response()->json($data);
        }
    }else{
        return "Please Input Data";
    }

    }
    public function update(Request $request,$mealId){


        if(count($request->all()) > 0){
            $data =  Media::where('id',$mealId)->first();
            if(!empty($data)){
            $data->user_id = $request->user_id;
            $data->title = $request->title;
            $data->about	   = $request->about;
            $data->rating      = $request->rating;
            $data->no_of_reviews	   = $request->no_of_reviews;
            $data->price	   = $request->price;
            $data->status      = $request->status;

            if($data->save()){
                $title      = "Media";
                $message    = "Media updated successfully. To view detail";
                $action     = "user/setting";

                if(isset($data) && !empty($data) && isset($data->id)){
                    PushNotification::createNotification(auth()->user(),1,$title,$message,User::TYPE_MEDIA,$action,$data->id);
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

        $relatedData = Media::with('singleImage')->where('id','!=',$Id)->take(4)->orderBy('id', 'DESC')->get();
        $detail =  Media::with('images')->with('video')->with('general_service')->with('expertiese')->where('id',$Id)->first();
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
