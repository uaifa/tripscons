<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    
    protected $status = 200;
    protected $response = [];



    public function getUsers(){

        // $validator = Validator::make($request->all(),[
        //         'contest_id' => 'numeric'
        //     ]);
        // if ($validator->fails()) {
        //     $this->status = 422;
        //     $this->response['success'] = false;
        //     $this->response['message'] = $validator->messages()->first();
        //     return response()->json($this->response, $this->status);
        // }
        $username = (isset(request()->username) && !empty(request()->username)) ? request()->username : '';
        $users = User::when(!empty($username), function($query) use ($username){
            $query->where('name', 'like', '%'.$username.'%')->orWhere('email', 'like', '%'.$username.'%');
        })->paginate(config()->get('global.pagination_records'));
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $users;

        return response()->json($this->response, $this->status);

    }
}
