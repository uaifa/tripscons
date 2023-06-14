<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;
use App\Models\OurTeam;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;


class OurTeamsController extends Controller
{
    protected $status = 200;
    protected $response = [];

    public function getOurTeams(){

        $our_teams = OurTeam::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $our_teams;
        $this->response['message'] = 'List Fetch Successfully';
        return response()->json($this->response, $this->status);

    }
    public function getTeams($user_id){

        $our_teams = OurTeam::where('user_id', $user_id)->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $our_teams;
        $this->response['message'] = 'List Fetch Successfully';
        return response()->json($this->response, $this->status);

    }

    public function addOurTeam(Request $request){

        $validator = Validator::make($request->all(), [
          'name' => 'required',
          'image' => 'required',
          'designation' => 'required',
          'skills' => 'required',
          'contact' => 'required',
          'email' => 'required',
          'dob' => 'required'  ,
        ]);

        if ($validator->fails()) {
          $this->status = 422;
          $this->response['success'] = false;
          $this->response['message'] = $validator->messages()->first();
          return response()->json($this->response, $this->status);
        }

        $our_teams = new OurTeam();
        $our_teams->name = $request->name;
        // $our_teams->image = $request->image;
        $our_teams->about = $request->about;
        $our_teams->designation = $request->designation;
        $our_teams->skills = $request->skills;
        $our_teams->contact = $request->contact;
        $our_teams->email = $request->email;
        $our_teams->dob = date("Y-m-d", strtotime($request->dob));
        if(isset($request->status))
            $our_teams->status = $request->status;

        $our_teams->image = $this->Imagestore($request);

        $our_teams->user_id = auth()->user()->id;
        $title      = "Team";
        $message    = "Team added successfully";
        $action     = "user/setting";
        $admin = User::where('id',User::ADMIN_ID)->first();
        if($our_teams->save()){

            if(isset($admin) && !empty($admin)){
                PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_TEAM,$action,$our_teams->id);
            }

            $this->status = 200;
              $this->response['success'] = true;
              $this->response['data'] = $our_teams;
              $this->response['message'] = 'Record add successfully.';
        }else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Please Input Data Properly.';
        }

        return response()->json($this->response, $this->status);

    }
    public function getOurTeamDetail($team_id){

        $our_teams = OurTeam::where('user_id', auth()->user()->id)->where('id', $team_id)->first();
        if(!empty($our_teams)){
              $this->status = 200;
              $this->response['success'] = true;
              $this->response['data'] = $our_teams;
              $this->response['message'] = 'Success';
        }else{
            if(empty($our_teams)){
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['data'] = [];
                $this->response['message'] = 'Record not found';
            }else{
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = 'Something went wrong.';
            }
        }
        return response()->json($this->response, $this->status);

    }
    public function updateOurTeam(Request $request, $team_id){

        $validator = Validator::make($request->all(), [
          'name' => 'required',
          'designation' => 'required',
          'skills' => 'required',
          'contact' => 'required',
          'email' => 'required',
          'dob' => 'required'  ,
        ]);

        if ($validator->fails()) {
          $this->status = 422;
          $this->response['success'] = false;
          $this->response['message'] = $validator->messages()->first();
          return response()->json($this->response, $this->status);
        }

        $our_teams = OurTeam::find($team_id);
        $our_teams->name = $request->name;
        // $our_teams->image = $request->image;
        $our_teams->about = $request->about;
        $our_teams->designation = $request->designation;
        $our_teams->skills = $request->skills;
        $our_teams->contact = $request->contact;
        $our_teams->email = $request->email;
        if(isset($request->dob) && !empty($request->dob)){
            $our_teams->dob = date("Y-m-d", strtotime($request->dob)); //$request->dob;
        }
        if(isset($request->status))
            $our_teams->status = $request->status;

        if($request->hasFile('image')){
            $our_teams->image = $this->Imagestore($request);
        }

        $our_teams->user_id = auth()->user()->id;

        if($our_teams->save()){
            $title      = "Team";
            $message    = "Team members updated successfully";
            $action     = "user/setting/".$our_teams->id;
            $admin = User::where('id',User::ADMIN_ID)->first();
            if(isset($admin) && !empty($admin)){
                PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_TEAM,$action,$our_teams->id);
            }

            $this->status = 200;
              $this->response['success'] = true;
              $this->response['data'] = $our_teams;
              $this->response['message'] = 'Record update successfully.';
        }else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Something went wrong';
        }

        return response()->json($this->response, $this->status);

    }
    public function deleteOurTeam($team_id){
        $our_teams = OurTeam::where('user_id', auth()->user()->id)->where('id', $team_id)->first();
        if($our_teams->delete()){
              $this->status = 200;
              $this->response['success'] = true;
              $this->response['data'] = $our_teams;
              $this->response['message'] = 'Record delete successfully.';
        }else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Something went wrong.';
        }
        return response()->json($this->response, $this->status);

    }

    public function Imagestore($request){

        if(isset($request->image)){
            request()->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,NEF,nef,svg',
            ]);
            if($files = $request->file('image')){
                $image_full_name = pathinfo($files->getClientOriginalName(), PATHINFO_FILENAME).'_'.time().'.'.$files->getClientOriginalExtension();
                $destinationPath = public_path('/assets/uploads/teams'); //Creating Sub directory in Public
                $files->move($destinationPath,$image_full_name);
                return $image_full_name;
            }
        }
        return '';
   }
}
