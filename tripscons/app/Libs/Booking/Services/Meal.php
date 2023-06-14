<?php
namespace App\Libs\Booking\Services;

use App\Libs\Booking\Interfaces\Bookable;
use App\Models\Country;
use App\Models\DeviceDetail;
use App\Models\Meal as ModelsMeal;
use App\Models\Notification;
use App\Models\Reservation;
use App\Models\ServiceTax;
use App\Notifications\PushNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class Meal implements Bookable {

    private $id;
    private $service;
    private $model = ModelsMeal::class;
    private $data;
    private $cart;
    private $subtotal;
    private $discounttotal;
    private $grandtotal;
    private $type = "Meal Booking";
    private $currency = null;

    private function convertedAmount($amount)
    {
        return round($amount * $this->currency->exchange_rate, 2);
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
        if($this->data['instant'] ?? false){
            $dateFrom = \Carbon\Carbon::now()->addMinutes(intval($this->service->food_preparation) ?? 30);
            $dateTo = \Carbon\Carbon::now()->addMinutes(intval($this->service->food_preparation) ?? 30);
        }
        else {
            $dateFrom = $this->data['start_date'];
            $dateTo = $this->data['start_date'];
        }

        $reservation = Reservation::forceCreate([
            'reference_no' => uniqid(),
            'bookable' => $this->model,
            'bookable_id' => $this->id,
            'room_id' => null,
            'provider_user_id' => $this->service->user_id,
            'user_id' => Auth::id(),
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'booking_detail' => $this->results(),
            'subtotal' => $this->subtotal,
            'discounttotal' => $this->discounttotal,
            'grandtotal' => $this->grandtotal,
            'remaining_amount' => $this->grandtotal,
            'minimum_payable_amount' => $this->minimum_payable_amount,
            'status' => '0',
            'reservation_type' => $this->type
        ]);
//        $this->sendNotification();

//        $title      = "Booking Request";
//        $message    = "You have 1 new booking request. To view booking details";
//        $action     = "api/meal";
//
//        PushNotification::createNotification(Auth::user(),$this->service->user_id,$title,$message,\App\Models\User::TYPE_BOOKING,$action);

// Notification Push to Vendor Accomodation Booking request
        $title      = "Booking Request";
        $message    = "You have 1 new booking request. To view booking details";
        $action     = "/host/bookings";
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
        $isInstant = $this->data['instant'] ?? false;
        // $this->cart['nights'] = Carbon::create($this->data['start_date'])->diffInDays($this->data['end_date']);
        $price = ((is_numeric($this->data['price']) ? $this->data['price'] : null) ?? $this->service->price);
        $this->cart['price'] = $this->convertedAmount($price);
        $this->cart['items'] = [];
        $this->cart['quantity'] = $this->data['quantity'];
        $this->cart['subtotal'] = 0;
        $this->cart['discounttotal'] = 0;
        $this->cart['grandtotal'] = 0;
        $this->cart['discounts'] = [];

        $this->cart['items'][] = [
            "label" => "Meal",
            "desc" => $this->service->title . " " . $this->convertedAmount($price) . " x " . $this->cart['quantity'],
            "price" => $this->convertedAmount($price * $this->cart['quantity'])
        ];

        if($this->service->is_offer_promotion_discount && $this->service->promotion_discount){
            $this->cart['discounts'][] =[
                "label" => "Promotional Discount",
                "desc" => "Promotional Discount",
                "price" => round((($price / 100) * $this->service->promotion_discount) * $this->cart['quantity'], 2)
            ];
            $this->cart['discounttotal'] += round((($price / 100) * $this->service->promotion_discount) * $this->cart['quantity'], 2);
        }

        foreach($this->cart['items'] as $item){
            if(is_numeric($item['price'])){
                $this->cart['subtotal'] += $item['price'];
            }
        }

        // $taxPercentage = ServiceTax::find($this->service->tax_id);

        // if($taxPercentage){
        //     $taxPercentage = $taxPercentage->tax;
        // }
        // else {
        //     $taxPercentage = 16;
        // }

        // $tax = round($this->cart['subtotal'] - $this->cart['discounttotal'], 2) /100 * $taxPercentage;
        $tax = 0;

        // $this->cart['taxes'][] =[
        //     "label" => "Tax",
        //     "desc" => "GST @ $taxPercentage%",
        //     "price" => round($tax, 2)
        // ];

        $this->cart['grandtotal'] = round($this->cart['subtotal'] - $this->cart['discounttotal'] + $tax, 2);

        $this->cart['subtotal'] = round($this->cart['subtotal'], 2);
        $this->cart['discounttotal'] = round($this->cart['discounttotal'], 2);
        $this->cart['grandtotal'] = round($this->cart['grandtotal'], 2);

        $this->subtotal = $this->cart['subtotal'];
        $this->discounttotal = $this->cart['discounttotal'];
        $this->grandtotal = $this->cart['grandtotal'];
        if($this->service->payment_partial_value > 0 && $this->service->payment_mode == 0){
            $this->minimum_payable_amount = ($this->grandtotal / 100) * $this->service->payment_partial_value;
        } else {
            $this->minimum_payable_amount = $this->grandtotal;
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
