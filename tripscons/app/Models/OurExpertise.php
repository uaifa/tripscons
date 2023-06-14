<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurExpertise extends Model
{
    use HasFactory;

    protected $table ='our_expertise';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'status', 'image'];


}
