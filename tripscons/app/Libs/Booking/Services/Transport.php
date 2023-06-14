<?php
namespace App\Libs\Booking\Services;

use App\Libs\Booking\Interfaces\Bookable;
use App\Models\Country;
use App\Models\DeviceDetail;
use App\Models\Notification;
use App\Models\Reservation;
use App\Models\ServiceTax;
use App\Models\Transport as ModelsTransport;
use App\Notifications\PushNotification;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Auth;

class Transport implements Bookable {

    private $id;
    private $service;
    private $model = ModelsTransport::class;
    private $data;
    private $cart;
    private $subtotal;
    private $discounttotal;
    private $grandtotal;
    private $type = "Transport/Vehicle Booking";
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

        $d = DateTime::createFromFormat('Y-m-d', $this->data['end_date']);
        if($d && $d->format('Y-m-d') === $this->data['end_date']){
            $this->data['end_date'] = $this->data['end_date'];
        }
        else {
            $this->data['end_date'] = $this->data['start_date'];
        }


        $reservation = Reservation::forceCreate([
            'reference_no' => uniqid(),
            'bookable' => $this->model,
            'bookable_id' => $this->id,
            'room_id' => null,
            'provider_user_id' => $this->service->user_id,
            'user_id' => Auth::id(),
            'date_from' => $this->data['start_date'],
            'date_to' => $this->data['end_date'],
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
//        $title      = "Transport Booking";
//        $message    = "Transport Booking request successfully";
//        $action     = "api/transport";
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
        $this->cart['persons'] = $this->data['adults'] ?? 0 + isset($this->data['children']) ?? 0;
        $this->cart['nights'] = 1;
        $this->cart['uom'] = 'days';
        $this->cart['rent'] = 0;
        switch($this->data['booking_type']) {
            case 'Per Day':
                $this->cart['nights'] = 1;
                $this->cart['uom'] = 'day';
                if($this->data['incity']){
                    $this->cart['rent'] = $this->convertedAmount($this->service->intercity_per_day_price);
                }
                else {
                    $this->cart['rent'] = $this->convertedAmount($this->service->outofcity_per_day_price);
                }
            break;
            case 'Multiple Day':
                $this->cart['nights'] = Carbon::create($this->data['start_date'])->diffInDays($this->data['end_date']) + 1;
                $this->cart['uom'] = 'days';
                if($this->data['incity']){
                    $this->cart['rent'] = $this->convertedAmount($this->service->intercity_multiple_day_price);
                }
                else {
                    $this->cart['rent'] = $this->convertedAmount($this->service->outofcity_multiple_day_price);
                }
            break;
            case 'Hourly':
                $this->cart['nights'] = Carbon::create($this->data['start_time'])->diffInHours($this->data['end_time']);
                $this->cart['rent'] = $this->convertedAmount($this->service->hourly_price);
                $this->cart['uom'] = 'hours';
            break;
            default:
            $this->cart['nights'] = 1;
        }


        $this->cart['items'] = [];
        $this->cart['subtotal'] = 0;
        $this->cart['discounttotal'] = 0;
        $this->cart['grandtotal'] = 0;
        $this->cart['discounts'] = [];

        if($this->service->category != 'road'){
            $this->cart['rent'] = $this->service->hourly_price;
            $this->cart['rent'] = (is_numeric($this->data['price']) ? $this->data['price'] : null) ?? $this->cart['rent'];
            $this->cart['items'][] = [
                "label" => "Rent",
                "desc" => "Rent " . $this->convertedAmount($this->cart['rent']) . " x " . $this->cart['persons'] . " / person " ,
                "price" => $this->convertedAmount($this->cart['rent'] * $this->cart['persons'])
            ];

            $tPrice = $this->convertedAmount($this->cart['rent']);

            if($this->service->is_offer_promotion_discount && $this->service->promotion_discount){
                $this->cart['discounts'][] =[
                    "label" => "Promotional Discount",
                    "desc" => "Promotional Discount",
                    "price" => round((($tPrice / 100) * $this->service->promotion_discount) * $this->cart['persons'], 2)
                ];
                $this->cart['discounttotal'] += round((($tPrice / 100) * $this->service->promotion_discount) * $this->cart['persons'], 2);
            }
        }
        else {
            $this->cart['items'][] = [
                "label" => "Rent",
                "desc" => "Rent PKR " . $this->cart['rent']. " x " . $this->cart['nights'] . " " . $this->cart['uom'],
                "price" => $this->cart['rent'] * $this->cart['nights']
            ];

            $tPrice = $this->cart['rent'];
            if($this->service->is_offer_promotion_discount && $this->service->promotion_discount){
                $this->cart['discounts'][] =[
                    "label" => "Promotional Discount",
                    "desc" => "Promotional Discount",
                    "price" => round((($tPrice / 100) * $this->service->promotion_discount) * $this->cart['nights'], 2)
                ];
                $this->cart['discounttotal'] += round((($tPrice / 100) * $this->service->promotion_discount) * $this->cart['nights'], 2);
            }
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

        $this->cart['grandtotal'] = round($this->cart['subtotal'] - $this->cart['discounttotal'] + $tax,2);
        $this->cart['subtotal'] = round($this->cart['subtotal'], 2);
        $this->cart['discounttotal'] = round($this->cart['discounttotal'], 2);
        $this->cart['grandtotal'] = round($this->cart['grandtotal'], 2);

        $this->subtotal = $this->cart['subtotal'];
        $this->discounttotal = $this->cart['discounttotal'];
        $this->grandtotal = $this->cart['grandtotal'];
        if($this->service->payment_partial_value > 0 && $this->service->payment_mode == 1){
            $this->minimum_payable_amount = ($this->grandtotal / 100) * $this->service->payment_partial_value;
        } else {
            $this->minimum_payable_amount = $this->grandtotal;
        }

    }

    public function getAvailability() : bool
    {
        $booking = Reservation::where('bookable', $this->model)
            ->whereDate('date_from', '>=', $this->data['start_date'])
            ->whereDate('date_to', '<=', $this->data['end_date'])
            ->where('bookable_id', $this->id)
            ->where('status', '!=', 1)
            ->exists();
        return !$booking;
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
