<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivitiesWeDo extends Model
{
    use HasFactory;

    protected $table ='activities_we_do';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'status', 'image'];

}
