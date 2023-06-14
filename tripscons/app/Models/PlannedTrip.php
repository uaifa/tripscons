<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlannedTrip extends Model
{
    use HasFactory;

    protected $casts = [
        'images' => 'array',
        'activities' => 'array',
    ];
}
