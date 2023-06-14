<?php

namespace App\Listeners;

use App\Events\PendingBooking;
use App\Http\Controllers\SmsController;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Telnyx;

class SendBookingSms
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
        $user = User::find($event->booking->provider_id);

        if($user && ($user->phone ?? false)){
            SmsController::send($user->country_code . $user->phone, "You have received a new booking #" . $event->booking->booking_number);
        }
    }
}
