<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Models\Visitor;

/**
 * @param $email
 * @return mixed
 *
 * @Author Khuram Qadeer.
 */
function getUserByEmail($email)
{
    return \App\User::whereEmail($email)->first();
}

/**
 * @Description check user exist or not by email
 *
 * @param $email
 * @return bool
 *
 * @Author Khuram Qadeer.
 */
function checkUserEmailExist($email)
{
    $res = false;
    if (\App\User::whereEmail($email)->exists())
        $res = true;
    return $res;
}

/**
 * @Description Get Current Url Segments by enter Segment Number
 *
 * @param $segmentNo
 * @return string|null
 *
 * @Author Khuram Qadeer.
 */
function getUrlSegment($segmentNo)
{
    return Request::segment($segmentNo);
}

/**
 * @Description Get Domain Name
 * @return string
 *
 * @Author Khuram Qadeer.
 */
function getDomainName()
{
    $url = url()->current();
    $parse = parse_url($url);
    return $parse['scheme'] . '://' . $parse['host'];
}

/**
 * @Description Delete file form avatar object
 * @param $avatarArray
 *
 * @Author Khuram Qadeer.
 */
function deleteFile($avatarArray)
{
    if ($avatarArray) {
        $avatar = json_decode($avatarArray);
        if (File::exists($avatar->path . $avatar->fileName))
            File::delete($avatar->path . $avatar->fileName);
    }
}


/**
 * @Description Get User Role Id
 * @param $userId
 * @return mixed
 * @Author Khuram Qadeer.
 */
function getUserRole($userId)
{
    $user = \App\User::find($userId);
    return $user['role_id'];
}

/**
 * @Description Get Split Avatar object
 * @param null $avatar
 * @param $key
 * @return string
 * @Author Khuram Qadeer.
 */
function getSplitAvatar($avatar = null, $key = null, $defaultImage = null)
{
    $res = '/basic/img/default-img.png';
    if ($defaultImage)
        $res = $defaultImage;
    if ($avatar) {
        $avatar = json_decode($avatar);
        if ($avatar->$key)
            $res = $avatar->$key;
    }
    return $res;
}

/**
 * @Description Get Current URL Name
 * @return string|null
 * @Author Khuram Qadeer.
 */
function getCurrentRouteName()
{
    return Route::currentRouteName();
}

/**
 * @Description Not Allow Routes for "/basic/css/bootstrap-material-design.min.css" file add into header or not
 * @return bool
 * @Author Khuram Qadeer.
 */
function allowedRotuesForMDBootstrap()
{
//    dd(getCurrentRouteName());
    $res = false;
    if (getCurrentRouteName() == 'signup.login' || getCurrentRouteName() == 'signup'
        || getCurrentRouteName() == 'user.setting' || getCurrentRouteName() == 'trips.create.previous'
        || getCurrentRouteName() == 'trips.previous.edit' || getCurrentRouteName() == 'packages.create'
        || getCurrentRouteName() == 'packages.editPackage' || getCurrentRouteName() == '/'
        || getCurrentRouteName() == 'planned.create' || getCurrentRouteName() == 'planned.edit'
        || getCurrentRouteName() == 'interest.create' || getCurrentRouteName() == 'interest.edit'
        || getCurrentRouteName() == 'home.search'
    ) {
        $res = true;
    }
    return $res;
}

/**
 * @Description Update Currencies in table with base table
 * @Author Khuram Qadeer.
 */
function updateCurrencies()
{
    $res = json_decode(file_get_contents('https://api.exchangerate-api.com/v4/latest/USD'), true);
    $rates = $res['rates'];
    if ($rates) {
        foreach ($rates as $countryCode => $rate) {
            $isBase = false;
            if ($countryCode == 'USD') {
                $isBase = true;
            }
            \App\Currency::updateOrCreate([
                'rate' => $rate,
                'is_base' => $isBase
            ], [
                'code' => $countryCode
            ]);
        }
    }

}

/**
 * @Description Split Notification body and get by key
 * @param $body
 * @param $key
 * @return array|string|null
 * @Author Khuram Qadeer.
 */
function getNotificationBodyByKey($body, $key)
{
    $res = null;
    $bodyArr = json_decode($body);
    if ($bodyArr) {
        foreach ($bodyArr as $item) {
            if ($item->key == $key) {
                if ($key == 'location') {
                    $res = (array)$item->value;
                } else {
                    $res = $item->value;
                }
                break;
            }
        }
    }
    return $res;
}

/**
 * @Description Get Strip Token
 * @param $cardName
 * @param $expireMonth
 * @param $expireYear
 * @param $cvc
 * @return array
 * @throws \Stripe\Exception\ApiErrorException
 * @Author Khuram Qadeer.
 */
