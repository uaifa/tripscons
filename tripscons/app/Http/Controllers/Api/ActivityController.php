<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accommodation;
use App\Models\Host;
use App\Models\Image;
use App\Models\Facility;
use App\Models\AccommodationSubType;
use App\Models\FacilityAccommodation;
use App\Models\Activity;
use Illuminate\Support\Facades\Config;

class ActivityController extends Controller
{
    protected $status = 200;
    protected $response = [];

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
        $resd = FacilityAccommodation::select('name','accommodation_id')->where('name',$propertyFacility)->orderBy('id', 'DESC')->get();
        foreach($resd as $response){
          array_push($res,$response->accommodation_id);
        }

        if(!empty($request)){   //with('images')->
           $experiences = Activity::with('images')->where(function($query) use ($proRating,$noOfPeople, $min,$max,$proType,$proSubType,$propertyFacility,$propertyThirdType,$country,$city) {


                if($proRating > 0){
                   // $query->where('stars',$proRating);

                }

                if($noOfPeople > 0){
                  //  $query->Where('no_of_people','>=',$noOfPeople);

                }

                if($min > 0){
                 //   $query->Where('per_day_price','>=', $min);

                }

                if($max > 0){
                  //  $query->Where('per_day_price','<=', $max);

                }

                if(!empty($proType)){

                // $query->Where('type_id', $proType);
                }
                if(!empty($proSubType)){
                // $query->Where('sub_type_id', $proSubType);
                }
                if($propertyThirdType !=0){
                //  $query->Where('sub_type_id', $proSubType);
                 }
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
        })->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));

        }else{
             $experiences = Activity::with('images')->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
        }

        $experiences->facilities = $facilities;
        print_r($experiences);
        die;
        //$experiences = Facility::all('name','image')->take(4); //fac replaced facilities and acc ko accommodation say
        //  $experiences = array('experiences'=>$experiences,facilities=>$facilities);

        return response()->json(['data'=>$experiences,$this->status]);
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
        $accommodation->stars	       = $request->stars;
        $accommodation->rating	       = $request->rating;
        // $accommodation->image	       = $request->image;
        $accommodation->status         = $request->status;

        if($accommodation->save()){
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
        $accommodation->stars	       = $request->stars;
        $accommodation->rating	       = $request->rating;
        // $accommodation->image	       = $request->image;
        $accommodation->status         = $request->status;
        if($accommodation->save()){
            $this->Imagestore($accommodationId,'accommodation',$request);
            return response()->json($accommodation, $this->status);
          }
    }
    public function AccommodationDetail($accommodationId){
        //fetch ist four accomudations
        $accomudations =  Accommodation::with('singleImage')->take(4)->orderBy('id', 'DESC')->get();
        $accommodation =  Accommodation::where('id',$accommodationId)->first();
        $accommodation->facility;
        $accommodation->images;
        return response()->json(['acc_detail'=>$accommodation,'acc'=>$accomudations]);
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
 public function getAccommodationSubType($accommodationTypeId){
   $subtype = AccommodationSubType::select('name','id')->where('type_id',$accommodationTypeId)->orderBy('id', 'DESC')->get();
  //$subtype = AccommodationSubType::getByTypeId($accommodationTypeId);
  return $subtype;
 }

}
