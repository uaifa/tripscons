<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Libs\Image\Optimizer;



class CompanyController extends Controller
{
    protected $status = 200;
    protected $response = [];


    public function addCompany(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'tag_line' => 'required',
            'team_size' => 'required',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        if(isset($request->is_company)){
            $is_company = !empty($request->is_company) ? 1 : 0;
            $user = User::find(auth()->user()->id);
            $user->is_company = $is_company;
            $user->save();
        }
        $data['name'] = $request->name;
        $data['tag_line'] = $request->tag_line;
        $data['about'] = $request->about ? $request->about : '';
        $data['team_size'] = $request->team_size;
        $data['user_id'] = auth()->user()->id;
        if(isset($request->is_company_registered) && !empty($request->is_company_registered)){
            $data['is_company_registered'] = $request->registration_no ? 1 : 0;
        }
        if(isset($request->registration_no) && !empty($request->registration_no)){
            $data['registration_no'] = $request->registration_no;
        }
        // if(auth()->user()->is_company){
        //     $data['image'] = '';
        // }

        if($files = $request->file('image')){
            $image_full_name = pathinfo($files->getClientOriginalName(), PATHINFO_FILENAME).'_'.time().'.'.$files->getClientOriginalExtension();
            $destinationPath = public_path('/assets/uploads/companies'); //Creating Sub directory in Public
            
            $files = $files->move($destinationPath,$image_full_name);
            Optimizer::optimize($files);

            $data['image'] = $image_full_name;
        }
        $message = 'Record add successfully!';
        $compan = Company::where('user_id', auth()->user()->id)->first();
        if(isset($compan) && !empty($compan)){
            $message = 'Record update successfully!';
            $title      = "Company";
            $message    = "Company added successfully. To view detail";
            $action     = "user/setting/".$compan->id;
            $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();
            if(isset($admin) && !empty($admin)){
                PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_COMPANY,$action,$compan->id);
            }
        }

        if ($company = Company::updateOrCreate(['user_id'=> auth()->user()->id],$data)) {
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = $message;
            $this->response['data'] = $company;
        } else {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Some thing went wrong!.';
        }
        return response()->json($this->response, $this->status);

    }
}