function getStripeToken($cardName, $expireMonth, $expireYear, $cvc)
{
    $res = [];
    \Stripe\Stripe::setApiKey('sk_test_C7RtydDPoqNKrmRCPEx3A8mk00RAiW9At7');
    try {
        $res['token'] = \Stripe\Token::create([
            'card' => [
                'number' => $cardName,
                'exp_month' => $expireMonth,
                'exp_year' => $expireYear,
                'cvc' => $cvc
            ]
        ]);
    } catch (\Stripe\Exception\CardException $e) {
        $res['error'] = $e->getMessage();
    }
    return $res;
}

/**
 * @Description Create Customer on Stripe
 * @param $clientId
 * @param $clientEmail
 * @param $stripeToken
 * @return array
 * @Author Khuram Qadeer.
 */
function createStripeCustomer($clientId, $clientEmail, $stripeToken)
{
    $res = [];
    try {
        $res['customer'] = \Stripe\Customer::create([
            "description" => "ClientID: " . $clientId . " Email: " . $clientEmail,
            "source" => $stripeToken // obtained with Stripe.js
        ]);
    } catch (\Stripe\Exception\ApiErrorException $e) {
        $res['error'] = $e->getMessage();
    }
    return $res;
}

/**
 * @Description Save Card on Stripe
 * @param $stripeCustomerId
 * @param $stripeToken
 * @return array
 * @Author Khuram Qadeer.
 */
function saveCardOnStripe($stripeCustomerId, $stripeToken)
{
    $res = [];
    try {
        $res['card'] = \Stripe\Customer::createSource(
            $stripeCustomerId,
            [
                'source' => $stripeToken,
            ]
        );
    } catch (\Stripe\Exception\ApiErrorException $e) {
        $res['error'] = $e->getMessage();
    }
    return $res;
}

/**
 * @Description Stripe Charge Amount
 * @param $customerId
 * @param $cardId
 * @param $amount
 * @return array
 * @Author Khuram Qadeer.
 */
function stripeCharge($customerId, $cardId, $amount)
{
    $res = [];
    try {
        \Stripe\Stripe::setApiKey('sk_test_C7RtydDPoqNKrmRCPEx3A8mk00RAiW9At7');
        $intent = \Stripe\PaymentIntent::create([
            'amount' => round($amount * 100),
            'currency' => 'usd',
            'customer' => $customerId,
            'payment_method' => $cardId,
        ]);
        $intent = \Stripe\PaymentIntent::retrieve($intent->id);
        $confirm = $intent->confirm([
            'payment_method' => $cardId,
        ]);
        $res['charge'] = $confirm->charges->data[0]->id;
    } catch (\Stripe\Exception\ApiErrorException $e) {
        $res['error'] = $e->getMessage();
    }
    return $res;
}

/**
 * @Description Get role name by role id for profile show
 * @param null $roleId
 * @return string
 * @Author Khuram Qadeer.
 */
function getRoleNameForProfile($roleId = null)
{
    $roleName = 'traveller';
    if ($roleId == null) {
        $roleName = 'traveller';
    } else {
        if ($roleId == 4) {
            $roleName = 'guide';
        } elseif ($roleId == 5) {
            $roleName = 'photographer';
        } elseif ($roleId == 6) {
            $roleName = 'visa_consultant';
        } elseif ($roleId == 9) {
            $roleName = 'movie_maker';
        }
    }
    return $roleName;
}

/**
 * @Description Get data form any table from near by location via latitude,longitude,
 *
 * @param $tableName
 * @param $startLatitude
 * @param $startLongitude
 * @param $columnNameLatitude
 * @param $columnNameLongitude
 * @param $distanceInKiloMeters
 * @param $limit
 * @return array
 *
 * @Author Khuram Qadeer.
 */
function getNearByData($tableName, $columnNameLatitude, $columnNameLongitude, $startLatitude, $startLongitude, $distanceInKiloMeters, $limit)
{
    return \Illuminate\Support\Facades\DB::select("SELECT * FROM (
            SELECT *, 
                (
                    (
                        (
                            acos(
                                sin(( $startLatitude * pi() / 180))
                                *
                                sin(( $columnNameLatitude * pi() / 180)) + cos(( $startLatitude * pi() /180 ))
                                *
                                cos(( $columnNameLatitude * pi() / 180)) * cos((($startLongitude - $columnNameLongitude) * pi()/180)))
                        ) * 180/pi()
                    ) * 60 * 1.1515 * 1.609344
                )
            as distance FROM $tableName
        ) $tableName
        WHERE distance <= $distanceInKiloMeters
        ORDER By distance 
        LIMIT $limit");
}

