<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notifications\PushNotification;
use App\Traits\HostServiceBookingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\Models\Experience;
use App\Models\User;
use App\Models\Rule;
use App\Models\Slot;
use App\Models\Booking;
use App\Models\Invoice;
use App\Traits\RadiusDistanceTrait;
use App\Models\Accommodation;
use App\Models\Meal;
use App\Models\Transport;



use App\Models\ExperienceBookingDetail;
use DateTime;


class ExperienceController extends Controller
{
    protected $status = 200;
    protected $response = [];
    use HostServiceBookingTrait;
    use RadiusDistanceTrait;

    public function index(Request $request)
    {

        if (count($request->all()) > 0) {
            $proRating =   $request->rating;
            $min =  $request->minValue;
            $max =  $request->maxValue;

            $searchTerm = $request->searchTerm;
            $user_id = isset($request->user_id) ? $request->user_id : '';
            $category = isset($request->category) ? $request->category : '';
            $gender = isset($request->gender) ? $request->gender : '';
            $duration = isset($request->duration) ? $request->duration : '';
            $reviewRating = isset($request->reviewRating) ? $request->reviewRating : false;
            $is_free_cancellation = isset($request->is_free_cancellation) ? $request->is_free_cancellation : '';
            $is_free_cancellation_value = isset($request->is_free_cancellation_value) ? $request->is_free_cancellation_value : '';
            $payment_mode = isset($request->payment_mode) ? $request->payment_mode : '';
            $payment_mode_value = isset($request->payment_mode_value) ? $request->payment_mode_value : '';
            //$selectedFacilities = isset($request->selectedFacilities) ? $request->selectedFacilities : '';
            if(isset($request->selectedFacilities)){
                $selectedFacilitiesExplode =  explode(",", $request->selectedFacilities);
            }else{
                $selectedFacilitiesExplode = '';
            }
            
            $city = $request->city; 
            $distance_result = '';
            

                $lat = isset($request->lat) ? round($request->lat, 8) : 0;
                $lng = isset($request->lng) ? round($request->lng, 8) : 0;
                $distance_result = "(6371 * acos(cos(radians($lat))
                        * cos(radians(lat))
                        * cos(radians(lng)
                        - radians($lng))
                        + sin(radians($lat))
                        * sin(radians(lat))))";

               $data = Experience::with('images')
               ->withAvg('ratings', 'average_rating')->where('is_publish',1)->where('status',1)->withAvg('rating_values','average_rating')->where(function ($query) use ($reviewRating, $min, $max, $category, $duration,$gender, $searchTerm, $distance_result,$payment_mode,$payment_mode_value,$is_free_cancellation,$is_free_cancellation_value,$user_id,$selectedFacilitiesExplode) {
                if($user_id){
                    $query->Where('user_id', $user_id);
                }
                if ($min > 0) {
                    $query->Where('price','>=', $min);
                }

                if ($max > 0) {
                    $query->Where('price','<=', $max);
                }
               
                if (!empty($gender)) {
                    $query->whereRelation('user','gender',$gender);
                }
                if (!empty($duration)) {
                    $query->Where('duration', $duration);
                }
                if (!empty($category)) {
                    $query->Where('category', $category);
                }
                if ($payment_mode == 1 && $payment_mode_value >= 25 ) {

                    $query->Where('payment_mode', $payment_mode);
                    $query->Where('payment_partial_value', $payment_mode_value);
                }
                if ($payment_mode === '0') {

                 $query->Where('payment_mode', $payment_mode);
                }

                if (!empty($searchTerm)) {

                    $query->orWhere('title', 'LIKE', "%{$searchTerm}%")->orWhere('about', 'LIKE', "%{$searchTerm}%");
                }
               
                if (!empty($selectedFacilitiesExplode)) {
                    $query->whereIn('type', $selectedFacilitiesExplode);
                }

            })

