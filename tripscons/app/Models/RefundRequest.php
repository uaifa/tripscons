<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundRequest extends Model
{
    use HasFactory;

    protected $table = 'refund_request';

    protected $fillable = [
         'reservation_id','refund_amount','status','processing_date','requested_by','payment_method'
    ];

    public function booking()
    {
        return $this->belongsTo(Reservation::class,'reservation_id','id');
    }

    public function getCreatedAtAttribute($value) {
            
        return $date=\Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');

    }

}
