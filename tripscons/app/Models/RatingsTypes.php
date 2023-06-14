<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingsTypes extends Model
{
    use HasFactory;


    protected $table = 'ratings_types';
    protected $primaryKey = 'id';

    protected $fillable = [    
        
        'rating_title_1',
        'rating_title_2',
        'rating_title_3',
        'rating_title_4',
        'rating_title_5',
        'module_name',

    ];
}