/**
 * @Description get all hosts users accommodations
 * @return array
 * @Author Khuram Qadeer.
 */
function getAllHostAccommodations()
{
    $res = [];
    $users = \App\User::where('is_host', 1)->get();
    if ($users) {
        foreach ($users as $user) {
            $data = \App\User::getAllUserData($user->id);
            if ($data) {
                $accommodations = $data['host_accommodations'];
                if ($accommodations) {
                    foreach ($accommodations as $accommodation) {
                        array_push($res, $accommodation);
                    }
                }
            }
        }
    }
    return $res;
}


/**
 * @Description get all hosts users meals
 * @return array
 * @Author Khuram Qadeer.
 */
function getAllHostMeals()
{
    $res = [];
    $users = \App\User::where('is_host', 1)->get();
    if ($users) {
        foreach ($users as $user) {
            $data = \App\User::getAllUserData($user->id);
            if ($data) {
                $meals = $data['host_meals'];
                if ($meals) {
                    foreach ($meals as $meal) {
                        array_push($res, $meal);
                    }
                }
            }
        }
    }
    return $res;
}


/**
 * @Description get all hosts users transport
 * @return array
 * @Author Khuram Qadeer.
 */
function getAllHostTransports()
{
    $res = [];
    $users = \App\User::where('is_host', 1)->get();
    if ($users) {
        foreach ($users as $user) {
            $data = \App\User::getAllUserData($user->id);
            if ($data) {
                $transports = $data['host_transports'];
                if ($transports) {
                    foreach ($transports as $transport) {
                        array_push($res, $transport);
                    }
                }
            }
        }
    }
    return $res;
}


/**
 * @Description get all hosts users Activities
 * @return array
 * @Author Khuram Qadeer.
 */
function getAllHostActivities()
{
    $res = [];
    $users = \App\User::where('is_host', 1)->get();
    if ($users) {
        foreach ($users as $user) {
            $data = \App\User::getAllUserData($user->id);
            if ($data) {
                $activities = $data['host_activities'];
                if ($activities) {
                    foreach ($activities as $activity) {
                        array_push($res, $activity);
                    }
                }
            }
        }
    }
    return $res;
}

/**
 * @Description get all hosts users Activities
 * @return array
 * @Author Khuram Qadeer.
 */
function getAllVerifiedHosts()
{
    $res = [];
    $users = \App\User::where('is_host', 1)->get();
    if ($users) {
        foreach ($users as $user) {
            $data = \App\User::getAllUserData($user->id);
            array_push($res, $data);
        }
    }
    return $res;
}

/**
 * @Description get all hosts users Activities
 * @return array
 * @Author Khuram Qadeer.
 */
function getTopRatedHosts()
{
    $res = [];
    $users = \App\User::where('is_host', 1)->get();
    if ($users) {
        foreach ($users as $user) {
            $data = \App\User::getAllUserData($user->id);
            array_push($res, $data);
        }
    }
    return $res;
}

/**
 * @Description Get All Dates Between two dates
 * @param $startDate
 * @param $endDate
 * @param string $format
 * @return array
 * @Author Khuram Qadeer.
 */
function getAllDatesBetween($startDate, $endDate, $format = 'm-d-Y')
{
    $dates = [];
    $current = strtotime($startDate);
    $date2 = strtotime($endDate);
    $stepVal = '+1 day';
    while ($current <= $date2) {
        $dates[] = date($format, $current);
        $current = strtotime($stepVal, $current);
    }
    return $dates;
}

/**
 * @Description Convert all single dates array to start date and end date object like {start: '07/10/2020',end:'07/15/2020'}
 * @param $allDates
 * @param string $explodeBy
 * @return array
 * @Author Khuram Qadeer.
 */
function convertDatesArrayToStartEndObject($allDates, $explodeBy = '-')
{
    $res = [];
    $prevIndex = null;
    $start = $end = $currentDay = $currentMonth = $prevMonth = $nextDay = '';
    if ($allDates) {
        foreach ($allDates as $i => $allDate) {
            $currentMonth = (int)explode($explodeBy, $allDate)[0];
            $currentDay = (int)explode($explodeBy, $allDate)[1];
            if ($i == 0) {
                $start = str_replace($explodeBy, '/', $allDate);
                $end = str_replace($explodeBy, '/', $allDate);
                $prevIndex = $i;
                $res[$prevIndex] = ['start' => $start, 'end' => $end];
            } else {
                $end = str_replace($explodeBy, '/', $allDate);
                if ($currentMonth == $prevMonth && $currentDay == $nextDay) {
                    $res[$prevIndex] = ['start' => $start, 'end' => $end];
                } else {
                    $prevIndex = $i;
                    $start = str_replace($explodeBy, '/', $allDate);
                }
            }
            $nextDay = $currentDay + 1;
            $prevMonth = $currentMonth;
        }

        //        index sorting
        $datesIndexSorted = [];
        if ($res) {
            foreach ($res as $item) {
                if ($item['start'] && $item['end'])
                    array_push($datesIndexSorted, ['start' => $item['start'], 'end' => $item['end']]);
            }
        }
        $res = $datesIndexSorted;
    }
    return $res;
}




