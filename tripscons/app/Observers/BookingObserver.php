<?php

namespace App\Observers;

use App\Models\Booking;
use App\Events\EmailShoot;

class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function created(Booking $booking)
    {
        //
    }

    /**
     * Handle the Booking "updated" event.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    // public function updated(Booking $booking)
    // {
    //     // Paid Status
    //     if ($booking->payment_status == 1) {
    //         event(
    //             new EmailShoot(
    //                 $booking->User->email,
    //                 $booking->Provider->email,
    //                 $booking->id
    //             )
    //         );
    //     }
    //     // Partial Payment Status
    //     if ($booking->payment_status == 2) {
    //         event(new EmailShoot(
    //             $booking->User->email,
    //             $booking->Provider->email,
    //             $booking->id
    //         ));
    //     }
    // }

    /**
     * Handle the Booking "deleted" event.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function deleted(Booking $booking)
    {
        //
    }

    /**
     * Handle the Booking "restored" event.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function restored(Booking $booking)
    {
        //
    }

    /**
     * Handle the Booking "force deleted" event.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function forceDeleted(Booking $booking)
    {
        //
    }
}
