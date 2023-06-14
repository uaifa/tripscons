<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;
use App\Models\Accommodation;
use App\Models\Host;
use App\Models\User;
use App\Models\Image;
use App\Models\Transport;
use App\Models\Experience;
use App\Models\Meal;
use App\Models\ServiceProviderRate;
use App\Models\UserActivity;
use App\Models\UserDocument;
use App\Models\Trip;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\Company;
use App\Models\MealsTypes;
use App\Models\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;



class UserController extends Controller{
    protected $status = 200;
    protected $response = [];

    public function __construct()
    {

    }
    public function index(Request $request){
        $proRating =   $request->rating;
        $country = $request->country;
        $city = $request->city;
        if(!empty($request)){
            $data = User::where('status','active')->where(function($query) use ($proRating,$country,$city) {
                if($proRating > 0){
                    $query->where('rating',$proRating);
                }
                if(!empty($country)){
                    $query->Where('country', $country);
                }
                if(!empty($city)){
                    $query->Where('city', $city);
                }

            })->paginate(15);

        }else{
            $data = User::where('status','active')->paginate(15);
        }
        if(empty($data)){
            $data=array();
        }
        return response()->json(['mates'=>$data]);

    }

    public function updateUser(Request $request){

            $validator = Validator::make($request->all(), [
                'phone' => [Rule::unique('users')->ignore(auth()->user()->id)],

            ]);
            if ($validator->fails()) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = $validator->messages()->first();
                return response()->json($this->response, $this->status);
            }

