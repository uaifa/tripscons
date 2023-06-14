<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class CancellationPolicy extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['model'];

    protected $fillable = [
                        'bookable_id', 
                        'cancellation_hour',   
                        'refund_percentage',   
                        'module_name', 
                        'bookable' 
                    ];
   
    public function getModelAttribute()
    {
        if($this->bookable){
            return (new ReflectionClass((new $this->bookable)))->getShortName();
        }
    }
    public function bookableTo(){
        return $this->morphTo();
    }
    public function bookable()
    {
        return $this->morphTo(null, 'bookable', 'bookable_id');
    }
}