function getLatLng(){
    $ip_address = file_get_contents('https://api.ipify.org');
    // dd($ip_address);

    dd(IPtoLocation($ip_address));
}


function IPtoLocation($ip){ 
    $apiURL = 'https://freegeoip.app/json/'.$ip; 
    // $ip = "66.96.147.144";
    $geoPlugin_array = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip) );
    echo '<pre>';
    print_r($geoPlugin_array);
    

    echo "<br>";

    // IP address 
$userIP = '162.222.198.75'; 
 
// API end URL 
$apiURL = 'https://freegeoip.app/json/'.$userIP; 
 
// Create a new cURL resource with URL 
$ch = curl_init($apiURL); 
 
// Return response instead of outputting 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
 
// Execute API request 
$apiResponse = curl_exec($ch); 
 
// Close cURL resource 
curl_close($ch); 
 
// Retrieve IP data from API response 
$ipData = json_decode($apiResponse, true); 
 
if(!empty($ipData)){ 
    $country_code = $ipData['country_code']; 
    $country_name = $ipData['country_name']; 
    $region_code = $ipData['region_code']; 
    $region_name = $ipData['region_name']; 
    $city = $ipData['city']; 
    $zip_code = $ipData['zip_code']; 
    $latitude = $ipData['latitude']; 
    $longitude = $ipData['longitude']; 
    $time_zone = $ipData['time_zone']; 
     
    echo 'Country Name: '.$country_name.'<br/>'; 
    echo 'Country Code: '.$country_code.'<br/>'; 
    echo 'Region Code: '.$region_code.'<br/>'; 
    echo 'Region Name: '.$region_name.'<br/>'; 
    echo 'City: '.$city.'<br/>'; 
    echo 'Zipcode: '.$zip_code.'<br/>'; 
    echo 'Latitude: '.$latitude.'<br/>'; 
    echo 'Longitude: '.$longitude.'<br/>'; 
    echo 'Time Zone: '.$time_zone; 
}else{ 
    echo 'IP data is not found!'; 
} 

     
    // Make HTTP GET request using cURL 
    $ch = curl_init($apiURL); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    $apiResponse = curl_exec($ch); 
    if($apiResponse === FALSE) { 
        $msg = curl_error($ch); 
        curl_close($ch); 
        return false; 
    } 
    curl_close($ch); 
     
    // Retrieve IP data from API response 
    $ipData = json_decode($apiResponse, true); 
     
    // Return geolocation data 
    return !empty($ipData)?$ipData:false; 
}


// google captacha site verify
function captachSiteverify($token){
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $secret = '6LcBFJciAAAAAD1p5qEi5Emd8vDEhNNhuQDSHvve';
    $rempte_id = $_SERVER['REMOTE_ADDR'];

    $response = file_get_contents($url.'?secret='.$secret.'&response='.$token);
    $result = json_decode($response);
    return $result;
    if($result && $result->success == true){
        return true;
    }else{
        return false;
    }

}

function percentage($num, $per)
{
  return (($num/100)*$per);
}



function getLatLong($address){
    if(!empty($address)){
        //Formatted address
        $formattedAddr = str_replace(' ','+',$address);
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=true_or_false&key=AIzaSyBURKqVNB1eT1EPIj4KqCh2N4zwlo_aLW4';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3000); // 3 sec.
        curl_setopt($ch, CURLOPT_TIMEOUT, 10000); // 10 sec.
        $result = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($result);
        $data = [];
        if($output && isset($output->results[0]) && !empty($output->results[0]->geometry)){
            $data['latitude']  = $output->results[0]->geometry->location->lat; 
            $data['longitude'] = $output->results[0]->geometry->location->lng;
        }
        return $data;
    }else{
        return false;   
    }
}



if(!function_exists('addCounter')){
    function addCounter($module_name, $package_id){
        $ip = hash('sha512', request()->ip());
        if (Visitor::where('date', today())->where('ip', $ip)->where('module_name', $module_name)->where('package_id', $package_id)->count() < 1)
        {
            Visitor::create([
                'date' => today(),
                'ip' => $ip,
                'module_name' => $module_name,
                'package_id' => $package_id,
            ]);
        }
    }
}