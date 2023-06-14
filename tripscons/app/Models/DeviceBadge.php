<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceBadge extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'count',
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
        return url('/admin/device-badges/'.$this->getKey());
    }
}
