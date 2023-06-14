<?php

namespace App\Traits;

use App\Models\Accommodation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use DB;
use Illuminate\Support\Facades\Config;

trait RadiusDistanceTrait
{

    // measure distance using latlng
    function findNearest($table, $lat, $lng, $radius = 30)
    {
        $distanceMeasure = DB::table($table)
            ->selectRaw("id, lat, lng,
                ( 6371000 * acos( cos( radians(?) ) *
                cos( radians( lat ) )
                * cos( radians( lng ) - radians(?)
                ) + sin( radians(?) ) *
                sin( radians( lat ) ) )
                ) AS distance", [$lat, $lng, $lat])
            ->having("distance", "<", $radius)->orderBy("distance", 'asc')
            ->first();
        $distance = $distanceMeasure->distance;
        return $distance;
    }

    // get users with in given latlng 

    public function getWithInLatLng($model, $radius, $lat, $lng)
    {
       
        $markerResult = $model::where('is_publish',1)->whereRaw($lat . ' <= (`lat` + (' . (0.00898315284 * $radius) . '))')
            ->whereRaw($lat . ' >= (`lat` - (' . (0.00898315284 * $radius) . '))')
            ->whereRaw($lng . ' <= (`lng` + (' . (0.00898315284 * $radius) . '))')
            ->whereRaw($lng . ' >= (`lng` - (' . (0.00898315284 * $radius) . '))')
            ->paginate(Config::get('global.pagination_records'));
        
        //===============================
      
        // $markerResult = ("SELECT *, 
        // ( 6371 * acos( cos( radians($lat) ) 
        // * cos( radians( latitude ) ) 
        // * cos( radians( longitude ) - radians($lng) ) + sin( radians($lat) ) 
        // * sin( radians( latitude ) ) ) ) 
        // AS calculated_distance 
        // FROM accommodations as T 
        // HAVING calculated_distance <= (SELECT distance FROM accommodations WHERE sid=T.sid) 
        // ORDER BY distance_calc") ;
        return $markerResult;
    }

    // calculate distance between 2 latlng  

    function point2point_distance($lat1, $lon1, $lat2, $lon2, $unit = 'K')
    {
        
        $theta = floatval($lon1) - floatval($lon2);
        $theta = intval(ceil($theta));
        $dist = sin(deg2rad(floatval($lat1))) * sin(deg2rad(floatval($lat2))) +  cos(deg2rad(floatval($lat1))) * cos(deg2rad(floatval($lat2))) * cos(deg2rad(intval($theta)));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            $miles = $miles * 1.609344;
            $miles = substr($miles, 0, 5);
            return $miles;
        } else if ($unit == "N") {
            $miles = $miles * 0.8684;
            $miles = substr($miles, 0, 5);
            return $miles;
        } else {
            return $miles;
        }
    }
}
