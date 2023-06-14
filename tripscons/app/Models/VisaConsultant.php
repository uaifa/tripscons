<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaConsultant extends Model
{
    use HasFactory;
    public function images(){
        return $this->hasMany(Image::class,'module_id', 'id')->where('module','visaconsultant')->where('type','!=','video');
        //->select(['name','type','module'])  check why not working soon
        }
        public function video(){
            return $this->hasMany(Image::class,'module_id', 'id')->where('module','visaconsultant')->where('type','video');
           
            }
        public function singleImage(){
           return $this->hasOne(Image::class,'module_id', 'id')->where('module','visaconsultant')->where('type','!=','video');     
        }
        public function general_service(){
            return $this->hasMany(GeneralService::class,'module_id', 'id')->where('module','visaconsultant');
           }
           public function general_country(){
            return $this->hasMany(GeneralCountry::class,'module_id', 'id')->where('module','visaconsultant');
           }
           
     
}

