<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingActivityLog extends Model
{
    protected $table = 'booking_activity_log';

    protected $fillable = [
        'booking_id',
        'admin_user_id',
        'status',
        'comments',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/booking-activity-logs/'.$this->getKey());
    }
}
