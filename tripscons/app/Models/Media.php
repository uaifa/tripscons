<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    public function images(){
        return $this->hasMany(Image::class,'module_id', 'id')->where('module','moviemaker')->where('type','!=','video');
       
        }
    public function singleImage(){
           return $this->hasOne(Image::class,'module_id', 'id')->where('module','moviemaker')->where('type','!=','video');  
        }
    public function video(){
            return $this->hasMany(Image::class,'module_id', 'id')->where('module','moviemaker')->where('type','video');
           
            }
       public function general_service(){
       return $this->hasMany(GeneralService::class,'module_id', 'id')->where('module','moviemaker');
      }

       public function  expertiese(){
       return $this->hasMany(MediaSkill::class,'module_id', 'id')->where('module','moviemaker');
        }
}
