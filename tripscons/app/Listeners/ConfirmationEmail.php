<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\ConfirmationLink;
use Mail;
use App\Mail\ConfirmationMail;
class ConfirmationEmail implements ShouldQueue
{
    use InteractsWithQueue;
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
    public function handle(ConfirmationLink $event)
    {
      
       Mail::to($event->data['email'])->send(new ConfirmationMail($event));
    //    if (Mail::failures()) {
    //        return response()->Fail('Sorry! Please try again latter');
    //    } 
    //     else {
    //        return response('Success');
    //    }
    }
}
