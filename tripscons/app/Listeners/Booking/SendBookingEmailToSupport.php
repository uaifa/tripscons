<?php

namespace App\Listeners\Booking;

use App\Events\PendingBooking;
use App\Libs\Firebase\Firebase;
use App\Mail\CustomerSupportBookingEmail;
use App\Models\Fcm;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendBookingEmailToSupport
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
     * @param  \App\Events\PendingBooking  $event
     * @return void
     */
    public function handle(PendingBooking $event)
    {
        Mail::to("cstripscon@mailinator.com")->send(new CustomerSupportBookingEmail($event->booking, [
            'subject' => 'New Booking Pending Approval',
            'message' => 'There is a new booking pending your approval, booking #' . $event->booking->booking_number,
            'title' => 'Booking Pending Approval'
        ]));
        $client = User::find($event->booking->user_id);
        $vendor = User::find($event->booking->provider_id);
        try{
            Mail::to($client)->send(new CustomerSupportBookingEmail($event->booking, [
                'subject' => 'Booking Received',
                'message' => 'We have received your booking #' . $event->booking->booking_number . ". We will update you once the booking is confirmed",
                'title' => 'Booking Received'
            ]));
        }catch(Exception $ex){

        }
        try{
            Mail::to($vendor)->send(new CustomerSupportBookingEmail($event->booking, [
                'subject' => 'Booking Received',
                'message' => 'You have received your booking #' . $event->booking->booking_number . ". Please confirm availability",
                'title' => 'Booking Received'
            ]));
        }catch(Exception $ex){

        }

        $firebase = new Firebase();
        $firebase->setTitle("New Booking");
        $firebase->setBody("A new booking received");
        $firebase->setData([
            'booking_id' => $event->booking->id,
            'type' => 'booking-created',
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
