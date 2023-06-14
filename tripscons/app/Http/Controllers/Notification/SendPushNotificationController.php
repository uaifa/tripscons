<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Controller;
use Auth;
use Edujugon\PushNotification\PushNotification;
use Exception;
use Illuminate\Http\Request;

class SendPushNotificationController extends Controller
{
    protected $URL = "https://fcm.googleapis.com/fcm/send";
    protected $key;
    protected $title;
    protected $body;
    protected $priority = 'high';
    protected $toTokens;
    protected $data = [];
    protected $image;
    protected $headers;

    public function __construct($headers = [
        "apns-push-type" => "background",
        "apns-priority" => "5",
        "apns-topic" => "io.flutter.plugins.firebase.messaging",
    ]) {
        $this->key = config('pushnotification.fcm.apiKey');
        $this->headers = $headers;
    }

    public function batchSend($parameters)
    {
        $this->setTitle($parameters['title']);
        $this->setBody($parameters['message']);
        $this->setData($parameters['payload']);
        $this->setToTokens($parameters['device_tokens']);
        $response = $this->send();
        return $response;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function setBody($body){
        $this->body = $body;
    }

    public function setData($data){
        $this->data = $data;
    }

    public function setToTokens($tokens){
        $this->toTokens = $tokens;
    }

    public function send()
    {
        $crl = curl_init();
        $headr = array();
        $headr[] = 'Content-type: application/json';
        $headr[] = 'Authorization: key=' . $this->key;
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($crl, CURLOPT_URL, $this->URL);
        curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
        curl_setopt($crl, CURLOPT_POST, true);
        curl_setopt($crl, CURLOPT_POSTFIELDS, json_encode($this->data(), JSON_FORCE_OBJECT));
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($crl);

        if ($resp == false) {
            $result_noti = 0;
        } else {
            $result_noti = 1;
        }
        curl_close($crl);
        return $resp;
    }

    public function data()
    {
        return [
            'to' => $this->toTokens,
            'priority' => $this->priority,
            'notification' => [
                'title' => $this->title,
                'body' => $this->body,
            ],
            'data' => $this->data,
            'apns' => [
                'payload' => [
                    'aps' => [
                        'contentAvailable' => true,
                    ],
                ],
                'fcm_options' => [
                    'image' => $this->image,
                ],
                'headers' => $this->headers,
            ],
        ];
    }

    public static function sendWebNotification($parameters)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        if($parameters) {
            $device_tokens   =     $parameters['device_tokens'];
            $serverKey      =     config('pushnotification.fcm.apiKey');
            $data = [
                "registration_ids" => is_array($device_tokens) ? $device_tokens : array($device_tokens),
                "notification" => [
                    "title" => $parameters['title'],
                    "body" =>  $parameters['message'],
                    "badge"=>  $parameters['payload']['badge']
                ],
                'data' => $parameters['payload'],
                'apns' => [
                    'payload' => [
                        'aps' => [
                            'contentAvailable' => true,
                            'badge'=>$parameters['payload']['badge']
                        ],
                    ],
                ],
            ];
            $encodedData = json_encode($data);
            $headers = [
                'Authorization:key=' . $serverKey,
                'Content-Type: application/json',
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
            // Execute post
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }
            // Close connection
            curl_close($ch);
            // FCM response
            dd($result);
            return $result;
        }
    }
}
