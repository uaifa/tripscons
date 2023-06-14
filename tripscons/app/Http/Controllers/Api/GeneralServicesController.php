<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UsersServices;
use App\Models\GeneralService;
use App\Models\CancellationPolicy;
use App\Models\User;
use App\Models\ServiceProviderRate;
use Illuminate\Support\Facades\Validator;


class GeneralServicesController extends Controller
{
    
     /**
     * @var array
     */
    protected $response = [];
    protected $status = 200;

    public function addUpdateGeneralService(){
        $general_services = json_decode(request()->general_services, true);
        $users = request()->user();
        if(!empty($general_services) && !empty($users)){
            $users->generalServices()->sync(array_column($general_services, 'id'));
            if($service_id = array_column($general_services, 'id')){
                if(isset($service_id[0]) && !empty($service_id[0])){
                    $general_services = GeneralService::find($service_id[0]);
                    if(!empty($general_services->user_module_type)){
                        $users->user_module_type = $general_services->user_module_type;
                        if($users->save()){

                            CancellationPolicy::forceCreate([
                                'bookable_id' => $users->id,
                                'cancellation_hour' => '96',
                                'refund_percentage' => '100',
                                'module_name' => $users->user_module_type,
                                'bookable' => User::class
                            ]);
                            CancellationPolicy::forceCreate([
                                'bookable_id' => $users->id,
                                'cancellation_hour' => '72',
                                'refund_percentage' => '75',
                                'module_name' => $users->user_module_type,
                                'bookable' => User::class
                            ]);
            
                            CancellationPolicy::forceCreate([
                                'bookable_id' => $users->id,
                                'cancellation_hour' => '48',
                                'refund_percentage' => '50',
                                'module_name' => $users->user_module_type,
                                'bookable' => User::class
                            ]);
                        }
                        
                    }
                }
            }

            ServiceProviderRate::firstOrCreate(['user_id' => auth()->user()->id]);

                   
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Updated Successfully';
            $this->response['data'] = $general_services;
        }else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'SomeThing Went Wrong!.';    
        }

        return response()->json($this->response, $this->status);
    }


    public function updateUserRole(Request $request){


        $validator = Validator::make($request->all(), [
            'user_ids' => 'required',
            'service_id' => 'numeric'
        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $user_ids = $request->user_ids;
        $service_id = $request->service_id;
        $user_ids = json_decode($user_ids);

        if(!empty($user_ids) && !empty($service_id)){
           
            foreach ($user_ids as $key => $value) {
                $user = User::find($value);
                if(!empty($user)){
                    $user->generalServices()->sync($service_id);
                    $user->user_module_type = 'hotels';
                    $user->switchProfile = 0;
                    $user->type = 1;
                    $user->save();
                    ServiceProviderRate::firstOrCreate(['user_id' => $value]);
                }
            }

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = '';
            $this->response['message'] = 'Role update successfully';
        }else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['data'] = '';
            $this->response['message'] = 'Record not found';
        }

        
        return response()->json($this->response,$this->status);
    }
}
