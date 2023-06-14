<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportCompanyService extends Model
{
    use HasFactory;

    protected $table = 'transport_company_services';
    protected $primaryKey = 'id';

    protected $fillable = [
                    'name',
                    'status'
        ];
}