        if(count($request->all()) > 0){
            $data =  $request->user();
            if(!empty($data)){
                if(isset($request->name)){
                    $data->name =  $request->name;
                }
                if(isset($request->postal_code)){
                    $data->postal_code = $request->postal_code;
                }
                if(isset($request->phone)){
                    $data->phone = $request->phone;
                }
                if(isset($request->about_host)){
                    $data->about = $request->about_host;
                }

                if(isset($request->is_mate)){
                    $data->is_mate= $request->is_mate;
                }
                if(isset($request->type)){
                    $data->type  =  $request->type;
                    $data->switchProfile = $request->type;
                }
                if(isset($request->service_provider_type)){
                    $data->service_provider_type = $request->service_provider_type;
                }
                if(isset($request->gender) && !empty($request->gender)){
                    $data->gender  = $request->gender;
                }
                if(isset($request->country)){
                    $data->country  = $request->country	;
                }
                if(isset($request->state)){
                    $data->state  = $request->state	;
                }
                if(isset($request->city)){
                    $data->city	   = $request->city;
                }
                if(isset($request->lat)){
                    $data->lat	   = round($request->lat, 8);
                }
                if(isset($request->lng)){
                    $data->lng	   = round($request->lng, 8);
                }
                if(isset($request->countryIso)){
                    $data->countryIso	   = $request->countryIso;
                }

                if(isset($request->address)){
                    $data->address  = $request->address	;
                }
                if(isset($request->about)){
                    $data->about    = $request->about;
                }
                if(isset($request->date_of_birth) && !empty($request->date_of_birth)){
                    $data->date_of_birth = date("Y-m-d", strtotime($request->date_of_birth));
                }
                if(isset($request->no_of_reviews)){
                    $data->no_of_reviews = $request->no_of_reviews;
                }
                if(isset($request->rating)){
                    $data->rating = $request->rating;
                }
                if(isset($request->languages) && !empty($request->languages)){
                    $data->languages  = $request->languages;
                }
                if(isset($request->country_code)){

                    if(strpos($request->country_code , "+") !== false){
                        $data->country_code  = $request->country_code;
                    } else{
                        $data->country_code  = "+".$request->country_code;
                    }

                }
                if(auth()->user()->user_module_type == 'guides'){
                    $data->is_company = 0;
                }else if(isset($request->is_company)){
                    if($request->is_company != 1 && auth()->user()->is_company != 1){
                        $data->is_individual = 1;
                    }
                    $data->is_company  = $request->is_company == 1 ? 1 : 0;
                }

                if(isset($request->expert_consultancy) && !empty($request->expert_consultancy)){
                    $data->expert_consultancy = $request->expert_consultancy;
                }

                if(isset($request->nationality) && !empty($request->nationality)){
                    $data->nationality = $request->nationality;
                }

                if(isset($request->tagline)){
                    $data->tagline = $request->tagline;
                }

                if (isset($request->is_offer_promotion_discount)) {
                    $data->is_offer_promotion_discount = $request->is_offer_promotion_discount;
                    $data->promotion_discount = $request->promotion_discount;
                }

                if(isset($request->detail_address) && !empty($request->detail_address)){
                    $data->detail_address = $request->detail_address;
                }
                if(isset($request->detail_address_lat) && !empty($request->detail_address_lat)){
                    $data->detail_address_lat = $request->detail_address_lat;
                }
                if(isset($request->detail_address_lng) && !empty($request->detail_address_lng)){
                    $data->detail_address_lng = $request->detail_address_lng;
                }

                if(isset($request->restaurant_location) && !empty($request->restaurant_location)){

                    $data->restaurant_location = $request->restaurant_location;
                    $data->restaurant_lat = $request->restaurant_lat;
                    $data->restaurant_lng = $request->restaurant_lng;

                }

                if(isset($request->company_image)){
                    $this->companyImagestore($request);
                }

                if($data->save()){
                    $this->Imagestore($request);
                    $this->status = 200;
                    $this->response['success'] = true;
                    $this->response['message'] = 'User has been updated';
                    $this->response['data'] = $data->makeVisible(['api_token']);
                }

                // $serivce_provder = ServiceProviderRate::where('user_id', auth()->user()->id)->first();

                $serivce_provder = ServiceProviderRate::firstOrCreate(['user_id' => auth()->user()->id]);
                // if(empty($serivce_provder)){
                //     $serivce_provder = new ServiceProviderRate();
                //     $serivce_provder->user_id = auth()->user()->id;
                //     $serivce_provder->save();
                // }


                if(isset(request()->selected_countries) && !empty(request()->selected_countries)){
                    $users = User::find(auth()->user()->id);
                    $selected_countries = json_decode(request()->selected_countries, true);
                    if(!empty($selected_countries) && !empty($users)){
                        $users->countries()->sync(array_column($selected_countries, 'id'));
                    }
                }



                if(auth()->user() && auth()->user()->type == 1){
                    // dd($request->all());
                    if(isset($request->languages) || isset($request->destinations) || isset($request->price_per_hour_rate) || isset($request->price_per_day_rate) || isset($request->payment_mode) || isset($request->payment_partial_value) || isset($request->terms_rule) || isset($request->cuisines) || isset($request->special_diets) || isset($request->meals) || isset($request->restaurant_location) || isset($request->restaurant_name) || isset($request->movie_photo_equipments) || isset($request->is_free_service) || isset($request->checked_transport_company_fleet) || isset($request->checked_transport_company_services))
                    {


                        $service_provider_rates = [];

                        if($request->movie_photo_equipments){
                            $service_provider_rates['movie_photo_equipments'] = $request->movie_photo_equipments;
                        }

                        if(isset($request->languages) && !empty($request->languages)){
                            $service_provider_rates['languages'] = $request->languages;
                        }
                        if(isset($request->destinations) && !empty($request->destinations)){
                            $service_provider_rates['destinations'] = $request->destinations;
                        }

                        if(isset($request->group_discount) && !empty($request->group_discount)){
                            $service_provider_rates['group_discount'] = $request->group_discount;
                        }
                        if(isset($request->start_time) && !empty($request->start_time)){
                            $service_provider_rates['start_time'] = $request->start_time;
                        }
                        if(isset($request->end_time) && !empty($request->end_time)){
                            $service_provider_rates['end_time'] = $request->end_time;
                        }
                        if(isset($request->skills) && !empty($request->skills)){
                            $service_provider_rates['skills'] = $request->skills;
                        }
                        if(isset($request->domestic_trip)){
                            $service_provider_rates['domestic_trip'] = $request->domestic_trip;
                        }
                        if(isset($request->international_trip)){
                            $service_provider_rates['international_trip'] = $request->international_trip;
                        }
                        if(isset($request->is_free_service)){
                            $service_provider_rates['is_free_service'] = $request->is_free_service;
                            if($request->is_free_service == 1){
                                $service_provider_rates['price_per_hour_rate'] = 0;
                                $service_provider_rates['price_per_day_rate'] = 0;

                                $service_provider_rates['number_of_persons'] = 0;
                                $service_provider_rates['extra_price_per_person'] = 0;
                                $service_provider_rates['extra_price_per_hours_per_person'] = 0;

                            }else{
                                if(isset($request->price_per_hour_rate) && !empty($request->price_per_hour_rate)){
                                    $service_provider_rates['price_per_hour_rate'] = $request->price_per_hour_rate;
                                }
                                if(isset($request->price_per_day_rate) && !empty($request->price_per_day_rate)){
                                    $service_provider_rates['price_per_day_rate'] = $request->price_per_day_rate;
                                }

                                if(isset($request->number_of_persons) && !empty($request->number_of_persons)){
                                    $service_provider_rates['number_of_persons'] = $request->number_of_persons;
                                }
                                if(isset($request->extra_price_per_person) && !empty($request->extra_price_per_person)){
                                    $service_provider_rates['extra_price_per_person'] = $request->extra_price_per_person;
                                }
                                if(isset($request->extra_price_per_hours_per_person) && !empty($request->extra_price_per_hours_per_person)){
                                    $service_provider_rates['extra_price_per_hours_per_person'] = $request->extra_price_per_hours_per_person;
                                }
                            }

                        }else{
                            if(isset($request->price_per_hour_rate) && !empty($request->price_per_hour_rate)){
                                $service_provider_rates['price_per_hour_rate'] = $request->price_per_hour_rate;
                            }
                            if(isset($request->price_per_day_rate) && !empty($request->price_per_day_rate)){
                                $service_provider_rates['price_per_day_rate'] = $request->price_per_day_rate;
                            }

                            if(isset($request->number_of_persons) && !empty($request->number_of_persons)){
                                $service_provider_rates['number_of_persons'] = $request->number_of_persons;
                            }
                            if(isset($request->extra_price_per_person) && !empty($request->extra_price_per_person)){
                                $service_provider_rates['extra_price_per_person'] = $request->extra_price_per_person;
                            }
                            if(isset($request->extra_price_per_hours_per_person) && !empty($request->extra_price_per_hours_per_person)){
                                $service_provider_rates['extra_price_per_hours_per_person'] = $request->extra_price_per_hours_per_person;
                            }
                        }
                        if(isset($request->cuisines) && !empty($request->cuisines)){
                            $service_provider_rates['cuisines'] = $request->cuisines;
                        }
                        if(isset($request->special_diets) && !empty($request->special_diets)){
                            $service_provider_rates['special_diets'] = $request->special_diets;
                        }
                        if(isset($request->meals) && !empty($request->meals)){
                            $service_provider_rates['meals'] = $request->meals;
                            $meals = json_decode($request->meals);
                            // dd($meals);
                            if(!empty($meals)){
                                $meal_data = [];
                                foreach ($meals as $key => $value) {
                                    array_push($meal_data, ['name' => $value, 'user_id' => auth()->user()->id]);
                                }
                                if(!empty($meal_data)){
                                    MealsTypes::where('user_id', auth()->user()->id)->delete();
                                    MealsTypes::insert($meal_data);
                                }
                            }


                        }

                        if(isset($request->restaurant_location) && !empty($request->restaurant_location)){
                            $service_provider_rates['restaurant_location'] = $request->restaurant_location;
                        }
                        if(isset($request->restaurant_name) && !empty($request->restaurant_name)){
                            $service_provider_rates['restaurant_name'] = $request->restaurant_name;
                        }
                        if(isset($request->experties) && !empty($request->experties)){
                            $service_provider_rates['experties'] = $request->experties;
                        }

                        if(isset($request->payment_mode) && !empty($request->payment_mode)){
                            $service_provider_rates['payment_mode'] = $request->payment_mode;
                        }
                        if(isset($request->payment_partial_value) && !empty($request->payment_partial_value)){
                            $service_provider_rates['payment_partial_value'] = $request->payment_partial_value;
                        }
                        if(isset($request->terms_rule) && !empty($request->terms_rule)){
                            $service_provider_rates['terms_rule'] = $request->terms_rule;
                        }

                        $service_provider_rates['user_id'] = auth()->user()->id;



                        ServiceProviderRate::updateOrCreate(['user_id'=>$data->id],$service_provider_rates);

                        $users = User::where('id',auth()->user()->id)->first()->toArray();

                        if(!empty($users) && isset($users['user_services']) && !empty($users['user_services'])){
                            $user = User::find(auth()->user()->id);
                            $user->user_module_type =  $users['user_services'][0]['user_module_type'];
                            $user->save();
                        }

                    }

                    if(isset(request()->our_expertise_ids) && !empty(request()->our_expertise_ids)){
                        $our_expertise_ids = json_decode(request()->our_expertise_ids, true);
                        $user_id = !is_null(auth()->user()) ? auth()->user()->id : 0;

                        if(!empty($our_expertise_ids)){
                            if($user = User::find($user_id)){
                                $user->ourExpertise()->sync($our_expertise_ids);
                            }
                        }
                    }

                    if(isset(request()->transport_company_fleet_ids) && !empty(request()->transport_company_fleet_ids)){
                        $transport_company_fleet_ids = json_decode(request()->transport_company_fleet_ids, true);
                        $user_id = !is_null(auth()->user()) ? auth()->user()->id : 0;

                        if(!empty($transport_company_fleet_ids)){
                            if($user = User::find($user_id)){
                                $user->transportCompanyFleet()->sync($transport_company_fleet_ids);
                            }
                        }
                    }
                    if(isset(request()->transport_company_service_ids) && !empty(request()->transport_company_service_ids)){
                        $transport_company_service_ids = json_decode(request()->transport_company_service_ids, true);
                        $user_id = !is_null(auth()->user()) ? auth()->user()->id : 0;

                        if(!empty($transport_company_service_ids)){
                            if($user = User::find($user_id)){
                                $user->transportCompanyService()->sync($transport_company_service_ids);
                            }
                        }
                    }


                }

                if(isset(request()->general_services) && !empty(request()->general_services)){
                    $general_services = json_decode(request()->general_services, true);
                    $users = request()->user();
                    if(!empty($general_services) && !empty($users)){
                        $users->generalServices()->sync(array_column($general_services, 'id'));
                    }
                }

                $data = [];
                $data = User::find(auth()->user()->id);


                if(isset($data) && !empty($data) && $data->is_company == 1){
                    $datas = [];
                    if(isset($request->company_name) && !empty($request->company_name)){
                        $datas['name'] = $request->company_name;
                    }

                    if(isset($request->tag_line) && !empty($request->tag_line)){
                        $datas['tag_line'] = $request->tag_line;
                    }
                    if(isset($request->about_company) && !empty($request->about_company)){
                        $datas['about'] = $request->about_company;
                    }else{
                        if(isset($request->about) && !empty($request->about)){
                            $datas['about'] = $request->about;
                        }
                    }

                    if(isset($request->team_size) && !empty($request->team_size)){
                        $datas['team_size'] = $request->team_size;
                    }

                    if(isset($request->is_company_registered) && !empty($request->is_company_registered)){
                        $datas['is_company_registered'] = $request->registration_no ? 1 : 0;
                    }
                    if(isset($request->registration_no) && !empty($request->registration_no)){
                        $datas['registration_no'] = $request->registration_no;
                    }


                    $datas['user_id'] = auth()->user()->id;

                    Company::updateOrCreate(['user_id'=> auth()->user()->id],$datas);
                }

                $title = "Profile Update";
                $message = "Your Profile has been Updated.";
                $action     = "account_info";
                $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();

                if(isset($admin) && !empty($admin)){
                     PushNotification::createNotification(auth()->user(),$admin->id,$title,$message,User::TYPE_PROFILE,$action,auth()->user()->id);
                }

                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'User has been updated';
                $this->response['data'] = $data->makeVisible(['api_token']);


            }else{
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = 'Invalid Information.';
            }
        }else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid Information.';
        }
        return response()->json($this->response, $this->status);
    }
    public function detail($Id){
        $relatedData =   User::take(4)->get();

        $detail =  User::with(['ServiceProviderRates','trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])->with('activity')->with('trips')->where('id',$Id)->first();
        return response()->json(['detail'=>$detail,'relatedData'=>$relatedData]);
    }

    public function Imagestore($request){
        if(isset($request->image)){
            request()->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,NEF,nef,svg',
            ]);
            if($files = $request->file('image')){
                $image_full_name = pathinfo($files->getClientOriginalName(), PATHINFO_FILENAME).'_'.time().'.'.$files->getClientOriginalExtension();
                $destinationPath = public_path('/assets/uploads/users'); //Creating Sub directory in Public
                $files->move($destinationPath,$image_full_name);
                $data =  $request->user();
                $data->image = $image_full_name;
                $data->save();

                $title      = "Image";
                $message    = "Image updated successfully";
                $action     = "account_info";
                $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();
                if(isset($admin) && !empty($admin)){
                    PushNotification::createNotification($request->user(),$admin->id,$title,$message,\App\Models\User::TYPE_PROFILE,$action,$request->user()->id);
                    $message    =$request->user()->name." has updated the profile image";
                    PushNotification::createNotification($admin,$request->user()->id,$title,$message,\App\Models\User::TYPE_PROFILE,$action,$request->user()->id);
                }

            }
        }
    }
    public function companyImagestore($request){

        if(isset($request->company_image)){
            request()->validate([
                'company_image' => 'image|mimes:jpeg,png,jpg,gif,NEF,nef,svg',
            ]);
            if($files = $request->file('company_image')){

                $image_full_name = pathinfo($files->getClientOriginalName(), PATHINFO_FILENAME).'_'.time().'.'.$files->getClientOriginalExtension();
                $destinationPath = public_path('/assets/uploads/companies'); //Creating Sub directory in Public
                $files->move($destinationPath,$image_full_name);
                $data = Company::where('user_id', auth()->user()->id)->first();
                $data->image = $image_full_name;
                $data->save();

                $title      = "Image";
                $message    = "Image updated successfully";
                $action     = "account_info";
                $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();
                if(isset($admin) && !empty($admin)){
                    PushNotification::createNotification($request->user(),$admin->id,$title,$message,\App\Models\User::TYPE_PROFILE,$action,$request->user()->id);
                    $message    =$request->user()->name." has updated the profile image";
                    PushNotification::createNotification($admin,$request->user()->id,$title,$message,\App\Models\User::TYPE_PROFILE,$action,$request->user()->id);
                }
            }
        }
    }
    public function userActivityAdd(Request $request){
        $data =[];
        UserActivity::where('user_id',$request->user()->id)->delete();
        $response = explode(',', $request->activity);
        foreach($response as $row){
            $activity_explode = explode('|',$row);
            array_push($data, ['name'=>$activity_explode[0], 'user_id'=> $request->user()->id,'image'=>$activity_explode[1]]);
        }

        if(UserActivity::insert($data)){
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'User activities  updated.';
        }else{
            $this->status = 500;
            $this->response['success'] = false;
            $this->response['message'] = 'Something went wrong!.';
        }
        return response()->json($this->response, $this->status);
    }
    public function getUserProfile(Request $request){

        if(!is_null(auth()->user()) && auth()->user()->type == 1){
            $user=  User::with(['ServiceProviderRates','trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])->withAvg('rating_values', 'average_rating')
                ->withAvg('trips_vendor_ratings', 'rating_value')
                ->where('id',$request->user()->id)->first();
        }else{

            $user=  User::with(['ServiceProviderRates','trips', 'activitiesWeDo', 'ourExpertise', 'rating_values', 'transportCompanyFleet', 'transportCompanyService'])
                        ->withAvg('rating_values', 'average_rating')
                        ->withAvg('trips_vendor_ratings', 'rating_value')
                        ->where('id',$request->user()->id)->first();
        }

        $tripsCount = Trip::where('user_id',$request->user()->id)->count();
        $user->tripsCount = $tripsCount;
        $user->comments = 100;
        $user->tripFriends = 29;
        $user->feedbacks = 400;
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $user->makeVisible(['api_token']);
        return response()->json($this->response, $this->status);
    }
    public function getUserDocuments(Request $request){
        $documents=  UserDocument::where('user_id',$request->user()->id)->orderBy('id', 'DESC')->get();
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Successfully Fetched';
        $this->response['data'] = $documents;
        return response()->json($this->response, $this->status);
    }
    public function deleteDocument($document_id){
        UserDocument::where('id',$document_id)->delete();
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Document deleted successfully';
        return response()->json($this->response, $this->status);
    }
    public function userDocumentFrontImage($request){
        try {
            if ($files = $request->file('frontImage')) {
                $image_full_name = pathinfo($files->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('/assets/uploads/users'); //Creating Sub directory in Public
                $img = \Image::make($files->getRealPath());
                $width = getimagesize($files)[0];
                $height = getimagesize($files)[1];
                if ($width > 3000) {
                    $width = $width / 4;
                    $height = $height / 4;
                }
                if ($width > 2000) {
                    $width = $width / 3;
                    $height = $height / 3;
                }
                if ($width > 1000) {
                    $width = $width / 2;
                    $height = $height / 2;
                }

                $img->resize($width, $height, function ($constraint) {
                    // $img->resize(400, 150, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $image_full_name);
                return $image_full_name;

            }

        } catch (Exception $e) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = "Image Size is greater than 5 MB";
            return response()->json($this->response, $this->status);
        }
    }
    public function userDocumentBackImage($request){
        try {
            if ($files = $request->file('backImage')) {
                $image_full_name = pathinfo($files->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('/assets/uploads/users'); //Creating Sub directory in Public
                $img = \Image::make($files->getRealPath());
                $width = getimagesize($files)[0];
                $height = getimagesize($files)[1];
                if ($width > 3000) {
                    $width = $width / 4;
                    $height = $height / 4;
                }
                if ($width > 2000) {
                    $width = $width / 3;
                    $height = $height / 3;
                }
                if ($width > 1000) {
                    $width = $width / 2;
                    $height = $height / 2;
                }

                $img->resize($width, $height, function ($constraint) {
                    // $img->resize(400, 150, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $image_full_name);

                return $image_full_name;
            }

        } catch (Exception $e) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = "Image Size is greater than 5 MB";
            return response()->json($this->response, $this->status);

        } catch (Exception $e) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = "Image Size is greater than 5 MB";
            return response()->json($this->response, $this->status);
        }
    }
    public function AddUserDocument(Request $request){
        $UserDocument ='';
        if(isset($request->id)){
            $validator = Validator::make($request->all(), [
                'frontImage' => 'image|mimes:jpeg,png,jpg,gif,NEF,nef,svg|max:5120',
                'backImage' => 'image|mimes:jpeg,png,jpg,gif,NEF,nef,svg|max:5120',
                'expiryDate' => 'required',
                'document_type' => 'required',
            ]);
            if ($validator->fails()) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = $validator->messages()->first();
                return response()->json($this->response, $this->status);
            }
            $UserDocument = UserDocument::where('id', $request->id)->first();

            if($UserDocument->type != $request->document_type){
                $alreadytypeExist = UserDocument::where('type', $request->document_type)->where('user_id',$request->user()->id)->first();

                if ($alreadytypeExist) {
                    $this->status = 422;
                    $this->response['success'] = false;
                    $this->response['message'] = "this type of document already added";
                    return response()->json($this->response, $this->status);
                }
            }

            $UserDocument = UserDocument::where('id', $request->id)->first();
            $log = new  Log;

        }else{
            $validator = Validator::make($request->all(), [
                'frontImage' => 'required|image|mimes:jpeg,png,jpg,gif,NEF,nef,svg|max:5120',
                'backImage' => 'required|image|mimes:jpeg,png,jpg,gif,NEF,nef,svg|max:5120',
                'expiryDate' => 'required',
                'document_type' => 'required',
            ]);
            if ($validator->fails()) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = $validator->messages()->first();
                return response()->json($this->response, $this->status);
            }
            $documentsCount = UserDocument::where('user_id',$request->user()->id)->count();

            if ($documentsCount == 2) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = "maximum documents already added,you can't more";
                return response()->json($this->response, $this->status);
            }
            $alreadytypeExist = UserDocument::where('type', $request->document_type)->where('user_id',$request->user()->id)->first();

            if ($alreadytypeExist) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = "this type of document already added";
                return response()->json($this->response, $this->status);
            }

        }


        // $alreadyExist = UserDocument::where('type', $request->document_type)->where('identitity_number',$request->identitity_number)->where('user_id',$request->user()->id)->first();

        // if ($alreadyExist) {
        //     $this->status = 422;
        //     $this->response['success'] = false;
        //     $this->response['message'] = "Document already existed";
        //     return response()->json($this->response, $this->status);
        // }
        $front = isset($request->frontImage) ? $this->userDocumentFrontImage($request) : $UserDocument->front;
        $back = isset($request->backImage) ? $this->userDocumentBackImage($request) : $UserDocument->back;

        $data = UserDocument::updateOrCreate(
            [ 'id' => $request->id ],
            [ 'user_id' => auth()->user()->id,
                'type' => $request->document_type,
                'expiry' => date("Y-m-d", strtotime($request->expiryDate)),
                'front' => $front,
                'back' => $back,
                'identitity_number' => $request->identitity_number,
            ]
        );

        $title      = "Document";
        $action     = "account_info/identification";
        $admin = User::where('role_id',User::ADMIN_ROLE_ID)->first();

        if(isset($request->id)){
            $message    = "Document updated successfully";
            $messageForAdmin    = $request->user()->name." updated the document";
            $log->logable  = "App\\Models\\". $request->model;
            $log->logable_id  = $request->id;
            $log->log  = $data->toArray();
            $log->save();
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Document updated successfully';
        }else{
            $messageForAdmin    = $request->user()->name." added the document";
            $message    = "Document added successfully";
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Document added successfully';
        }
        if(isset($admin) && !empty($admin)){
            
            PushNotification::createNotification($request->user(),$admin->id,$title,$message,User::TYPE_DOCUMENT,$action,$request->user()->id);

            PushNotification::createNotification($admin,$request->user()->id,$title,$messageForAdmin,User::TYPE_VERIFIED,$action,$request->user()->id);
        }

        return response()->json($this->response, $this->status);
    }
    public function deleteUser(){

        $user = Auth::user();
        $this->status = 422;
        $this->response['success'] = false;
        $this->response['message'] = 'Unauthenticated User';

        if($user){
            
            // $users = DB::table('enteries')->where('user_id', auth()->user()->id)->delete();
            
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'User has been deleted successfully.';
            return response()->json($this->response, $this->status);
        }
        return response()->json($this->response, $this->status);
    
    }
    public function addAndUpdateActivitiesWeDo(){

        $this->status = 422;
        $this->response['success'] = false;
        $this->response['message'] = 'someThing went wrong';

        $activities_ids = json_decode(request()->activities_ids, true);
        $user_id =  !is_null(auth()->user()) ? auth()->user()->id : 0;

        if(!empty($activities_ids)){
            if($user = User::find($user_id)){
                $user->activitiesWeDo()->sync($activities_ids);
                $title      = "Activities added";
                $message    = "Activities added successfully";
                $action     = "api/addAndUpdateActivitiesWeDo";
                PushNotification::createNotification(auth()->user(),1,$title,$message,User::TYPE_ACTIVITY,$action);

                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'Activities added successfully';
            }
        }

        return response()->json($this->response, $this->status);
    }
    public function addAndUpdateOurExpertise(){
        $this->status = 422;
        $this->response['success'] = false;
        $this->response['message'] = 'SomeThing went wrong';

        $our_expertise_ids = json_decode(request()->our_expertise_ids, true);
        $user_id = !is_null(auth()->user()) ? auth()->user()->id : 0;

        if(!empty($our_expertise_ids)){
            if($user = User::find($user_id)){
                $user->ourExpertise()->sync($our_expertise_ids);
                $title      = "Expertise added";
                $message    = "Expertise added successfully";
                $action     = "api/addAndUpdateOurExpertise";
                PushNotification::createNotification(auth()->user(),1,$title,$message,User::TYPE_EXPERTISE,$action);

                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'Expertise added successfully';
            }
        }

        return response()->json($this->response, $this->status);
    }


    public function copyImageToThumb($ids){
        // dd(json_decode($ids));
        if(isset($ids) && !empty($ids)){
            $users = User::select('id', 'image')->whereIn('id', json_decode($ids))->get();
            if(isset($users) && !empty($users)){
                foreach ($users as $key => $value) {

                    $path = public_path('/assets/uploads/users');
                    if(file_exists($path.'/'.$value->image)){
                        if(!file_exists($path.'/'.$value->image.'_thumb.jpg')){
                            File::copy($path.'/'.$value->image, $path.'/'.$value->image.'_thumb.jpg');
                        }
                    }
                }

                return 'image copied successfull';
            }
        }
        return 'something went wrong';
    }

    public function copiedRestaurantAddress(){

        $users = User::where('user_module_type', 'restaurants')->get();
        $array_data = [];
        if(isset($users) && !empty($users)){
            foreach ($users as $key => $value) {
                if(isset($value->ServiceProviderRates) && !empty($value->ServiceProviderRates)){
                    if(isset($value->ServiceProviderRates->restaurant_location) && !empty($value->ServiceProviderRates->restaurant_location)){
                        array_push($array_data,['id' => $value->id, 'restaurant_location' => $value->ServiceProviderRates->restaurant_location]);
                    }
                }
            }
        }
        if(!empty($array_data)){
            foreach ($array_data as $key => $value) {
                $data = getLatLong($value['restaurant_location']);
                if(!empty($data)){
                    $user = User::find($value['id']);
                    if(!empty($user)){
                        $user->restaurant_lat = $data['latitude'];
                        $user->restaurant_lng = $data['longitude'];
                        $user->restaurant_location = $value['restaurant_location'];
                        $user->save();
                    }
                }
            }
        }
        dd($array_data);
        // $data = getLatLong('Via Aldo Manuzio, 66b, 00153 Roma RM, Italy');
    }

}
