<?php


namespace App\Tripscon\Services\Order;


use App\Conversion;
use App\GuideProfile;
use App\Message;
use App\Notification;
use App\Order;
use App\OrderItem;
use App\PaymentReceipt;
use App\Tripscon\Interfaces\iOrder;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Guide implements iOrder
{

    /**
     * @Description Send Notification when user send proposal for buy host
     * @param Request $request
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public function sendNotificationBeforeBook(Request $request)
    {
        $request->validate([
            'selectedDate' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ], [
            'selectedDate.required' => 'Date is required.',
            'start_time.required' => 'Start Time is required.',
            'end_time.required' => 'End Time is required.',
        ]);

        $provider = User::find($request->providerId);
        $refType = 'guide:hourly:book';
        $order = Order::create([
            'user_id' => Auth::id(),
            'provider_id' => $provider->id,
            'description' => $request->description,
            'ref_id' => $provider->id,
            'type' => $refType,
            'status' => 'pending',
        ]);

//        $cardNumber = $request['card']['cardNumber'];
//        $expireMonth = explode('/', $request['card']['expiration'])[0];
//        $expireYear = explode('/', $request['card']['expiration'])[1];
//        $cvc = $request['card']['security'];
//        // getting strip token
//        $stripeToken = getStripeToken($cardNumber, $expireMonth, $expireYear, $cvc);
//        // Create Customer on stripe
//        $stripeCustomer = createStripeCustomer(Auth::id(), Auth::user()->email, $stripeToken['token']->id);
//        // getting strip New Token for further use
//        $newStripeToken = getStripeToken($cardNumber, $expireMonth, $expireYear, $cvc);
//        // Saving Card on Stripe
//        $savedStripeCard = saveCardOnStripe($stripeCustomer['customer']->id, $newStripeToken['token']->id);

        $body = [
            ['key' => 'order_id', 'value' => $order->id],
        ];

        $notification = Notification::create([
            'user_id' => $provider->id,
            'sender_user' => Auth::id(),
            'message' => $request->description,
            'body' => json_encode($body),
            'type' => $refType,
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

        $totalAmount = $provider->hourly_rate * $request->totalHours;
        $orderItemsBody = [
            ['key' => 'date', 'value' => (string)$request->selectedDate],
            ['key' => 'start_time', 'value' => (string)$request->start_time],
            ['key' => 'end_time', 'value' => (string)$request->end_time],
            ['key' => 'hours', 'value' => $request->totalHours],
            ['key' => 'total', 'value' => (int)$totalAmount],
        ];

        if ($orderItemsBody) {
            OrderItem::create([
                'user_id' => Auth::id(),
                'provider_id' => (int)$provider->id,
                'order_id' => (int)$order->id,
                'ref_id' => (int)$provider->id,
                'ref_type' => $refType,
                'date_from' => (string)$request->selectedDate,
                'date_to' => (string)$request->selectedDate,
                'day_or_hourly' => 'hourly',
                'total' => $totalAmount,
                'detail_in_json' => json_encode($orderItemsBody),
            ]);
        }

        /**
         * @Description Saving Stripe Card and customer detail into db
         */
        PaymentReceipt::create([
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'amount' => $totalAmount,
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
                    // Notification send to client
                    Notification::create([
                        'user_id' => $notification->sender_user,
                        'sender_user' => Auth::id(),
                        'message' => 'Your Order has been accepted.',
                        'type' => 'guide:book:info',
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
