<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    use HasFactory;
    
    protected $fillable = [
    	'type',
      	'vendor_id',
      	'service_title',
      	'service_id',
      	'service_url',
      	'client_email',
      	'client_id',
      	'vendor_phone',
      	'vendor_email',
      	'client_phone',
    ];
}
