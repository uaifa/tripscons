<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPaymentMethodDetail extends Model
{
    use HasFactory;
    protected $table = 'user_payment_method_details';
    protected $fillable = [

        'bank_name', 'bank_account_title', 'bank_account_number', 'jazzcash_holder_title', 'jazz_cash_number', 'easy_paisa_holder_title','easy_paisa_number','sada_pay_holder_title','sada_pay_number','user_id',
    ];


}
