<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'location', 'title', 'description', 'price', 'days', 'nights',
        'images', 'status', 'active', 'no_of_people', 'date_from', 'date_to', 'agenda_type', 'category_id', 'trip_type_id',
        'physical_level', 'everything_excluded', 'excluded', 'terms', 'video_urls', 'child_age_limit_discount',
        'child_discount_percentage', 'discount_age_limit_for_free', 'allow_group_discount',
        'group_limit_discount', 'group_discount_amount', 'age_min', 'age_max'
    ];

    /**
     * @Description Get All User Packages
     *
     * @param $userId
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function getAllUserPackages($userId)
    {
        $res = [];
        $packages = self::whereUser_id($userId)->orderBy('id', 'DESC')->get();
        foreach ($packages as $trip) {
            $data = [];
            $data = $trip;
            $data['activities'] = ActivityLink::getByRefIdAndType($trip->id, 'trip:package');
            $data['agendas'] = AgendaDay::getByRef($trip->id, 'trip:package', $userId);
            $data['amenities'] = AmenityLink::getAmenities($trip->id, 'trip:package', $userId);
            array_push($res, $data);
        }
        return $res;
    }

    /**
     * @Description Get Package Detail
     * @param $packageId
     * @return array
     *
     * @Author Khuram Qadeer.
     */
    public static function getPackageId($packageId)
    {
        $res = [];
        $package = self::find($packageId);
        if ($package) {
            $userId = $package->user_id;
            $res = $package;
            $res['activities'] = ActivityLink::getByRefIdAndType($package->id, 'trip:package');
            $res['agendas'] = AgendaDay::getByRef($package->id, 'trip:package', $userId);
            $res['amenities'] = AmenityLink::getAmenities($package->id, 'trip:package', $userId);
        }
        return $res;
    }

    /**
     * @Description Get Disable Dates for guide booking
     *              In which dates are:
     *                      1) Hourly Booked dates
     *                      2) Packages Dates "Fixed Date-wise"
     * @param $guideUserId
     * @return array
     * @Author Khuram Qadeer.
     */
    public static function getDisabledDates($guideUserId)
    {
        $res = [];
        if ($guideUserId) {
            $ordersHourly = Order::getOrderByRefIdAndRefType($guideUserId, 'guide:hourly:book');
            if ($ordersHourly) {
                foreach ($ordersHourly as $order) {
                    $orderItem = $order['order_items'][0];
                    if ($orderItem) {
                        array_push($res, ['start' => str_replace('-', '/', $orderItem['date_from']),
                            'end' => str_replace('-', '/', $orderItem['date_to'])]);
                    }
                }
            }

            $packages = Package::getAllUserPackages($guideUserId);
            if ($packages) {
                foreach ($packages as $package) {
                    if ($package->agenda_type == 'datewise') {
                        array_push($res,
                            ['start' => str_replace('-', '/', $package->date_from),
                                'end' => str_replace('-', '/', $package->date_to)]);
                    }
                }
            }
        }
        return $res;
    }

    /**
     * @Description Get booking dates sets for Date-wise package if dates are comming
     * @param $packageId
     * @return array
     * @Author Khuram Qadeer.
     */
    public static function getDateWisePackageAvailableDates($packageId)
    {
        $res = [];
        $package = self::find($packageId);
        if ($package) {
            if ($package->agenda_type == 'datewise') {
                if (Carbon::today() < Carbon::parse($package->date_from)) {
                    array_push($res, ['start' => $package->date_from, 'end' => $package->date_to]);
                }
            }
        }
        return $res;
    }

}
