<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SmsController;
use App\Libs\Inquiry\Trip;
use App\Libs\Inquiry\Vehicle;
use App\Mail\InquiryEmail;
use App\Models\Accommodation;
use App\Models\Experience;
use App\Models\Guide;
use App\Models\Transport;
use App\Models\User;
use App\Traits\RadiusDistanceTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\CheckBookingMail;
use App\Models\Reservation;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\FacadesDB;
use Illuminate\Support\Facades\Redirect;
use App\Mail\SendAppLinksEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    use RadiusDistanceTrait;

    protected $status = 200;
    protected $response = [];

    public function index(Request $request)
    {
        /*
        @10-12-21
        @Rehan Hussain
         */
        //fetch four guides
        $ldate = date('Y-m-d');

        $lat = isset($request->lat) ? round($request->lat, 8) : 0;
        $lng = isset($request->lng) ? round($request->lng, 8) : 0;
        $rad = isset($request->radius) ? (int)$request->radius : 0;

        $rad = floor($rad / 1000);


        $distance_result = 'ROUND(DEGREES(ACOS(SIN(RADIANS(' . $lat . ')) 
                    * SIN(RADIANS(lat)) 
                    + COS(RADIANS(' . $lat . '))  
                    * COS(RADIANS(lat))
                    * COS(RADIANS(' . $lng . ' - lng)))) * 69.09)';

        $guide_distance_result = 'ROUND(DEGREES(ACOS(SIN(RADIANS(' . $lat . ')) 
                    * SIN(RADIANS(latitude_to)) 
                    + COS(RADIANS(' . $lat . '))  
                    * COS(RADIANS(latitude_to))
                    * COS(RADIANS(' . $lng . ' - longitude_to)))) * 69.09)';

        $guides = Guide::query()
                    ->select('id', 'is_offer_promotion_discount', 'is_free_guide as is_free_service', 'promotion_discount', 'location', 'title', 'price')
                    ->withAvg('rating_values', 'average_rating')
                    ->withCount('rating_values')
                    ->with([
                        'rating_values',
                        'destination',
                        'services',
                        'guide_user',
                        // Add other necessary relationships here
                    ])
                    ->where('is_published', 1)
                    ->where('status', 1)
                    ->where(function ($query) use ($ldate) {
                        $query->where('is_day_wise_trip', 0)->whereDate('end_date', '>=', $ldate)
                            ->orWhere('is_day_wise_trip', 1);
                    })
                    ->whereIn('user_module_type', ['trip_operators', 'trips', 'guides', 'travel_agency'])
                    ->when(!empty($guide_distance_result), function ($query) use ($guide_distance_result, $rad) {
                        if (!empty($rad)) {
                            $query->selectRaw("{$guide_distance_result} AS distance")
                                ->whereRaw("{$guide_distance_result} < ?", [$rad])
                                ->orderBy('distance');
                        } else {
                            $query->addSelect(DB::raw($guide_distance_result . " as distance"))
                                ->orderBy(DB::raw($guide_distance_result));
                        }
                    })
                    ->orderBy('id', 'DESC')
                    ->take(4)
                    ->get();

       $guides = $guides->map(function ($guide) {

            return [
                'id' => $guide['id'],
                'is_offer_promotion_discount' => $guide['is_offer_promotion_discount'],
                'is_free_service' => $guide['is_free_service'] ?? null,
                'single_image' => $guide['single_image'],
                'promotion_discount' => $guide['promotion_discount'],
                'location' => $guide['location'],
                'title' => $guide['title'],
                'rating_values_avg_average_rating' => $guide['rating_values_avg_average_rating'] ?? null,
                'rating_values_count' => $guide['rating_values_count'],
                'price' => $guide['price'],
                'distance' => $guide['distance'],
            ];
        });
        //fetch four activities
        $activities = Experience::query()
                    ->select('id', 'title', 'is_offer_promotion_discount', 'age_limit_for_child_free', 'promotion_discount', 'location', 'detail_location')
                    ->withAvg('ratings', 'average_rating')
                    ->withAvg('rating_values', 'average_rating')
                    ->withAvg('trips_vendor_ratings', 'rating_value')
                    ->withCount('rating_values')
                    ->with('singleImage')
                    ->where('is_publish', 1)
                    ->where('status', 1)
                    ->when(!empty($distance_result), function ($query) use ($distance_result, $rad) {
                        if (!empty($rad)) {
                            $query->selectRaw("{$distance_result} AS distance")
                                ->whereRaw("{$distance_result} < ?", [$rad])
                                ->orderBy('distance');
                        } else {
                            $query->addSelect(DB::raw($distance_result . " as distance"))
                                ->orderBy(DB::raw($distance_result));
                        }
                    })
                    ->orderBy('id', 'DESC')
                    ->take(4)
                    ->get();
       
        $activities = $activities->map(function ($activity) {
            return [
                'id' => $activity['id'],
                'is_offer_promotion_discount' => $activity['is_offer_promotion_discount'],
                'is_free_service' => $activity['is_free_service'] ?? null,
                'single_image' => $activity['singleImage'],
                'promotion_discount' => $activity['promotion_discount'],
                'location' => $activity['location'] ?? null,
                'detail_location' => $activity['detail_location'] ?? null,
                'rating_values_avg_average_rating' => $activity['rating_values_avg_average_rating'] ?? null,
                'rating_values_count' => $activity['rating_values_count'],
                'title' => $activity['title'],
                'distance' => $activity['distance'],
            ];
        });

        //fetch ist four accomudations
        $accomudations = Accommodation::query()
                    ->select('id', 'title', 'is_offer_promotion_discount', 'promotion_discount', 'location', 'no_of_people', 'detail_location', 'per_night')
                    ->withOut(['ratings', 'ratings_types', 'rating_values', 'singleImage', 'policies', 'User'])
                    ->with(['ratings', 'ratings_types', 'rating_values', 'singleImage', 'policies', 'User'])
                    ->withAvg('ratings', 'average_rating')
                    ->withAvg('rating_values', 'average_rating')
                    ->withAvg('trips_vendor_ratings', 'rating_value')
                    ->withCount('rating_values')
                    ->with('singleImage')
                    ->where('is_publish', 1)
                    ->where('status', 1)
                    ->when(!empty($distance_result), function ($query) use ($distance_result, $rad) {
                        if (!empty($rad)) {
                            $query->selectRaw("{$distance_result} AS distance")
                                ->whereRaw("{$distance_result} < ?", [$rad])
                                ->orderBy('distance');
                        } else {
                            $query->addSelect(DB::raw($distance_result . " as distance"))
                                ->orderBy(DB::raw($distance_result));
                        }
                    })
                    ->whereNotNull('lat')
                    ->whereNotNull('lng')
                    ->orderBy('id', 'DESC')
                    ->take(4)
                    ->get();


        $accomudations = $accomudations->map(function ($accomudation) {
            return [
                'id' => $accomudation['id'],
                'is_offer_promotion_discount' => $accomudation['is_offer_promotion_discount'],
                'is_free_service' => $accomudation['is_free_service'] ?? null,
                'single_image' => $accomudation['single_image'],
                'promotion_discount' => $accomudation['promotion_discount'],
                'location' => $accomudation['location'] ?? null,
                'rating_values_avg_average_rating' => $accomudation['rating_values_avg_average_rating'] ?? null,
                'rating_values_count' => $accomudation['rating_values_count'],
                'no_of_people' => $accomudation['no_of_people'],
                'detail_location' => $accomudation['detail_location'],
                'title' => $accomudation['title'],
                'per_night' => $accomudation['per_night'],
                'distance' => $accomudation['distance'],
            ];
        });

      
        //fetch ist three trips
        $trips = Guide::query()
                        ->select('id', 'title', 'location', 'location_to', 'price')
                        ->withAvg('rating_values', 'average_rating')
                        ->withAvg('trips_vendor_ratings', 'rating_value')
                        ->withAvg('ratingsProfile', 'average_rating')
                        ->withCount('rating_values')
                        ->withCount('reservation')
                        ->where('is_published', 1)
                        ->where('status', 1)
                        ->where(function ($query) use ($ldate) {
                            $query->where(function ($query) use ($ldate) {
                                $query->where('is_day_wise_trip', 0)
                                    ->whereDate('end_date', '>=', $ldate);
                            })
                            ->orWhere('is_day_wise_trip', 1);
                        })
                        ->when(!empty($guide_distance_result), function ($query) use ($guide_distance_result, $rad) {
                            if (!empty($rad)) {
                                $query->selectRaw("{$guide_distance_result} AS distance")
                                    ->whereRaw("{$guide_distance_result} < ?", [$rad])
                                    ->orderBy('distance');
                            } else {
                                $query->addSelect(DB::raw($guide_distance_result . " as distance"))
                                    ->orderBy(DB::raw($guide_distance_result));
                            }
                        })
                        ->whereIn('user_module_type', ['trip_operators', 'trips'])
                        ->orderBy('id', 'DESC')
                        ->take(4)
                        ->get();

        $trips = $trips->map(function ($trip) {
            return [
                'id' => $trip['id'],
                'image' => $trip['single_image'],
                'location' => $trip['location'],
                'location_to' => $trip['location_to'],
                'price' => $trip['price'],
                'title' => $trip['title'],
                'ratings_types' => $trip['ratings_types'],
                'rating_values' => $trip['rating_values'],
                'reservation_count' => $trip['reservation_count'],
                'rating_values_count' => $trip['rating_values_count'],
                'rating_values_avg_average_rating' => $trip['rating_values_avg_average_rating'],
                'distance' => $trip['distance'],
            ];
        });

  
        //fetch ist four transports
        $transposrts = Transport::query()
                        ->select('id', 'title', 'is_offer_promotion_discount', 'promotion_discount', 'location', 'detail_location', 'no_of_people', 'per_day_price', 'hourly_price', 'intercity_per_day_price', 'intercity_per_day_extra_milage_price', 'intercity_multiple_day_price', 'intercity_multiple_day_extra_milage_price', 'outofcity_per_day_price')
                    ->withAvg('ratings', 'average_rating')
                    ->withAvg('rating_values', 'average_rating')
                    ->withAvg('trips_vendor_ratings', 'rating_value')
                    ->withCount('rating_values')
                    ->withCount('reservation')
                    ->withCount('images')
                    ->with('singleImage')
                    ->when(!empty($distance_result), function ($query) use ($distance_result, $rad) {
                        if (!empty($rad)) {
                            $query->selectRaw("{$distance_result} AS distance")
                                ->whereRaw("{$distance_result} < ?", [$rad])
                                ->orderBy('distance');
                        } else {
                            $query->addSelect(DB::raw($distance_result . " as distance"))
                                ->orderBy(DB::raw($distance_result));
                        }
                    })
                    ->having('images_count', '>', 0)
                    ->where('is_publish', 1)
                    ->where('status', 1)
                    ->orderBy('id', 'DESC')
                    ->take(4)
                    ->get();

        $transposrts = $transposrts->map(function ($transport) {
            return [
                'id' => $transport['id'],
                'is_offer_promotion_discount' => $transport['is_offer_promotion_discount'],
                'is_free_service' => $transport['is_free_service'] ?? null,
                'single_image' => $transport['single_image'],
                'promotion_discount' => $transport['promotion_discount'],
                'location' => $transport['location'] ?? null,
                'rating_values_avg_average_rating' => $transport['rating_values_avg_average_rating'] ?? null,
                'rating_values_count' => $transport['rating_values_count'],
                'no_of_people' => $transport['no_of_people'],
                'detail_location' => $transport['detail_location'],
                'title' => $transport['title'],
                'per_day_price' => $transport['per_day_price'],
                'hourly_price' => $transport['hourly_price'],
                'intercity_per_day_price' => $transport['intercity_per_day_price'],
                'intercity_per_day_extra_milage_price' => $transport['intercity_per_day_extra_milage_price'],
                'intercity_multiple_day_price' => $transport['intercity_multiple_day_price'],
                'intercity_multiple_day_extra_milage_price' => $transport['intercity_multiple_day_extra_milage_price'],
                'outofcity_per_day_price' => $transport['outofcity_per_day_price'],
                'ratings_types' => $transport['ratings_types'],
                'rating_values' => $transport['rating_values'],
                'reservation_count' => $transport['reservation_count'],
                'rating_values_count' => $transport['rating_values_count'],
                'rating_values_avg_average_rating' => $transport['rating_values_avg_average_rating'],
                'distance' => $transport['distance'],
            ];
        });

        //fetch ist 6 hosts
        $hosts = User::query()
                    ->select('id', 'name', 'email', 'is_offer_promotion_discount', 'image', 'promotion_discount', 'type', 'address', 'detail_address')
                    ->with(['ServiceProviderRates', 'trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])
                    ->withAvg('ratings', 'average_rating')
                    ->withAvg('rating_values', 'average_rating')
                    ->withAvg('trips_vendor_ratings', 'rating_value')
                    ->withCount(['accommodations', 'vehicles', 'experiences', 'meals', 'rating_values', 'reservation'])
                    ->when(!empty($distance_result), function ($query) use ($distance_result, $rad) {
                        if (!empty($rad)) {
                            $query->selectRaw("{$distance_result} AS distance")
                                ->whereRaw("{$distance_result} < ?", [$rad])
                                ->orderBy('distance');
                        } else {
                            $query->addSelect(DB::raw($distance_result . " as distance"))
                                ->orderBy(DB::raw($distance_result));
                        }
                    })
                    ->where('type', 2)
                    ->orderByRaw('(accommodations_count + vehicles_count + experiences_count + meals_count) DESC')
                    ->take(6)
                    ->get();
            
        
        $hosts = $hosts->map(function ($host) {
            return [
                'id' => $host['id'],
                'is_offer_promotion_discount' => $host['is_offer_promotion_discount'],
                'is_free_service' => $host['is_free_service'] ?? null,
                'image' => $host['image'],
                'promotion_discount' => $host['promotion_discount'],
                'rating_values_avg_average_rating' => $host['rating_values_avg_average_rating'] ?? null,
                'rating_values_count' => $host['rating_values_count'],
                'type' => $host['type'],
                'name' => $host['name'],
                'host_services_count' => ($host['accommodations_count'] + $host['vehicles_count'] + $host['meals_count'] + $host['experiences_count']),
                'address' => $host['address'],
                'detail_address' => $host['detail_address'],

                'ratings_types' => $host['ratings_types'],
                'rating_values' => $host['rating_values'],
                'reservation_count' => $host['reservation_count'],
                'rating_values_count' => $host['rating_values_count'],
                'rating_values_avg_average_rating' => $host['rating_values_avg_average_rating'],
                'distance' => $host['distance'],
            ];
        });

     

        $service_providers = User::query()
                        ->select('id', 'name', 'email', 'is_offer_promotion_discount', 'image', 'promotion_discount', 'type', 'address', 'detail_address', 'country', 'city')
                        ->with(['ServiceProviderRates', 'trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])
                        ->withAvg('ratings', 'average_rating')
                        ->withAvg('rating_values', 'average_rating')
                        ->withAvg('trips_vendor_ratings', 'rating_value')
                        ->withCount(['rating_values', 'reservation'])
                        ->where('user_module_type', 'guides')
                        ->where('type', 1)
                        ->when(!empty($distance_result), function ($query) use ($distance_result, $rad) {
                            if (!empty($rad)) {
                                $query->selectRaw("{$distance_result} AS distance")
                                    ->whereRaw("{$distance_result} < ?", [$rad])
                                    ->orderBy('distance');
                            } else {
                                $query->addSelect(DB::raw($distance_result . " as distance"))
                                    ->orderBy(DB::raw($distance_result));
                            }
                        })
                        ->take(4)
                        ->orderBy('id', 'DESC')
                        ->get();

        $service_providers = $service_providers->map(function ($service_provider) {
            return [
                'id' => $service_provider['id'],
                'is_offer_promotion_discount' => $service_provider['is_offer_promotion_discount'],
                'is_free_service' => $service_provider['is_free_service'] ?? null,
                'image' => $service_provider['image'],
                'promotion_discount' => $service_provider['promotion_discount'],
                'location' => $service_provider['location'] ?? null,
                'rating_values_avg_average_rating' => $service_provider['rating_values_avg_average_rating'] ?? null,
                'rating_values_count' => $service_provider['rating_values_count'],
                'country' => $service_provider['country'],
                'city' => $service_provider['city'],
                'name' => $service_provider['name'],
                'address' => $service_provider['address'],
                'detail_address' => $service_provider['detail_address'],
                'ratings_types' => $service_provider['ratings_types'],
                'rating_values' => $service_provider['rating_values'],
                'reservation_count' => $service_provider['reservation_count'],
                'rating_values_count' => $service_provider['rating_values_count'],
                'rating_values_avg_average_rating' => $service_provider['rating_values_avg_average_rating'],
                'distance' => $service_provider['distance'],
            ];
        });

        // transport_company
        $transport_company = User::query()
                    ->select('id', 'name', 'email', 'is_offer_promotion_discount', 'image', 'promotion_discount', 'type', 'address', 'detail_address', 'country', 'city')
                    ->with(['ServiceProviderRates', 'trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])
                    ->withAvg('rating_values', 'average_rating')
                    ->withAvg('trips_vendor_ratings', 'rating_value')
                    ->withCount(['rating_values', 'reservation'])
                    ->where('user_module_type', 'transport_company')
                    ->where('type', 1)
                    ->when(!empty($distance_result), function ($query) use ($distance_result, $rad) {
                        if (!empty($rad)) {
                            $query->selectRaw("{$distance_result} AS distance")
                                ->whereRaw("{$distance_result} < ?", [$rad])
                                ->orderBy('distance');
                        } else {
                            $query->addSelect(DB::raw($distance_result . " as distance"))
                                ->orderBy(DB::raw($distance_result));
                        }
                    })
                    ->take(4)
                    ->orderBy('id', 'DESC')
                    ->get();
        $transport_company = $transport_company->map(function ($transport_com) {
            return [
                'id' => $transport_com['id'],
                'is_offer_promotion_discount' => $transport_com['is_offer_promotion_discount'],
                'is_free_service' => $transport_com['is_free_service'] ?? null,
                'image' => $transport_com['image'],
                'promotion_discount' => $transport_com['promotion_discount'],
                'location' => $transport_com['location'] ?? null,
                'rating_values_avg_average_rating' => $transport_com['rating_values_avg_average_rating'] ?? null,
                'rating_values_count' => $transport_com['rating_values_count'],
                'country' => $transport_com['country'],
                'city' => $transport_com['city'],
                'name' => $transport_com['name'],
                'address' => $transport_com['address'],
                'detail_address' => $transport_com['detail_address'],
                'ratings_types' => $transport_com['ratings_types'],
                'rating_values' => $transport_com['rating_values'],
                'reservation_count' => $transport_com['reservation_count'],
                'rating_values_count' => $transport_com['rating_values_count'],
                'rating_values_avg_average_rating' => $transport_com['rating_values_avg_average_rating'],
                'company_name' => $transport_com['company'] ? $transport_com['company']['name'] : '',
                'company_logo' => $transport_com['company'] ? $transport_com['company']['image'] : '',
                'distance' => $transport_com['distance'],
            ];
        });

   
        $tripMates = User::query()
                ->select('id', 'name', 'email', 'is_offer_promotion_discount', 'image', 'promotion_discount', 'type', 'address', 'detail_address')
                ->with([
                    'ServiceProviderRates',
                    'trips',
                    'activitiesWeDo',
                    'ourExpertise',
                    'rating_values',
                    'transportCompanyFleet',
                    'transportCompanyService'
                ])
                ->withAvg('trips_vendor_ratings', 'rating_value')
                ->withCount(['rating_values', 'reservation'])
                ->whereHas('trip_mates', function ($q) {
                    $q->whereDate('date_from', '>=', date('Y-m-d'));
                })
                ->when(!empty($distance_result), function ($q) use ($distance_result, $rad) {
                    if (!empty($rad)) {
                        $q->selectRaw("{$distance_result} AS distance")
                            ->whereRaw("{$distance_result} < ?", [$rad])
                            ->orderBy('distance');
                    } else {
                        $q->addSelect(DB::raw($distance_result . " as distance"))
                            ->orderBy(DB::raw($distance_result));
                    }
                })
                ->take(6)
                ->get();


        return response()->json(['guides' => $guides, 'service_providers' => $service_providers, 'transport_company' => $transport_company, 'activities' => $activities, 'accomudations' => $accomudations, 'trips' => $trips, 'transposrts' => $transposrts, 'host' => $hosts, 'tripmates' => $tripMates]);
    }

    public function sendInquiry(Request $request)
    {
        $request->dateFrom = date('Y-m-d', strtotime($request->dateFrom));
        $request->dateTo = date('Y-m-d', strtotime($request->dateTo));

        $inquiry = new Trip();
        if ($inquiry->validate()) {
            return response([
                'message' => $inquiry->validate(),
                'success' => false
            ], 422);
        }

        $inquiry->create();

        if (!empty(auth()->user())) {

            $validator = Validator::make(request()->all(), [
                // 'name' => 'required',
                'phone' => 'required',
                // 'email' => 'required|email',
                'dateFrom' => 'required',
                'dateTo' => 'required',
                'location' => 'required',
                'no_of_people' => 'required',
                'budget' => 'required',
                // 'selectedServices' => 'required',

            ]);
        } else {
            $validator = Validator::make(request()->all(), [
                'name' => 'required',
                'phone' => 'required',
                'email' => 'required|email',
                'dateFrom' => 'required',
                'dateTo' => 'required',
                'location' => 'required',
                'no_of_people' => 'required',
                'budget' => 'required',
                // 'selectedServices' => 'required',

            ]);
        }

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        Mail::to("sales@tripscon.com")->send(new InquiryEmail($request->all()));

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'We have received your request, we will get back to you with some amazing offers soon!';
        $this->response['data'] = $inquiry;
        return response()->json($this->response, $this->status);
    }

    public function getQuote()
    {
        return response()->json('');
    }

    public function checkReservation()
    {

        $ldate = date('Y-m-d');
        $reservations = \App\Models\Reservation::where('is_send_email', 0)->whereDate('date_to', '<', $ldate)->take(2)->get();
        $vendors = [];
        $users = [];

        foreach ($reservations as $key => $value) {

            $vendors = [];
            $users = [];

            $booking_link = '';
            if (isset($value) && !empty($value->provider) && isset($value->provider->user_module_type) && !empty($value->provider->user_module_type) && in_array($value->provider->user_module_type, ['guides', 'movie_makers', 'trips', 'visa_consultants', 'photographers', 'trip_mates', 'trip_operators', 'travel_agency', 'user_profile'])) {

                $booking_link = Config::get('global.website_base_url') . '/service/bookings';
            } else {
                $booking_link = Config::get('global.website_base_url') . '/host/bookings';
            }

            array_push($vendors, ['reservation_id' => $value->id, 'email' => $value->provider->email, 'name' => $value->provider->name, 'phone' => $value->provider->phone, 'booking_link' => $booking_link]);

            $u_booking_link = Config::get('global.website_base_url') . '/user/bookings';

            array_push($users, ['reservation_id' => $value->id, 'email' => $value->user->email, 'name' => $value->user->name, 'phone' => $value->user->phone, 'booking_link' => $u_booking_link]);

            if ($vendors || $users) {
                if (isset($vendors[0]) && !empty($vendors[0])) {
                    $vendors = collect($vendors[0]);
                }
                if (isset($users[0]) && !empty($users[0])) {
                    $users = collect($users[0]);
                }
                if (!empty($vendors) || !empty($users)) {
                    Mail::to($vendors['email'])->send(new CheckBookingMail($vendors));
                    Mail::to($users['email'])->send(new CheckBookingMail($users));
                    $reservation = Reservation::find($value->id);
                    $reservation->is_send_email = 1;
                    $reservation->save();
                }
            }
        }
        return response()->json(['guides' => $vendors, 'user' => $users]);
    }

    // getDashboardData
    public function getDashboardData(Request $request)
    {
        /*
        @10-12-21
        @Rehan Hussain
         */
        //fetch four guides
        $ldate = date('Y-m-d');

        $guides = DB::table('guides')->select(DB::raw('guides.id,guides.is_offer_promotion_discount,guides.promotion_discount,guides.location,guides.title,guides.price, count(distinct p.id) as rating_values_count, round(AVG(p.average_rating),2) as rating_values_avg_average_rating, images.name as image'))
            ->leftJoin("images", "images.module_id", "=", "guides.id", "type", "=", "main")
            ->leftJoin('rating_values as p', 'p.package_id', '=', 'guides.id')
            ->leftJoin('users as u', 'u.id', '=', 'guides.user_id')
            ->whereIn('guides.user_module_type', ['trip_operators', 'trips', 'guides', 'travel_agency'])
            // ->whereIn('p.module_name', ['trip_operators', 'trips', 'guides', 'travel_agency'])
            ->where('guides.is_published', '=', 1)
            ->where('guides.status', 1)
            ->where('is_day_wise_trip', 1)
            ->where('images.module', 'guides')
            ->groupBy('guides.id')
            ->limit(4)
            ->orderBy('u.user_score', 'DESC')
            ->orderBy('id', 'DESC')
            // ->toSql();
            ->get()->toArray();
        // dd($guides);
        //fetch four activities

        $activities = DB::table('experiences as exp')->select(DB::raw('exp.id,exp.is_offer_promotion_discount,exp.promotion_discount,exp.location,exp.title,exp.price, count(distinct rating_values.id) as rating_values_count, round(AVG(rating_values.average_rating),2) as rating_values_avg_average_rating, images.name as image'))
            ->leftJoin("images", "images.module_id", "=", "exp.id", "type", "=", "main")
            ->leftJoin('rating_values', 'rating_values.package_id', '=', 'exp.id')
            ->leftJoin('users as u', 'u.id', '=', 'exp.user_id')
            ->where('images.module', 'experiences')
            ->where('exp.is_publish', 1)->where('exp.status', 1)
            ->groupBy('exp.id')
            ->limit(4)
            ->orderBy('u.user_score', 'DESC')
            ->orderBy('id', 'DESC')
            ->get()->toArray();

        // SELECT guides.id,guides.is_offer_promotion_discount,guides.promotion_discount,guides.location,guides.title,guides.price, count(p.package_id) as rating_values_count, round(AVG(p.average_rating),2) as rating_values_avg_average_rating, images.name as image from experiences as guides LEFT OUTER JOIN rating_values AS p ON p.package_id = guides.id INNER JOIN images ON images.module_id = guides.id GROUP BY guides.id LIMIT 4;

        $accomudations = DB::table('accommodations as acc')->select(DB::raw('acc.id,acc.is_offer_promotion_discount,acc.promotion_discount,acc.location,acc.title, acc.no_of_people,acc.detail_location,acc.per_night, count(distinct rating_values.id) as rating_values_count, round(AVG(rating_values.average_rating),2) as rating_values_avg_average_rating, images.name as image'))
            ->leftJoin("images", "images.module_id", "=", "acc.id", "type", "=", "main")
            ->leftJoin('rating_values', 'rating_values.package_id', '=', 'acc.id')
            ->leftJoin('users as u', 'u.id', '=', 'acc.user_id')
            ->where('images.module', 'accommodations')
            ->where('acc.is_publish', 1)->where('acc.status', 1)
            ->groupBy('acc.id')
            ->limit(4)
            ->orderBy('u.user_score', 'DESC')
            ->orderBy('id', 'DESC')
            ->get()->toArray();

        //fetch ist three trips
        $trips = DB::table('guides')->select(DB::raw('guides.id,guides.is_offer_promotion_discount,guides.promotion_discount,guides.location,guides.title,guides.price, count(distinct p.id) as rating_values_count, round(AVG(p.average_rating),2) as rating_values_avg_average_rating, images.name as image'))
            ->leftJoin("images", "images.module_id", "=", "guides.id", "type", "=", "main")
            ->leftJoin('rating_values as p', 'p.package_id', '=', 'guides.id')
            ->leftJoin('users as u', 'u.id', '=', 'guides.user_id')
            ->where(DB::raw('(is_day_wise_trip = 0 and end_date >= ' . $ldate . ') OR is_day_wise_trip = 1'))
            ->where('images.module', 'guides')
            ->whereIn('guides.user_module_type', ['trip_operators', 'trips'])
            ->where('guides.is_published', 1)->where('guides.status', 1)
            ->groupBy('guides.id')
            ->limit(4)
            ->orderBy('u.user_score', 'DESC')
            ->orderBy('id', 'DESC')
            ->get()->toArray();

        //fetch ist four transports
        $transposrts = DB::table('transports as t')->select(DB::raw('t.id,t.is_offer_promotion_discount,t.promotion_discount,t.location,t.title, t.no_of_people,t.detail_location,t.per_day_price,t.hourly_price,t.intercity_per_day_price,t.intercity_per_day_extra_milage_price,t.intercity_multiple_day_price,t.intercity_multiple_day_extra_milage_price,t.outofcity_per_day_price, count(distinct rating_values.id) as rating_values_count, round(AVG(rating_values.average_rating),2) as rating_values_avg_average_rating, images.name as image, t.is_publish, t.status'))
            ->leftJoin("images", "images.module_id", "=", "t.id", "images.type", "=", "main")
            ->leftJoin('rating_values', 'rating_values.package_id', '=', 't.id')
            ->leftJoin('users as u', 'u.id', '=', 't.user_id')
            ->whereIn('images.module', ['transports', 'transport_company'])
            ->where('images.type', 'main')
            ->where('t.is_publish', 1)->where('t.status', 1)
            ->groupBy('t.id')
            ->limit(4)
            ->orderBy('u.user_score', 'DESC')
            ->orderBy('id', 'DESC')
            ->get()->toArray();

        //fetch ist four transports
        $hosts = DB::table('users as u')->select(DB::raw('u.id, u.name,u.image,u.is_offer_promotion_discount,u.type,u.promotion_discount,u.address,u.detail_address,u.is_company, count(distinct rating_values.id) as rating_values_count, round(AVG(rating_values.average_rating),2) as rating_values_avg_average_rating, companies.image as company_image, (select count(*) from accommodations ac where ac.user_id = u.id) as accommodations_count, 
            (select count(*) from transports veh where veh.user_id = u.id) as vehicles_count,
            (select count(*) from experiences exp where exp.user_id = u.id) as experiences_count,
            (select count(*) from meals m where m.user_id = u.id) as meals_count

            
            '))
            ->leftJoin('rating_values', 'rating_values.provider_id', '=', 'u.id')
            // ->whereIn('rating_values.module_name', ['accommodations', 'experiences', 'meals', 'transports', 'restaurants', 'vehicles', 'home_cheff', 'transport_company'])
            ->leftJoin('companies', 'companies.user_id', '=', 'u.id')
            ->where('u.type', 2)
            ->groupBy('u.id')
            ->limit(3)
            ->orderBy(DB::raw('accommodations_count + vehicles_count + experiences_count + meals_count'), 'DESC')
            ->orderBy('u.user_score', 'DESC')
            ->get()->toArray();

        $service_providers = DB::table('users as u')->select(DB::raw('u.id, u.name,u.image,u.is_offer_promotion_discount,u.type,u.promotion_discount,u.address,u.detail_address,u.is_company, count(distinct rating_values.id) as rating_values_count, round(AVG(rating_values.average_rating),2) as rating_values_avg_average_rating,companies.image as company_image'))
            ->leftJoin('rating_values', 'rating_values.package_id', '=', 'u.id')
            ->leftJoin('companies', 'companies.user_id', '=', 'u.id')
            ->where('u.user_module_type', 'guides')
            ->where('u.type', 1)
            // ->orWhere('rating_values.module_name','guides')
            ->groupBy('u.id')
            ->limit(4)
            ->orderBy('u.user_score', 'DESC')
            ->orderBy('id', 'DESC')
            ->get()->toArray();


        $photographers = DB::table('users as u')->select(DB::raw('u.id, u.name,u.image,u.is_offer_promotion_discount,u.type,u.promotion_discount,u.address,u.detail_address,u.is_company, count(distinct rating_values.id) as rating_values_count, round(AVG(rating_values.average_rating),2) as rating_values_avg_average_rating,companies.image as company_image'))
            ->leftJoin('rating_values', 'rating_values.package_id', '=', 'u.id')
            // ->where('rating_values.module_name','photographers')
            ->leftJoin('companies', 'companies.user_id', '=', 'u.id')
            ->where('u.user_module_type', 'photographers')
            ->where('u.type', 1)
            ->groupBy('u.id')
            ->limit(4)
            ->orderBy('u.user_score', 'DESC')
            ->orderBy('id', 'DESC')
            ->get()->toArray();

        // transport_company

        $transport_company = DB::table('users as u')->select(DB::raw('u.id, u.name, u.image,u.is_offer_promotion_discount,u.type,u.promotion_discount,u.address,u.detail_address, u.is_company, count(distinct rating_values.id) as rating_values_count, round(AVG(rating_values.average_rating),2) as rating_values_avg_average_rating,companies.image as company_logo'))
            ->leftJoin('rating_values', 'rating_values.user_id', '=', 'u.id')
            ->leftJoin('companies', 'companies.user_id', '=', 'u.id')
            ->whereNotNull('u.image')
            ->where('u.user_module_type', 'transport_company')
            ->where('u.type', 1)
            ->groupBy('u.id')
            ->limit(4)
            ->orderBy('u.user_score', 'DESC')
            ->orderBy('id', 'DESC')
            ->get()->toArray();


        $tripMates = User::withOut(['policies', 'userServices', 'countries', 'galleries', 'company', 'rules', 'ratings_types', 'cancellation_policy', 'activity', 'participants', 'activitiesWeDo'])->with(['ServiceProviderRates', 'trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])->withAvg('trips_vendor_ratings', 'rating_value')
            ->whereHas('trip_mates', function ($q) {
                $q->whereDate('date_from', ">=", date('Y-m-d'))
                    ->orderBy('id', 'DESC');
            })
            ->orderBy('user_score', 'DESC')
            ->get()->take(6);


        return response()->json(['guides' => $guides, 'service_providers' => $service_providers, 'transport_company' => $transport_company, 'activities' => $activities, 'accomudations' => $accomudations, 'trips' => $trips, 'transposrts' => $transposrts, 'host' => $hosts, 'tripmates' => $tripMates, 'photographers' => $photographers]);
    }

    public function postAppLinks(Request $request)
    {

        if ($request->has('phone') && $request->phone != '') {

            $to = $request->countryCode . $request->phone;

            $message = 'Download the tripscon.com app to travel the world with mobile-exclusive deals! Click ' . config('app.url') . 'install-app to install.';

            $resp = SmsController::send($to, $message);

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'SMS has been sent';

            return response()->json($this->response, $this->status);
        }
        if ($request->has('email') && $request->email != '') {
            $data = [];
            Mail::to($request->email)->send(new SendAppLinksEmail($data));

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Email has been sent';

            return response()->json($this->response, $this->status);
        }
        $this->status = 422;
        $this->response['success'] = false;
        $this->response['message'] = 'Data is not valid.';
        return response()->json($this->response, $this->status);
    }
}
