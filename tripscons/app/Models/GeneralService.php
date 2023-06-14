<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class GeneralService extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'general_services';
    protected $primaryKey = 'id';

    protected $with = [];

    protected $fillable = [
        'name',
        'image',
        'module',
        'module_id',
        'status',
        'sort_order',
        'description',

    ];

    // return $this->belongsToMany('App\Product', 'products_shops');

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'users_services',
            'service_id',
            'user_id'
        )->select('users.id');
    }

    public function userServices()
    {
        return $this->belongsToMany(GeneralService::class, UsersServices::class, 'user_id', 'service_id')->take(1);
    }
}
