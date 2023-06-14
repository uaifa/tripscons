<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use App\Models\Experience;
use App\Models\User;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;
use App\Models\PackageItinerary;
use App\Models\PackageFacility;
use App\Models\TripsProperty;
use App\Models\PackageVideo;
use Illuminate\Support\Facades\Validator;
use App\Models\Guide;
use App\Models\Meal;
use App\Models\Transport;

class PackageFacilitiesController extends Controller
{

    protected $status = 200;
    protected $response = [];

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

    public function addPackageFacilities(Request $request){

        $bookable = Guide::where('id', $request->package_id)->where('user_id', request()->user()->id)->first();

        if(!$bookable) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid bookable';
            return response()->json($this->response, $this->status);
        }

        if(isset($request->type) && $request->type == 'excluded'){

            $data['everything_considered'] = (isset($request->everything_considered) && !empty($request->everything_considered)) ? 1 : 0;

            $data['description'] = $request->what_excluded;
            $data['type'] = $request->type;
            $data['package_id'] = $request->package_id;
            PackageFacility::where('package_id', $request->package_id)->where('type','excluded')->delete();
            PackageFacility::insert($data);
            $title      = "Package Created";
            $message    = "Package Created service created successfully";
            $action     = "api/tripPackageAdd";
            PushNotification::createNotification(auth()->user(),1,$title,$message,User::TYPE_PACKAGE,$action);

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $data;
            $this->response['message'] = 'Add package facilities successfully';


        }else{

            $trip_facilities = json_decode($request->trip_facilities, true);
            $data = [];
            if(!empty($trip_facilities) && !empty($request->package_id)){
                foreach ($trip_facilities as $key => $value) {

                    if($value['type'] == 'excluded'){
                        $everything_considered = 0;

                        $everything_considered = (isset($value['everything_considered']) && !empty($value['everything_considered'])) ? 1 : 0;

                        array_push($data, ['type' => $value['type'], 'everything_considered' => $everything_considered, 'description' => $value['description'], 'package_id' => $request->package_id]);
                    }else{
                        array_push($data, ['type' => $value['type'], 'title' => $value['title'], 'description' => $value['description'], 'package_id' => $request->package_id]);
                    }

                    if(!empty($value['type'])){
                        PackageFacility::where('package_id', $request->package_id)->where('type',$value['type'])->delete();
                    }
                }

                if(!empty($data)){
                    foreach ($data as $key => $value) {
                        PackageFacility::insert($value);
                    }
                }
                // $title      = "Package facility";
                // $message    = "Package facility created successfully.To view detail";
                // $action     = "user/setting";
                // $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();
                
                // if(isset($admin) && !empty($admin)){
                //     PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_PACKAGE,$action,$data->id);
                // }

                $this->status = 200;
                $this->response['success'] = true;
                $this->response['data'] = $data;
                $this->response['message'] = 'Add package facilities successfully';


            }
        }
        $this->response['data'] = $request->all();
        return response()->json($this->response,$this->status);

    }
    public function addPackageItinerary(Request $request){

        $validator = Validator::make($request->all(), [
            'trip_itinerary' => 'required|json',
            'package_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $bookable = Guide::where('id', $request->package_id)->where('user_id', request()->user()->id)->first();

        if(!$bookable) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid bookable';
            return response()->json($this->response, $this->status);
        }

        $trip_itinerary = json_decode($request->trip_itinerary, true);
        // return $trip_itinerary;
        $data = [];
        if(!empty($trip_itinerary) && !empty($request->package_id)){
            foreach ($trip_itinerary as $key => $value) {
                if(isset($value['items']) && !empty($value['items'])){
                    foreach ($value['items'] as $key => $item) {

                        array_push($data, ['time' => $item['time'], 'activity' => $item['activity'], 'destination' => $item['destination'], 'date' => date("Y-m-d", strtotime($item['date'])),  'package_id' => $request->package_id]);
                    }
                }

            }
            // return $data;
            if(!empty($data)){
                PackageItinerary::where('package_id', $request->package_id)->delete();
                PackageItinerary::insert($data);
                $title      = "Package itinerary";
                $message    = "Add Package itinerary created successfully";
                $action     = "api/tripPackageItinerary";
                PushNotification::createNotification(auth()->user(),1,$title,$message,User::TYPE_PACKAGE,$action);

                $this->status = 200;
                $this->response['success'] = true;
                $this->response['data'] = $data;
                $this->response['message'] = 'Add package itinerary successfully';

            }
        }else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Please Input Data Properly.';
        }

        return response()->json($this->response,$this->status);
    }

    public function addPackageProperties(Request $request)
    {
        $bookable = Guide::where('id', $request->package_id)->where('user_id', request()->user()->id)->first();
        // return request()->user()->id;
        if(!$bookable){
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid bookable';
            return response()->json($this->response, $this->status);
        }
        $data = [];
        $data['trip_type'] = $request->trip_type;
        $data['group_size'] = $request->group_size;
        $data['activity_level'] = $request->activity_level;
        $data['suitable_age'] = $request->suitable_age;
        $data['group_discount'] = $request->group_discount;
        $data['couple_discount'] = $request->couple_discount;
        $data['child_discount'] = $request->child_discount;
        $data['group_discount_members'] = $request->group_discount_members;
        $data['package_id'] = $request->package_id;
        $data['departure_date'] = $request->departure_date;

        if (isset($request->is_offer_promotion_discount)) {
            $guide = Guide::find($request->package_id);
            $guide->is_offer_promotion_discount = $request->is_offer_promotion_discount;
            $guide->promotion_discount = $request->promotion_discount;
            $guide->save();
        }

        TripsProperty::updateOrCreate(['package_id' => $request->package_id], $data);
        $title      = "Package properties";
        $message    = "Add Package properties created successfully";
        $action     = "api/tripPackageProperties";
        PushNotification::createNotification(auth()->user(),1,$title,$message,User::TYPE_PACKAGE,$action);

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        $this->response['message'] = 'Add package properties successfully';

        return response()->json($this->response,$this->status);

    }
    public function addPackageVideosUrl(Request $request){

        $trip_videos = json_decode($request->trip_videos, true);

        $data = [];

        $bookable = (new $this->moduleBinding[$request->module])->where('user_id', $request->user()->id)->where('id', $request->package_id)->first();

        if($request->module == null){
            $bookable = Guide::where('user_id', $request->user()->id)->where('id', $request->package_id)->first();
        }

        if(!$bookable) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid bookable';
            return response()->json($this->response,$this->status);
        }

        if(!empty($trip_videos) && !empty($request->package_id)){
            foreach ($trip_videos as $key => $value) {
                array_push($data, ['title' => $value['title'], 'url' => $value['video_url'], 'package_id' => $request->package_id,'module' =>$request->module]);
            }

            if(!empty($data)){
                PackageVideo::where('package_id', $request->package_id)->delete();
                PackageVideo::insert($data);
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['data'] = $data;
                $this->response['message'] = 'videos added successfully';
            }

        }else{

            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Please Input Data Properly.';

        }
        return response()->json($this->response,$this->status);

    }
}
