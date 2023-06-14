<?php


namespace App\Tripscon\Interfaces;


use Illuminate\Http\Request;

interface iOrder
{
    /**
     * @Description Send Notification when user send proposal for buy host
     * @param Request $request
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public function sendNotificationBeforeBook(Request $request);

    /**
     * @Description Accept Order
     * @param $notificationId
     * @param $orderId
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public function accept($notificationId,$orderId);

    /**
     * @Description Reject Order
     * @param $notificationId
     * @param $orderId
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public function reject($notificationId,$orderId);
}
