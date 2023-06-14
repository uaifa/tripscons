<?php


namespace App\Tripscon\Services\Order;


use App\Tripscon\Interfaces\iOrder;
use Illuminate\Http\Request;

class VisaConsultant implements iOrder
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

        return $request->all();
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
        // TODO: Implement accept() method.
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
        // TODO: Implement reject() method.
    }
}
