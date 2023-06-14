<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Host;



class ServicesProviderController extends Controller
{
    
    protected $status = 200;
    protected $response = [];


    public function detail($Id){
        
        $detail =  User::with(['guides','guides.singleImage','activity'])->where('id',$Id)->first();

        if(!$detail){
            $this->status = 200;
            $this->response['success'] = false;
            $this->response['message'] = 'invalid Id';
            return response()->json($this->response,$this->status);  
        }

        $relatedData =   Host::take(4)->orderBy('id', 'DESC')->get();
        $detail->relatedData =  $relatedData;

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $detail;
        return response()->json($this->response,$this->status);   
    }
}
