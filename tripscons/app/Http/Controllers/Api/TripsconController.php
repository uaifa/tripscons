<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Tripscon;


class TripsconController extends Controller{
    protected $status = 200;
    protected $response = [];
    
    public function add(Request $request){
        
        $this->status = 401;
        $this->response['success'] = false;
        $this->response['message'] = 'invalid data.';

        if(count($request->all()) > 0){
            $data = new Tripscon;
            $data->user = serialize($request->user); 
            $data->module = $request->module;
            $data->application_mode = $request->application_mode; 
            $data->data = serialize($request->data); 
            
            if($data->save()){
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'data saved.';
            }
        }
         
        return response()->json($this->response, $this->status);
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
