<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\SignUp;
use Mail;
use App\Mail\SignUpMailler;

class SignUpMail
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
    public function handle(SignUp $event)
    {
        // dd($event->email);s 
        // Mail::to($event->email)->send(new SignUpMailler($event));

        // if (Mail::failures()) {
        //     return response()->Fail('Sorry! Please try again latter');
        // } 
        //  else {
        //     return response()->success('Great! Successfully send in your mail');
        // }
    }
}
