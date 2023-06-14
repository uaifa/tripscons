<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TripMate extends Model
{
    const TRIP_MATE ="trip_mate";

    const IMAGE_TYPE1 ="Main";

    const IMAGE_TYPE2 ="Normal";

    const MESSAGE = 'Trip Mate Request Received';

    const TYPE = 'TRIPMATE_INVITATION';

    const ACTION = 'send/tripmate-invitation/notification';

    const STATUS = 'SENT';

    const TITLE = 'Trip Mate Request';

    use SoftDeletes;

    protected $table = 'trip_mate';

    protected $fillable = [
        'user_id',
        'trip_id',
        'pick_up',
        'destination',
        'lat',
        'lng',
        'city',
        'country',
        'date_from',
        'date_to',
        'description',

    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/trip-mates/'.$this->getKey());
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'module_id', 'id')->where('module', TripMate::TRIP_MATE);
    }
    public function single_image()
    {
        return $this->hasOne(Image::class, 'module_id', 'id')->where('module', TripMate::TRIP_MATE);
    }

    public function activities()
    {
        return $this->hasMany(GuideActivity::class, 'guide_id', 'id')->where('type', TripMate::TRIP_MATE);
    }
    public function trip_mate_invitation(){
        return $this->hasMany(TripMateInvitation::class, 'trip_id', 'id');
    }

    public function users(){
        return $this->belongsTo(User::class, 'user_id', 'id');

    }

}
