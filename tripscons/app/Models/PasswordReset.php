<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['token', 'email'];
}
