<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;

class SmsController extends Controller
{
    public static function send($to, $message)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.veevotech.com/sendsms?hash=bd2b622ebff84150786931bab59bccf4&receivernum=".$to."&receivernetwork=&screen_name=&sender_address=&textmessage=".urlencode($message)."&sendernum=8583",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;

        // return;
        // $account_sid = 'ACf4a2b14b467a12b57c81ea0a341052ec';
        // $auth_token = '567061baaec2af1e5171af547c2330bc';
        // // In production, these should be environment variables. E.g.:
        // // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

        // // A Twilio number you own with SMS capabilities
        // $twilio_number = "+16572558678";
        // // dd($to);
        // $client = new Client($account_sid, $auth_token);
        // $client->messages->create(
        //     // Where to send a text message (your cell phone?)
        //     $to,
        //     array(
        //         'from' => $twilio_number,
        //         'body' => $message,
        //     )
        // );
//         $ch = curl_init();

    }
}
