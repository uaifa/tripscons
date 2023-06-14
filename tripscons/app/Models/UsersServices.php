<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersServices extends Model
{
    use HasFactory;

    protected $table = 'users_services';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','service_id',];

    
}
