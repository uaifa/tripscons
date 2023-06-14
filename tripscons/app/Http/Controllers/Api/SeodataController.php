<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guide;
use App\Models\Meal;
use App\Models\Experience;
use App\Models\Accommodation;
use App\Models\Transport;
use App\Models\Seodata;

class SeodataController extends Controller
{
    

    /**
     * @var array
     */
    protected $response = [];
    protected $status = 200;

    // seo data page list api 
    public function seoPagesList(){
        $pages['data'] = array("home_page" => "Home page",
                "aboutus" => "About page",
                "careers" => "Careers page",
                "ourteam" => "Our team page",
                "investors" => "Investors page",
                "contact" => "Contact page",
                "faqs" => "Faqs page",
                "guider_list_page" => "Guider list",
                "guider_detail_page" => "Guide paclages list",
                "trips_list_page" => "Trips list",
                "trips_detail_page" => "Trips paclages list",
                "movie_maker_list_page" => "Movie maker list",
                "movie_maker_detail_page" => "Movie maker paclages list",
                "visa_consultant_list_page" => "Visa consultant list",
                "visa_consultant_detail_page" => "Visa consultant paclages list",
                "photographer_list_page" => "Photographer list",
                "photographer_detail_page" => "Photographer paclages list",
                "trip_mate_list_page" => "Trip mate list",
                "trip_mate_detail_page" => "Trip mate paclages list",
                "trip_operator_list_page" => "Trip operator list",
                "trip_operator_detail_page" => "Trip operator paclages list",
                "travel_agency_list_page" => "Travel agency list",
                "travel_agency_detail_page" => "Travel agency paclages list",
                "accommodation_list_page" => "Accommodation list",
                "accommodation_detail_page" => "Accommodation paclages list",
                "transport_list_page" => "Transport list",
                "transport_detail_page" => "Transport paclages list",
                "experience_list_page" => "Experience list",
                "experience_detail_page" => "Experience paclages list",
                "meal_list_page" => "Meal list",
                "meal_detail_page" => "Meal paclages list",
                "restaurant_list_page" => "Restaurant list",
                "restaurant_detail_page" => "Restaurant paclages list",
                "home_cheff_list_page" => "Homecheff list",
                "home_cheff_detail_page" => "Homecheff paclages list",
                "trip_listings_list_page" => "Trip listings list",
                "guides" => "Guides",
                "movie_makers" => "Movie makers",
                "transports" => "Transports",
                "trips" => "Trips",
                "visa_consultants" => "Visa consultants",
                "photographers" => "Photographers",
                "restaurants" => "Restaurants",
                "trip_mates" => "Trip mates",
                "trip_operators" => "Trip operators",
                "home_cheff" => "Home cheff",
                "travel_agency" => "Travel agency",
                "accommodations" => "Accommodations",
                "experiences" => "Experiences",
                "meals" => "Meals",
            );

        $this->response['success'] = true;
        $this->response['message'] = 'Pages list';
        $this->response['data'] = $pages;
       
        return response()->json($this->response, $this->status);

    }
    public function seoPagesListType($type){
        $pages['data'] = [];
        $sp_list = ['guides','movie_makers','trips','visa_consultants','photographers','trip_mates','trip_operators','travel_agency'];
        $host_list = ['accommodations','transports','experiences','meals','events', 'restaurants', 'home_cheff'];
          if(in_array($type, $sp_list)){

            $pages['data'] = Guide::select('id', 'title', 'user_module_type')->where('user_module_type', $type)->get();
          }else if(in_array($type, ['meals','restaurants', 'home_cheff'])){
            $pages['data'] = Meal::select('id', 'title', 'module_name')->where('module_name', $type)->get();
          }else if(in_array($type, $host_list)){
            if($type == 'accommodations'){
                $pages['data'] = Accommodation::select('id', 'title', 'module_name as user_module_type')->get();
            }else if($type == 'transports'){
                $pages['data'] = Transport::select('id', 'title', 'module_name as user_module_type')->get();
            }else if($type == 'experiences'){
                $pages['data'] = Experience::select('id', 'title', 'module_name as user_module_type')->get();
            }
          }

        $this->response['success'] = true;
        $this->response['message'] = 'Pages list';
        $this->response['data'] = $pages;
        return response()->json($this->response, $this->status);
    }

