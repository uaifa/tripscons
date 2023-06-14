<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageVideo extends Model
{
    use HasFactory;


    protected $table = 'package_videos';
    protected $primaryKey = 'id';

    protected $with = [];

    protected $fillable = [
            'title',
            'url',
            'package_id',
    ];

}
