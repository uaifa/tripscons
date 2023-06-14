<?php

namespace App\Listeners\Welcome;

use App\Events\UserRegistration;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendWelcomeSms
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
     * @param  \App\Events\UserRegistration  $event
     * @return void
     */
    public function handle(UserRegistration $event)
    {
        //Send SMS
    }
}
