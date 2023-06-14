<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LogsController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'vendor_id' => 'required',
            'service_title' => 'required',
            'service_id' => 'required',
            'service_url' => 'required',
            'client_id'=>'required'
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }
        $vendor=User::find($request->vendor_id);
        $client=User::find($request->client_id);

        if($vendor && $client){

            UserActivityLog::Create([
                
                'client_id' => $client->id,
                'client_email' => $client->email,
                'client_phone' => $client->phone,
                'vendor_id' => $request->vendor_id,
                'vendor_email' => $vendor->email,
                'vendor_phone' => $vendor->phone,
                'service_title' => $request->service_title,
                'service_url' => $request->service_url,
                'type' => $request->type,
            ]);
        }
        

        return response([
            'success' => true,
            'message' => 'log updated successfully'
        ]);

    }
}
