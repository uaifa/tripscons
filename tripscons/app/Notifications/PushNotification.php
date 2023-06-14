<?php

namespace App\Notifications;

use App\Models\DeviceBadge;
use App\Models\DeviceDetail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PushNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public static function createNotification($receiver,$sender_id,$title,$message,$type = 'BOOKING',$action = null,$model_id = 0)
    {
        try {
            $device_token   = [];
            $receiver_id    = $receiver->id;
            $deviceTokens   = DeviceDetail::select('device_token')->where('user_id', $receiver_id)->get();
            if ($deviceTokens) {
                foreach ($deviceTokens as $key => $deviceToken) {
                    $device_token[$key] = $deviceToken->device_token;
                }
            }
            $notification               =   new \App\Models\Notification();
            $notification->user_id      =   $receiver_id;
            $notification->sender_id    =   $sender_id;
            $notification->receiver_id  =   $receiver_id;
            $notification->model_id     =   $model_id;
            $notification->message      =   $title;
            $notification->body         =   $message;
            $notification->type         =   $type;
            $notification->actions      =   $action;
            $notification->seen         =   0;
            $notification->status       =   User::STATUS;
            $notification->active       =   1;
            $notification->save();
            $badge = PushNotification::deviceBadgesUpdate($receiver_id,$type);
            PushNotification::sendNotification([
                'title'             => $title,
                'message'           => $message,
                'device_tokens'     => $device_token,
                'user'              => $receiver,
                'payload' => [
                    'id'            => $receiver->id,
                    'type'          => $type,
                    'sender_id'     => $sender_id,
                    'badge'         => $badge,
                    'model_id'      => $model_id
                ]
            ]);
            return $badge;

        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }

    public static function sendNotification($parameters)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        if($parameters) {
            $device_tokens   =     $parameters['device_tokens'];
            $serverKey       =     config('pushnotification.fcm.apiKey');
            $data = [
                "registration_ids" => is_array($device_tokens) ? $device_tokens : array($device_tokens),
                "notification" => [
                    "title" => $parameters['title'],
                    "body" => $parameters['message'],
                    'badge'=>$parameters['payload']['badge'],
                    'sound'=> 'default'
                ],
                'data' => $parameters['payload'],
                'apns' => [
                    'payload' => [
                        'aps' => [
                            'contentAvailable' => true,
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
            return $result;
        }
    }

    public static function deviceBadgesUpdate($user_id,$type = 'BOOKING')
    {
        try {
            $device_badges = DeviceBadge::where('user_id',$user_id)->where('type',$type)->first();
            if ($device_badges) {
                if ($device_badges->type == $type) {
                    $device_badges->count = $device_badges->count + 1;
                    $device_badges->update();
                }
            } else {
                $device_badges = new DeviceBadge();
                $device_badges->user_id = $user_id;
                $device_badges->type = $type;
                $device_badges->status = 'ACTIVE';
                $device_badges->count = 1;
                $device_badges->save();
            }
            return $device_badges->count;
        }
        catch (\Exception $e){
            return $e->getMessage();

        }
    }

}
