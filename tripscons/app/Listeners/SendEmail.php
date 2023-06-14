<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\NotifyMail;
use App\Events\EmailShoot;

class SendEmail
{

     /**
      * Create the event listener.
      *
      * @return void
      */
     public function __construct()
     {
     }

     /**
      * Handle the event.
      *
      * @param  object  $event
      * @return void
      */
     public function handle(EmailShoot $event)
     {
          // dd($event);
          Mail::to($event->user)->send(new NotifyMail($event));
          if (Mail::failures()) {
               return response()->Fail('Sorry! Please try again latter');
          }
          Mail::to($event->provider)->send(new NotifyMail($event));
          if (Mail::failures()) {
               return response()->Fail('Sorry! Please try again latter');
          }
     }
}
