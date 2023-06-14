<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceDetail extends Model
{
    protected $fillable = [
        'user_id',
        'device_id',
        'device_token',
        'device_type',
        'status',
    
    ];
    
    
    protected $dates = [
        'updated_at',
        'created_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/device-details/'.$this->getKey());
    }
}
