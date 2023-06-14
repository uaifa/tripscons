<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;
use App\Traits\HostServiceBookingTrait;
use App\Models\Host;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DateTime;
use App\Models\Guide;
use App\Models\GuideBookingDetail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Invoice;
use App\Models\ServiceProviderRate;
use App\Models\TripsProperties;
class ServiceProviderBookingsController extends Controller
{
    protected $status = 200;
    protected $response = [];
    use HostServiceBookingTrait;
    public function checkServiceProviderAvailability(Request $request){

        $validator = Validator::make($request->all(), [
            'booking_type' => 'required'
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }
        if($request->booking_type == 'Package'){
          return  $this->serviceProviderPackageAvailability($request);
        }
        else{
             if($request->module_name == 'guideprofile'){
                return  $this->serviceProviderAvailability($request);
             }else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'please enter valid module name';
            return response()->json($this->response, $this->status);
             }

            //may be change later that's why make seperate
        }

     }
    public function serviceProviderPackageAvailability($request){

        $validator = Validator::make($request->all(), [
            'module_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            $this->response['data']['availability'] = false;
            return response()->json($this->response, $this->status);
        }
        $guide =  Guide::where('id',$request->module_id)->first();

        if(!$guide){
        $this->status = 422;
        $this->response['success'] = false;
        $this->response['message'] = 'invalid module id /package id';
        $this->response['data']['availability'] = false;
        return response()->json($this->response,$this->status);
        }
        $user_id = $guide->user_id;
        //$guide->user_module_type == "trips" ||  cant add because no departure date and size
        if($guide->user_module_type == "trip_operators"){
          return  $this->checkTripsAvailability($request,$guide);
        }

        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
            'booking_type' => 'required'
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }
        //->where('user_module_type',$request->module_name)



        if($request->booking_type == 'Package'){
            $booking = Booking::where('provider_id',$user_id)->where('start_date',date("Y-m-d", strtotime($request->start_date)))->where('status', 0)->first();
            if($booking){
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = 'Package is already booked sorry for that,please see in other days';
                // $this->response['availability'] = false;
                $this->response['data']['availability'] = false;
                return response()->json($this->response, $this->status);
            }
             $this->status = 200;
             $this->response['success'] = true;
             $this->response['data'] = $this->packagePrice($guide,$request->booking_type,1);
             $this->response['data']['booking_type'] = $request->booking_type;
             $this->response['data']['availability'] = true;
        }
        else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid booking type';
            // $this->response['availability'] = false;
            $this->response['data']['availability'] = false;
        }
         return response()->json($this->response, $this->status);
    }
    public function checkTripsAvailability($request,$guide){
        $validator = Validator::make($request->all(), [
            'no_of_traveller' => 'required',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['data']['availability'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $TripsProperties =  TripsProperties::where('package_id',$request->module_id)->first();
        $remainingSeats = 0;
        if(!empty($TripsProperties)){
            $remainingSeats = $TripsProperties->group_size - $TripsProperties->booked_counter;
        }
        if($request->no_of_traveller > $remainingSeats){
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Seats are not enough,In this trip only '.$remainingSeats.' seats are remaining so you cannot book more than that, you can see other trips';

            $this->response['data']['availability'] = false;
            return response()->json($this->response, $this->status);
        }
        $dt = new DateTime();
        $TripPackage =  Guide::where('id',$request->module_id)->Where('start_date','<=',$dt->format('Y-m-d'))->first();
        if($TripPackage){
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'That package date has been passed please try another one';

            $this->response['data']['availability'] = false;
            return response()->json($this->response, $this->status);
        }
        $booking =  TripsProperties::where('package_id',$request->module_id)->Where('departure_date','<=',$dt->format('Y-m-d'))->where('booked_counter','>=',$TripsProperties->group_size)->first();
            if($booking){
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = 'Trip group size is full,please see other trips';

                $this->response['data']['availability'] = false;
                return response()->json($this->response, $this->status);
            }
             $this->status = 200;
             $this->response['success'] = true;
             $this->response['data'] = $this->packagePrice($guide,$request->booking_type,$request->no_of_traveller);
             $this->response['data']['booking_type'] = $request->booking_type;
             $this->response['data']['availability'] = true;
             return response()->json($this->response, $this->status);

    }
    public function serviceProviderAvailability(Request $request){

        $validator = Validator::make($request->all(), [
            'module_id' => 'required',
            'module_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'booking_type' => 'required',
        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }


        if($request->booking_type == 'Hourly'){

            $st = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_date)->format('Y-m-d');
            $et = Carbon::createFromFormat('Y-m-d H:i:s', $request->end_date)->format('Y-m-d');
            //in case
            $booking = Booking::where('provider_id',$request->module_id)->where('status',0)->where(function($query) use  ($st,$et){
                  $query->wherebetween('start_date',[$st, $et])
                  ->orwherebetween('end_date', [$st, $et]);

              })->first();
              if($booking){
                  $this->status = 200;
                  $this->response['success'] = true;
                  $this->response['message'] = 'In this duration that person is already booked sorry for that';
                  $this->response['data']['availability'] = false;
                  return response()->json($this->response, $this->status);
              }

          }
        $booking = Booking::where('status',0)->where('provider_id',$request->module_id)->where(function($query) use  ($request){
            $query->wherebetween('start_date',[date("Y-m-d", strtotime($request->start_date)),date("Y-m-d", strtotime($request->end_date))])
            ->orwherebetween('end_date', [date("Y-m-d", strtotime($request->start_date)),date("Y-m-d", strtotime($request->end_date))]);

        })->first();


     if($booking){
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'In these days that person is already booked sorry for that';
            $this->response['data']['availability'] = false;
        }else{


            if($request->booking_type == 'Hourly'){
                $nights =  $this->caluclateTime(date("Y-m-d", strtotime($request->start_date)),date("Y-m-d", strtotime($request->end_date)));
                if($nights ==1){
                    $this->status = 422;
                    $this->response['success'] = false;
                    $this->response['message'] = 'Atleast one hour you need to book';
                    $this->response['data']['availability'] = false;
                    return response()->json($this->response, $this->status);
                }

            }else{

                $nights =  $this->caluclateDaysorNights(date("Y-m-d", strtotime($request->start_date)),date("Y-m-d", strtotime($request->end_date)));
            }
            $service_provider_rate = ServiceProviderRate::where('user_id',$request->module_id)->first();
            if(!$service_provider_rate){
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = 'Invalid service provider id/please add price of user';
                $this->response['data']['availability'] = false;
                return response()->json($this->response, $this->status);
            }

            if($nights  <= 0){
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'please select valid date';
                $this->response['data']['availability'] = false;
                return response()->json($this->response, $this->status);
            }
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $this->servicePrice($service_provider_rate,$nights,$request->booking_type);
            $this->response['data']['booking_type'] = $request->booking_type;
            $this->response['data']['availability'] = true;

        }
       return response()->json($this->response, $this->status);
    }
   public function createServiceProviderBooking(Request $request){
      if(count($request->all()) > 0){


          if($request->module_name =='guideprofile'){
            $response = $this->serviceProviderAvailability($request);
            if($response->original['data']['availability'] == false){
                 return $this->serviceProviderAvailability($request);
             }
            return $this->guideProfileBooking($request);
          }

          $response = $this->serviceProviderPackageAvailability($request);
          if($response->original['data']['availability'] == false){
                 return $this->serviceProviderPackageAvailability($request);
             }
          $this->response['data'] = [];
          $booking = new Booking;
          $booking_detail = new GuideBookingDetail;
          $invoice = new Invoice;


          $validator = Validator::make($request->all(), [

              'module_id' => 'required',
              'start_date' => 'required',
              'booking_type' => 'required',
              'no_of_traveller' => 'required',

          ]);
          if ($validator->fails()) {
              $this->status = 422;
              $this->response['success'] = false;
              $this->response['message'] = $validator->messages()->first();
              return response()->json($this->response, $this->status);
          }
          $response = $this->checkServiceProviderAvailability($request);

          if($response->original['data']['availability'] == false){
              return $this->checkServiceProviderAvailability($request);
          }

          $this->response['data'] = [];
          $guide = Guide::where('id',$request->module_id)->first();
          $tripsProperties =  TripsProperties::where('package_id',$request->module_id)->first();

          $priceDetail = $this->packagePrice($guide,$request->booking_type,$request->no_of_traveller);
          $booking->provider_id	       = $guide->user_id;
          $booking->module_name	       = $guide->user_module_type;
          $booking->module_id      = $request->module_id;
          $booking->user_id = $request->user()->id;
          $booking->no_of_nights	   = 0; //fixed package
          if(isset($request->start_date)){
              $booking->start_date	   = date("Y-m-d", strtotime($request->start_date)); // $request->start_date;
              $booking->end_date	   = date("Y-m-d", strtotime($request->end_date)); //$request->end_date;
          }
          $booking->price	   = $priceDetail['price'];
          $booking->sub_total	   = $priceDetail['sub_total'];
          $booking->discount	   = $priceDetail['discount'];
          $booking->total	   = $priceDetail['total'];
          $booking->grand_total	   = $priceDetail['grand_total'];
          $booking->booking_type	   = $request->booking_type;
          $booking->provider_name	   = 'service provider';


          //later change it place dynamic id of status 0 means pending
          $booking->booking_number	   = rand(100000,999999);
          $booking->status	   = 0;  //its means pending booking
          $booking->payment_status	   = 0;
          if($booking->save()){
              $booking_detail->no_of_traveller	   = $request->no_of_traveller;
              $booking_detail->destination	   = $request->destination;
              $booking_detail->module_id	   =         $request->module_id;
              $booking_detail->booking_id	   =         $booking->id;
              $booking_detail->booking_type	   =        $request->booking_type;
              $booking_detail->save();
              //invoice detail created...
              $invoice->booking_id = $booking->id;
              $invoice->number = rand(100000,999999);
              $invoice->status = 0; //used for unpaid
              $invoice->save();
              if($guide->user_module_type == 'trip_operators'){
                $tripsProperties->booked_counter = $tripsProperties->booked_counter + $request->no_of_traveller;
                $tripsProperties->save();
              }
              $title      = "Booking Request";
              $message    = "You have 1 new booking request. To view booking details";
              $action     = "Booking";
              $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();
              $provider      = User::where('id',$booking->provider_id	)->first();
              if(isset($admin) && !empty($admin)){
                  PushNotification::createNotification($admin,$guide->user_id,$title,$message,User::TYPE_BOOKING,$action,$booking->id);
                  $adminMessage    = "1 new booking request by ". Auth::user()->name." for ". $provider->name;
                  PushNotification::createNotification($provider,$admin->id,$title,$adminMessage,User::TYPE_BOOKING,$action,$booking->id);
              }

              $this->status = 200;
              $this->response['success'] = true;
              $this->response['message'] = 'Booking created successfully!';
              $this->response['data']['booking_id'] = $booking->id;
           }
      }else{
          $this->status = 422;
          $this->response['success'] = false;
          $this->response['message'] = 'Some thing went wrong!.';
      }
      return response()->json($this->response, $this->status);
  }
  public function guideProfileBooking($request){
    $this->response['data'] = [];
    $validator = Validator::make($request->all(), [
        'destination' => 'required',

    ]);
    if ($validator->fails()) {
        $this->status = 422;
        $this->response['success'] = false;
        $this->response['message'] = $validator->messages()->first();
        return response()->json($this->response, $this->status);
    }
    $this->response['data'] = [];
    $booking = new Booking;
    $booking_detail = new GuideBookingDetail;
    $invoice = new Invoice;
    if($request->booking_type == 'Hourly'){
        $nights =  $this->caluclateTime(date("Y-m-d", strtotime($request->start_date)),date("Y-m-d", strtotime($request->end_date)));
    }else{

        $nights =  $this->caluclateDaysorNights(date("Y-m-d", strtotime($request->start_date)),date("Y-m-d", strtotime($request->end_date)));
    }
    $serviceProvider = ServiceProviderRate::where('user_id',$request->module_id)->first();

    $priceDetail = $this->servicePrice($serviceProvider,$nights,$request->booking_type);
    $booking->provider_id	       = $request->module_id;
    $booking->module_name	       = $request->module_name;
    $booking->module_id      = $request->module_id;
    $booking->user_id = $request->user()->id;
    $booking->no_of_nights	   = $nights; //in hour case hour save
    if(isset($request->start_date)){
        $booking->start_date	   = date("Y-m-d", strtotime($request->start_date)); //$request->start_date;
        $booking->end_date	   = date("Y-m-d", strtotime($request->end_date)); //$request->end_date;
    }

    if($request->booking_type == 'Hourly'){
        $booking->price	   = $priceDetail['hourly_price'];
    }else{
        $booking->price	   = $priceDetail['per_day_price'];
    }
    $booking->sub_total	   = $priceDetail['sub_total'];
    $booking->discount	   = 0;
    $booking->total	   = $priceDetail['total'];
    $booking->grand_total	   = $priceDetail['grand_total'];

    //later change it place dynamic id of status 0 means pending
    $booking->booking_number	   = rand(100000,999999);
    $booking->status	   = 0;  //its means pending booking
    $booking->payment_status	   = 0;
    $booking->booking_type	   = $request->booking_type;
    $booking->provider_name	   = 'service provider';

    if($booking->save()){
       //invoice detail created...
        $invoice->booking_id = $booking->id;
        $invoice->number = rand(100000,999999);
        $invoice->status = 0; //used for unpaid
        $invoice->save();
        $booking_detail->no_of_traveller	   = $request->no_of_traveller;
        if (isset($request->destination)) {
            $booking_detail->destination	   = $request->destination;
        }


        $booking_detail->module_id	   =         $request->module_id;
        $booking_detail->booking_id	   =         $booking->id;
        $booking_detail->booking_type	   =        $request->booking_type;

        $booking_detail->save();
        $title      = "Booking Request";
        $message    = "You have 1 new booking request. To view booking details";
        $action     = "Booking/".$booking->id;
        $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();
        $provider      = User::where('id',$booking->provider_id	)->first();
        if(isset($admin) && !empty($admin)){
            PushNotification::createNotification($admin,$booking->provider_id,$title,$message,User::TYPE_BOOKING,$action,$booking->id);
            $adminMessage    = "1 new booking request by ". Auth::user()->name." for ". $provider->name;
            PushNotification::createNotification($provider,$admin->id,$title,$adminMessage,User::TYPE_BOOKING,$action,$booking->id);
        }

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Booking created successfully!';
        $this->response['data']['booking_id'] = $booking->id;
        return response()->json($this->response, $this->status);
     }
  }
}
