<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cheff;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class CheffsController extends Controller
{
    
    protected $status = 200;
    protected $response = [];

    public function index(){

        $cheffs = Cheff::orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $cheffs;
        return response()->json($this->response, $this->status);
    
    }
    public function addCheff(Request $request){
        
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,NEF,nef,svg',
            'menu' => 'required',
            'location' => 'required'
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $cheffs = New Cheff();
        $cheffs->title = $request->title;
        $cheffs->menu = $request->menu;
        $cheffs->location = $request->location;
        $cheffs->city = $request->city;
        $cheffs->country = $request->country;
        $cheffs->lng = round($request->lng, 8);
        $cheffs->lat = round($request->lat, 8);
        $cheffs->user_id = auth()->user()->id;
        $cheffs->image = '';
        if(isset($request->image)){
            
            if($files = $request->file('image')){ 
                $image_full_name = pathinfo($files->getClientOriginalName(), PATHINFO_FILENAME).'_'.time().'.'.$files->getClientOriginalExtension(); 
                $destinationPath = public_path('/assets/uploads/cheffs'); //Creating Sub directory in Public 
                $files->move($destinationPath,$image_full_name); 
                $cheffs->image = $image_full_name;
            }
        }

        $cheffs->save();

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $cheffs;
        $this->response['message'] = 'Record save successfully';
        return response()->json($this->response, $this->status); 
           
    }
}
