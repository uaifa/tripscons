<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;


class DestinationsController extends Controller
{
    public function index()
    {
        $destinations = City::whereIn('id', [
            153362,
            85450,
            85724,
            153364,
            153365,
            85625,
            153363,
            85521,
            85572,
            85475
        ])->get();

        return [
            'success' => true,
            'data' => $destinations
        ];
    }

    public function explorePageName($page_name = null){

        $lat = 0;
        $lng = 0;
        $options = '';

        $data['page_name'] = $page_name;
        $data['blogs'] = '';
        $data['og_data_listing_page'] = '';
        $data['seo_data_listing_page'] = '';
        $data['lat'] = 0;
        $data['lng'] = 0;
        $data['locations'] = '';
        $data['api_url'] = config('app.API_URL');
        //fetch four guides
        $ldate = date('Y-m-d');
        $data['options'] = '';
        $data['trip_category'] = '';


        
        if(isset($page_name) && !empty($page_name)){
                $types = explode('-', $page_name);

                $page_name = str_replace('-', ' ', $page_name);
                
                $city = DB::table('cities')->where(strtolower('name'), strtolower($page_name))->first();

                if(isset($city) && !empty($city)){
                        $lat = $city->latitude;
                        $lng = $city->longitude;

                        $data['lat'] = $city->latitude;
                        $data['lng'] = $city->longitude;
                        $data['locations'] = $city->name;

                        if(isset($city->options) && !empty($city->options)){
                                $options = json_decode($city->options);
                                if(isset($options->blogs)){
                                        $data['blogs'] = $options->blogs;
                                }  

                                if(isset($options->og_data_listing_page)){
                                        $data['og_data_listing_page'] = $options->og_data_listing_page;
                                }  
                                if(isset($options->seo_data_listing_page)){
                                        $data['seo_data_listing_page'] = $options->seo_data_listing_page;
                                }  
                        } 
                }

                $trips_list = array('weekend break', 'package holiday', 'group', 'family', 'religious', 'event', 'medical', 'honeymoon', 'safari');


                if(!empty($types) && isset($types[0])){
                        $trips_category = $types[0];
                        $trips_category = ($trips_category == 'weekend') ? 'weekend break' : (($trips_category == 'holiday') ? 'package holiday' : $trips_category);
                        
                        if(in_array($trips_category,$trips_list)){
                        
                                $trips_categories = DB::table('trips_categories')->where(strtolower('name'), $trips_category)->first();

                                if(isset($trips_categories) && !empty($trips_categories)){
                                        $data['trip_category'] = $trips_categories->name;
                                        if(isset($trips_categories->options) && !empty($trips_categories->options)){
                                                $data['options'] = json_decode($trips_categories->options);
                                        }
                                }

                                $data['guides'] = DB::table('guides')->select(DB::raw('guides.id,guides.is_offer_promotion_discount,guides.promotion_discount,guides.location,guides.title,guides.price, count(p.package_id) as rating_values_count, round(AVG(p.average_rating),2) as rating_values_avg_average_rating, images.name as image, ROUND(DEGREES(ACOS(SIN(RADIANS('.$lat.')) * SIN(RADIANS(latitude_to)) + COS(RADIANS('.$lat.')) * COS(RADIANS(latitude_to)) * COS(RADIANS('.$lng.' - longitude_to)))) * 69.09) as distance'))
                                ->leftJoin("images","images.module_id", "=", "guides.id", "type", "=", "main")
                                ->leftJoin('rating_values as p', 'p.package_id', '=', 'guides.id')
                                ->leftJoin('users as u', 'u.id', '=', 'guides.user_id')
                                ->whereIn('guides.user_module_type', ['trip_operators', 'trips', 'guides', 'travel_agency'])
                                ->where('images.type', 'main')
                                ->where('guides.is_published','=',1)
                                ->where('guides.status', 1)
                                ->where(function($query){
                                        $query->where(function($q){
                                                $q->where('is_day_wise_trip',0)->whereDate('end_date', '>=',date('Y-m-d'));
                                        })->orWhere('is_day_wise_trip', 1);
                                })
                                ->where('images.module', 'guides')
                                ->where(strtolower('trip_category'), strtolower($trips_category))
                                // ->having('distance', '<=',20)
                                ->groupBy('guides.id')
                                // ->limit(4)
                                ->orderBy('u.user_score', 'DESC')
                                ->orderBy('distance', 'ASC')
                                ->get();

                                $this->status = 200;
                                $this->response['success'] = true;
                                $this->response['data'] = $data;
                                $this->response['message'] = 'List Fetch Successfully';
                                return response()->json($this->response,$this->status);

                        }
                }

                      
        }


        $data['options'] = $options;


        $data['guides'] = DB::table('guides')->select(DB::raw('guides.id,guides.is_offer_promotion_discount,guides.promotion_discount,guides.location,guides.title,guides.price, count(p.package_id) as rating_values_count, round(AVG(p.average_rating),2) as rating_values_avg_average_rating, images.name as image, ROUND(DEGREES(ACOS(SIN(RADIANS('.$lat.')) * SIN(RADIANS(latitude_to)) + COS(RADIANS('.$lat.')) * COS(RADIANS(latitude_to)) * COS(RADIANS('.$lng.' - longitude_to)))) * 69.09) as distance'))
                ->leftJoin("images","images.module_id", "=", "guides.id", "type", "=", "main")
                ->leftJoin('rating_values as p', 'p.package_id', '=', 'guides.id')
                ->leftJoin('users as u', 'u.id', '=', 'guides.user_id')
                ->whereIn('guides.user_module_type', ['trip_operators', 'trips', 'guides', 'travel_agency'])
                ->where('images.type', 'main')
                ->where('guides.is_published','=',1)
                ->where('guides.status', 1)
                ->where('is_day_wise_trip', 1)
                ->where('images.module', 'guides')
                ->having('distance', '<=',50)
                ->groupBy('guides.id')
                ->limit(4)
                ->orderBy('u.user_score', 'DESC')
                ->orderBy('distance', 'ASC')
               
                ->get();

        //fetch four activities
    
        $data['activities'] = DB::table('experiences as exp')->select(DB::raw('exp.id,exp.is_offer_promotion_discount,exp.promotion_discount,exp.location,exp.title,exp.price, count(rating_values.package_id) as rating_values_count, round(AVG(rating_values.average_rating),2) as rating_values_avg_average_rating, images.name as image, ROUND(DEGREES(ACOS(SIN(RADIANS('.$lat.')) * SIN(RADIANS(exp.lat)) + COS(RADIANS('.$lat.')) * COS(RADIANS(exp.lat)) * COS(RADIANS('.$lng.' - exp.lng)))) * 69.09) as distance'))
                ->leftJoin("images","images.module_id", "=", "exp.id","type", "=", "main")
                ->leftJoin('rating_values', 'rating_values.package_id', '=', 'exp.id')
                ->leftJoin('users as u', 'u.id', '=', 'exp.user_id')
                ->where('images.type', 'main')
                ->where('images.module', 'experiences')
                ->where('exp.is_publish', 1)->where('exp.status', 1)
                ->having('distance', '<=',50)
                ->groupBy('exp.id')
                ->limit(4)
                ->orderBy('u.user_score', 'DESC')
                ->orderBy('distance', 'ASC')
                ->get()->toArray();

                // SELECT guides.id,guides.is_offer_promotion_discount,guides.promotion_discount,guides.location,guides.title,guides.price, count(p.package_id) as rating_values_count, round(AVG(p.average_rating),2) as rating_values_avg_average_rating, images.name as image from experiences as guides LEFT OUTER JOIN rating_values AS p ON p.package_id = guides.id INNER JOIN images ON images.module_id = guides.id GROUP BY guides.id LIMIT 4;

        $data['accomudations'] = DB::table('accommodations as acc')->select(DB::raw('acc.id,acc.is_offer_promotion_discount,acc.promotion_discount,acc.location,acc.title, acc.no_of_people,acc.detail_location,acc.per_night, count(rating_values.package_id) as rating_values_count, round(AVG(rating_values.average_rating),2) as rating_values_avg_average_rating, images.name as image, ROUND(DEGREES(ACOS(SIN(RADIANS('.$lat.')) * SIN(RADIANS(acc.lat)) + COS(RADIANS('.$lat.')) * COS(RADIANS(acc.lat)) * COS(RADIANS('.$lng.' - acc.lng)))) * 69.09) as distance'))
                ->leftJoin("images","images.module_id", "=", "acc.id", "type", "=", "main")
                ->leftJoin('rating_values', 'rating_values.package_id', '=', 'acc.id')
                ->leftJoin('users as u', 'u.id', '=', 'acc.user_id')
                ->where('images.type', 'main')
                ->where('images.module', 'accommodations')
                ->where('acc.is_publish', 1)->where('acc.status', 1)
                ->having('distance', '<=',50)
                ->groupBy('acc.id')
                ->limit(4)
                ->orderBy('u.user_score', 'DESC')
                ->orderBy('distance', 'ASC')
                ->get()->toArray();

        //fetch ist three trips
        $data['trips'] = DB::table('guides')->select(DB::raw('guides.id,guides.is_offer_promotion_discount,guides.promotion_discount,guides.location,guides.title,guides.price, count(p.package_id) as rating_values_count, round(AVG(p.average_rating),2) as rating_values_avg_average_rating, images.name as image, ROUND(DEGREES(ACOS(SIN(RADIANS('.$lat.')) * SIN(RADIANS(latitude_to)) + COS(RADIANS('.$lat.')) * COS(RADIANS(latitude_to)) * COS(RADIANS('.$lng.' - longitude_to)))) * 69.09) as distance'))
                ->leftJoin("images","images.module_id", "=", "guides.id", "type", "=", "main")
                ->leftJoin('rating_values as p', 'p.package_id', '=', 'guides.id')
                ->leftJoin('users as u', 'u.id', '=', 'guides.user_id')
                ->where('images.type', 'main')
                ->where(DB::raw('(is_day_wise_trip = 0 and end_date >= '.$ldate.') OR is_day_wise_trip = 1'))
                ->where('images.module', 'guides')
                ->whereIn('guides.user_module_type', ['trip_operators', 'trips'])
                ->where('guides.is_published', 1)->where('guides.status', 1)
                ->having('distance', '<=',50)
                ->groupBy('guides.id')
                ->limit(4)
                ->orderBy('u.user_score', 'DESC')
                ->orderBy('distance', 'ASC')
                ->get()->toArray();

        //fetch ist four transports
        $data['transposrts'] = DB::table('transports as t')->select(DB::raw('t.id,t.is_offer_promotion_discount,t.promotion_discount,t.location,t.title, t.no_of_people,t.detail_location,t.per_day_price,t.hourly_price,t.intercity_per_day_price,t.intercity_per_day_extra_milage_price,t.intercity_multiple_day_price,t.intercity_multiple_day_extra_milage_price,t.outofcity_per_day_price, count(rating_values.package_id) as rating_values_count, round(AVG(rating_values.average_rating),2) as rating_values_avg_average_rating, images.name as image, t.is_publish, t.status, ROUND(DEGREES(ACOS(SIN(RADIANS('.$lat.')) * SIN(RADIANS(t.lat)) + COS(RADIANS('.$lat.')) * COS(RADIANS(t.lat)) * COS(RADIANS('.$lng.' - t.lng)))) * 69.09) as distance'))
                ->leftJoin("images","images.module_id", "=", "t.id", "type", "=", "main")
                ->leftJoin('rating_values', 'rating_values.package_id', '=', 't.id')
                ->leftJoin('users as u', 'u.id', '=', 't.user_id')
                ->where('images.type', 'main')
                ->whereIn('images.module', ['transports', 'transport_company'])
                ->where('t.is_publish', 1)->where('t.status', 1)
                ->having('distance', '<=',50)
                ->groupBy('t.id')
                ->limit(4)
                ->orderBy('u.user_score', 'DESC')
                ->orderBy('distance', 'ASC')
                ->get()->toArray();

        //fetch ist four transports
        $data['hosts'] = DB::table('users as u')->select(DB::raw('u.id, u.name,u.image,u.is_offer_promotion_discount,u.type,u.promotion_discount,u.address,u.detail_address,u.is_company, count(rating_values.package_id) as rating_values_count, round(AVG(rating_values.average_rating),2) as rating_values_avg_average_rating, companies.image as company_image, (select count(*) from accommodations ac where ac.user_id = u.id) as accommodations_count, 
(select count(*) from transports veh where veh.user_id = u.id) as vehicles_count,
(select count(*) from experiences exp where exp.user_id = u.id) as experiences_count,
(select count(*) from meals m where m.user_id = u.id) as meals_count, ROUND(DEGREES(ACOS(SIN(RADIANS('.$lat.')) * SIN(RADIANS(lat)) + COS(RADIANS('.$lat.')) * COS(RADIANS(lat)) * COS(RADIANS('.$lng.' - lng)))) * 69.09) as distance'))
                ->leftJoin('rating_values', 'rating_values.user_id', '=', 'u.id')
                ->leftJoin('companies', 'companies.user_id', '=', 'u.id')
                ->where('u.type', 2)
                ->having('distance', '<=',50)
                ->groupBy('u.id')
                ->limit(3)
                // ->orderBy(DB::raw('accommodations_count + vehicles_count + experiences_count + meals_count'), 'DESC')
                ->orderBy('u.user_score', 'DESC')
                ->orderBy('distance', 'ASC')
                ->get()
                ->toArray();

        $data['service_providers'] = DB::table('users as u')->select(DB::raw('u.id, u.name,u.image,u.is_offer_promotion_discount,u.type,u.promotion_discount,u.address,u.detail_address,u.is_company, count(rating_values.package_id) as rating_values_count, round(AVG(rating_values.average_rating),2) as rating_values_avg_average_rating,companies.image as company_logo, ROUND(DEGREES(ACOS(SIN(RADIANS('.$lat.')) * SIN(RADIANS(lat)) + COS(RADIANS('.$lat.')) * COS(RADIANS(lat)) * COS(RADIANS('.$lng.' - lng)))) * 69.09) as distance'))
                ->leftJoin('rating_values', 'rating_values.user_id', '=', 'u.id')
                ->leftJoin('companies', 'companies.user_id', '=', 'u.id')
                ->where('u.user_module_type', 'guides')
                ->where('u.type', 1)
                ->having('distance', '<=',50)
                ->groupBy('u.id')
                ->limit(4)
                ->orderBy('u.user_score', 'DESC')
                ->orderBy('distance', 'ASC')
                ->get()->toArray();
      
            // transport_company
 
        $data['transport_company'] = DB::table('users as u')->select(DB::raw('u.id, u.name, u.image,u.is_offer_promotion_discount,u.type,u.promotion_discount,u.address,u.detail_address, u.is_company, count(rating_values.package_id) as rating_values_count, round(AVG(rating_values.average_rating),2) as rating_values_avg_average_rating,companies.image as company_logo, ROUND(DEGREES(ACOS(SIN(RADIANS('.$lat.')) * SIN(RADIANS(lat)) + COS(RADIANS('.$lat.')) * COS(RADIANS(lat)) * COS(RADIANS('.$lng.' - lng)))) * 69.09) as distance'))
                ->leftJoin('rating_values', 'rating_values.user_id', '=', 'u.id')
                ->leftJoin('companies', 'companies.user_id', '=', 'u.id')
                ->whereNotNull('u.image')
                ->where('u.user_module_type', 'transport_company')
                ->where('u.type', 1)
                ->having('distance', '<=',50)
                ->groupBy('u.id')
                ->limit(4)     
                ->orderBy('u.user_score', 'DESC')
                ->orderBy('distance', 'ASC')
               
                ->get()->toArray();


        
        $data['tripMates'] = DB::table('users as u')->select(DB::raw('u.id, u.name,u.image,u.is_offer_promotion_discount,u.type,u.promotion_discount,u.address,u.detail_address,u.is_company, count(vendor_ratings.package_id) as trips_vendor_ratings_count, round(AVG(vendor_ratings.rating_value),2) as trips_vendor_ratings_avg_rating_value, ROUND(DEGREES(ACOS(SIN(RADIANS('.$lat.')) * SIN(RADIANS(u.lat)) + COS(RADIANS('.$lat.')) * COS(RADIANS(u.lat)) * COS(RADIANS('.$lng.' - u.lng)))) * 69.09) as distance'))
                ->leftJoin('vendor_ratings', 'vendor_ratings.user_id', '=', 'u.id')
                ->leftJoin('trip_mate', 'trip_mate.user_id', '=', 'u.id')
                ->whereDate('trip_mate.date_from', '>=',date('Y-m-d'))
                ->having('distance', '<=',20)
                ->groupBy('u.id')
                ->limit(6)
                ->orderBy('u.user_score', 'DESC')
                ->orderBy('distance', 'ASC')
                ->get()->toArray();

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        $this->response['message'] = 'List Fetch Successfully';
        return response()->json($this->response,$this->status);

    }


    public function serviceType($page_name, $type){


        $data['page_name'] = $page_name;

        $types = substr(strrchr($type, '-'), 1);

        if($types == 'tours'){
                $type = 'trips';
        }else if($type = explode('-', $type)){
                if(!empty($type) && isset($type[0])){
                        $type = $type[0];
                }
        }

        $lat = 0;
        $lng = 0;
        $options = '';
        $data['blogs'] = '';
        $data['og_data_listing_page'] = '';
        $data['seo_data_listing_page'] = '';
        $data['lat'] = 0;
        $data['lng'] = 0;
        $data['locations'] = '';


        if(isset($page_name) && !empty($page_name)){
                $page_name = str_replace('-', ' ', $page_name);
                $city = DB::table('cities')->where(strtolower('name'), strtolower($page_name))->first();
                if(isset($city) && !empty($city)){
                        $lat = $city->latitude;
                        $lng = $city->longitude;

                        $data['lat'] = $city->latitude;
                        $data['lng'] = $city->longitude;
                        $data['locations'] = $city->name;

                        if(isset($city->options) && !empty($city->options)){
                                $options = json_decode($city->options);

                                if(isset($options->blogs)){
                                        $data['blogs'] = $options->blogs;
                                }  

                                if($type == 'trips' || $type == 'tours'){
                                        if(isset($options->og_data_trips_listing_page)){
                                                $data['og_data_listing_page'] = $options->og_data_trips_listing_page;
                                        }  
                                        if(isset($options->seo_data_trips_listing_page)){
                                                $data['seo_data_listing_page'] = $options->seo_data_trips_listing_page;
                                        }
                                }else if($type == 'accommodations' || $type == 'hotels'){
                                        if(isset($options->og_data_hotel_listing_page)){
                                                $data['og_data_listing_page'] = $options->og_data_hotel_listing_page;
                                        }  
                                        if(isset($options->seo_data_hotel_listing_page)){
                                                $data['seo_data_listing_page'] = $options->seo_data_hotel_listing_page;
                                        }
                                }
                                
                        } 

                          
                }
        }
        $data['options'] = $options;
        $data['api_url'] = config('app.API_URL');
        $data['type'] = $type;
        // dd($data);
        //fetch four guides
        $ldate = date('Y-m-d');
        if($type == 'trips' || $type == 'tours'){

                $data['packages'] = DB::table('guides')->select(DB::raw('guides.id,guides.is_offer_promotion_discount,guides.promotion_discount,guides.location,guides.title,guides.price, count(p.package_id) as rating_values_count, round(AVG(p.average_rating),2) as rating_values_avg_average_rating, images.name as image, ROUND(DEGREES(ACOS(SIN(RADIANS('.$lat.')) * SIN(RADIANS(latitude_to)) + COS(RADIANS('.$lat.')) * COS(RADIANS(latitude_to)) * COS(RADIANS('.$lng.' - longitude_to)))) * 69.09) as distance, tp.group_size, guides.location_to'))
                ->leftJoin("images","images.module_id", "=", "guides.id", "type", "=", "main")
                ->leftJoin('rating_values as p', 'p.package_id', '=', 'guides.id')
                ->leftJoin('trips_properties as tp', 'tp.package_id', '=', 'guides.id')
                ->leftJoin('users as u', 'u.id', '=', 'guides.user_id')
                ->where('images.type', 'main')
                ->whereIn('guides.user_module_type', ['trip_operators', 'trips', 'guides', 'travel_agency'])
                ->where('guides.is_published','=',1)
                ->where('guides.status', 1)
                ->where('is_day_wise_trip', 1)
                ->where('images.module', 'guides')
                ->having('distance', '<=',20)
                ->groupBy('guides.id')
                ->orderBy('u.user_score', 'DESC')
                ->orderBy('distance', 'ASC')
                ->paginate(Config::get('global.pagination_records'));

        }else if($type == 'accommodations' || $type == 'hotels'){

                $data['packages'] = DB::table('accommodations as acc')->select(DB::raw('acc.id,acc.is_offer_promotion_discount,acc.promotion_discount,acc.location,acc.title, acc.no_of_people,acc.detail_location,acc.per_night, count(rating_values.package_id) as rating_values_count, round(AVG(rating_values.average_rating),2) as rating_values_avg_average_rating, images.name as image, ROUND(DEGREES(ACOS(SIN(RADIANS('.$lat.')) * SIN(RADIANS(acc.lat)) + COS(RADIANS('.$lat.')) * COS(RADIANS(acc.lat)) * COS(RADIANS('.$lng.' - acc.lng)))) * 69.09) as distance, acc.lat, acc.lng, acc.sub_type_name'))
                ->leftJoin("images","images.module_id", "=", "acc.id", "type", "=", "main")
                ->leftJoin('rating_values', 'rating_values.package_id', '=', 'acc.id')
                ->leftJoin('users as u', 'u.id', '=', 'acc.user_id')
                ->where('images.type', 'main')
                ->where('images.module', 'accommodations')
                ->where('acc.is_publish', 1)->where('acc.status', 1)
                ->having('distance', '<=',20)
                ->groupBy('acc.id')
                ->orderBy('u.user_score', 'DESC')
                ->orderBy('distance', 'ASC')
                ->paginate(Config::get('global.pagination_records'));
        }

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        $this->response['message'] = 'List Fetch Successfully';
        return response()->json($this->response,$this->status);

    }
}
