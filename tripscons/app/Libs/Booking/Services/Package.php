<?php
namespace App\Libs\Booking\Services;

use App\Libs\Booking\Interfaces\Bookable;
use App\Models\Country;
use App\Models\DeviceDetail;
use App\Models\Guide;
use App\Models\Notification;
use App\Models\Reservation;
use App\Models\ServiceProviderRate;
use App\Models\ServiceTax;
use App\Models\TripsProperty;
use App\Notifications\PushNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class Package implements Bookable {

    private $id;
    private $service;
    private $model = Guide::class;
    private $data;
    private $cart;
    private $subtotal;
    private $discounttotal;
    private $grandtotal;
    private $type = "Package Booking";
    private $currency = null;

    private function convertedAmount($amount)
    {
        return round($amount * $this->currency->exchange_rate);
    }

    public function __construct($id, $data = [], $currency = 'PKR')
    {
        $this->id = $id;
        $this->service = $this->getService($id);
        $this->data = $data;
        $this->currency = Country::where('currency', $currency)->first();
        $this->setCart();
    }

    public function getService($id)
    {
        $service = $this->model::find($id);
        //Validate service id
        if(!$service) throw new Exception("INVALID SERVICE IDENTIFER $id");

        return $service
        ->loadAvg('rating_values','rating_value_1')
        ->loadAvg('rating_values','rating_value_2')
        ->loadAvg('rating_values','rating_value_3')
        ->loadAvg('rating_values','rating_value_4')
        ->loadAvg('rating_values','rating_value_5')
        ->loadAvg('rating_values','average_rating')
        ->loadSum('rating_values','rating_value_1')
        ->loadSum('rating_values','rating_value_2')
        ->loadSum('rating_values','rating_value_3')
        ->loadSum('rating_values','rating_value_4')
        ->loadSum('rating_values','rating_value_5')
        ->loadSum('rating_values','average_rating');
    }

    public function book()
    {
        if(request()->user()->id == $this->service->user_id) throw new Exception("You can not book your own service");
        $fromDate = $this->service->is_day_wise_trip ? $this->data['start_date'] : $this->service->start_date;
        $toDate = $this->service->is_day_wise_trip ? $this->data['end_date'] ?? $this->data['start_date'] : $this->service->end_date;
        if($this->service->is_day_wise_trip === null){
            $fromDate = $this->data['start_date'] ?? $this->service->start_date;
            $toDate = $this->data['end_date'] ?? $this->data['start_date'];
        }

        if($this->service->is_day_wise_trip == 1){

            $fromDate = $this->data['start_date'];
            if(intval($this->service->number_of_days) > 1){
                $toDate = Carbon::create($this->data['start_date'])->addDays(intval($this->service->number_of_days) -1);
            }else{
                $toDate = $this->data['start_date'];
            }

        }

        if(($this->service->user_module_type == 'photographers') && intval($this->service->duration) > 1){
            $toDate = Carbon::create($this->data['start_date'])->addDays($this->service->duration -1);
        }
        if(($this->service->user_module_type == 'movie_makers') && intval($this->service->no_of_days) > 1){
            $toDate = Carbon::create($this->data['start_date'])->addDays(intval($this->service->no_of_days) -1);
        }


        $reservation = Reservation::forceCreate([
            'reference_no' => uniqid(),
            'bookable' => $this->model,
            'bookable_id' => $this->id,
            'room_id' => null,
            'provider_user_id' => $this->service->user_id,
            'user_id' => Auth::id(),
            'date_from' => $fromDate,
            'date_to' => $toDate,
            'booking_detail' => $this->results(),
            'subtotal' => $this->subtotal,
            'discounttotal' => $this->discounttotal,
            'grandtotal' => $this->grandtotal,
            'remaining_amount' => $this->grandtotal,
            'minimum_payable_amount' => $this->minimum_payable_amount,
            'status' => '0',
            'reservation_type' => $this->type,
        ]);
//        $this->sendNotification();
//
//        $title      = "Package Booking";
//        $message    = "Package Booking request successfully";
//        $action     = "api/Package";
//
//        PushNotification::createNotification(Auth::user(),$this->service->user_id,$title,$message,\App\Models\User::TYPE_BOOKING,$action);


// Notification Push to Vendor Accomodation Booking request
        $title      = "Booking Request";
        $message    = "You have 1 new booking request. To view booking details";
        $action     = "/service/bookings";
        # $action = "/bookings/summary/".$reservation->id;
        $vendor = \App\Models\User::where('id',$this->service->user_id)->first();
         if(isset($vendor) && !empty($vendor)){
            PushNotification::createNotification($vendor,Auth::user()->id,$title,$message,\App\Models\User::TYPE_BOOKING,$action,$reservation->id);
        }


// Notification Push to Admin Accomodation Booking request
        $admin = \App\Models\User::where('role_id',\App\Models\User::ADMIN_ID)->first();
        $adminMessage    = "1 new booking request by ". Auth::user()->name." for ". $vendor->name;
        if(isset($admin) && !empty($admin)){
            PushNotification::createNotification($admin,Auth::user()->id,$title,$adminMessage,\App\Models\User::TYPE_BOOKING,$action,$reservation->id);
        }


        return $reservation;
    }

    public function results() : array
    {
        $this->cart['currency'] = $this->currency->currency;
        return [
            'id' => $this->id,
            'reservation_class' => self::class,
            'availibility' => $this->getAvailability(),
            'data' => $this->data,
            'cart' => $this->cart,
            'service' => $this->service
        ];
    }

    public function getCart() : array
    {
        return $this->cart;
    }

    public function setCart()
    {
        if($this->service->user_module_type == 'photographers' && intval($this->service->duration) > 1){
            $this->cart['nights'] = intval($this->service->duration);
        }


        if(($this->service->user_module_type == 'movie_makers') && intval($this->service->no_of_days) > 1){
            $this->cart['nights'] = intval($this->service->no_of_days);
        }
        $price = round((is_numeric($this->data['price']) ? $this->data['price'] : null) ?? $this->service->price);
        $this->cart['persons'] = $this->data['adults'] + $this->data['children'];
        $this->cart['rent'] = round($this->convertedAmount($price));
        $this->cart['items'] = [];
        $this->cart['subtotal'] = 0;
        $this->cart['discounttotal'] = 0;
        $this->cart['grandtotal'] = 0;
        $this->cart['discounts'] = [];
        $personText = $this->service->user_module_type == "photographers" || $this->service->user_module_type == "movie_makers" ? " " : " x " .  $this->cart['persons'] . " Persons";
        $this->cart['items'][] = [
            "label" => "Profile Booking",
            "desc" => "Booking " . $this->currency->currency . " " . round($this->convertedAmount($price)) . $personText,
            "price" => round($this->convertedAmount($price * $this->cart['persons']))
        ];

        foreach($this->cart['items'] as $item){
            if(is_numeric($item['price'])){
                $this->cart['subtotal'] += round($item['price']);
            }
        }



        if($this->service->user_module_type == 'guides' || $this->service->user_module_type == 'trip_operators' || $this->service->user_module_type == 'travel_agency'){
            $discounts = TripsProperty::where('package_id', $this->service->id)->first();
            if($discounts) {

                if(intval(intval($discounts->group_discount) != 0) && $this->cart['persons'] >= $discounts->group_discount_members && !empty($discounts->group_discount_members)){
                    $this->cart['discounts'][] =[
                        "label" => "Group Discount",
                        "desc" => "Group Discount " . $discounts->group_discount . "%",
                        "price" => $this->convertedAmount(((($price * $this->cart['persons']) / 100) * $discounts->group_discount))
                    ];

                    $this->cart['discounttotal'] += round((($price * $this->cart['persons']) / 100) * $discounts->group_discount);
                }
                else {
                    if(intval($this->data['children']) != 0 && intval($discounts->child_discount) != 0){
                        $this->cart['discounts'][] =[
                            "label" => "Child Discount",
                            "desc" => "Child Discount " . $discounts->child_discount . "%",
                            "price" => round((($this->cart['rent'] / 100) * $discounts->child_discount))
                        ];

                        $this->cart['discounttotal'] += round(($this->cart['rent'] / 100) * $discounts->child_discount);
                    }

                }
                // dd($this->cart['discounttotal']);
            }
        }

        if(intval($this->data['children']) != 0 && ($this->service->child_discount ?? 0) > 0 && $this->service->user_module_type == 'visa_consultants'){
            $this->cart['discounts'][] =[
                "label" => "Child Discount",
                "desc" => "Child Discount " . $this->service->child_discount . "%",
                "price" => round(($this->convertedAmount($price) / 100) * $this->service->child_discount)
            ];

            $this->cart['discounttotal'] += round(($this->convertedAmount($price) / 100) * $this->service->child_discount);
        }

        if($this->service->is_offer_promotion_discount && $this->service->promotion_discount){
            $this->cart['discounts'][] =[
                "label" => "Promotional Discount",
                "desc" => "Promotional Discount " . $this->service->promotion_discount . "%",
                "price" => round((($price / 100) * $this->service->promotion_discount) * $this->cart['persons'])
            ];
            $this->cart['discounttotal'] += round((($price / 100) * $this->service->promotion_discount) * $this->cart['persons']);
        }

        // $taxPercentage = ServiceTax::find($this->service->tax_id);

        // if($taxPercentage){
        //     $taxPercentage = $taxPercentage->tax;
        // }
        // else {
        //     $taxPercentage = 16;
        // }

        // $tax = round(($this->cart['subtotal'] - $this->cart['discounttotal']) /100 * $taxPercentage);
        $tax = 0;

        // $this->cart['taxes'][] =[
        //     "label" => "Tax",
        //     "desc" => "GST @ $taxPercentage%",
        //     "price" => round($tax)
        // ];

        $this->cart['grandtotal'] = round($this->cart['subtotal'] - $this->cart['discounttotal'] + $tax);
        $this->cart['subtotal'] = round($this->cart['subtotal']);
        $this->cart['discounttotal'] = round($this->cart['discounttotal']);
        $this->subtotal = $this->cart['subtotal'];
        $this->discounttotal = $this->cart['discounttotal'];
        $this->grandtotal = $this->cart['grandtotal'];
        if($this->service->payment_partial_value > 0){
            if($this->service->payment_partial_value == 'undefined' || $this->service->payment_mode == 0){
                $this->minimum_payable_amount = $this->grandtotal;
            } else if($this->service->payment_mode == 1) {
                $this->minimum_payable_amount = round(($this->grandtotal / 100) * $this->service->payment_partial_value);
            }
        } else {
            $this->minimum_payable_amount = round($this->grandtotal);
        }

    }

    public function getAvailability() : bool
    {
        return true;
    }
    public function sendNotification()
    {
        try {
            $device_token = [];
            $user = Auth::user();
            $receiver_id = $this->service->user_id;
            $deviceTokens = DeviceDetail::select('device_token')->where('user_id', $receiver_id)->get();
            if ($deviceTokens) {
                foreach ($deviceTokens as $key => $deviceToken) {
                    $device_token[$key] = $deviceToken->device_token;
                }
            }
            $notification = new Notification();
            $notification->user_id=$receiver_id;
            $notification->sender_id=$user->id;
            $notification->receiver_id=$receiver_id;
            $notification->message=$this->model::TITLE;
            $notification->body=$this->model::MESSAGE;
            $notification->type=$this->model::TYPE;
            $notification->actions= $this->model::ACTION;
            $notification->seen=0;
            $notification->status=$this->model::STATUS;
            $notification->active=1;
            $notification->save();
            $badge = PushNotification::deviceBadgesUpdate($receiver_id,$this->model::TYPE);
            PushNotification::sendNotification([
                'message' => $this->model::MESSAGE,
                'title' => $this->model::TITLE,
                'device_tokens'=> $device_token,
                'user' => $user,
                'payload' => [
                    'id'=>  $this->id,
                    'type' => 'BOOKING_REQUEST',
                    'sender_id' => $user->id,
                    'badge' => $badge,

                ]
            ]);
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Notification send successfully.';
            return response()->json($this->response, $this->status);
        }
        catch (\Exception $e)
        {
            $this->status = 401;
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }
}