            ->when($lat && $lng, function ($q) use ($distance_result) {
                $q->addSelect(\DB::raw($distance_result . " as distance"));
                $q->orderBy(\DB::raw($distance_result));
            })
            ->when(!$lat || !$lng, function ($q)  use ($distance_result) {
                $q->addSelect(\DB::raw("0 as distance"));
            })->when($reviewRating, function ($rating){
                $rating->having('rating_values_avg_average_rating', 5);

            })->when($is_free_cancellation, function ($p) use ($is_free_cancellation_value){

                $p->whereHas('policies',function ($q) use ($is_free_cancellation_value){
                   $q->where('cancellation_hour', $is_free_cancellation_value)->where('refund_percentage',100);
                  });

               })->where('lat', '!=', NULL)
               ->where('lng', '!=', NULL)
            ->orderBy('distance')
            ->paginate(Config::get('global.pagination_records'));
        } else {

            $data = Experience::with('images')->withAvg('ratings', 'average_rating')->withAvg('rating_values','average_rating')->where('is_publish',1)->where('status',1)->whereHas('slots')->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));
        }
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        $this->response['message'] = 'List Fetch Successfully';
        return response()->json($this->response, $this->status);
    }

    public function detail($Id)
    {

        if(!empty($Id)){
            addCounter('experiences', $Id);
        }
        
        $detail =  Experience::with('images')
            ->withAvg('ratings', 'location_rating')
            ->withAvg('ratings', 'cleanliness_rating')
            ->withAvg('ratings', 'comfort_rating')
            ->withAvg('ratings', 'quality_rating')
            ->withAvg('ratings', 'average_rating')
            ->withSum('ratings', 'location_rating')
            ->withSum('ratings', 'cleanliness_rating')
            ->withSum('ratings', 'comfort_rating')
            ->withSum('ratings', 'quality_rating')

            ->withAvg('rating_values','rating_value_1')
            ->withAvg('rating_values','rating_value_2')
            ->withAvg('rating_values','rating_value_3')
            ->withAvg('rating_values','rating_value_4')
            ->withAvg('rating_values','rating_value_5')
            ->withAvg('rating_values','average_rating')
            ->withSum('rating_values','rating_value_1')
            ->withSum('rating_values','rating_value_2')
            ->withSum('rating_values','rating_value_3')
            ->withSum('rating_values','rating_value_4')
            ->withSum('rating_values','rating_value_5')
            ->withSum('rating_values','average_rating')

            ->with(['two_images','mainImage','exp_videos'])->where('id', $Id)->first();

        if (!$detail) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'invalid Id';
            return response()->json($this->response, $this->status);
        }
        $accommodationCount =   Accommodation::where('user_id', $detail->user_id)->where('is_publish', 1)->where('status',1)->count();
        if (empty($accommodationCount)) {
            $accommodationCount = 0;
        }
        $mealCount =        Meal::where('user_id', $detail->user_id)->where('is_publish', 1)->where('status',1)->count();
        if (empty($mealCount)) {
            $mealCount = 0;
        }
        $activityCount =    Experience::where('user_id', $detail->user_id)->where('is_publish', 1)->where('status',1)->count();
        if (empty($activityCount)) {
            $activityCount = 0;
        }

        $transCount =         Transport::where('user_id', $detail->user_id)->where('is_publish', 1)->where('status',1)->count();
        if (empty($transCount)) {
            $transCount = 0;
        }
        $detail->mealCount = $mealCount;
        $detail->transportCount = $transCount;
        $detail->accommodationCount = $accommodationCount;
        $detail->activityCount = $activityCount;
        $detail->rules = Rule::where('module_name', 'experiences')->where('module_id', $Id)->orderBy('id', 'DESC')->get();

        $detail->slots = Slot::where('experience_id', $Id)->get();

        $detail->user = User::where('id', $detail->user_id)->first();

        $percentage_50  = percentage($detail->price, 50);
        $percentage_50_plus = $detail->price + $percentage_50;
        $percentage_50_minus = $detail->price - $percentage_50;

        $detail->relatedData =  Experience::with(['singleImage', 'slots'])
            ->withAvg('ratings', 'average_rating')
            ->withAvg('rating_values','average_rating')
            ->where('type', $detail->type)
            ->where('id', '<>', $detail->id)
            // ->whereBetween('price', [$percentage_50_minus, $percentage_50_plus])
            // ->when(isset($detail), function($query) use ($detail){
            //     $query->where('detail_location','like', '%'.$detail->detail_location.'%');
            // })
            // ->when(isset($detail), function($query) use ($detail){
            //     $query->where('user_id', $detail->user_id);
            // })
            ->orderBy('id', 'DESC')
            ->get();


        $detail->relatedData = $detail->relatedData->take(4);
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Detail fetch successfully';
        $this->response['data'] = $detail;
        return response()->json($this->response, $this->status);
    }

    public function checkAvailability(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'module_id' => 'required',
            'module_name' => 'required',
            'no_of_childs' => 'required',
            'no_of_adults' => 'required',
            'slot_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }
        $no_of_guest = $request->no_of_childs + $request->no_of_adults;
        $experience = Experience::where('id', $request->module_id)->first();
        if (!$experience) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid experience id';
            $this->response['data']['availability'] = false;
            return response()->json($this->response, $this->status);
        } else {
            $experienceSlot = Slot::where('id', $request->slot_id)->first();
            if (!$experienceSlot) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = 'Invalid experience slot id';
                $this->response['data']['availability'] = false;
                return response()->json($this->response, $this->status);
            }

            $dt = new DateTime();
            $remainingSeats = 0;

            if (!empty($experienceSlot)) {
                $remainingSeats = $experienceSlot->class_size - $experienceSlot->booked_counter;
            }
            if ($no_of_guest > $remainingSeats) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = 'Seats are not enough,In this activity only ' . $remainingSeats . ' seats are remaining so you cannot book more than that, you can see other activities';

                $this->response['data']['availability'] = false;
                return response()->json($this->response, $this->status);
            }
            $slot = Slot::where('booked_counter', '>=', $experienceSlot->class_size)->Where('date', '<=', $dt->format('Y-m-d'))->where('experience_id',$request->module_id)->first();
            if ($slot) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = 'Booking complete no more space';
                $this->response['data']['availability'] = false;
                return response()->json($this->response, $this->status);
            }

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $this->slotPriceCalculate($experienceSlot, $no_of_guest);
            $this->response['data']['availability'] = true;
        }
        return response()->json($this->response, $this->status);
    }

    public function createBooking(Request $request)
    {
        if (count($request->all()) > 0) {
            $booking = new Booking;
            $booking_detail = new ExperienceBookingDetail;
            $invoice = new Invoice;
            $validator = Validator::make($request->all(), [
                'module_id' => 'required',
                'module_name' => 'required',
                'no_of_adults' => 'required',
                'no_of_childs' => 'required',
                'slot_id' => 'required',
            ]);

            if ($validator->fails()) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = $validator->messages()->first();
                return response()->json($this->response, $this->status);
            }
            $no_of_guest = $request->no_of_childs + $request->no_of_adults;
            $response = $this->checkAvailability($request);
            if ($response->original['data']['availability'] == false) {
                return $this->checkAvailability($request);
            }
            $this->response['data'] = [];
            $experienceSlot = Slot::where('id', $request->slot_id)->first();
            $experience = Experience::where('id', $request->module_id)->first();
            $priceDetail = $this->slotPriceCalculate($experienceSlot, $no_of_guest);
            $booking->provider_id           = $experience->user_id;
            $booking->module_name           = $request->module_name;
            $booking->module_id      = $request->module_id;
            $booking->user_id = $request->user()->id;
            $booking->no_of_nights       = $request->no_of_guest;      //nights is also equl to qty
            $dt = new DateTime();
            $booking->start_date       =   $dt;
            $booking->end_date       =     $dt;

            $booking->price       = $priceDetail['per_head'];
            $booking->sub_total       = $priceDetail['sub_total'];
            $booking->discount       = $priceDetail['discount'];
            $booking->total       = $priceDetail['total'];
            $booking->grand_total       = $priceDetail['grand_total'];
            $booking->booking_type       = 'Per day';
            $booking->provider_name       = 'host';
            $booking->booking_number       = rand(100000, 999999);
            $booking->status       = 0;  //its means pending booking
            $booking->payment_status       = 0;  //later change it place dynamic id of status 0 means pending
            if ($booking->save()) {
                $booking_detail->no_of_adults       = $request->no_of_adults;

                $booking_detail->module_id       =         $request->module_id;
                $booking_detail->booking_id       =         $booking->id;
                $booking_detail->slot_id        =         $request->slot_id;
                $booking_detail->no_of_childs       =         $request->no_of_childs;
                $booking_detail->save();
                //slot update...
                $experienceSlot->booked_counter = $experienceSlot->booked_counter +  $no_of_guest;
                $experienceSlot->save();
                //invoice detail created...
                $invoice->booking_id = $booking->id;
                $invoice->number = rand(100000, 999999);
                $invoice->status = 0; //used for unpaid
                $invoice->save();

//                $title      = "Activity Booked";
//                $message    = "Activity booked successfully";
//                $action     = "api/updateMedia";
//
//                PushNotification::createNotification(auth()->user(),$booking->provider_id,$title,$message,User::TYPE_BOOKING,$action);
//

// Notification Push to Vendor vehicle Booking request
                $title      = "Booking Request";
                $message    = "You have 1 new booking request. To view booking details";
                $action     = "user/setting";
                $vendor = User::where('id',$booking->provider_id)->first();
                if(isset($vendor) && !empty($vendor)){
                    PushNotification::createNotification($vendor,$booking->user_id,$title,$message,User::TYPE_BOOKING,$action,$booking->id);
                }


// Notification Push to Admin vehicle Booking request
                $admin = User::where('id',User::ADMIN_ID)->first();
                $adminMessage    = "1 new booking request by ". $request->user()->name." for ". $vendor->name;
                if(isset($admin) && !empty($admin)){
                    PushNotification::createNotification($admin,$booking->user_id,$title,$adminMessage,User::TYPE_BOOKING,$action,$booking->id);
                }


                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'Activity booked successfully!';
                $this->response['data']['booking_id'] = $booking->id;
            }
        } else {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Some thing went wrong!.';
        }
        return response()->json($this->response, $this->status);
    }
}
