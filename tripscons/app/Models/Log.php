<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $casts = ['log' => 'array'];
    protected $guarded = [
        'logable_id',
        'logable',
        'log',
    ];
}
