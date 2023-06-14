<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    const TYPE = 'CHAT_MESSAGE';

    const ACTION = 'send/message/notification';

    const STATUS = 'SENT';

    protected $appends = ['latest_inquiry'];

    public function participants()
    {
        if(request()->user()){
            return $this->hasMany(Participant::class, 'thread_id', 'id')->where('user_id', '!=', request()->user()->id);
        }
        return $this->hasMany(Participant::class, 'thread_id', 'id');
    }

    public function getLatestInquiryAttribute()
    {
        $inquiry = Message::where('booking_id', '!=', 'null')->where('thread_id', $this->id)->orderByDesc('id')->first();

        return $inquiry;
    }
    public function messages()
    {
        $messages = $this->hasMany(Message::class,'thread_id' , 'id');

        return $messages;
    }
}
