<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MakeEnquiry extends Model
{
    use HasFactory;

    protected $table ='make_enquiries';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'email', 'phone_number', 'enquiry_detail', 'user_id', 'status', 'user_module_type'];
}
