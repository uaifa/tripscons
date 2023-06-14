<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;
use App\Models\Accommodation;
use App\Models\Host;
use App\Models\Image;
use App\Models\Facility;
use App\Models\AccommodationSubType;
use App\Models\FacilityAccommodation;
use App\Models\TripOperator;

class TripOeratorController extends Controller
{
    protected $status = 200;
    public function index(Request $request){


        $proRating =   $request->rating;
        $noOfPeople =  $request->adultGuest + $request->childGuest;
        $min =  $request->minValue ;
        $max =  $request->maxValue ;
        $proType = $request->propertyType;
        $proSubType = $request->propertySubType;
        $propertyFacility = $request->propertyFacility;
        $propertyThirdType = $request->propertyThirdType;
        $country = $request->country;
        $city = $request->city;
        $res   = [];
        $resd = FacilityAccommodation::select('name','accommodation_id')->where('name',$propertyFacility)->get();
        foreach($resd as $response){
            array_push($res,$response->accommodation_id);
        }

        if(!empty($request)){   //with('images')->
            $accommodations = TripOperator::with('images')->where(function($query) use ($proRating,$noOfPeople, $min,$max,$proType,$proSubType,$propertyFacility,$propertyThirdType,$country,$city) {


                if($proRating > 0){
                    // $query->where('stars',$proRating);

                }

                if($noOfPeople > 0){
                    //  $query->Where('no_of_people','>=',$noOfPeople);

                }

                if($min > 0){
                    $query->Where('price','>=', $min);

                }

                if($max > 0){
                    $query->Where('price','<=', $max);

                }

                if(!empty($proType)){

                    // $query->Where('type_id', $proType);
                }
                if(!empty($proSubType)){
                    // $query->Where('sub_type_id', $proSubType);
                }
                // if($propertyThirdType !=0){
                //  $query->Where('sub_type_id', $proSubType);
                // }
                if(!empty($country)){
                    //  $query->Where('country', $country);
                }
                if(!empty($city)){
                    //  $query->Where('city', $city);
                }
                if(!empty($propertyFacility)){
                    if(!empty($res)){
                        //  $query->WhereIn('id', $res);
                    }
                }
            })->paginate(8);

        }else{
            $accommodations = TripOperator::with('images')->paginate(8);
        }

        $facility = Facility::all('name','image')->take(4);

        return response()->json(['acc'=>$accommodations,'fac'=>$facility]);

    }

    public function add(Request $request)
    {

        if(count($request->all()) > 0){
            $accommodation = new Accommodation;
            $accommodation->user_id = $request->user_id	;
            $accommodation->title = $request->title	;
            $accommodation->no_of_rooms	   = $request->no_of_rooms	;
            $accommodation->no_of_people   = $request->no_of_people	;
            $accommodation->description	   = $request->description;
            $accommodation->lat	           = round($request->lat, 8);
            $accommodation->lng	           = round($request->lng, 8);
            $accommodation->per_night      = $request->per_night;
            $accommodation->type_id	       = $request->type_id;
            $accommodation->type_name      = $request->type_name;
            $accommodation->sub_type_id	   = $request->sub_type_id;
            $accommodation->sub_type_name  = $request->sub_type_name	;
            $accommodation->min_stay	   = $request->min_stay;
            $accommodation->max_stay       = $request->max_stay	;
            $accommodation->dicount        = $request->dicount;
            $accommodation->phone          = $request->phone	;
            $accommodation->taxes_fees	   = $request->taxes_fees;
            $accommodation->location       = $request->location;
            $accommodation->rating	       = $request->stars;
            $accommodation->rating	       = $request->rating;
            // $accommodation->image	       = $request->image;
            $accommodation->status         = $request->status;


            if($accommodation->save()){

                $title      = "TripOperator";
                $message    = "TripOperator Package created successfully. To view detail";
                $action     = "packages/detail/".$accommodation->id;
                $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();
                if(isset($admin) && !empty($admin)){
                    PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_TRIP_OPERATOR,$action,$accommodation->id);
                }

                return response()->json($accommodation, $this->status);
            }
        }else{
            return "Please Input Data";
        }

    }

    public function update(Request $request,$accommodationId){

        $accommodation =  Accommodation::where('id',$accommodationId)->first();
        $accommodation->user_id = $request->user_id	;
        $accommodation->title = $request->title	;
        $accommodation->no_of_rooms	   = $request->no_of_rooms	;
        $accommodation->no_of_people   = $request->no_of_people	;
        $accommodation->description	   = $request->description;
        $accommodation->lat	           = round($request->lat, 8);
        $accommodation->lng	           = round($request->lng, 8);
        $accommodation->per_night      = $request->per_night;
        $accommodation->type_id	       = $request->type_id;
        $accommodation->type_name      = $request->type_name;
        $accommodation->sub_type_id	   = $request->sub_type_id;
        $accommodation->sub_type_name  = $request->sub_type_name	;
        $accommodation->min_stay	   = $request->min_stay;
        $accommodation->max_stay       = $request->max_stay	;
        $accommodation->dicount        = $request->dicount;
        $accommodation->phone          = $request->phone	;
        $accommodation->taxes_fees	   = $request->taxes_fees;
        $accommodation->location       = $request->location;
        $accommodation->rating	       = $request->stars;
        $accommodation->rating	       = $request->rating;
        // $accommodation->image	       = $request->image;
        $accommodation->status         = $request->status;

        if($accommodation->save()){
            $title      = "TripOperator";
            $message    = "TripOperator Package updated successfully. To view detail";
            $action     = "packages/detail/".$accommodation->id;
            $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();
            if(isset($admin) && !empty($admin)){
                PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_TRIP_OPERATOR,$action,$accommodation->id);
            }

            $this->Imagestore($accommodationId,'accommodation',$request);
            return response()->json($accommodation, $this->status);
        }
    }

    public function detail($accommodationId){
        //fetch ist four accomudations
        $accomudations =  TripOperator::with('singleImage')->take(4)->get();
        $accommodation =  TripOperator::where('id',$accommodationId)->first();
        $accommodation->facility;
        $accommodation->images;
        return response()->json(['acc_detail'=>$accommodation,'acc'=>$accomudations]);
    }

    public function Imagestore($module_id,$module,$request)
    {

        request()->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

    public function getAccommodationSubType($accommodationTypeId){
        $subtype = AccommodationSubType::select('name','id')->where('type_id',$accommodationTypeId)->get();
        //$subtype = AccommodationSubType::getByTypeId($accommodationTypeId);
        return $subtype;
    }

}
