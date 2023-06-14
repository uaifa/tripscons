<?php

namespace App\Models;

use Illuminate\Support\Env;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Laravel\Fortify\TwoFactorAuthenticatable;
use App\Events\UserRegistration;
use App\Events\ConfirmationLink;


class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
    // use TwoFactorAuthenticatable;

    const MESSAGE = 'Host Service Booked Successfully';
    const TYPE = 'BOOKING';
    const TYPE_REGISTER = 'USER_REGISTER';
    const TYPE_BLOCKED = 'USER_BLOCKED';
    const TYPE_BOOKING = 'BOOKING';
    const TYPE_BOOKING_CONFIRM = 'BOOKING_CONFIRM';
    const TYPE_BOOKING_CANCEL = 'BOOKING_CANCEL';
    const TYPE_BOOKING_ACCEPT = 'BOOKING_ACCEPT';
    const TYPE_PROFILE = 'PROFILE';
    const TYPE_ACCOMMODATION = 'ACCOMMODATION';
    const TYPE_VEHICLE = 'VEHICLE';
    const TYPE_VISA = 'VISA';
    const TYPE_MEDIA = 'MEDIA';
    const TYPE_TRIP_OPERATOR = 'TRIP_OPERATOR';
    const TYPE_PACKAGE = 'PACKAGE';
    const TYPE_COMPANY = 'COMPANY';
    const TYPE_TEAM = 'TEAM';
    const TYPE_PLACE = 'PLACE';
    const TYPE_TRIP_MATE = 'TRIP_MATE';
    const TYPE_TRIP_MATE_INVITATION = 'TRIP_MATE_INVITATION';
    const TYPE_TRIP_MATE_INVITATION_ACCEPT = 'TRIP_MATE_INVITATION_ACCEPT';
    const TYPE_TRIP_MATE_INVITATION_REJECT = 'TRIP_MATE_INVITATION_REJECT';
    const TYPE_TRIP = 'TRIP';
    const TYPE_ACTIVITY = 'ACTIVITY';
    const TYPE_EXPERTISE = 'EXPERTISE';
    const TYPE_RESTAURANT = 'RESTAURANT';
    const TYPE_GUIDE = 'GUIDE';
    const TYPE_SERVICE_PROVIDER = 'SERVICE_PROVIDER';
    const TYPE_RATING_REVIEW = 'RATING_REVIEW';
    const TYPE_VENDOR_RATING_REVIEW = 'VENDOR_RATING_REVIEW';
    const TYPE_MEAL = 'MEAL';
    const TYPE_EXPERIENCE = 'EXPERIENCE';
    const TYPE_VERIFIED = 'VERIFIED';
    const ACTION = 'send/host/notification';
    const STATUS = 'SENT';
    const TITLE = 'Host Reservation';
    const TYPE_DOCUMENT = 'DOCUMENT';
    const ADMIN_ID = 1;
    const ADMIN_ROLE_ID = 1;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'email', 'status', 'postal_code', 'address', 'country_code', 'email_verified_at', 'provider_id', 'provider', 'type', 'pin_code', 'gender', 'phone', 'phone_verified_at', 'is_phone_verified', 'state_id', 'city_id', 'country', 'state', 'city', 'country_short_name', 'state_short_name', 'city_short_name', 'longitude', 'latitude', 'password', 'token', 'about', 'tag_line', 'name', 'role_status', 'role_id', 'username', 'hourly_rate', 'is_host', 'currency_id', 'verified', 'date_of_birth', 'per_day_rate', 'is_mate', 'host_out_of_city', 'api_token', 'phone_code', 'is_profile_complete', 'role_profile_id',
        'device_type', 'device_token', 'social_platform', 'social_platform_id', 'image', 'is_company', 'expert_consultancy', 'nationality', 'tagline', 'is_individual', 'switchProfile', 'is_offer_promotion_discount', 'promotion_discount', 'detail_address', 'detail_address_lat', 'detail_address_lng', 'plain_text', 'is_password_changed', 'restaurant_location', 'restaurant_lat', 'restaurant_lng', 'is_profile_verify', 'is_logout'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token', 'api_token',
    ];
    // , 'api_token', 'email'

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'date_of_birth'  => 'date:d-m-Y',
        // 'date_of_birth' => 'date:Y-m-d',
        'type' => 'integer',
        'switchProfile' => 'integer'
    ];

    protected $dates = [
        // 'date_of_birth',
        'email_verified_at',
        'phone_verified_at',
        'created_at',
        'updated_at',
        'trial_ends_at',

    ];

    protected $withCount = ['ratings', 'awesomeRatings', 'excellentRatings', 'averagesRatings', 'badRatings', 'terribleRatings', 'rating_values', 'awesomeRatingsValue', 'excellentRatingsValue', 'averagesRatingsValue', 'badRatingsValue', 'terribleRatingsValue', 'reservation', 'accommodations', 'vehicles', 'meals', 'experiences', 'trips_reservation', 'trips_vendor_ratings', 'participants', 'trip_mate'];


    protected $appends = ['resource_url'];

    // public $with_relations;

    // ratings
    protected $with = ['policies', 'userServices', 'countries', 'galleries', 'company', 'rules', 'ratings_types', 'cancellation_policy', 'activity', 'participants', 'activitiesWeDo'];


    protected $dispatchesEvents = [
        // 'created' =>  ConfirmationLink::class, //UserRegistration::class

        // 'created' => event(new UserRegistration($this->model, request()->all()))
    ];


    public function getIsOfferPromotionDiscount($value)
    {
        return (int)$value;
    }

    public function getTaglineAttribute($value)
    {
        return $value != null ? $value : '';
    }
    public function getAboutAttribute($value)
    {
        return $value != null ? $value : '';
    }

    public function rules()
    {
        return $this->hasMany(Rule::class, 'module_id', 'id')->where('module_name', 'user_profile');
    }

    public static function getUserToken($userId)
    {
        return self::find($userId)['api_token'];
    }
    public function activity()
    {
        return $this->hasMany(UserActivity::class, 'user_id', 'id');
    }
    // public function activity(){
    //     return $this->hasMany(UserActivity::class,'user_id', 'id');
    // }

    public function trips()
    {
        return $this->hasMany(Trip::class, 'user_id', 'id')->with('singleImage');
    }
    public function singleImage()
    {
        return $this->hasOne(Image::class, 'module_id', 'id')->where('module', 'a');
    }

    public function generalServices()
    {
        return $this->belongsToMany(User::class, UsersServices::class, 'user_id', 'service_id');
    }
    public function userServices()
    {
        return $this->belongsToMany(GeneralService::class, UsersServices::class, 'user_id', 'service_id')->take(1);
    }

    public function ServiceProviderRates()
    {
        return $this->hasOne(ServiceProviderRate::class, 'user_id');
    }
    //  guides
    public function guides()
    {
        return $this->hasMany('App\Models\Guide', 'user_id', 'id');
    }

    public function activitiesWeDo()
    {
        return $this->belongsToMany(ActivitiesWeDo::class, 'users_activities_we_do', 'user_id', 'activities_we_do_id');
    }
    public function ourExpertise()
    {
        return $this->belongsToMany(OurExpertise::class, 'users_our_expertises', 'user_id', 'our_expertise_id');
    }

    public function transportCompanyFleet()
    {
        return $this->belongsToMany(TransportCompanyFleet::class, 'users_transport_company_fleets', 'user_id', 'transport_company_fleet_id');
    }
    public function transportCompanyService()
    {
        return $this->belongsToMany(TransportCompanyService::class, 'users_transport_company_services', 'user_id', 'transport_company_service_id');
    }

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/users/' . $this->getKey());
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'provider_id', 'id');
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class, 'users_countries', 'user_id', 'country_id');
    }

    public function our_teams()
    {
        return $this->hasMany(OurTeam::class, 'user_id', 'id');
    }

    public function awesomeRatings()
    {

        return $this->hasMany(Rating::class, 'provider_id', 'id')
            ->where('average_rating', '<', 6)
            ->where('average_rating', '>=', 5)
            ->whereIn('ratings.module_name', ['guides', 'movie_makers', 'trips', 'visa_consultants', 'photographers', 'trip_mates', 'trip_operators', 'guideprofile']);
    }
    public function excellentRatings()
    {

        return $this->hasMany(Rating::class, 'provider_id', 'id')
            ->where('average_rating', '<', 5)
            ->where('average_rating', '>=', 4)
            ->whereIn('ratings.module_name', ['guides', 'movie_makers', 'trips', 'visa_consultants', 'photographers', 'trip_mates', 'trip_operators', 'guideprofile']);
    }
    public function averagesRatings()
    {

        return $this->hasMany(Rating::class, 'provider_id', 'id')
            ->where('average_rating', '<', 4)
            ->where('average_rating', '>=', 3)
            ->whereIn('ratings.module_name', ['guides', 'movie_makers', 'trips', 'visa_consultants', 'photographers', 'trip_mates', 'trip_operators', 'guideprofile']);
    }
    public function badRatings()
    {

        return $this->hasMany(Rating::class, 'provider_id', 'id')
            ->where('average_rating', '<', 3)
            ->where('average_rating', '>=', 2)
            ->whereIn('ratings.module_name', ['guides', 'movie_makers', 'trips', 'visa_consultants', 'photographers', 'trip_mates', 'trip_operators', 'guideprofile']);
    }
    public function terribleRatings()
    {

        return $this->hasMany(Rating::class, 'provider_id', 'id')
            ->where('average_rating', '<', 2)
            ->where('average_rating', '>=', 1)
            ->whereIn('ratings.module_name', ['guides', 'movie_makers', 'trips', 'visa_consultants', 'photographers', 'trip_mates', 'trip_operators', 'guideprofile']);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'user_id', 'id');
    }

    public function trip_mates()
    {
        return $this->hasMany(TripMate::class, 'user_id', 'id');
    }
    public function trip_mate()
    {
        return $this->hasMany(TripMate::class, 'user_id', 'id')->whereDate('date_from', ">=", date('Y-m-d'));
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'user_id');
    }

    public function rating_values()
    {

        $date_plug_14 = date_create(date('Y-m-d', strtotime('-14 days')))->format('Y-m-d');

        if (isset(request()->user_module_type) && (request()->user_module_type == 'trip_operators' || request()->user_module_type == 'travel_agency' || request()->user_module_type == 'restaurants' || request()->user_module_type == 'meals' || request()->user_module_type == 'home_cheff')) {
            return $this->hasMany(RatingValues::class, 'provider_id', 'id')->whereIn('module_name', ['accommodations', 'experiences', 'guides', 'meals', 'movie_makers', 'transports', 'trips', 'visa_consultants', 'events', 'photographers', 'restaurants', 'trip_mates', 'trip_operators', 'hosts', 'vehicles', 'home_cheff', 'travel_agency', 'user_profile', 'transport_company'])->whereIn('rating_type', ['Package Booking', 'Meal Booking', ''])
                ->where(function ($q) use ($date_plug_14) {
                    $q->whereHas('vendor_ratings');
                    $q->orWhereDate('date_to', '<=', Carbon::create($date_plug_14));
                })
                ->orderBy('id', 'DESC');
        } else if (!empty(auth()->user()) && (auth()->user()->user_module_type == 'trip_operators' || auth()->user()->user_module_type == 'travel_agency' || auth()->user()->user_module_type == 'restaurants' || auth()->user()->user_module_type == 'meals' || auth()->user()->user_module_type == 'home_cheff')) {
            return $this->hasMany(RatingValues::class, 'provider_id', 'id')->whereIn('module_name', ['accommodations', 'experiences', 'guides', 'meals', 'movie_makers', 'transports', 'trips', 'visa_consultants', 'events', 'photographers', 'restaurants', 'trip_mates', 'trip_operators', 'hosts', 'vehicles', 'home_cheff', 'travel_agency', 'user_profile', 'transport_company'])->whereIn('rating_type', ['Package Booking', 'Meal Booking', ''])
                ->where(function ($q) use ($date_plug_14) {
                    $q->whereHas('vendor_ratings');
                    $q->orWhereDate('date_to', '<=', Carbon::create($date_plug_14));
                })
                ->orderBy('id', 'DESC');
        } else {
            return $this->hasMany(RatingValues::class, 'provider_id', 'id')->whereIn('module_name', ['accommodations', 'experiences', 'guides', 'meals', 'movie_makers', 'transports', 'trips', 'visa_consultants', 'events', 'photographers', 'restaurants', 'trip_mates', 'trip_operators', 'hosts', 'vehicles', 'home_cheff', 'travel_agency', 'user_profile', 'transport_company'])->whereIn('rating_type', ['Service Provider Booking', 'Meal Booking', 'Accomodation Booking', 'Transport/Vehicle', 'Hotel Room Booking', 'Activity Booking', 'accommodations', 'meals', 'transports', 'experiences', 'Transport/Vehicle Booking', 'Package Booking', 'User'])
                ->where(function ($q) use ($date_plug_14) {
                    $q->whereHas('vendor_ratings');
                    $q->orWhereDate('date_to', '<=', Carbon::create($date_plug_14));
                })
                ->orderBy('id', 'DESC');
        }
    }

    public function awesomeRatingsValue()
    {
        if (isset(request()->user_module_type) && (request()->user_module_type == 'trip_operators' || request()->user_module_type == 'travel_agency' || request()->user_module_type == 'restaurants')) {
            return $this->hasMany(RatingValues::class, 'provider_id', 'id')
                ->where('average_rating', '<=', 5)
                ->where('average_rating', '>', 4)
                ->whereIn('rating_values.module_name', ['accommodations', 'experiences', 'guides', 'meals', 'movie_makers', 'transports', 'trips', 'visa_consultants', 'events', 'photographers', 'restaurants', 'trip_mates', 'trip_operators', 'hosts', 'vehicles', 'home_cheff', 'travel_agency', 'user_profile', 'transport_company'])->whereIn('rating_type', ['Package Booking', 'Meal Booking']);
        } else {
            return $this->hasMany(RatingValues::class, 'provider_id', 'id')
                ->where('average_rating', '<=', 5)
                ->where('average_rating', '>', 4)
                ->whereIn('rating_values.module_name', ['accommodations', 'experiences', 'guides', 'meals', 'movie_makers', 'transports', 'trips', 'visa_consultants', 'events', 'photographers', 'restaurants', 'trip_mates', 'trip_operators', 'hosts', 'vehicles', 'home_cheff', 'travel_agency', 'user_profile', 'transport_company'])->where('rating_type', 'Service Provider Booking');
        }
    }
    public function excellentRatingsValue()
    {
        if (isset(request()->user_module_type) && (request()->user_module_type == 'trip_operators' || request()->user_module_type == 'travel_agency' || request()->user_module_type == 'restaurants')) {
            return $this->hasMany(RatingValues::class, 'provider_id', 'id')
                ->where('average_rating', '<=', 4)
                ->where('average_rating', '>', 3)
                ->whereIn('rating_values.module_name', ['accommodations', 'experiences', 'guides', 'meals', 'movie_makers', 'transports', 'trips', 'visa_consultants', 'events', 'photographers', 'restaurants', 'trip_mates', 'trip_operators', 'hosts', 'vehicles', 'home_cheff', 'travel_agency', 'user_profile', 'transport_company'])->whereIn('rating_type', ['Package Booking', 'Meal Booking']);
        } else {
            return $this->hasMany(RatingValues::class, 'provider_id', 'id')
                ->where('average_rating', '<=', 4)
                ->where('average_rating', '>', 3)
                ->whereIn('rating_values.module_name', ['accommodations', 'experiences', 'guides', 'meals', 'movie_makers', 'transports', 'trips', 'visa_consultants', 'events', 'photographers', 'restaurants', 'trip_mates', 'trip_operators', 'hosts', 'vehicles', 'home_cheff', 'travel_agency', 'user_profile', 'transport_company'])->where('rating_type', 'Service Provider Booking');
        }
    }
    public function averagesRatingsValue()
    {
        if (isset(request()->user_module_type) && (request()->user_module_type == 'trip_operators' || request()->user_module_type == 'travel_agency' || request()->user_module_type == 'restaurants')) {
            return $this->hasMany(RatingValues::class, 'provider_id', 'id')
                ->where('average_rating', '<=', 3)
                ->where('average_rating', '>', 2)
                ->whereIn('rating_values.module_name', ['accommodations', 'experiences', 'guides', 'meals', 'movie_makers', 'transports', 'trips', 'visa_consultants', 'events', 'photographers', 'restaurants', 'trip_mates', 'trip_operators', 'hosts', 'vehicles', 'home_cheff', 'travel_agency', 'user_profile', 'transport_company'])->whereIn('rating_type', ['Package Booking', 'Meal Booking']);
        } else {
            return $this->hasMany(RatingValues::class, 'provider_id', 'id')
                ->where('average_rating', '<=', 3)
                ->where('average_rating', '>', 2)
                ->whereIn('rating_values.module_name', ['accommodations', 'experiences', 'guides', 'meals', 'movie_makers', 'transports', 'trips', 'visa_consultants', 'events', 'photographers', 'restaurants', 'trip_mates', 'trip_operators', 'hosts', 'vehicles', 'home_cheff', 'travel_agency', 'user_profile', 'transport_company'])->where('rating_type', 'Service Provider Booking');
        }
    }
    public function badRatingsValue()
    {
        if (isset(request()->user_module_type) && (request()->user_module_type == 'trip_operators' || request()->user_module_type == 'travel_agency' || request()->user_module_type == 'restaurants')) {
            return $this->hasMany(RatingValues::class, 'provider_id', 'id')
                ->where('average_rating', '<=', 2)
                ->where('average_rating', '>', 1)
                ->whereIn('rating_values.module_name', ['accommodations', 'experiences', 'guides', 'meals', 'movie_makers', 'transports', 'trips', 'visa_consultants', 'events', 'photographers', 'restaurants', 'trip_mates', 'trip_operators', 'hosts', 'vehicles', 'home_cheff', 'travel_agency', 'user_profile', 'transport_company'])->whereIn('rating_type', ['Package Booking', 'Meal Booking']);
        } else {
            return $this->hasMany(RatingValues::class, 'provider_id', 'id')
                ->where('average_rating', '<=', 2)
                ->where('average_rating', '>', 1)
                ->whereIn('rating_values.module_name', ['accommodations', 'experiences', 'guides', 'meals', 'movie_makers', 'transports', 'trips', 'visa_consultants', 'events', 'photographers', 'restaurants', 'trip_mates', 'trip_operators', 'hosts', 'vehicles', 'home_cheff', 'travel_agency', 'user_profile', 'transport_company'])->where('rating_type', 'Service Provider Booking');
        }
    }
    public function terribleRatingsValue()
    {
        if (isset(request()->user_module_type) && (request()->user_module_type == 'trip_operators' || request()->user_module_type == 'travel_agency' || request()->user_module_type == 'restaurants')) {
            return $this->hasMany(RatingValues::class, 'provider_id', 'id')
                ->where('average_rating', '<=', 1)
                ->where('average_rating', '>', 0)
                ->whereIn('rating_values.module_name', ['accommodations', 'experiences', 'guides', 'meals', 'movie_makers', 'transports', 'trips', 'visa_consultants', 'events', 'photographers', 'restaurants', 'trip_mates', 'trip_operators', 'hosts', 'vehicles', 'home_cheff', 'travel_agency', 'user_profile', 'transport_company'])->whereIn('rating_type', ['Package Booking', 'Meal Booking']);
        } else {
            return $this->hasMany(RatingValues::class, 'provider_id', 'id')
                ->where('average_rating', '<=', 1)
                ->where('average_rating', '>', 0)
                ->whereIn('rating_values.module_name', ['accommodations', 'experiences', 'guides', 'meals', 'movie_makers', 'transports', 'trips', 'visa_consultants', 'events', 'photographers', 'restaurants', 'trip_mates', 'trip_operators', 'hosts', 'vehicles', 'home_cheff', 'travel_agency', 'user_profile', 'transport_company'])->where('rating_type', 'Service Provider Booking');
        }
    }

    public function ratings_types()
    {
        return $this->belongsTo(RatingsTypes::class, 'user_module_type', 'module_name');
    }

    public function cancellation_policy()
    {
        return $this->hasMany('App\Models\CancellationPolicy', 'bookable_id', 'id')->where('bookable', self::class);
    }

    public function policies()
    {
        return $this->hasMany(CancellationPolicy::class, 'bookable_id', 'id')->where('bookable', self::class);
    }

    public function meals_types()
    {
        return $this->belongsTo(MealsTypes::class, 'id', 'user_id');
    }
    public function userDocument()
    {
        return $this->belongsTo(UserDocument::class, 'id', 'user_id');
    }
    public function routeNotificationForFcm()
    {
        return User::where('id', $this->id)->first()->device_token;
    }
    //    public function routeNotificationForFcm()
    //    {
    //        return $this->getDeviceTokens();
    //    }
    //
    //    public function getDeviceTokens()
    //    {
    //        return User::where('id',277)
    //            ->first()->device_token;
    //    }
    public function reservation()
    {
        if(!isset(request()->user_module_type) && !empty(auth()->user()) && !empty(auth()->user()->user_module_type)){
            request()->user_module_type = auth()->user()->user_module_type;
        }

        if (isset(request()->user_module_type) && (request()->user_module_type == 'movie_makers' || request()->user_module_type == 'visa_consultants' || request()->user_module_type == 'photographers' || request()->user_module_type == 'guides' || request()->user_module_type == 'guides' || request()->user_module_type == 'trip_operators' || request()->user_module_type == 'travel_agency')) {
            $model = "App\\Models\\Guide";
            return $this->hasMany(Reservation::class, 'provider_user_id', 'id')->where('bookable', $model);
        }else if(isset(request()->type) && !empty(request()->type) && request()->type == 2 || (request()->user_module_type == 'transport_company' || request()->user_module_type == 'hotels')){
            $model1 = "App\\Models\\Meal";
            $model2 = "App\\Models\\Accommodation";
            $model3 = "App\\Models\\Transport";
            $model4 = "App\\Models\\Experience";

            return $this->hasMany(Reservation::class, 'provider_user_id', 'id')->whereIn('bookable', [$model1,  $model2,  $model3,  $model4]);
        }else if (!empty(auth()->user()) && (int)auth()->user()->type == 2 || (request()->user_module_type == 'transport_company' || request()->user_module_type == 'hotels')) {
            $model1 = "App\\Models\\Meal";
            $model2 = "App\\Models\\Accommodation";
            $model3 = "App\\Models\\Transport";
            $model4 = "App\\Models\\Experience";

            return $this->hasMany(Reservation::class, 'provider_user_id', 'id')->whereIn('bookable', [$model1,  $model2,  $model3,  $model4]);
        } else if (!empty(auth()->user()) && (auth()->user()->user_module_type == 'movie_makers' || auth()->user()->user_module_type == 'visa_consultants' || auth()->user()->user_module_type == 'photographers' || auth()->user()->user_module_type == 'guides' || auth()->user()->user_module_type == 'guides' || auth()->user()->user_module_type == 'trip_operators' || auth()->user()->user_module_type == 'travel_agency')) {
            $model = "App\\Models\\Guide";
            return $this->hasMany(Reservation::class, 'provider_user_id', 'id')->where('bookable', $model);
        } else if ((isset(request()->user_module_type) && request()->user_module_type == 'restaurants')) {
            $model = "App\\Models\\Meal";
            return $this->hasMany(Reservation::class, 'provider_user_id', 'id')->where('bookable', $model);
        } else {
            return $this->hasMany(Reservation::class, 'bookable_id', 'id')->where('bookable', self::class);
        }
    }

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class, 'user_id')->where('is_publish', 1)->where('status', 1);
    }
    public function vehicles()
    {
        return $this->hasMany(Transport::class, 'user_id')->where('is_publish', 1)->where('status', 1);
    }
    public function meals()
    {
        return $this->hasMany(Meal::class, 'user_id')->where('is_publish', 1)->where('status', 1);
    }
    public function experiences()
    {
        return $this->hasMany(Experience::class, 'user_id')->where('is_publish', 1)->where('status', 1);
    }
    public function trips_reservation()
    {
        return $this->hasMany(Reservation::class, 'user_id', 'id')->where('bookable', self::class);
    }
    public function trips_vendor_ratings()
    {
        $date_plug_14 = date_create(date('Y-m-d', strtotime('-14 days')))->format('Y-m-d');

        return $this->hasMany(VendorRating::class, 'user_id', 'id')
            ->where(function ($q) use ($date_plug_14) {
                $q->whereHas('rating_values');
                $q->orWhereDate('date_to', '<=', Carbon::create($date_plug_14));
            });
    }

    public function participants()
    {
        return $this->hasMany(Participant::class, 'user_id', 'id');
    }
}
