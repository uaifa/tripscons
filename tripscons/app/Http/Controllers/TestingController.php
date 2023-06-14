<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\CancellationPolicy;
use App\Models\Experience;
use App\Models\Guide;
use App\Models\Meal;
use App\Models\Transport;
use App\Models\User;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Redirect;

class TestingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function transports()
    {
        ini_set('max_execution_time', '0');
        $module_name = 'transports';
        $Transports = Transport::select('id','module_name')->get();
        foreach ($Transports as $Transport) {
            $cancelation_policy1 =CancellationPolicy::where('module_name',$module_name)
                ->where('bookable_id',$Transport->id)
                ->where('cancellation_hour','96')
                ->where('refund_percentage','100')
                ->first();
            if (empty($cancelation_policy1)) {
                CancellationPolicy::forceCreate([
                    'bookable_id' => $Transport->id,
                    'cancellation_hour' => '96',
                    'refund_percentage' => '100',
                    'module_name' => $Transport->module_name,
                    'bookable' => Transport::class
                ]);
            }
            $cancelation_policy2 =CancellationPolicy::where('module_name',$module_name)
                ->where('bookable_id',$Transport->id)
                ->where('cancellation_hour','72')
                ->where('refund_percentage','75')
                ->first();
            if (empty($cancelation_policy2)) {
                CancellationPolicy::forceCreate([
                    'bookable_id' => $Transport->id,
                    'cancellation_hour' => '72',
                    'refund_percentage' => '75',
                    'module_name' => $Transport->module_name,
                    'bookable' => Transport::class
                ]);
            }
            $cancelation_policy3 =CancellationPolicy::where('module_name',$module_name)
                ->where('bookable_id',$Transport->id)
                ->where('cancellation_hour','48')
                ->where('refund_percentage','50')
                ->first();
            if (empty($cancelation_policy3)) {
                CancellationPolicy::forceCreate([
                    'bookable_id' => $Transport->id,
                    'cancellation_hour' => '48',
                    'refund_percentage' => '50',
                    'module_name' => $Transport->module_name,
                    'bookable' => Transport::class
                ]);
            }
        }
        return true;
    }

    public function accommodation()
    {
        ini_set('max_execution_time', '0');
        $module_name = 'accommodations';
        $accomodations = Accommodation::select('id','module_name')->get();
        foreach ($accomodations as $accomodation) {
            $cancelation_policy1 =CancellationPolicy::where('module_name',$module_name)
                ->where('bookable_id',$accomodation->id)
                ->where('cancellation_hour','96')
                ->where('refund_percentage','100')
                ->first();
            if (empty($cancelation_policy1)) {
                CancellationPolicy::forceCreate([
                    'bookable_id' => $accomodation->id,
                    'cancellation_hour' => '96',
                    'refund_percentage' => '100',
                    'module_name' => $accomodation->module_name,
                    'bookable' => Accommodation::class
                ]);
            }
            $cancelation_policy2 =CancellationPolicy::where('module_name',$module_name)
                ->where('bookable_id',$accomodation->id)
                ->where('cancellation_hour','72')
                ->where('refund_percentage','75')
                ->first();
            if (empty($cancelation_policy2)) {
                CancellationPolicy::forceCreate([
                    'bookable_id' => $accomodation->id,
                    'cancellation_hour' => '72',
                    'refund_percentage' => '75',
                    'module_name' => $accomodation->module_name,
                    'bookable' => Accommodation::class
                ]);
            }
            $cancelation_policy3 =CancellationPolicy::where('module_name',$module_name)
                ->where('bookable_id',$accomodation->id)
                ->where('cancellation_hour','48')
                ->where('refund_percentage','50')
                ->first();
            if (empty($cancelation_policy3)) {
                CancellationPolicy::forceCreate([
                    'bookable_id' => $accomodation->id,
                    'cancellation_hour' => '48',
                    'refund_percentage' => '50',
                    'module_name' => $accomodation->module_name,
                    'bookable' => Accommodation::class
                ]);
            }
        }
        return true;
    }

    public function user()
    {
        ini_set('max_execution_time', '0');
        $module_name = 'users';
        $users = User::select('id')->get();
        foreach ($users as $user) {
            $cancelation_policy1 =CancellationPolicy::where('module_name',$module_name)
                ->where('bookable_id',$user->id)
                ->where('cancellation_hour','96')
                ->where('refund_percentage','100')
                ->first();
            if (empty($cancelation_policy1)) {
                CancellationPolicy::forceCreate([
                    'bookable_id' => $user->id,
                    'cancellation_hour' => '96',
                    'refund_percentage' => '100',
                    'module_name' => $module_name,
                    'bookable' => User::class
                ]);
            }
            $cancelation_policy2 =CancellationPolicy::where('module_name',$module_name)
                ->where('bookable_id',$user->id)
                ->where('cancellation_hour','72')
                ->where('refund_percentage','75')
                ->first();
            if (empty($cancelation_policy2)) {
                CancellationPolicy::forceCreate([
                    'bookable_id' => $user->id,
                    'cancellation_hour' => '72',
                    'refund_percentage' => '75',
                    'module_name' => $module_name,
                    'bookable' => User::class
                ]);
            }
            $cancelation_policy3 =CancellationPolicy::where('module_name',$module_name)
                ->where('bookable_id',$user->id)
                ->where('cancellation_hour','48')
                ->where('refund_percentage','50')
                ->first();
            if (empty($cancelation_policy3)) {
                CancellationPolicy::forceCreate([
                    'bookable_id' => $user->id,
                    'cancellation_hour' => '48',
                    'refund_percentage' => '50',
                    'module_name' => $module_name,
                    'bookable' => User::class
                ]);
            }
        }
        return true;
    }

    public function guide()
    {
        ini_set('max_execution_time', '0');
        $module_name = 'guides';
        $guides = Guide::select('id','user_module_type')
            ->get();

        foreach ($guides as $guide) {
            $cancelation_policy1 =CancellationPolicy::where('module_name',$guide->user_module_type)
                ->where('bookable_id',$guide->id)
                ->where('cancellation_hour','96')
                ->where('refund_percentage','100')
                ->first();
            if (empty($cancelation_policy1)) {
                CancellationPolicy::forceCreate([
                    'bookable_id' => $guide->id,
                    'cancellation_hour' => '96',
                    'refund_percentage' => '100',
                    'module_name' => $guide->user_module_type,
                    'bookable' => Guide::class
                ]);
            }
            $cancelation_policy2 =CancellationPolicy::where('module_name',$guide->user_module_type)
                ->where('bookable_id',$guide->id)
                ->where('cancellation_hour','72')
                ->where('refund_percentage','75')
                ->first();
            if (empty($cancelation_policy2)) {
                CancellationPolicy::forceCreate([
                    'bookable_id' => $guide->id,
                    'cancellation_hour' => '72',
                    'refund_percentage' => '75',
                    'module_name' => $guide->user_module_type,
                    'bookable' => Guide::class
                ]);
            }
            $cancelation_policy3 =CancellationPolicy::where('module_name',$guide->user_module_type)
                ->where('bookable_id',$guide->id)
                ->where('cancellation_hour','48')
                ->where('refund_percentage','50')
                ->first();
            if (empty($cancelation_policy3)) {
                CancellationPolicy::forceCreate([
                    'bookable_id' => $guide->id,
                    'cancellation_hour' => '48',
                    'refund_percentage' => '50',
                    'module_name' => $guide->user_module_type,
                    'bookable' => Guide::class
                ]);
            }
        }
        return true;
    }

    public function meals()
    {
        ini_set('max_execution_time', '0');
        $module_name = 'meals';
        $meals = Meal::select('id')->get();
        foreach ($meals as $meal) {
            $cancelation_policy1 =CancellationPolicy::where('module_name',$module_name)
                ->where('bookable_id',$meal->id)
                ->where('cancellation_hour','96')
                ->where('refund_percentage','100')
                ->first();
            if (empty($cancelation_policy1)) {
                CancellationPolicy::forceCreate([
                    'bookable_id' => $meal->id,
                    'cancellation_hour' => '96',
                    'refund_percentage' => '100',
                    'module_name' => $module_name,
                    'bookable' => Meal::class
                ]);
            }
            $cancelation_policy2 =CancellationPolicy::where('module_name',$module_name)
                ->where('bookable_id',$meal->id)
                ->where('cancellation_hour','72')
                ->where('refund_percentage','50')
                ->first();
            if (empty($cancelation_policy2)) {
                CancellationPolicy::forceCreate([
                    'bookable_id' => $meal->id,
                    'cancellation_hour' => '72',
                    'refund_percentage' => '75',
                    'module_name' => $module_name,
                    'bookable' => Meal::class
                ]);
            }
            $cancelation_policy3 =CancellationPolicy::where('module_name',$module_name)
                ->where('bookable_id',$meal->id)
                ->where('cancellation_hour','48')
                ->where('refund_percentage','50')
                ->first();
            if (empty($cancelation_policy3)) {
                CancellationPolicy::forceCreate([
                    'bookable_id' => $meal->id,
                    'cancellation_hour' => '48',
                    'refund_percentage' => '50',
                    'module_name' => $module_name,
                    'bookable' => Meal::class
                ]);
            }
        }
        return true;
    }

    public function experiences()
    {
        ini_set('max_execution_time', '0');
        $experiences = Experience::select('id')->get();
        $module_name = 'experiences';
        foreach ($experiences as $experience) {
            $cancelation_policy1 =CancellationPolicy::where('module_name',$module_name)
                ->where('bookable_id',$experience->id)
                ->where('cancellation_hour','96')
                ->where('refund_percentage','100')
                ->where('bookable',Experience::class)

                ->first();
            if (empty($cancelation_policy1)) {
                CancellationPolicy::forceCreate([
                    'bookable_id' => $experience->id,
                    'cancellation_hour' => '96',
                    'refund_percentage' => '100',
                    'module_name' => $module_name,
                    'bookable' => Experience::class
                ]);
            }
            $cancelation_policy2 =CancellationPolicy::where('module_name',$module_name)
                ->where('bookable_id',$experience->id)
                ->where('cancellation_hour','72')
                ->where('refund_percentage','75')
                ->where('bookable',Experience::class)

                ->first();
            if (empty($cancelation_policy2)) {
                CancellationPolicy::forceCreate([
                    'bookable_id' => $experience->id,
                    'cancellation_hour' => '72',
                    'refund_percentage' => '75',
                    'module_name' => $module_name,
                    'bookable' => Experience::class
                ]);
            }
            $cancelation_policy3 =CancellationPolicy::where('module_name',$module_name)
                ->where('bookable_id',$experience->id)
                ->where('cancellation_hour','48')
                ->where('refund_percentage','50')
                ->where('bookable',Experience::class)
                ->first();
            if (empty($cancelation_policy3)) {
                CancellationPolicy::forceCreate([
                    'bookable_id' => $experience->id,
                    'cancellation_hour' => '48',
                    'refund_percentage' => '50',
                    'module_name' => $module_name,
                    'bookable' => Experience::class
                ]);
            }
        }
        return true;
    }

    public function removeguides(){
        $module_name = 'guides';
        $cancelation_policy1 =CancellationPolicy::where('module_name',$module_name)
            ->delete();
    }

    public function updateCancelationpolicy(){
        $cancelation_policys =CancellationPolicy::where('cancellation_hour','48')
            ->where('refund_percentage','50')
            ->get();
        foreach ($cancelation_policys as $cancelation_policy){
            $cancelation_policy->cancellation_hour = '48% Refund';
            $cancelation_policy->refund_percentage = '50% Refund';

            dd($cancelation_policy);
        }
        dd($cancelation_policy);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getAppLink(Request $request){

        // $iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
        // $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
        // $iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
        // $Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
        // $webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");
        $agent = new Agent();
        // return $agent->is('Windows');

        if($agent->is('iPhone')){

            return Redirect::to('https://apps.apple.com/app/tripscon/id1603074345');

        }else if($agent->isAndroidOS()){

             return Redirect::to('https://play.google.com/store/apps/details?id=com.tripscon.app&pli=1');
       
        }else if($agent->is('Windows')){
             return Redirect::to('https://play.google.com/store/apps/details?id=com.tripscon.app&pli=1');
            //browser reported as a webOS device -- do something here
        }
         return Redirect::to('https://play.google.com/store/apps/details?id=com.tripscon.app&pli=1');
    }
}
