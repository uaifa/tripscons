<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\Accommodation;
use App\Models\Experience;
use App\Models\Guide;
use App\Models\Transport;
use App\Models\Meal;

trait ServiceTrait
{

    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function deleteServices($module, $id)
    {
        if ($module == 'accommodations') {
            $accommodation = Accommodation::where('id', $id)->first();
            if ($accommodation) {
                $accommodation->images()->delete();
                $accommodation->places()->delete();
                $accommodation->rules()->delete();
                $accommodation->ratings()->delete();
                $accommodation->delete();
                return true;
            }
        } else if ($module == 'experiences') {
            $experience = Experience::where('id', $id)->first();
            if ($experience) {
                $experience->images()->delete();
                $experience->rules()->delete();
                $experience->ratings()->delete();
                $experience->slots()->delete();
                $experience->delete();
                return true;
            }
        } else if ($module == 'transports') {
            $transport = Transport::where('id', $id)->first();
            if ($transport) {
                $transport->images()->delete();
                $transport->rules()->delete();
                $transport->ratings()->delete();
                $transport->transport_feature()->delete();
                $transport->delete();
                return true;
            }
        } else if ($module == 'meals') {
            $meal = Meal::where('id', $id)->first();
            if ($meal) {
                $meal->images()->delete();
                $meal->rules()->delete();
                $meal->ratings()->delete();
                $meal->delete();
                return true;
            }
        } else if (
            $module == 'visa_consultants'   ||
            $module == 'movie_makers'       ||
            $module == 'vehicles'           ||
            $module == 'guides'             ||
            $module == 'trips'              ||
            $module == 'events'             ||
            $module == 'photographers'      ||
            $module == 'resturants'         ||
            $module == 'trip_mates'         ||
            $module == 'trip_operators'     ||
            $module == 'hosts'
        ) {
            $guide = Guide::where('id', $id)->first();
            if ($guide) {

                if ($module == 'guides') {
                    $guide->package_facilities()->delete();
                    $guide->package_itinerary()->delete();
                    $guide->packageVideos()->delete();
                    $guide->packagesCoveredEvents()->delete();
                    $guide->services()->delete();
                }
                if ($module == 'visa_consultants') {
                    $guide->package_facilities()->delete();
                    $guide->package_itinerary()->delete();
                    $guide->packageVideos()->delete();
                    $guide->packagesCoveredEvents()->delete();
                    $guide->services()->delete();
                }
                if ($module == 'movie_makers') {
                    $guide->package_facilities()->delete();
                    $guide->package_itinerary()->delete();
                    $guide->packageVideos()->delete();
                    $guide->packagesCoveredEvents()->delete();
                    $guide->services()->delete();
                }
                if ($module == 'photographers') {
                    $guide->package_facilities()->delete();
                    $guide->package_itinerary()->delete();
                    $guide->packageVideos()->delete();
                    $guide->packagesCoveredEvents()->delete();
                    $guide->services()->delete();
                }
                if ($module == 'trip_operators') {
                    $guide->package_facilities()->delete();
                    $guide->package_itinerary()->delete();
                    $guide->packageVideos()->delete();
                    $guide->packagesCoveredEvents()->delete();
                    $guide->services()->delete();
                }
                $guide->images()->delete();
                $guide->rules()->delete();
                $guide->ratings()->delete();
                $guide->delete();
                return true;
            }
        } else {
            return false;
        }
    }
}
