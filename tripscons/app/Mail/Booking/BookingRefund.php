<?php

namespace App\Mail\Booking;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingRefund extends Mailable
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
        $this->booking->title = $this->data['title'];
        $this->booking->subject = $this->data['subject'];
        $this->booking->message = $this->data['message'];
        return $this->view('emails.cs-booking', [
            'booking' => $this->booking,
        ])->subject($this->data['subject']);
    }
}
