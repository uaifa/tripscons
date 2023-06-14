<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    const MESSAGE = 'Inquiry Service Booked Successfully';
    const TYPE = 'Inquiry BOOKING';
    const ACTION = 'send/meal/notification';
    const STATUS = 'SENT';
    const TITLE = 'Inquiry Reservation';
    const ACTIVE_INQUIRY = 1;
    const CLOSED_INQUIRY = 0;

    protected $table = 'inquiries';
    protected $primaryKey = 'id';
    protected $fillable = [
            'location',    
            'date_from', 
            'date_to', 
            'persons', 
            'user_id', 
            'type', 
            'trip_type',   
            'budget',  
            'notes',
            'vehicle_category',    
            'vehicle_type',    
            'with_driver', 
            'name',  
            'email',  
            'phone',   
    ];

    
    protected $casts = [
        'location' => 'array'
    ];

    protected $with = [
        'user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function purposals()
    {
        return $this->hasMany(InquiryProposal::class);
    }
}
