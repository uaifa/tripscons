<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportCompanyFleet extends Model
{
    use HasFactory;


    protected $table = 'transport_company_fleets';
    protected $primaryKey = 'id';

    protected $fillable = [
                    'name',
                    'status'
        ];
}
