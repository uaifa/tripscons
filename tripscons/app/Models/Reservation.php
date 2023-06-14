<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = [
        'bookable_id',
        'bookable',
        'user_id',
        'provider_user_id',
        'room_id',
        'reference_no',
        'module_name'
    ];

    protected $casts = [
        'booking_detail' => 'array',
        'processor_order_details' => 'array'
    ];

    protected $appends = [
        'provider',
        'paid_ammount',
        'module_type',
        'handler',
        'invoice_no'
    ];

    protected $with = ['ratings_types', 'rating_values', 'vendor_ratings', 'user'];

    public function getInvoiceNoAttribute(){
        return str_pad($this->id, 7, "0", STR_PAD_LEFT);
    }

    public function getProviderAttribute()
    {
        return User::find($this->provider_user_id);
    }

    public function getModuleTypeAttribute()
    {
        return $this->bookable;
    }

    public function getHandlerAttribute()
    {
        $transaction = Transaction::where('reservation_id', $this->id)->where('paid', 1)->first();
        return $transaction->payment_processor ?? null;
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_user_id');
    }

    public function bookable()
    {
        return $this->morphTo(null, 'bookable', 'bookable_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPaidAmmountAttribute()
    {
        if($this->remaining_amount == $this->grandtotal) {
            return 0;
        }
        else {
            return $this->grandtotal - $this->remaining_amount;
        }
    }

    public function ratings_types(){
        return $this->belongsTo(RatingsTypes::class, 'module_name', 'module_name');
    }

    public function rating_values(){
        return $this->belongsTo(RatingValues::class, 'id', 'booking_id');
    }
    public function vendor_ratings(){
        return $this->belongsTo(VendorRating::class, 'id','booking_id');
    }
}
