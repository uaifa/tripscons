<?php
namespace App\Libs\Booking\Services;

use App\Libs\Booking\Interfaces\Bookable;
use App\Models\Accommodation as ModelsAccommodation;
use App\Models\Country;
use App\Models\DeviceDetail;
use App\Models\Notification;
use App\Models\Reservation;
use App\Models\ServiceTax;
use App\Notifications\PushNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class Accommodation implements Bookable
{

    private $id;
    private $service;
    private $model = ModelsAccommodation::class;
    private $data;
    private $cart;
    private $subtotal;
    private $discounttotal;
    private $grandtotal;
    private $type = "Accomodation Booking";
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
        if (!$service) {
            throw new Exception("INVALID SERVICE IDENTIFER $id");
        }

        //Validate if id is compatible with this class
        if ($service->type_id == 0) {
            throw new Exception("PROVIDED ID $id IS NOT COMPATIBLE WITH PROVIDED TYPE " . self::class);
        }

        return $service
            ->loadAvg('rating_values', 'rating_value_1')
            ->loadAvg('rating_values', 'rating_value_2')
            ->loadAvg('rating_values', 'rating_value_3')
            ->loadAvg('rating_values', 'rating_value_4')
            ->loadAvg('rating_values', 'rating_value_5')
            ->loadAvg('rating_values', 'average_rating')
            ->loadSum('rating_values', 'rating_value_1')
            ->loadSum('rating_values', 'rating_value_2')
            ->loadSum('rating_values', 'rating_value_3')
            ->loadSum('rating_values', 'rating_value_4')
            ->loadSum('rating_values', 'rating_value_5')
            ->loadSum('rating_values', 'average_rating');
    }

    public function book()
    {
        $reservation = Reservation::forceCreate([
            'reference_no' => uniqid(),
            'bookable' => $this->model,
            'bookable_id' => $this->id,
            'room_id' => null,
            'provider_user_id' => $this->service->user_id,
            'user_id' => Auth::id(),
            'date_from' => $this->data['date_from'],
            'date_to' => $this->data['date_to'],
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

// Notification Push to Vendor Accomodation Booking request
        $title = "Booking Request";
        $message = "You have 1 new booking request. To view booking details";
        $action = "/host/bookings";
        // $action = "/bookings/summary/".$reservation->id;
        $vendor = \App\Models\User::where('id', $this->service->user_id)->first();
        if (isset($vendor) && !empty($vendor)) {
            PushNotification::createNotification($vendor, Auth::user()->id, $title, $message, \App\Models\User::TYPE_BOOKING, $action, $reservation->id);
        }

// Notification Push to Admin Accomodation Booking request
        $admin = \App\Models\User::where('id', \App\Models\User::ADMIN_ID)->first();
        $adminMessage = "1 new booking request by " . Auth::user()->name . " for " . $vendor->name;
        if (isset($admin) && !empty($admin)) {
            PushNotification::createNotification($admin, Auth::user()->id, $title, $adminMessage, \App\Models\User::TYPE_BOOKING, $action, $reservation->id);
        }

        return $reservation;
    }

    public function results(): array
    {
        $this->cart['currency'] = $this->currency->currency;
        return [
            'id' => $this->id,
            'reservation_class' => self::class,
            'availibility' => $this->getAvailability(),
            'data' => $this->data,
            'cart' => $this->cart,
            'service' => $this->service,
        ];
    }

    public function getCart(): array
    {
        return $this->cart;
    }

    public function setCart()
    {
        $this->cart['nights'] = Carbon::create($this->data['date_from'])->diffInDays($this->data['date_to']);
        $this->cart['persons'] = $this->data['adults'] + $this->data['children'];
        $this->cart['rent'] = $this->convertedAmount((is_numeric($this->data['price']) ? $this->data['price'] : null) ?? $this->service->per_night);
        $this->cart['lunch'] = $this->convertedAmount($this->service->lunch_price);
        $this->cart['breakfast'] = $this->convertedAmount($this->service->breakfast_price);
        $this->cart['dinner'] = $this->convertedAmount($this->service->dinner_price);
        $this->cart['items'] = [];
        $this->cart['free_dinner'] = false;
        $this->cart['free_lunch'] = false;
        $this->cart['free_breakfast'] = false;
        $this->cart['subtotal'] = 0;
        $this->cart['discounttotal'] = 0;
        $this->cart['grandtotal'] = 0;
        $this->cart['discounts'] = [];
        $this->cart['items'][] = [
            "label" => "Room",
            "desc" => "Rent " . $this->currency->currency . " " . $this->convertedAmount((is_numeric($this->data['price']) ? $this->data['price'] : null) ?? $this->service->per_night) . " x " . $this->cart['nights'] . " nights",
            "price" => round($this->convertedAmount((is_numeric($this->data['price']) ? $this->data['price'] : null) ?? $this->service->per_night) * $this->cart['nights']),
        ];
        if ($this->data['lunch']) {
            $this->cart['items'][] = [
                "label" => "Lunch",
                "desc" => "Lunch " . $this->currency->currency . " " . $this->convertedAmount($this->service->lunch_price) . " x " . $this->cart['persons'] . " persons x " . $this->cart['nights'] . " nights",
                "price" => round($this->service->lunch_included == 'Yes' ? "FREE" : $this->convertedAmount($this->service->lunch_price * $this->cart['persons'] * $this->cart['nights'])),
            ];
        }

        if ($this->data['breakfast']) {
            $this->cart['items'][] = [
                "label" => "Breakfast",
                "desc" => "Break Fast " . $this->currency->currency . " " . $this->convertedAmount($this->service->breakfast_price) . " x " . $this->cart['persons'] . " persons x " . $this->cart['nights'] . " nights",
                "price" => round($this->service->breakfast_included == 'Yes' ? "FREE" : $this->convertedAmount($this->service->breakfast_price * $this->cart['persons'] * $this->cart['nights'])),
            ];
        }

        if ($this->data['dinner'] && $this->service->dinner_included == 'No') {
            $this->cart['items'][] = [
                "label" => "Dinner",
                "desc" => "Dinner " . $this->currency->currency . " " . $this->convertedAmount($this->service->dinner_price) . " x " . $this->cart['persons'] . " persons x " . $this->cart['nights'] . " nights",
                "price" => round($this->service->dinner_included == 'Yes' ? "FREE" : $this->convertedAmount($this->service->dinner_price * $this->cart['persons'] * $this->cart['nights'])),
            ];
        }

        if ($this->service->lunch_included == 'Yes') {
            $this->cart['free_lunch'] = true;
            $this->cart['items'][] = [
                "label" => "Lunch",
                "desc" => "Lunch",
                "price" => 'FREE',
            ];
        }
        if ($this->service->breakfast_included == 'Yes') {
            $this->cart['free_breakfast'] = true;
            $this->cart['items'][] = [
                "label" => "Breakfast",
                "desc" => "Breakfast ",
                "price" => 'FREE',
            ];
        }
        if ($this->service->dinner_included == 'Yes') {
            $this->cart['free_dinner'] = true;
            $this->cart['items'][] = [
                "label" => "Dinner",
                "desc" => "DInner",
                "price" => 'FREE',
            ];
        }

        foreach ($this->cart['items'] as $item) {
            if (is_numeric($item['price'])) {
                $this->cart['subtotal'] += round($item['price']);
            }
        }

        if (intval($this->data['children']) != 0 && intval($this->service->child_discount) != 0) {
            $this->cart['discounts'][] = [
                "label" => "Child Discount",
                "desc" => "Child Discount",
                "price" => round((($this->cart['rent'] / 100) * $this->service->child_discount) * $this->cart['nights']),
            ];

            $this->cart['discounttotal'] += round((($this->cart['rent'] / 100) * $this->service->child_discount) * $this->cart['nights']);
        }

        if ($this->cart['nights'] >= 30 && $this->service->discount_for_monthly > 0) {
            $this->cart['discounts'][] = [
                "label" => "Monthly Discount",
                "desc" => "Monthly Discount",
                "price" => round((($this->cart['rent'] / 100) * $this->service->discount_for_monthly) * $this->cart['nights']),
            ];

            $this->cart['discounttotal'] += round((($this->cart['rent'] / 100) * $this->service->discount_for_monthly) * $this->cart['nights']);
        } elseif ($this->cart['nights'] >= 15 && $this->service->discount_for_two_week > 0) {
            $this->cart['discounts'][] = [
                "label" => "15 days Discount",
                "desc" => "15 days Discount",
                "price" => round((($this->cart['rent'] / 100) * $this->service->discount_for_two_week) * $this->cart['nights']),
            ];

            $this->cart['discounttotal'] += round((($this->cart['rent'] / 100) * $this->service->discount_for_two_week) * $this->cart['nights']);
        } elseif ($this->cart['nights'] >= 7 && $this->service->discount_for_one_week > 0) {
            $this->cart['discounts'][] = [
                "label" => "Weekly Discount",
                "desc" => "Weekly Discount",
                "price" => round((($this->cart['rent'] / 100) * $this->service->discount_for_one_week) * $this->cart['nights']),
            ];

            $this->cart['discounttotal'] += round((($this->cart['rent'] / 100) * $this->service->discount_for_one_week) * $this->cart['nights']);
        }

        if ($this->service->is_offer_promotion_discount && $this->service->promotion_discount) {
            $this->cart['discounts'][] = [
                "label" => "Promotional Discount",
                "desc" => "Promotional Discount (" . $this->service->promotion_discount . "%)",
                "price" => round(((round($this->cart['subtotal'] - $this->cart['discounttotal']) / 100) * $this->service->promotion_discount)),
            ];
            $this->cart['discounttotal'] += round(((round($this->cart['subtotal'] - $this->cart['discounttotal']) / 100) * $this->service->promotion_discount));
        }
        $this->cart['discounttotal'] = round($this->cart['discounttotal']);
        $this->cart['subtotal'] = round($this->cart['subtotal']);

        // $taxPercentage = ServiceTax::find($this->service->tax_id);

        // if ($taxPercentage) {
        //     $taxPercentage = $taxPercentage->tax;
        // } else {
        //     $taxPercentage = 16;
        // }

        // $tax = round($this->cart['subtotal'] - $this->cart['discounttotal']) / 100 * $taxPercentage;
        $tax = 0;

        // $this->cart['taxes'][] = [
        //     "label" => "Tax",
        //     "desc" => "GST @ $taxPercentage%",
        //     "price" => round($tax),
        // ];

        $this->cart['grandtotal'] = round($this->cart['subtotal'] - $this->cart['discounttotal'] + $tax);

        $this->subtotal = $this->cart['subtotal'];
        $this->discounttotal = $this->cart['discounttotal'];
        $this->grandtotal = round($this->cart['grandtotal']);
        if ($this->service->payment_partial_value > 0 && $this->service->payment_mode == 1) {
            $this->minimum_payable_amount = round(($this->grandtotal / 100) * $this->service->payment_partial_value);
        } else {
            $this->minimum_payable_amount = $this->grandtotal;
        }

    }

    public function getAvailability(): bool
    {
        $booking = Reservation::where('bookable', $this->model)
            ->where('date_from', '<=', $this->data['date_to'])
            ->where('date_to', '>', $this->data['date_from'])
            ->where('bookable_id', $this->id)
            ->where('status', '=', 7)
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
            $notification->user_id = $receiver_id;
            $notification->sender_id = $user->id;
            $notification->receiver_id = $receiver_id;
            $notification->message = $this->model::TITLE;
            $notification->body = $this->model::MESSAGE;
            $notification->type = $this->model::TYPE_BOOKING;
            $notification->actions = $this->model::ACTION;
            $notification->seen = 0;
            $notification->status = $this->model::STATUS;
            $notification->active = 1;
            $notification->save();
            $badge = PushNotification::deviceBadgesUpdate($receiver_id, $this->model::TYPE_BOOKING);
            PushNotification::sendNotification([
                'message' => $this->model::MESSAGE,
                'title' => $this->model::TITLE,
                'device_tokens' => $device_token,
                'user' => $user,
                'payload' => [
                    'id' => $this->id,
                    'type' => $this->model::TYPE_BOOKING,
                    'sender_id' => $user->id,
                    'badge' => $badge,
                ],
            ]);
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Notification send successfully.';
            return response()->json($this->response, $this->status);
        } catch (\Exception$e) {
            $this->status = 401;
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }
}
