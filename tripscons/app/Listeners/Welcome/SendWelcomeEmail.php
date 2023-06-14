<?php

namespace App\Listeners\Welcome;

use App\Events\UserRegistration;
use App\Mail\WelcomeEmail;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail
{

    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserRegistration  $event
     * @return void
     */
    public function handle(UserRegistration $event)
    {
        try{
            Mail::to($event->user)->send(new WelcomeEmail($event->user));
        }catch(Exception $ex){

        }
    }
}
