<?php

namespace App\Listeners\Booking;

use App\Events\Booking\BookingRefunded;
use App\Libs\Firebase\Firebase;
use App\Mail\Booking\BookingRefund;
use App\Models\Fcm;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class BookingRefundEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Booking\BookingRefunded  $event
     * @return void
     */
    public function handle(BookingRefunded $event)
    {
        $client = User::find($event->booking->user_id);
        $vendor = User::find($event->booking->provider_id);
        try{
            Mail::to($client)->send(new BookingRefund($event->booking, [
                'subject' => 'Booking Refunded',
                'message' => 'We have refunded your booking #' . $event->booking->booking_number,
                'title' => 'Booking Refunded'
            ]));
        }catch(Exception $ex){

        }
        try{
            Mail::to($vendor)->send(new BookingRefund($event->booking, [
                'subject' => 'Booking Refunded',
                'message' => 'We have issued a refund to client against booking #' . $event->booking->booking_number,
                'title' => 'Booking Refunded'
            ]));

        }catch(Exception $ex){

        }

        $firebase = new Firebase();
        $firebase->setTitle("Booking Canceled");
        $firebase->setBody("A booking was cancelled");
        $firebase->setData([
            'booking_id' => $event->booking->id,
            'type' => 'booking-refunded',
            'provider_id' => $event->booking->provider_id,
            'client_id' => $event->booking->user_id,
        ]);
        $tokens = Fcm::whereIn('user_id', [$vendor->id, $client->id])->pluck('token');
        foreach($tokens as $token){
            $firebase->setToTokens($token);
            $firebase->send();
        }
    }
}
