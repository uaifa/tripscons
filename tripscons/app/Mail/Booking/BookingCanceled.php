<?php

namespace App\Mail\Booking;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingCanceled extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $data;

    public function __construct($booking, $data)
    {
        $this->booking = $booking;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.booking.bookingcanceled', [
            'booking' => $this->booking,
            'data' => $this->data,
        ])->subject("Booking Cancellation Notification #" . $this->booking->booking_number);
    }
}