    public function addSeodata(Request $request){


        $data['seo_main_title'] = $request->seo_main_title;
        $data['seo_title'] = $request->seo_title;
        $data['seo_description'] = $request->seo_description;
        $data['seo_keywords'] = $request->seo_keywords;
        $data['seo_canonical'] = $request->seo_canonical;
        $data['seo_page_type'] = $request->seo_page_type;
        $data['seo_sub_page_type'] = $request->seo_sub_page_type;
        $data['user_module_type'] = $request->user_module_type;

        if($data['seo_page_type'] == 'guides'){
            $data['user_module_type'] = 'guides';
        }else if($data['seo_page_type'] == 'movie_makers'){
            $data['user_module_type'] = 'movie_makers';
        }else if($data['seo_page_type'] == 'transports'){
            $data['user_module_type'] = 'transports';
        }else if($data['seo_page_type'] == 'trips'){
            $data['user_module_type'] = 'trips';
        }else if($data['seo_page_type'] == 'visa_consultants'){
            $data['user_module_type'] = 'visa_consultants';
        }else if($data['seo_page_type'] == 'photographers'){
            $data['user_module_type'] = 'photographers';
        }else if($data['seo_page_type'] == 'restaurants'){
            $data['user_module_type'] = 'restaurants';
        }else if($data['seo_page_type'] == 'trip_mates'){
            $data['user_module_type'] = 'trip_mates';
        }else if($data['seo_page_type'] == 'trip_operators'){
            $data['user_module_type'] = 'trip_operators';
        }else if($data['seo_page_type'] == 'home_cheff'){
            $data['user_module_type'] = 'home_cheff';
        }else if($data['seo_page_type'] == 'travel_agency'){
            $data['user_module_type'] = 'travel_agency';
        }else if($data['seo_page_type'] == 'accommodations'){
            $data['user_module_type'] = 'accommodations';
        }else if($data['seo_page_type'] == 'experiences'){
            $data['user_module_type'] = 'experiences';
        }else if($data['seo_page_type'] == 'meals'){
            $meal = Meal::find($data['seo_sub_page_type']);
            if(isset($meal) && !empty($meal)){
                $data['user_module_type'] = $meal->module_name;
            }else{
                $data['user_module_type'] = 'meals';
            }
        }

        if(isset($request->package_id) && !empty($request->package_id)){
            $data['package_id'] = $request->package_id;
        }else{
            $data['package_id'] = isset($data['seo_sub_page_type']) ? $data['seo_sub_page_type'] : 0;
        }

        if(Seodata::where('seo_page_type', $data['seo_page_type'])->first()){
            $this->response['message'] = 'Seo data updated successfully';
        }else{
            $this->response['message'] = 'Seo data added successfully';
        }
        if(isset($data['user_module_type']) && !empty($data['user_module_type'])){
            Seodata::updateOrCreate(['seo_page_type' => $data['seo_page_type'], 'user_module_type' => $data['user_module_type'], 'seo_sub_page_type' => $data['seo_sub_page_type']], $data);
        }else{
            Seodata::updateOrCreate(['seo_page_type' => $data['seo_page_type']], $data);
        }

        $this->response['success'] = true;
        // $this->response['message'] = 'Pages list';
        $this->response['data'] = $data;
        return response()->json($this->response, $this->status);

        return $request->all();
    }

    public function getSeodata($page_type = 'home_page', $user_module_type = '', $package_id = 0){

        $data['data'] = [];

        if($user_module_type == 'guides'){
            $guide = Guide::find($package_id);
            if(!empty($guide)){
                $user_module_type = $guide->user_module_type;
                $data['data'] = Seodata::where('seo_page_type', $user_module_type)->where('user_module_type', $user_module_type)->where('package_id', $package_id)->first();
            }else{
                $data['data'] = Seodata::where('seo_page_type', $page_type)->first();
            }
        }else{
            if($user_module_type == 'accommodation_list_page'){
                $data['data'] = Seodata::where('seo_page_type', $page_type)->first();
            }else if($user_module_type == 'accommodations'){
                $data['data'] = Seodata::where('seo_page_type', $page_type)->where('package_id', $package_id)->first();
            }else if($user_module_type == 'experiences'){
                $data['data'] = Seodata::where('seo_page_type', $page_type)->where('package_id', $package_id)->first();
            }else if($user_module_type == 'experience_list_page'){
                $data['data'] = Seodata::where('seo_page_type', $page_type)->first();
            }else if($user_module_type == 'transport_list_page'){
                $data['data'] = Seodata::where('seo_page_type', $page_type)->first();
            }else if($user_module_type == 'transports'){
                $data['data'] = Seodata::where('seo_page_type', $page_type)->where('package_id', $package_id)->first();
            }else if($user_module_type == 'meal_list_page'){
                $data['data'] = Seodata::where('seo_page_type', $page_type)->first();
            }else if($user_module_type == 'meals'){
                $meal = Meal::find($package_id);
                if(!empty($meal)){
                    $user_module_type = $meal->module_name;
                     $data['data'] = Seodata::where('seo_page_type', $user_module_type)->where('user_module_type', $user_module_type)->where('package_id', $package_id)->first();
                }
            }else{
                $data['data'] = Seodata::where('seo_page_type', $page_type)->first();
            }

        }

        $this->response['success'] = true;
        $this->response['message'] = 'Seodata ';
        $this->response['data'] = $data;
        return response()->json($this->response, $this->status);


    }
}
