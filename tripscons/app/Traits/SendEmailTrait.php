<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Reservation;

use App\Mail\NotifyMail;

trait SendEmailTrait
{

    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function sendMail($data)
    {

        Mail::to($data['email'])->send(new NotifyMail($data));
        if (Mail::failures()) {
            return response()->Fail('Sorry! Please try again latter');
        } else {
            // return response()->success('Great! Successfully send in your mail');
        }
    }

    public function InvoicePdf($booking_id)
    {
        $booking_detail = Reservation::where('id', $booking_id)->first();
        
        if (!$booking_detail) {
            $detail = 'Invalid booking id.';
            return $detail;
        }

        $detail = $booking_detail;

        // if ($booking_detail->reservation_type == "Transport/Vehicle Booking") {
        //     $detail =  Reservation::with('VehicleBookingDetail')->with('Invoice')->with('Transport')->with('Provider')->with('User')->where('id', $booking_id)->first();
        // } else if ($booking_detail->reservation_type == "Accomodation Booking" || $booking_detail->reservation_type == 'Hotel Room Booking') {
        //     $detail =  Reservation::with('Provider')->with('User')->with('Accommodation')->with('AccommodationBookingDetail')->with('Invoice')->where('id', $booking_id)->first();
        // } else if ($booking_detail->reservation_type == "meals") {
        //     $detail =  Reservation::with('Provider')->with('MealBookingDetail')->with('Invoice')->with('Provider')->with('User')->with('Meal')->where('id', $booking_id)->first();
        // } else if ($booking_detail->reservation_type == "experiences") {
        //     $detail =  Reservation::with('Provider')->with('User')->with('ExperienceBookingDetail')->with('Experience')->with('slotBook.Slot')->with('Invoice')->where('id', $booking_id)->first();
        // } else if ($booking_detail->reservation_type == "guides" || $booking_detail->reservation_type == "photographers" || $booking_detail->reservation_type == "movie_makers" || $booking_detail->reservation_type == "visa_consultants" || $booking_detail->reservation_type == "trip_operators") {
        //     $detail =  Reservation::with(['Provider', 'User', 'GuideBookingDetail', 'Guide', 'Invoice'])->where('id', $booking_id)->first();
        // } else if ($booking_detail->reservation_type == "guideprofile") {
        //     $detail =  Reservation::with(['Provider', 'User', 'Invoice', 'GuideBookingDetail'])->where('id', $booking_id)->first();
        // }
        if (!$detail) {
            $detail = 'Invalid booking id.';
            return $detail;
        }
        return $detail;
    }



    // public function InvoicePdf($booking_id)
    // {
    //     $booking_detail = Booking::where('id', $booking_id)->first();
    //     if (!$booking_detail) {
    //         $detail = 'Invalid booking id.';
    //         return $detail;
    //     }
    //     if ($booking_detail->module_name == "transports") {
    //         $detail =  Booking::with('VehicleBookingDetail')->with('Invoice')->with('Transport')->with('Provider')->with('User')->where('id', $booking_id)->first();
    //     } else if ($booking_detail->module_name == "accommodations") {
    //         $detail =  Booking::with('Provider')->with('User')->with('Accommodation')->with('AccommodationBookingDetail')->with('Invoice')->where('id', $booking_id)->first();
    //     } else if ($booking_detail->module_name == "meals") {
    //         $detail =  Booking::with('Provider')->with('MealBookingDetail')->with('Invoice')->with('Provider')->with('User')->with('Meal')->where('id', $booking_id)->first();
    //     } else if ($booking_detail->module_name == "experiences") {
    //         $detail =  Booking::with('Provider')->with('User')->with('ExperienceBookingDetail')->with('Experience')->with('slotBook.Slot')->with('Invoice')->where('id', $booking_id)->first();
    //     } else if ($booking_detail->module_name == "guides" || $booking_detail->module_name == "photographers" || $booking_detail->module_name == "movie_makers" || $booking_detail->module_name == "visa_consultants" || $booking_detail->module_name == "trip_operators") {
    //         $detail =  Booking::with(['Provider', 'User', 'GuideBookingDetail', 'Guide', 'Invoice'])->where('id', $booking_id)->first();
    //     } else if ($booking_detail->module_name == "guideprofile") {
    //         $detail =  Booking::with(['Provider', 'User', 'Invoice', 'GuideBookingDetail'])->where('id', $booking_id)->first();
    //     }
    //     if (!$detail) {
    //         $detail = 'Invalid booking id.';
    //         return $detail;
    //     }
    //     return $detail;
    // }
}
