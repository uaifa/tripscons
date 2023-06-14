<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * @var string
     */
    protected $table = 'countries';
    protected $primaryKey ='id';

    protected $fillable = [
        'name',    
        'iso3',  
        'numeric_code',    
        'iso2',
        'phonecode',   
        'capital',
        'currency',    
        'currency_name',   
        'currency_symbol', 
        'tld',
        'native',  
        'region',
        'subregion',   
        'timezones', 
        'translations',    
        'latitude',    
        'longitude',  
        'emoji', 
        'emojiu',  
        'created_at',  
        'updated_at',
        'flag',
        'wikiDataId',
    ];

    /**
     * @Description Get By Country name
     * @param $name
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function getByName($name)
    {
        return self::whereName($name)->first();
    }

    public function getEmojiuAttribute()
    {
        $flag_emoji_code = '';
        $emojiu = $this->attributes['emojiu'];
        $emojiu = explode(" ", $emojiu);
        if(!empty($emojiu)){   
            $i = 0;
            foreach ($emojiu as $key => $value) {
                if(!empty($value)){
                    $i++;
                    if($i == 0){
                        $flag_emoji_code = $str_replace("U+", "&#x",$value); 
                    }else{
                        $flag_emoji_code = $flag_emoji_code.str_replace("U+", "&#x",$value).';'; 
                    }
                }
            }
        }
      return trim($flag_emoji_code);
    }

}
