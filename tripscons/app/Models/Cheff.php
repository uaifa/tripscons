<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cheff extends Model
{
    use HasFactory;

    protected $table = 'cheffs';
    protected $primaryKey = 'id';

    protected $fillable = [
                    'title',
                    'image',
                    'menu',
                    'location',
                    'user_id',
                    'lat',
                    'lng',
                    'city',
                    'country',

        ];

  
}
