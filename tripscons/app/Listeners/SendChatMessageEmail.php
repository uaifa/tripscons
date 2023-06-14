<?php

namespace App\Listeners;

use App\Events\MessageSent;
use App\Libs\Firebase\Firebase;
use App\Mail\NewMessageEmail;
use App\Models\Fcm;
use App\Models\Participant;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendChatMessageEmail implements ShouldQueue
{

    use InteractsWithQueue;
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
     * @param  \App\Events\MessageSent  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {

        $user = User::where('id', $event->userId)->first();
        $sender = User::find($event->senderId);
        Log::debug($event->userId);
        $data = [
            'name' => $user->name,
            'sender' => $sender->name,
            'message' => $event->message
        ];

        Log::debug($user->name);
        try{
            Mail::to($user)->send(new NewMessageEmail($data));
        }catch(Exception $ex){

        }

        // $firebase = new Firebase();
        // $firebase->setTitle($sender->name);
        // $firebase->setBody($event->message);
        // $firebase->setData([
        //     'thread_id' => $event->threadId,
        //     'type' => 'message',
        // ]);
        // $tokens = Fcm::where('user_id', Participant::where('thread_id', $event->threadId)->where('user_id', '!=', Auth::id())->pluck('user_id'))->pluck('token');
        // foreach($tokens as $token){
        //     $firebase->setToTokens($token);
        //     $firebase->send();
        // }

    }
}
