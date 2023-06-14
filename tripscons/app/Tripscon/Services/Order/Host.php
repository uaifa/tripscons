<?php


namespace App\Tripscon\Services\Order;


use App\Conversion;
use App\Message;
use App\Notification;
use App\Order;
use App\OrderItem;
use App\PaymentReceipt;
use App\Tripscon\Interfaces\iOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Host implements iOrder
{
    /**
     * @Description Send Notification to host for booking before order and order would be in pending till acceptation
     * @inheritDoc
     * @Author Khuram Qadeer.
     */
    public function sendNotificationBeforeBook(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'card.name' => 'required',
            'card.cardNumber' => 'required',
            'card.expiration' => 'required',
            'card.security' => 'required',
        ], [
            'card.name.required' => 'Enter Card name is required.',
            'card.cardNumber.required' => 'Card number is field.',
            'card.expiration.required' => 'Card expiration date is required.',
            'card.security.required' => 'Card security code is required.',
        ]);

        $providerId = $request->providerId;
        $selectedAccommodation = $request->selectedAccommodation;
        $quantityAccommodation = $request->accommodationDays;
        $selectedTransport = $request->selectedTransport;
        $quantityTransport = $request->transportDays;
        $selectedMeal = $request->selectedMeal;
        $quantityMeal = $request->mealDays;
        $description = $request->description;
        $selectedAvailability = $request->selectedAvailability;
        $availableDates = $request->availableDates;
        $availabilityAdults = (int)$request->availabilityAdults;
        $availabilityChildrens = (int)$request->availabilityChildrens;
        $availabilityInfants = (int)$request->availabilityInfants;
        $availabilityDays = (int)$request->availabilityDays;
        $availabilityTotalAmount = (int)$request->availabilityTotalAmount;

        if ($selectedAccommodation) {
            $request->validate([
                'accommodationFrom' => 'required',
                'accommodationTo' => 'required',
            ]);
        }
        if ($selectedMeal) {
            $request->validate([
                'mealFrom' => 'required',
                'mealTo' => 'required',
            ]);
        }

        if ($selectedTransport) {
            $request->validate([
                'transportCity' => 'required',
                'userPickUpLocation' => 'required',
            ], [
                'transportCity.required' => 'Please, Select one you want to go in city or out of city.',
                'userPickUpLocation.required' => 'Please, Select Pick up location.',
            ]);
            if ($request->transportCity == 'in') {
                $request->validate([
                    'transportInCityRequire' => 'required',
                ], [
                    'transportInCityRequire.required' => 'Please, Select Day or Hourly.',
                ]);
                if ($request->transportInCityRequire == 'day') {
                    $request->validate([
                        'transportDateFrom' => 'required',
                        'transportTime' => 'required',
                    ], [
                        'transportTime.required' => 'Please, Select Time.',
                        'transportDateFrom.required' => 'Please, Select Date.',
                    ]);
                } else if ($request->transportInCityRequire == 'days') {
                    $request->validate([
                        'transportDateFrom' => 'required',
                        'transportDateTo' => 'required',
                        'transportTime' => 'required',
                    ], [
                        'transportTime.required' => 'Please, Select Time.',
                    ]);
                } elseif ($request->transportInCityRequire == 'hourly') {
                    $request->validate([
                        'transportHoulyDate' => 'required',
                        'hourlyBookings' => 'required',
                    ], [
                        'transportHoulyDate.required' => 'Please, Select Date.',
                        'hourlyBookings.required' => 'Please, Add atleast one hourly booking.',
                    ]);
                }
            } elseif ($request->transportCity == 'out') {
                $request->validate([
                    'transportDateFrom' => 'required',
                    'transportDateTo' => 'required',
                    'transportTime' => 'required',
                ], [
                    'transportTime.required' => 'Please, Select Time.',
                ]);
            }
        }


        if ($selectedAccommodation || $selectedTransport || $selectedMeal || $selectedAvailability) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'provider_id' => $providerId,
                'description' => $description,
                'type' => 'host:book',
                'status' => 'pending',
            ]);
        } else {
            $request->validate([
                'selectedAccommodation' => 'required',
            ], [
                'selectedAccommodation.required' => 'Please, Select Any Service and try again'
            ]);
        }

        $cardNumber = $request['card']['cardNumber'];
        $expireMonth = explode('/', $request['card']['expiration'])[0];
        $expireYear = explode('/', $request['card']['expiration'])[1];
        $cvc = $request['card']['security'];
        // getting strip token
        $stripeToken = getStripeToken($cardNumber, $expireMonth, $expireYear, $cvc);
        // Create Customer on stripe
        $stripeCustomer = createStripeCustomer(Auth::id(), Auth::user()->email, $stripeToken['token']->id);
        // getting strip New Token for further use
        $newStripeToken = getStripeToken($cardNumber, $expireMonth, $expireYear, $cvc);
        // Saving Card on Stripe
        $savedStripeCard = saveCardOnStripe($stripeCustomer['customer']->id, $newStripeToken['token']->id);

        $body = [
            ['key' => 'order_id', 'value' => $order->id],
        ];

        $notification = Notification::create([
            'user_id' => $providerId,
            'sender_user' => Auth::id(),
            'message' => $description,
            'body' => json_encode($body),
            'type' => 'host:book',
            'seen' => 0,
            'active' => true
        ]);

        if ($notification) {
            $callToActions = [
                ['type' => 'info', 'key' => 'detail', 'value' => '/notification/show/' . $notification->id],
            ];
            $notification->update([
                'actions' => json_encode($callToActions),
            ]);
        }
        $totalAmount = 0;
        // Accommodation saving into order items table against order id
        if ($selectedAccommodation) {
            if ($quantityAccommodation) {
                $adultsCount = (int)$request->adults + (int)$request->childrens;
                $perNigthRate = (int)$selectedAccommodation['per_night'];
                if ($adultsCount > (int)$selectedAccommodation['limit_people']) {
                    $extraAdults = $adultsCount - $selectedAccommodation['limit_people'];
                    $perNigthRate = $perNigthRate + ($extraAdults * $selectedAccommodation['extra_price']);
                }
                $taxesFee = (int)$selectedAccommodation['service_fee'] + (int)$selectedAccommodation['clean_fee'] + (int)$selectedAccommodation['taxes_fees'];
                $totalAccommodationPrice = ((int)$perNigthRate * (int)$quantityAccommodation) + (int)$taxesFee;

                if ($totalAccommodationPrice) {
                    $discountedAmount = 0;
                    // Weekly Discount
                    if ((int)$quantityAccommodation >= 28 && (int)$selectedAccommodation['discount_week_4'] > 0) {
                        $discountedAmount = ($totalAccommodationPrice / 100) * (int)$selectedAccommodation['discount_week_4'];
                    } elseif ((int)$quantityAccommodation >= 21 && (int)$selectedAccommodation['discount_week_3'] > 0) {
                        $discountedAmount = ($totalAccommodationPrice / 100) * (int)$selectedAccommodation['discount_week_3'];
                    } elseif ((int)$quantityAccommodation >= 14 && (int)$selectedAccommodation['discount_week_2'] > 0) {
                        $discountedAmount = ($totalAccommodationPrice / 100) * (int)$selectedAccommodation['discount_week_2'];
                    } elseif ((int)$quantityAccommodation >= 7 && (int)$selectedAccommodation['discount_week_1'] > 0) {
                        $discountedAmount = ($totalAccommodationPrice / 100) * (int)$selectedAccommodation['discount_week_1'];
                    }
                    $totalAccommodationPrice = ($totalAccommodationPrice - (int)$discountedAmount);
                    $totalAmount += $totalAccommodationPrice;
                    $accommodationJson = [
                        ['key' => 'adults', 'value' => $request->adults ? (int)$request->adults : 0],
                        ['key' => 'childrens', 'value' => $request->childrens ? (int)$request->childrens : 0],
                        ['key' => 'infants', 'value' => $request->infants ? (int)$request->infants : 0],
                        ['key' => 'date_form', 'value' => (string)$request->accommodationFrom],
                        ['key' => 'date_to', 'value' => (string)$request->accommodationTo],
                        ['key' => 'total', 'value' => (int)$totalAccommodationPrice],
                    ];
                    OrderItem::create([
                        'user_id' => Auth::id(),
                        'provider_id' => (int)$providerId,
                        'order_id' => (int)$order->id,
                        'ref_id' => (int)$selectedAccommodation['id'],
                        'ref_type' => 'user_accommodations',
                        'date_from' => (string)$request->accommodationFrom,
                        'date_to' => (string)$request->accommodationTo,
                        'price' => (int)$selectedAccommodation['per_day'],
                        'quantity' => (int)$quantityAccommodation,
                        'total' => (int)$totalAccommodationPrice,
                        'detail_in_json' => json_encode($accommodationJson),
                    ]);
                }
            }
        }

        // Meal saving into order items table against order id
        if ($selectedMeal) {
            if ($quantityMeal) {
                $totalMealPrice = (int)$request->mealPrice;
                $totalAmount += $totalMealPrice;
                if ($totalMealPrice) {
                    if ($request->mealBookings) {
                        $mealJson = [
                            ['key' => 'selected_meals', 'value' => json_encode($request->mealBookings)],
                            ['key' => 'total', 'value' => (int)$totalMealPrice],
                        ];
                        foreach ($request->mealBookings as $mealBooking) {
                            OrderItem::create([
                                'user_id' => Auth::id(),
                                'provider_id' => (int)$providerId,
                                'order_id' => (int)$order->id,
                                'ref_id' => (int)$mealBooking['meal']['id'],
                                'ref_type' => 'user_meals',
                                'date_from' => (string)$mealBooking['date_from'],
                                'date_to' => (string)$mealBooking['date_to'],
                                'price' => (int)$mealBooking['meal']['price'],
//                                'quantity' => (int)$quantityMeal,
//                                'total' => (int)$totalMealPrice,
                                'detail_in_json' => json_encode($mealJson),
                            ]);
                        }
                    }
                }
            }
        }

        // Transport saving into order items table against order id
        if ($selectedTransport) {
            $totalTransportPrice = 0;
            $price = 0;
            if (($request->transportCity == 'in' && ($request->transportInCityRequire == 'day' || $request->transportInCityRequire == 'days'))
                || $request->transportCity == 'out') {
                $extraKmPrice = (int)$request->transportExtraKmPrice ? (int)$request->transportExtraKmPrice : 0;
                $price = (int)$selectedTransport['full_day_price'];
                if ($request->transportInCityRequire == 'day') {
                    $price = (int)$selectedTransport['per_day_price'];
                }
                $totalTransportPrice = ($price * (int)$quantityTransport) + $extraKmPrice;
                $totalAmount += $totalTransportPrice;
                $transportJson = [
                    ['key' => 'in_city', 'value' => (string)$request->transportCity],
                    ['key' => 'date_form', 'value' => (string)$request->transportDateFrom],
                    ['key' => 'date_to', 'value' => (string)$request->transportDateTo],
                    ['key' => 'time', 'value' => (string)$request->transportTime],
                    ['key' => 'pick_up_location', 'value' =>  $request->userPickUpLocation['locality'] . ', ' . $request->userPickUpLocation['country']],
                    ['key' => 'total', 'value' => (int)$totalTransportPrice],
                ];
            } elseif ($request->transportCity == 'in' && $request->transportInCityRequire == 'hourly') {
                $hourlyBookings = $request->hourlyBookings;
                $totalHours = 0;
                if ($hourlyBookings) {
                    foreach ($hourlyBookings as $hourlyBooking) {
                        $totalHours += $hourlyBooking['hours'];
                    }
                }
                $extraKmPrice = (int)$request->transportExtraKmPrice ? (int)$request->transportExtraKmPrice : 0;
                $price = (int)$selectedTransport['hourly_price'];
                $totalTransportPrice = ($price * (int)$totalHours) + $extraKmPrice;
                $transportJson = [
                    ['key' => 'hourly_dates', 'value' => json_encode($request->hourlyBookings)],
                    ['key' => 'in_city', 'value' => (string)$request->transportCity],
                    ['key' => 'pick_up_location', 'value' => $request->userPickUpLocation['locality'] . ', ' . $request->userPickUpLocation['country']],
                    ['key' => 'total', 'value' => (int)$totalTransportPrice],
                ];
            }

            if ($transportJson) {
                OrderItem::create([
                    'user_id' => Auth::id(),
                    'provider_id' => (int)$providerId,
                    'order_id' => (int)$order->id,
                    'ref_id' => (int)$selectedTransport['id'],
                    'ref_type' => 'user_transports',
                    'date_from' => (string)$request->transportDateFrom,
                    'date_to' => (string)$request->transportDateTo,
                    'time' => (string)$request->transportTime,
                    'in_city' => (string)$request->transportCity,
                    'pick_up_location' => json_encode($request->userPickUpLocation),
                    'day_or_hourly' => (string)$request->transportInCityRequire,
                    'price' => $price,
                    'quantity' => (int)$quantityTransport,
                    'total' => (int)$totalTransportPrice,
                    'detail_in_json' => json_encode($transportJson),
                ]);
            }
        }

        // Availability saving into order items table against order id
        if ($selectedAvailability) {
            $totalAmount += $availabilityTotalAmount;
            $detailJson = [
                ['key' => 'days', 'value' => $availabilityDays],
                ['key' => 'date_form', 'value' => (string)$availableDates['start']],
                ['key' => 'date_to', 'value' => (string)$availableDates['end']],
                ['key' => 'adults', 'value' => $availabilityAdults],
                ['key' => 'childrens', 'value' => $availabilityChildrens],
                ['key' => 'infants', 'value' => $availabilityInfants],
                ['key' => 'total', 'value' => $availabilityTotalAmount],
            ];
            OrderItem::create([
                'user_id' => Auth::id(),
                'provider_id' => (int)$providerId,
                'order_id' => (int)$order->id,
                'ref_id' => (int)$selectedAvailability['id'],
                'ref_type' => 'user_host_availabilities',
                'date_from' => (string)$availableDates['start'],
                'date_to' => (string)$availableDates['end'],
                'price' => $selectedAvailability['per_person_price'],
                'quantity' => ((int)$request->availabilityAdults + (int)$request->availabilityChildrens),
                'total' => (int)$availabilityTotalAmount,
                'detail_in_json' => json_encode($detailJson),
            ]);
        }

        /**
         * @Description Saving Stripe Card and customer detail into db
         */
        PaymentReceipt::create([
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'card_id' => $savedStripeCard['card']->id,
            'customer_id' => $stripeCustomer['customer']->id,
            'amount' => $totalAmount,
            'percentage_amount' => 10,
            'advance_amount' => $totalAmount * 10 / 100,
            'advance_status' => 'pending',
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'You request has been submitted.'], 200);
    }

    /**
     * @Description Accept Order
     * @param $notificationId
     * @param $orderId
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public function accept($notificationId, $orderId)
    {
        $message = 'Unprocessable Entity.';
        $status = 422;
        $paymentReceipt = PaymentReceipt::getByOrderId((int)$orderId);
        if ($paymentReceipt) {
            // Amount charge from stripe
            $paymentCharge = stripeCharge($paymentReceipt->customer_id, $paymentReceipt->card_id, $paymentReceipt->advance_amount);
            if (isset($paymentCharge['error'])) {
                $message = (string)$paymentCharge['error'];
                $status = 422;
                $paymentReceipt->update([
                    'errors' => $message
                ]);
            } else if (isset($paymentCharge['charge'])) {
                $notification = Notification::find($notificationId);
                if ($notification) {
                    // notification send to client
                    Notification::create([
                        'user_id' => $notification->sender_user,
                        'sender_user' => Auth::id(),
                        'message' => 'Your Order has been accepted.',
                        'type' => 'host:book:info',
                        'seen' => 0,
                        'active' => true
                    ]);
                    $notification->update([
                        'seen' => 1,
                    ]);
                }
                // transaction id store and update status
                $paymentReceipt->update([
                    'transaction_id' => $paymentCharge['charge'],
                    'advance_status' => 'paid',
                    'status' => 'accepted'
                ]);
                // order accepted
                Order::find($orderId)->update([
                    'status' => 'accepted',
                ]);

                /**
                 * @Description Conversion open between client and service provider
                 *              And auto message send from service provider to client
                 */
                $senderId = Auth::id();
                $receiverId = $notification->sender_user;
                $conversionExist = Conversion::getBySenderReceiverOrReceiverSender($senderId, $receiverId);
                if ($conversionExist) {
                    $conversion = $conversionExist;
                } else {
                    $conversion = Conversion::create([
                        'sender_id' => $senderId,
                        'receiver_id' => $receiverId,
                        'message' => 'Congrats! You order has been accepted by ' . Auth::user()->name . '.If you have any questions or anything let\'s talk here about it.',
                        'active' => true
                    ]);
                }
                Message::create([
                    'conversion_id' => $conversion->id,
                    'sender_id' => $senderId,
                    'receiver_id' => $receiverId,
                    'message' => 'Congrats! You order has been accepted by ' . Auth::user()->name . '.If you have any questions or anything let\'s talk here about it.',
                    'status' => 'new',
                    'active' => true
                ]);
                $message = 'Order has been accepted.';
                $status = 200;
            }
        }

        return response()->json(['message' => $message], $status);
    }

    /**
     * @Description Reject Order
     * @param $notificationId
     * @param $orderId
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public function reject($notificationId, $orderId)
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            Notification::create([
                'user_id' => $notification->sender_user,
                'sender_user' => Auth::id(),
                'message' => 'Your Order has been rejected by ' . Auth::user()->name,
                'type' => 'host:book:info',
                'seen' => 0,
                'active' => true
            ]);
            $notification->update([
                'seen' => 1,
            ]);
        }
        Order::find($orderId)->update([
            'status' => 'rejected',
        ]);
        return response()->json(['message' => 'Order has been rejected.'], 200);
    }
}
