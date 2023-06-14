<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerSupportBookingEmail extends Mailable
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
     * Build the data.
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
