<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    use HasFactory;

    const IMAGE_CONTEST = 1;
    const VIDEO_CONTEST = 2;

    const STATUS_ACTIVE = 'active';
    const STATUS_CLOSE = 'close';
    const STATUS_REWARD_ANNOUNCE = 'reward_announce';

    protected $casts = [
        'winner_list' => 'array',
    ];
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
}
