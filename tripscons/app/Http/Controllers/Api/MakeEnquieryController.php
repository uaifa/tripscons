<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MakeEnquiry;

class MakeEnquieryController extends Controller
{
    protected $status = 200;
    protected $response = [];


    public function submitEnquiery(){
        
        $make_enquiry = new MakeEnquiry();

        $make_enquiry->name = request()->name;
        $make_enquiry->email = request()->email;
        $make_enquiry->phone_number = request()->phone_number; 
        $make_enquiry->enquiry_detail = request()->enquiry_detail;
        $make_enquiry->user_id =  request()->user_id;
        $make_enquiry->status =  request()->status;
        $make_enquiry->user_module_type = request()->user_module_type;

        if($make_enquiry->save()){
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Query submit successfull!';
            $this->response['data'] = $make_enquiry;
        }else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Please Input Data Properly.';
        }
        return response()->json($this->response, $this->status);
    }
}
