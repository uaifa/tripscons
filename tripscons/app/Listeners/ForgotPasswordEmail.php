<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ForgotPassword;
use Mail;
use App\Mail\ForgotPasswordMail;
class ForgotPasswordEmail
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
     * @param  object  $event
     * @return void
     */
    public function handle(ForgotPassword $event)
    {
       
        Mail::to($event->data['email'])->send(new ForgotPasswordMail($event));
        if (Mail::failures()) {
            return response()->Fail('Sorry! Please try again latter');
        } 
         else {
            return response('Success');
        }
    }
}
