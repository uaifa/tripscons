<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurTeam extends Model
{
    use HasFactory;

    protected $table = 'our_teams';
    protected $primaryKey ='id';

    public $fillable = [
        'name',
        'image',
        'about',
        'designation',
        'skills',
        'contact',
        'email',
        'dob',
        'status',
        'user_id',
    ];

    protected $casts = [
        // 'dob'  => 'date:d-m-Y',
        'dob' => 'date:Y-m-d'
    ];
}
