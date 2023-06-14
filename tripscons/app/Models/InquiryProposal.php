<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InquiryProposal extends Model
{
    protected $table="inquiry_purposals";

    protected $fillable = [
            'title',
            'purposedBudget',
            'inquiry_id',
            'user_id',
            'payment_term',
            'notes',
            'rules',
            'itinerary',
            'included',
            'excluded',
            'cancellation_policies',
            'activities',
            'status',
            'terms'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }
}
