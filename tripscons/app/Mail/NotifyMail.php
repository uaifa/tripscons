<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Traits\SendEmailTrait;
use PDF;
use Mail;

class NotifyMail extends Mailable
{
  use Queueable, SerializesModels;
  use SendEmailTrait;

  public $data;
  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($data)
  {
    $this->user  = $data->user;
    $this->provider  = $data->provider;
    $this->bookingId  = $data->bookingId;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $bookingId = $this->bookingId;
    $detail = $this->InvoicePdf($bookingId);
    $data["email"] =  $this->user;;
    $data["title"] = "From Tripscon PDF Booking File";
    $pdf = PDF::loadView('Invoice.Booking', compact('detail'));

    // dd($this->bookingId, $this->provider, $this->user, $detail , $pdf);
    // Storage::put('/list/' . $bookingId . '.pdf/', $pdf->output());

    return $this->markdown('basic.emails.thank_you')->subject($data["title"])->attachData($pdf->output(), "text.pdf");
  }
}
