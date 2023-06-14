<?php

namespace App\Listeners;

use App\Models\Message;
use App\Models\Notification;
use App\Models\Participant;
use App\Models\TripMateInvitation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Events\Counters;

class Counter
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
    public function handle(Counters $counter)
    {
        $user_id = $counter->user_id;
        $notifications = Notification::where('receiver_id',$user_id)->where('seen',0)->count();

        $participant = Participant::whereHas('thread',function ($query) use ($user_id) {
            $query->whereHas('messages');
//                ,function ($q) use ($user_id){
//                $q->where('user_id','!=',$user_id);
//            });
        })
            ->where('user_id',$user_id)
            ->where('seen',0)
            ->count();
        $tripMateInvitations = TripMateInvitation::whereHas('trip_mate',function ($query) use ($user_id){
            $query->where('user_id',$user_id);
        })
            ->where('status','!=','REJECTED')
            ->count();
        $counts = [
            'notifications'         => $notifications,
            'chats'                 => $participant,
            'tripMateInvitations'   => $tripMateInvitations,
        ];

        return $counts;

    }
}
