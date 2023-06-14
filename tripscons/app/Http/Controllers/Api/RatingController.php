<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\RatingValues;
use Illuminate\Support\Facades\Validator;
use App\Models\VendorRating;
use Illuminate\Support\Facades\Config;
use App\Models\Reservation;
use Carbon\Carbon;
use App\Models\Guide;


class RatingController extends Controller
{
    protected $status = 200;
    protected $response = [];

    public function addRating(){

        $validator = Validator::make(request()->all(), [
            'comments' => 'required',
            'user_id' => 'required|numeric',
            'provider_id' => 'required|numeric',
            'booking_id' => 'required|numeric',
            'module_name' => 'required',
            'rating_type' => 'required',

        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $data['rating_value_1'] = request()->rating_value_1;
        $data['rating_value_2'] = request()->rating_value_2;
        $data['rating_value_3'] = request()->rating_value_3;
        $data['rating_value_4'] = request()->rating_value_4;
        $data['rating_value_5'] = request()->rating_value_5;
        $data['comments'] = request()->comments;
        $data['user_id'] = request()->user_id;
        $data['package_id'] = request()->package_id;
        $data['provider_id'] = request()->provider_id;
        $data['booking_id'] = request()->booking_id;
        $data['type'] = request()->type;

        if(isset(request()->rating_type) && !empty(request()->rating_type)){
            if(request()->rating_type == 'Package Booking'){
                if(isset(request()->module_name) && !empty(request()->module_name)){
                    request()->module_name = request()->module_name;
                }else{
                    $guide = Guide::find(request()->package_id);
                    if(!empty($guide)){
                        request()->module_name = $guide->user_module_type;
                    }
                }
            }   
        }

        $data['module_name'] = request()->module_name;
        $data['rating_type'] = request()->rating_type;

        if(isset(request()->booking_id)){
            $reservation = Reservation::find(request()->booking_id);
            if(isset($reservation) && !empty($reservation)){
                $data['date_to'] = $reservation->date_to;
            }
        }

        $data['status'] = (isset(request()->statu) && !empty(request()->status)) ? request()->status : 0;
        $data_list = [];
        $data_list['rating_value_1'] = request()->rating_value_1 ? request()->rating_value_1 : 0;
        $data_list['rating_value_2'] = request()->rating_value_2 ? request()->rating_value_2 : 0;
        $data_list['rating_value_3'] = request()->rating_value_3 ? request()->rating_value_3 : 0;
        $data_list['rating_value_4'] = request()->rating_value_4 ? request()->rating_value_4 : 0;
        $data_list['rating_value_5'] = request()->rating_value_5 ? request()->rating_value_5 : 0;

        $average_rating = array_sum($data_list) / count($data_list);

        $data['average_rating'] = $average_rating;

        // return $data;

        $ratingValues =  RatingValues::updateOrCreate([
            'user_id' => request()->user_id,
            'package_id' => request()->package_id,
            'provider_id' => request()->provider_id,
            'booking_id' => request()->booking_id,
            'type' => request()->type
        ], $data);

        // Rating::updateOrCreate([
        //                         'user_id' => request()->user_id,
        //                         'package_id' => request()->package_id,
        //                         'provider_id' => request()->provider_id,
        //                         'booking_id' => request()->booking_id,
        //                         'type' => request()->type
        //                     ], $data);
        $title = "Rating review";
        $message = "what's your opinion about your booking? please review it";
        $action = "service/booking";
        $user = User::where('id',$data['provider_id'])->first();
        if(isset($user) && !empty($user) && isset($ratingValues)){
            PushNotification::createNotification($user,auth()->user()->id,$title,$message,User::TYPE_RATING_REVIEW,$action,$ratingValues->id);
        }

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        $this->response['message'] = 'Thanks for your feedback';
        return response()->json($this->response, $this->status);

    }

    public function addVendorRating(){

        $validator = Validator::make(request()->all(), [
            'comments' => 'required',
            'user_id' => 'required|numeric',
            'provider_id' => 'required|numeric',
            'booking_id' => 'required|numeric',
            'module_name' => 'required',
            'rating_type' => 'required',

        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $data['rating_value'] = request()->rating_value;
        $data['comments'] = request()->comments;
        $data['user_id'] = request()->user_id;
        $data['package_id'] = request()->package_id;
        $data['provider_id'] = request()->provider_id;
        $data['booking_id'] = request()->booking_id;
        $data['type'] = request()->type;
        $data['module_name'] = request()->module_name;
        $data['rating_type'] = request()->rating_type;
        $data['status'] = (isset(request()->status) && !empty(request()->status)) ? request()->status : 0;
        $data['vendor_id'] = auth()->user()->id;
        $data['package_name'] = request()->package_name ? request()->package_name : '';
        $data['rated_by_name'] = auth()->user()->name;
        if(isset(request()->booking_id)){
            $reservation = Reservation::find(request()->booking_id);
            if(isset($reservation) && !empty($reservation)){
                $data['date_to'] = $reservation->date_to;
            }
        }


        $vendorRating =VendorRating::updateOrCreate([
            'user_id' => request()->user_id,
            'package_id' => request()->package_id,
            'provider_id' => request()->provider_id,
            'booking_id' => request()->booking_id,
            'type' => request()->type,
            'vendor_id' => auth()->user()->id
        ], $data);
        $title = "Rating & Review";
        $message = "what's your opinion about your booking? Please review it";
        $action = "service/booking";
        $user = User::where('id',request()->user_id)->first();
        if(isset($user) && !empty($user) && isset($vendorRating) && !empty($vendorRating)){
            PushNotification::createNotification($user,auth()->user()->id,$title,$message,User::TYPE_VENDOR_RATING_REVIEW,$action,$vendorRating->id);
        }

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        $this->response['message'] = 'Thanks for your feedback';
        return response()->json($this->response, $this->status);

    }

    public function getReviews(){

        $validator = Validator::make(request()->all(), [
            'user_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }
        // dd(request()->user_id);;
        // if(isset(request()->user_id) && request()->user_id == 0){
        //     request()->user_id = (auth()->user()) ? auth()->user()->id : 0;
        // }

        $from = date_create(date('Y-m-d'));
        $date_plug_14 = date_create(date('Y-m-d', strtotime('-14 days')))->format('Y-m-d');
        //   dd($date_plug_14);
        // $diff = date_diff($date_plug_14,$from);
        // $no_of_days = $diff->format('%a');

        // dd($date_plug_14);

        $ratings = VendorRating::with('rating_values')->where('user_id', request()->user_id)
            ->where(function($q) use ($date_plug_14){
                $q->whereHas('rating_values');
                $q->orWhereDate('date_to', '<=', Carbon::create($date_plug_14));

            })
            ->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $ratings;
        $this->response['message'] = '';
        return response()->json($this->response, $this->status);
    }

    public function getHostRating(){

        $from = date_create(date('Y-m-d'));
        $date_plug_14 = date_create(date('Y-m-d', strtotime('-14 days')))->format('Y-m-d');

        $ratings = RatingValues::with('vendor_ratings')->where('provider_id', auth()->user()->id)
            ->where(function($q) use ($date_plug_14){
                $q->whereHas('vendor_ratings');
                $q->orWhereDate('date_to', '<=', Carbon::create($date_plug_14));

            })
            ->orderBy('id', 'DESC')->paginate(Config::get('global.pagination_records'));

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $ratings;
        $this->response['message'] = '';
        return response()->json($this->response, $this->status);

    }

}
