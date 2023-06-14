<?php

namespace App\Listeners\Booking;

use App\Events\Booking\BookingCanceled as BookingBookingCanceled;
use App\Libs\Firebase\Firebase;
use App\Mail\Booking\BookingCanceled;
use App\Models\Fcm;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class BookingCancelationEmail
{

    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\BookingCanceled  $event
     * @return void
     */
    public function handle(BookingBookingCanceled $event)
    {
        $client = User::find($event->booking->user_id);
        $vendor = User::find($event->booking->provider_id);
        try{
            Mail::to($client)->send(new BookingCanceled($event->booking, $client));
        }
        catch(Exception $ex){

        }
        try{
            Mail::to($vendor)->send(new BookingCanceled($event->booking, $vendor));
        }
        catch(Exception $ex){

        }
        $firebase = new Firebase();
        $firebase->setTitle("Booking Canceled");
        $firebase->setBody("A booking was cancelled");
        $firebase->setData([
            'booking_id' => $event->booking->id,
            'type' => 'booking-cancelled',
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
