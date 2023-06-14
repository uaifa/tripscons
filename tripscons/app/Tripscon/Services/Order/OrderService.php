<?php


namespace App\Tripscon\Services\Order;


use App\Tripscon\Interfaces\iOrder;
use Illuminate\Http\Request;

class OrderService
{
    /**
     * @Description Send Notification before ordering its first step for order
     * @param iOrder $iOrder
     * @param Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function sendNotificationBeforeBook(iOrder $iOrder, Request $request)
    {
        return $iOrder->sendNotificationBeforeBook($request);
    }

    /**
     * @Description Order Accept
     * @param iOrder $iOrder
     * @param $notificationId
     * @param $orderId
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function orderAccept(iOrder $iOrder,$notificationId, $orderId)
    {
        return $iOrder->accept($notificationId,$orderId);
    }

    /**
     * @Description Order Reject
     * @param iOrder $iOrder
     * @param $notificationId
     * @param $orderId
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function orderReject(iOrder $iOrder, $notificationId, $orderId)
    {
        return $iOrder->reject($notificationId, $orderId);
    }

}
