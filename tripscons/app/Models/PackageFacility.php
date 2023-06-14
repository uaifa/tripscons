<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageFacility extends Model
{
    use HasFactory;

    protected $table ='package_facilities';
    protected $primaryKey = 'id';

    protected $fillable = ['title', 'description', 'everything_considered', 'package_id', 'type'];

}
