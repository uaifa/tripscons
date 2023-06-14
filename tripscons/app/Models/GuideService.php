<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuideService extends Model
{
    use HasFactory;

    protected $table="guide_services";
    protected $primaryKey = "id";

    protected $fillable = [
            'name',
            'image',
            'status',
            'type',
            'module_id',
    ];
}
