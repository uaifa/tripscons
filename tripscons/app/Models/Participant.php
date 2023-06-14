<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;


    protected $with = ['getMessages'];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function getMessages(){
        // return $this->hasMany(Message::class);
        return $this->belongsToMany(Message::class, Participant::class,'thread_id', 'thread_id', 'user_id', 'user_id');
    }
}
