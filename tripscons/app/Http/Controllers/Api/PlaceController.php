<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Place;
use Illuminate\Support\Facades\Validator;

class PlaceController extends Controller{
    protected $status = 200;
    protected $response = [];
    public function addPlace(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'module_id' => 'required',
            'distance' => 'required'
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }
        $accommodation = Accommodation::where('user_id', $request->user()->id)->where('id', $request->module_id)->first();
        if(!$accommodation){
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = "Invalid accommodation";
            return response()->json($this->response, $this->status);
        }

        $place = Place::where('title',$request->title)->where('module_id',$request->module_id)->first();
        if($place){
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Place Already Existed.';
            return response()->json($this->response, $this->status);
        }
       $place = new Place;
       $place->title = $request->title;
       $place->module_id = $request->module_id;
       $place->distance = $request->distance;
    //    $place->type = $request->type;
       $place->module ='accommodation';
       if($place->save()){

           $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Place Added Successfully';
       }
       return response()->json($this->response, $this->status);
   }

   public function getPlaces(Request $request){

        $validator = Validator::make($request->all(), [
            'module_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $places = Place::where('module_id',$request->module_id)->get();
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $places;
        if(empty($places)){
            $this->response['message'] = 'Places Not Found';
        }

        return response()->json($this->response, $this->status);
   }
   public function deletePlace(Request $request){
        $validator = Validator::make($request->all(), [
            'place_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }
        $place = Place::where('id',$request->place_id)->delete();
        if($place){
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Place Deleted Successfully';
            return response()->json($this->response, $this->status);
        }else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Place Deleted Fail';
            return response()->json($this->response, $this->status);
        }
   }

}
