<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;
use App\Models\CoveredEvent;
use App\Models\PackagesCoveredEvents;

class CoveredEventsController extends Controller
{

    /**
     * @var array
     */
    protected $response = [];
    protected $status = 200;

    public function getCoveredEvents(){

        $covered_events = CoveredEvent::orderBy('id', 'DESC')->get();
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $covered_events;
        $this->response['message'] = 'List Fetch Successfully';
        return response()->json($this->response, $this->status);
    }

    public function addUpdatePackagesCoveredEvents(){

        $packages_covered_events = json_decode(request()->packages_covered_events, true);
        $package_id = request()->package_id;

        if(!empty($packages_covered_events)){
            $data = [];
            foreach ($packages_covered_events as $key => $value) {
                    $data[$key]['package_id'] = request()->package_id;
                    $data[$key]['name'] = $value['name'];
                    $data[$key]['image'] = $value['image'];
                   }
                if(!empty($data)){
                    PackagesCoveredEvents::where('package_id', request()->package_id)->delete();
                    $packages_covered_events = PackagesCoveredEvents::insert($data);
                }
            $title      = "Package";
            $message    = "Package covered events added successfully";
            $action     = "user/setting/".$packages_covered_events->id;
            PushNotification::createNotification(auth()->user(),1,$title,$message,User::TYPE_PACKAGE,$action,$packages_covered_events->id);

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $packages_covered_events;
            $this->response['message'] = 'Package covered events added successfully';
        }

        return response()->json($this->response,$this->status);
    }
}
