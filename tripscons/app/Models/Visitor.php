<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $table = 'visitors';
    protected $primaryKey = 'id';

    protected $fillable = [
            'ip',
            'date',
            'module_name',
            'package_id',
            'hits',
        ];
}


// CREATE TABLE `trips`.`visitors` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `date` DATE NOT NULL , `module_name` VARCHAR(255) NOT NULL , `package_id` INT(11) NOT NULL , `hits` INT(11) NOT NULL DEFAULT '0' , `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;
