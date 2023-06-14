<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuideProfile extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'tag_line', 'about', 'hourly_rate', 'offer_free_service', 'multi_city_service',
        'start_hourly_time','end_hourly_time'];

    /**
     * @Description Get By profile id
     * @param $id
     * @return array
     * @Author Khuram Qadeer.
     */
    public static function getById($id)
    {
        $res = [];
        $profile = self::find($id);
        if ($profile) {
            $res = $profile;
            $res['skills'] = GuideSkillsLink::getByRefIdAndType($profile->id, 'guide:profile');
            $res['guide_activities'] = ActivityLink::getByRefIdAndType($profile->id, 'guide:profile');
            $res['guide_languages'] = UserLanguage::getByRefIdAndType($profile->id, 'guide:profile');
            $res['knowledge_cities'] = KnowledgeCity::getByRefIdAndType($profile->id, 'guide:profile');
        }
        return $res;
    }
}
