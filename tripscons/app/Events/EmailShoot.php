<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Mail\NotifyMail;
use App\Models\Booking;

class EmailShoot
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user;
    public $provider;
    public $bookingId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $provider, $bookingId)
    {
        $this->user = $user;
        $this->provider = $provider;
        $this->bookingId = $bookingId;
        // dd($this->bookingId, $this->provider, $this->user);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
    }
}
