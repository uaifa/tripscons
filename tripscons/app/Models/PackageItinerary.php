<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageItinerary extends Model
{
    use HasFactory;

    protected $table ='package_itinerary';
    protected $primaryKey = 'id';

    protected $fillable = ['time', 'activity', 'destination', 'date'];

    protected $visible = ['time', 'activity', 'destination', 'date'];

}
