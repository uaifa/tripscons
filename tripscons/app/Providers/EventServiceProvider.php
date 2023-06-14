<?php

namespace App\Providers;

use App\Events\Booking\BookingCanceled;
use App\Events\Counters;
use App\Listeners\Counter;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\EmailShoot;
use App\Events\MessageSent;
use App\Events\PendingBooking;
use App\Events\SignUp;
use App\Events\ForgotPassword;
use App\Events\ConfirmationLink;
use App\Events\UserRegistration;
use App\Listeners\Booking\BookingCancelationEmail;
use App\Listeners\Booking\SendBookingEmailToSupport;
use App\Listeners\SendBookingSms;
use App\Listeners\SendChatMessageEmail;
use App\Listeners\SendEmail;
use App\Listeners\Welcome\SendWelcomeEmail;
use App\Listeners\SignUpMail;
use App\Listeners\ForgotPasswordEmail;
use App\Listeners\ConfirmationEmail;
use App\Models\Booking;
use App\Models\Image;
use App\Observers\BookingObserver;
use App\Observers\ImageObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        EmailShoot::class => [
            SendEmail::class,
        ],

        SignUp::class => [
            SignUpMail::class,
        ],

        UserRegistration::class => [
            SendWelcomeEmail::class,
            // SendWelcomeSms::class,
        ],

        PendingBooking::class => [
            SendBookingEmailToSupport::class,
            SendBookingSms::class,
        ],

        BookingCanceled::class => [
            BookingCancelationEmail::class,
        ],

        MessageSent::class =>  [
            SendChatMessageEmail::class,
        ],
        ForgotPassword::class =>  [
            ForgotPasswordEmail::class,
        ],
        ConfirmationLink::class =>  [
            ConfirmationEmail::class,
        ],
        Counters::class =>  [
            Counter::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Booking::observe(BookingObserver::class);
        Image::observe(ImageObserver::class);
    }
}
