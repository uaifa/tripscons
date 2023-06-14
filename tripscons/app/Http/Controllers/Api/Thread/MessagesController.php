<?php

namespace App\Http\Controllers\Api\Thread;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\DeviceDetail;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Participant;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\PushNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MessagesController extends Controller
{
    public function create(Request $request)
    {

        $rules = [
            'receiver_user_id' => 'exists:users,id',
            'message' => 'required',
        ];

        if ($request->receiver_user_id == null) {
            // $rules['booking_id'] = 'required|exists:bookings,id';
            // $rules['booking_details'] = 'required';
        }
        $request->validate($rules);

        $transaction = DB::transaction(function () use($request) {
            try {
                $receiverId = $request->receiver_user_id;

                if (!$request->receiver_user_id) {
                    $booking = Booking::find($request->booking_id);
                    $receiverId = $booking->provider_id;
                }

                //Get all thread ids
                $threads = Participant::where('user_id', $request->user()->id)->pluck('thread_id')->toArray();

                //Check if receiver exists in users threads
                $existingThread = Participant::where('user_id', $receiverId)->whereIn('thread_id', $threads)->first();
                if (!$existingThread) {
                    $existingThread = Thread::forceCreate([
                        'sock_id' => Str::uuid(),
                        'subject' => $request->message,
                    ]);
                    Participant::forceCreate([
                        'thread_id' => $existingThread->id,
                        'user_id' => $request->user()->id,
                    ]);
                    Participant::forceCreate([
                        'thread_id' => $existingThread->id,
                        'user_id' => $receiverId,
                    ]);
                } else {
                    $existingThread = Thread::find($existingThread->thread_id);
                }

                if($request->message){
                    $this->sendNotification($receiverId, Auth::id(), $request->message, $existingThread->id , $existingThread->sock_id);
                    MessageSent::dispatch($receiverId, Auth::id(), $request->message, $existingThread->id);
                }
                DB::commit();
                return [
                    "message" => "success",
                    "data" => null
                ];
            } catch (Exception $ex) {
                DB::rollBack();
                throw $ex;
            }
        });
        return $transaction;
    }

    public function getThreads(Request $request)
    {
        $threads = Thread::with(['participants.user'])->whereIn('id', Participant::where('user_id', $request->user()->id)->pluck('thread_id')->toArray())->orderByDesc("id")->get();

        return [
            'message' => 'success',
            'data' => $threads,
        ];
    }

    public function getMessages(Request $request, Thread $thread)
    {
        $messages = Message::with('user')->where('thread_id', $thread->id)->get();

        return [
            'message' => 'success',
            'data' => $messages,
        ];
    }

    public function message(Request $request)
    {
        $request->validate([
            'sock_id' => 'required|exists:threads,sock_id',
            'message' => 'required',
        ]);

        $thread = Thread::where('sock_id', $request->sock_id)->first();

        $message = Message::forceCreate([
            'thread_id' => $thread->id,
            'user_id' => $request->user()->id,
            'type' => 0,
            'body' => $request->message,
            'booking_id' => null,
            'booking_details' => null,
        ]);
        if($request->message){
            $receiverId = Participant::where('thread_id', $thread->id)->where('user_id', '!=', $request->user()->id)->first()->user_id;
            $this->sendNotification($receiverId, $request->user()->id, $request->message, $thread->id ,$thread->sock_id);
            MessageSent::dispatch($receiverId, $request->user()->id, $request->message, $thread->id);
            Log::debug("done");
        }
        return [
            'message' => 'success',
            'data' => $message->load("user")
        ];
    }

    public function openThread(Request $request)
    {
        $request->validate([
           'receiverId' => 'required',
        ]);
        $user = User::where('id', $request->receiverId)->first();
        if (!$user) {
            $this->response['success'] = false;
            $this->response['message'] = 'Receiver id does not existed.';
            return response()->json($this->response);

        }
        //Get all thread ids
        $threads = Participant::where('user_id', $request->user()->id)->pluck('thread_id')->toArray();
        $existingThread = Participant::where('user_id', $request->receiverId)->whereIn('thread_id', $threads)->first();
                if (!$existingThread) {
                    $existingThread = Thread::forceCreate([
                        'sock_id' => Str::uuid(),
                        'subject' => '',
                    ]);

                    Participant::forceCreate([
                        'thread_id' => $existingThread->id,
                        'user_id' => $request->user()->id,
                    ]);
                    Participant::forceCreate([
                        'thread_id' => $existingThread->id,
                        'user_id' => $request->receiverId,
                    ]);
                    $existingThread->load('participants.user');
                } else {
                    $existingThread = Thread::with('participants.user')->find($existingThread->thread_id);
                }

        return [
            'message' => 'success',
            'data' => $existingThread
        ];
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:png,jpg,pdf,mp4,gif,jpeg,pdf',
            'sock_id' => 'required|exists:threads,sock_id'
        ]);
        $files = $request->file('file');
        $image_full_name = time().'.'.$files->getClientOriginalExtension();
        $destinationPath = public_path('/assets/uploads/');
        $files->move($destinationPath,$image_full_name);
        $thread = Thread::where('sock_id', $request->sock_id)->first();
        $fileUrl = url("/assets/uploads/".$image_full_name);
        $message = Message::forceCreate([
            'thread_id' => $thread->id,
            'user_id' => $request->user()->id,
            'type' => 0,
            'body' => '<a target="_blank" href="'.$fileUrl.'">'.$files->getClientOriginalName().'</a>',
            'booking_id' => null,
            'booking_details' => null,
        ]);
        $participant =Participant::where('thread_id',$thread->id)->where('user_id','!=', $request->user()->id)->first();
        if ($participant)
        {
            $receiverId = $participant->user_id;
            $NotificationMessage = "File received" ;
            $this->sendNotification($receiverId, $request->user()->id, $NotificationMessage, $thread->id ,$thread->sock_id);
        }

        return [
            'message' => 'success',
            'data' => $message->load('user')
        ];
    }

    public function sendNotification($receiver_id, $sender_id, $message, $thread_id ,$sock_id)
    {
        try {
            $device_token = [];
            $user = User::where('id',$sender_id)->first();
            $deviceTokens = DeviceDetail::select('device_token')->where('user_id', $receiver_id)->get();
            if ($deviceTokens) {
                foreach ($deviceTokens as $key => $deviceToken) {
                    $device_token[$key] = $deviceToken->device_token;
                }
            }
            $badge = PushNotification::deviceBadgesUpdate($receiver_id,Thread::TYPE);
            PushNotification::sendNotification([
                'title' => $user->name,
                'message' => $message,
                'device_tokens'=> $device_token,
                'user' => $user,
                'payload' => [
                    'id'=>  $thread_id,
                    'thread_id'=> $sock_id,
                    'type' => 'CHAT',
                    'sender_id' => $user->id,
                    'badge' => $badge,
                ]
            ]);

        }
        catch (\Exception $e)
        {

        }
    }
}
