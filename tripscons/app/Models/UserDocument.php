<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    use HasFactory;
    protected $fillable = [

        'user_id', 'type', 'expiry', 'front', 'back', 'identitity_number',
    ];
}