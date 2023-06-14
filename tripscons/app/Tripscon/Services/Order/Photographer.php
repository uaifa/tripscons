<?php


namespace App\Tripscon\Services\Order;


use App\Conversion;
use App\Message;
use App\Notification;
use App\Order;
use App\OrderItem;
use App\PaymentReceipt;
use App\Tripscon\Interfaces\iOrder;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Photographer implements iOrder
{

    /**
     * @Description Send Notification when user send proposal for book Photographer
     * @param Request $request
     * @return mixed
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
        $userProvider = User::find($providerId);
        if ($request->dayOrHourly == 'day') {
            $request->validate([
                'date_from' => 'required',
                'date_to' => 'required',
            ]);
        } elseif ($request->dayOrHourly == 'hourly') {
            $request->validate([
                'houlyDate' => 'required',
                'hourlyCheckIn' => 'required',
                'hourlyCheckOut' => 'required',
                'hourlyBookings' => 'required',
            ], [
                'hourlyBookings.required' => 'Please, Add atleast one hourly booking.',
            ]);
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'provider_id' => $providerId,
            'description' => $request->description,
            'type' => 'photographer:book',
            'status' => 'pending',
        ]);

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
            'message' => $request->description,
            'body' => json_encode($body),
            'type' => 'photographer:book',
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
        $orderItemsBody = [];
        if ($request->dayOrHourly == 'day') {
            $totalAmount = (int)$userProvider->per_day_rate * (int)$request->totalDays;
            $orderItemsBody = [
                ['key' => 'date_form', 'value' => (string)$request->date_from],
                ['key' => 'date_to', 'value' => (string)$request->date_to],
                ['key' => 'total', 'value' => (int)$totalAmount],
            ];

        } elseif ($request->dayOrHourly == 'hourly') {
            $hourlyBookings = $request->hourlyBookings;
            $totalHours = 0;
            if ($hourlyBookings) {
                foreach ($hourlyBookings as $hourlyBooking) {
                    $totalHours += $hourlyBooking['hours'];
                }
            }

            $totalAmount = (int)$userProvider->hourly_rate * (int)$totalHours;
            $orderItemsBody = [
                ['key' => 'hourly_dates', 'value' => json_encode($request->hourlyBookings)],
                ['key' => 'total', 'value' => (int)$totalAmount],
            ];
        }

        if ($orderItemsBody) {
            OrderItem::create([
                'user_id' => Auth::id(),
                'provider_id' => (int)$providerId,
                'order_id' => (int)$order->id,
                'ref_type' => 'photographer:book',
                'day_or_hourly' => (string)$request->dayOrHourly,
                'price' => $request->dayOrHourly == 'day' ? (int)$userProvider->per_day_rate : (int)$userProvider->hourly_rate,
                'total' => (int)$totalAmount,
                'detail_in_json' => json_encode($orderItemsBody),
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
                        'type' => 'photographer:book:info',
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
                'type' => 'photographer:book:info',
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
