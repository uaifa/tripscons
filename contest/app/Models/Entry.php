<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $withCount = ['comments'];

    public function scopePopular($query)
    {
        return $query->orderByDesc('votes');
    }

    public function scopeRecent($query)
    {
        return $query->orderByDesc('created_at');
    }

    public function scopeOldest($query)
    {
        return $query->orderBy('created_at');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
        // ->whereNull('parent_id');
    }
}
