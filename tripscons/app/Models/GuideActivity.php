<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuideActivity extends Model
{
    use HasFactory;

    protected $table="guide_activities";
    protected $primaryKey = "id";

    protected $fillable = [
            'guide_id',
            'name',
            'image',
            'type',
    ];
}
