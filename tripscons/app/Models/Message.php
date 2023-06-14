<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    protected $guarded = [];
    protected $cast = [
        'booking_details' => 'array',
        'type' => 'integer'
    ];
    protected $appends = ['mine', 'inquiry_text', 'is_inquiry'];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class, 'thread_id','thread_id');
    }

    public function getMineAttribute()
    {
        if(request()->user()){
            if(request()->user()->id == $this->user_id){
                return true;
            }
        }
        return false;
    }

    public function getIsInquiryAttribute()
    {
        if($this->booking_id != null && $this->booking_details != null){
            return true;
        }

        return false;
    }

    public function getInquiryTextAttribute()
    {
        $inquiry = "";
        if($this->booking_details){
            foreach(json_decode($this->booking_details) as $key => $item){
                $inquiry .= "<b>" . $key . "</b>: " . $item . "<br/>";
            }
        }

        return $inquiry;
    }

}
