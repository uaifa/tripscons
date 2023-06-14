<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seodata extends Model
{
    use HasFactory;


    protected $table = 'seo_data';
    protected $primaryKey = 'id';

    protected $fillable = [
                    'seo_main_title',
                    'seo_title',
                    'seo_description',
                    'seo_keywords',
                    'seo_canonical',
                    'seo_page_type',
                    'seo_sub_page_type',
                    'user_module_type',  
                    'package_id',  
        ];
}
