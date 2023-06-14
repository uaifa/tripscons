<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fcm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FCMsController extends Controller
{
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        Fcm::firstOrCreate([
            'user_id' => $request->user()->id,
            'token' => $request->token,
        ]);

        return response([
            'success' => true,
            'message' => 'Fcm token updated successfully'
        ]);

    }
}
