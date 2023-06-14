<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;


    protected $table = 'companies';
    protected $primaryKey = 'id';

    protected $fillable = [
                    'name',
                    'tag_line',
                    'about',
                    'image',
                    'status',
                    'team_size',
                    'user_id',
                    'is_company_registered',
                    'registration_no',
                    

        ];



    public function getNameAttribute($value)
    {
        return $value != null ? $value : '';
    }
    public function getTagLineAttribute($value)
    {
        return $value != null ? $value : '';
    }
    public function getAboutAttribute($value)
    {
        return $value != null ? $value : '';
    }
    public function getRegistrationNoAttribute($value)
    {
        return $value != null ? $value : '';
    }
    
}
