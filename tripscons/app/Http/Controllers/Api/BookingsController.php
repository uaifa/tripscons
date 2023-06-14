<?php

namespace App\Http\Controllers\Api;

use App\Events\Booking\BookingCanceled;
use App\Http\Controllers\Controller;
use App\Libs\Booking\Services\RoomAccommodation;
use App\Models\Accommodation;
use App\Models\Booking;
use App\Models\BookingPaymentGatewayDetail;
use App\Models\BookingRefund;
use App\Models\CancelBookingDetail;
use App\Models\CancellationPolicy;
use App\Models\Experience;
use App\Models\Guide;
use App\Models\Invoice;
use App\Models\Meal;
use App\Models\Package;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Models\Transport;
use App\Models\User;
use App\Notifications\PushNotification;
use App\Traits\HostServiceBookingTrait;
use App\Traits\SendEmailTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class BookingsController extends Controller
{
    protected $status = 200;
    protected $response = [];
    use HostServiceBookingTrait;
    use SendEmailTrait;

    public $classBindings = [
        'accommodation' => Accommodation::class,
        'transport' => Transport::class,
        'meal' => Meal::class,
        'profile' => User::class,
        'package' => Guide::class,
        'experience' => Experience::class,
    ];

    //get user bookings
    public function index(Request $request, $booking_type = 'upcoming')
    {
        $date = Carbon::now();
        // echo $date;die;
        //$date = $date->format('Y-m-d'); echo $date;die;
        $data = [];
        if ($booking_type == "upcoming") {
            //accommodations
            $data = Booking::with(['Provider', 'Accommodation', 'Meal', 'Experience', 'Transport', 'Guide'])->where('user_id', $request->user()->id)->whereDate('end_date', '>=', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
        } else if ($booking_type == "past") {
            //accommodations
            $data = Booking::with(['Provider', 'Accommodation', 'Meal', 'Experience', 'Transport', 'Guide'])->where('user_id', $request->user()->id)->whereDate('end_date', '<', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
        }
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        // $this->response['pastBookings'] = $pastBookings;
        return response()->json($this->response, $this->status);
    }

    public function getClientBookings(Request $request)
    {
        $request->validate([
            'module_type' => 'required|array'
        ]);
        $modules = [];

        foreach($request->module_type as $type){
            $modules[] = $this->classBindings[$type];
        }

        $date = Carbon::now();
        $currentBookings = [];
        $pastBookings = [];

        if((isset($request->booking_type) && $request->booking_type == 'current_booking') || (isset($request->booking_type) && $request->booking_type == 'current')){

            $currentBookings = Reservation::with('provider')
                ->with(['bookable.singleImage', 'user'])
                ->where('user_id', $request->user()->id)
                // ->whereDate('date_from', '>=', $date)
                ->whereDate('date_to', '>=', $date)
                ->whereIn('bookable', $modules)
                ->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
        }else if((isset($request->booking_type) && $request->booking_type == 'past_booking') || (isset($request->booking_type) && $request->booking_type == 'past')){

                $pastBookings = Reservation::with('provider')
                ->with(['bookable.singleImage', 'user'])
                ->where('user_id', $request->user()->id)
                ->whereDate('date_to', '<', $date)
                ->whereIn('bookable', $modules)
                ->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
            }

        if($request->booking_type == 'current'){
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $currentBookings;
            return response()->json($this->response, $this->status);
        }
        if($request->booking_type == 'past'){
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $pastBookings;
            return response()->json($this->response, $this->status);
        }

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data']['currentBookings'] = $currentBookings;
        $this->response['data']['pastBookings'] = $pastBookings;
        return response()->json($this->response, $this->status);
    }

    public function getHostBookings(Request $request)
    {
        $request->validate([
            'module_type' => 'required|array'
        ]);

        $modules = [];

        foreach($request->module_type as $type){
            $modules[] = $this->classBindings[$type];
        }

        $date = Carbon::now();
        $currentBookings = [];
        $pastBookings = [];

        if((isset($request->booking_type) && $request->booking_type == 'current_booking') || (isset($request->booking_type) && $request->booking_type == 'current')){

            $currentBookings = Reservation::with('provider')
                ->with(['bookable.singleImage', 'user',])
                ->where('provider_user_id', $request->user()->id)
                ->whereDate('date_to', '>=', $date)
                ->whereIn('bookable', $modules)
                ->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
        }else if((isset($request->booking_type) && $request->booking_type == 'past_booking') || (isset($request->booking_type) && $request->booking_type == 'past')){

            $pastBookings = Reservation::with('provider')
                ->with(['bookable.singleImage', 'user'])
                ->where('provider_user_id', $request->user()->id)
                ->whereDate('date_to', '<', $date)
                ->whereIn('bookable', $modules)
                ->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
        }

        if($request->booking_type == 'current'){
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $currentBookings;
            return response()->json($this->response, $this->status);
        }
        if($request->booking_type == 'past'){
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $pastBookings;
            return response()->json($this->response, $this->status);
        }

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data']['currentBookings'] = $currentBookings;
        $this->response['data']['pastBookings'] = $pastBookings;
        return response()->json($this->response, $this->status);
    }

    public function accept(Request $request)
    {
        $booking = Reservation::find($request->booking_id);
        switch($booking->booking_detail['reservation_class']){
            case RoomAccommodation::class:
                $request->request->add([
                    'accommodation_id' => $booking->bookable_id,
                    'date_from' => Carbon::create($booking->date_from)->subDay(1),
                    'date_to' => Carbon::create($booking->date_to),
                ]);

                $hostServices = new HostController();
                $availableRooms = $hostServices->getAvailableRooms($request);
                $availableRooms = collect(json_decode($availableRooms->getContent(), true)['data']);

                $bookedRooms = $booking->booking_detail['data']['rooms'];

                foreach($bookedRooms as $bookedRoom){
                    $availibility = $availableRooms->where('id', $bookedRoom['id'])->where('quantityAvailable', '>=', $bookedRoom['roomQuantity'])->count();
                    if(!$availibility){
                        $this->status = 422;
                        $this->response['success'] = false;
                        $this->response['message'] = 'Room/s not available for further reservation';
                        $this->response['data'] = $bookedRoom;
                        return response()->json($this->response, $this->status);
                    }
                }
            break;
        }

        if($booking->provider_user_id != $request->user()->id) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['data'] = null;
            return response()->json($this->response, $this->status);
        }

        $booking->status = $request->accept == 1 ? 7 : 8;

        $title      = "Accept Booking";
        $message    = "Your booking request has been approved. To confirm your booking please proceed to payment.";
        $action     = "user/bookings";
        $user      = User::where('id',$booking->user_id)->first();


        if(isset($user) && !empty($user)){
            PushNotification::createNotification($user,$booking->provider_id,$title,$message,User::TYPE_BOOKING_ACCEPT,$action,$booking->id);
        }
        $booking->update();


        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $booking;
        return response()->json($this->response, $this->status);
    }

    public function getMyBookingsForWeb(Request $request, $module = 'accommodations')
    {
        $date = Carbon::now();
        if ($module == "accommodations") {
            $data = Booking::with('Provider')->with('Accommodation')->with('rooms')->where('user_id', $request->user()->id)->where('module_name', $module)->whereDate('end_date', '>=', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
            //pastbookings
            $pastBookings = Booking::with('Provider')->with('Accommodation')->with('rooms')->where('user_id', $request->user()->id)->where('module_name', $module)->whereDate('end_date', '<', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
        } else if ($module == "meals") {

            $data = Booking::with('Provider')->with('Meal')->where('user_id', $request->user()->id)->where('module_name', $module)->whereDate('end_date', '>=', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
            //pastbookings
            $pastBookings = Booking::with('Provider')->with('Meal')->where('user_id', $request->user()->id)->where('module_name', $module)->whereDate('end_date', '<', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
        } else if ($module == "experiences") {

            $data = Booking::with('Provider')->with('Experience')->where('user_id', $request->user()->id)->where('module_name', $module)->whereDate('end_date', '>=', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
            //pastbookings
            $pastBookings = Booking::with('Provider')->with('Experience')->where('user_id', $request->user()->id)->where('module_name', $module)->whereDate('end_date', '<', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
        } else if ($module == "transports") {

            $data = Booking::with('Provider')->with('Transport')->where('user_id', $request->user()->id)->where('module_name', $module)->whereDate('end_date', '>', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
            //pastbookings
            $pastBookings = Booking::with('Provider')->with('Transport')->where('user_id', $request->user()->id)->where('module_name', $module)->whereDate('end_date', '<', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
        } else if ($module == "services") {

            $data = Booking::with('Provider')->where('provider_name', 'service provider')->where('user_id', $request->user()->id)->whereDate('start_date', '>=', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
            //pastbookings
            $pastBookings = Booking::with('Provider')->where('provider_name', 'service provider')->where('user_id', $request->user()->id)->whereDate('start_date', '<', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
        }

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        $this->response['pastBookings'] = $pastBookings;
        return response()->json($this->response, $this->status);
    }
    //provider or host booking list
    public function getProviderBookings(Request $request, $booking_type = 'upcoming')
    {
        $date = Carbon::now();
        $data = [];
        if ($booking_type == "upcoming") {
            //accommodations
            $data = Booking::with(['User', 'Accommodation', 'Meal', 'Experience', 'Transport', 'Guide'])->where('provider_id', $request->user()->id)->whereDate('end_date', '>', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
        } else if ($booking_type == "past") {
            //accommodations
            $data = Booking::with(['User', 'Accommodation', 'Meal', 'Experience', 'Transport', 'Guide'])->where('provider_id', $request->user()->id)->whereDate('end_date', '<', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
        }
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        // $this->response['pastBookings'] = $pastBookings;
        return response()->json($this->response, $this->status);
    }

    public function getProviderBookingsForWeb(Request $request, $module = 'accommodations')
    {

        $date = Carbon::now();
        $data = [];
        $pastBookings = [];
        if ($module == "accommodations") {

            $data = Booking::with('User')->with('Accommodation')->where('provider_id', $request->user()->id)->where('module_name', $module)->whereDate('end_date', '>=', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
            //pastbookings
            $pastBookings = Booking::with('User')->with('Accommodation')->where('provider_id', $request->user()->id)->where('module_name', $module)->whereDate('end_date', '<', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
        } else if ($module == "meals") {
            $data = Booking::with('User')->with('Meal')->where('provider_id', $request->user()->id)->where('module_name', $module)->whereDate('created_at', '>=', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
            //pastbookings
            $pastBookings = Booking::with('User')->with('Meal')->where('provider_id', $request->user()->id)->where('module_name', $module)->whereDate('created_at', '<', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
        } else if ($module == "experiences") {

            $data = Booking::with('User')->with('Experience')->where('provider_id', $request->user()->id)->where('module_name', $module)->whereDate('end_date', '>=', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
            //pastbookings
            $pastBookings = Booking::with('User')->with('Experience')->where('provider_id', $request->user()->id)->where('module_name', $module)->whereDate('end_date', '<', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
        } else if ($module == "transports") {

            $data = Booking::with('User')->with('Transport')->where('provider_id', $request->user()->id)->where('module_name', $module)->whereDate('end_date', '>=', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
            //pastbookings
            $pastBookings = Booking::with('User')->with('Transport')->where('provider_id', $request->user()->id)->where('module_name', $module)->whereDate('end_date', '<', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
        } else if ($module == "services") {

            $data = Booking::with(['User', 'Provider'])->where('provider_id', $request->user()->id)->whereDate('start_date', '>=', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
            //pastbookings
            $pastBookings = Booking::with(['User', 'Provider'])->where('provider_id', $request->user()->id)->whereDate('start_date', '<', $date)->orderBy('id', 'DESC')
                ->paginate(Config::get('global.pagination_records'));
        }

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $data;
        $this->response['pastBookings'] = $pastBookings;
        return response()->json($this->response, $this->status);
    }

    public function cancelBookingDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $booking = Booking::where('id', $request->booking_id)->first();
        $this->status = 200;
        $this->response['success'] = false;
        $this->response['data'] = $this->refundPercentage($booking);
        return response()->json($this->response, $this->status);
    }
    public function updateBookingStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',
            'reason' => 'required',
            'booking_status' => 'required',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $booking = Booking::where('id', $request->booking_id)->first();
        $CancelBookingDetail = new CancelBookingDetail;
        if (!$booking) {
            $this->status = 200;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid booking id.';
            return response()->json($this->response, $this->status);
        }
        $title      = "Booking";
        $message    = "Your booking request has been updated";
        $action     = "/service/bookings/";

        // 0  is used for pending /reserve
        // 1  is used for cancel
        // 2  used for complete
        // 3  Not check in
        // 4  close (for any reason)
        $date = Carbon::now();
        $statusTitle = '';
        if ($booking->status == 1) {
            $statusTitle = 'Cancel';
            $message    = "Your booking has been declined";

        } else if ($booking->status == 2) {
            $statusTitle = 'Complete';
            $message    = "Your booking has been completed";
        } else if ($booking->status == 3) {
            $statusTitle = 'Not Check In';
            $message    = "You are't check in your booking";
        } else if ($booking->status == 4) {
            $statusTitle = 'Close';
            $message    = "Your booking is closed.";
        }
        if ($booking->status != 2 && $booking->status != 1 && $booking->status != 3 && $booking->status != 4) {
            if ($request->booking_status == 2) {
                $booking->payment_status = 1;
            }
            $booking->status = $request->booking_status;

            PushNotification::createNotification(auth()->user(),$booking->provider_id,$title,$message,User::TYPE_BOOKING,$action,$booking->id);

            $booking->save();
            $CancelBookingDetail->booking_id = $request->booking_id;
            $CancelBookingDetail->user_id = $request->user()->id;
            $CancelBookingDetail->reason = $request->reason;
            $CancelBookingDetail->save();

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Booking status updated successfully.';

            if ($request->payment_status) {
                $booking->payment_status = $request->payment_status;
                $booking->save();
            }
            return response()->json($this->response, $this->status);
        } else {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'You cannot change it because your booking status is already ' . $statusTitle . '';
            return response()->json($this->response, $this->status);
        }
    }
    public function detail(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }
        $booking_detail = Booking::with(['User', 'Provider'])->where('id', $request->booking_id)->first();
        if (!$booking_detail) {
            $this->status = 200;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid booking id.';
            return response()->json($this->response, $this->status);
        }
        // ->with('Accommodation') ->with('User')->with('Provider')
        if ($booking_detail->module_name == "transports") {
            $detail = Booking::with('VehicleBookingDetail')->with('Invoice')->with('Transport')->with('Provider')->with('User')->where('id', $request->booking_id)->first();
        } else if ($booking_detail->module_name == "accommodations") {

            $detail = Booking::with('Provider')->with('User')->with('Accommodation')->with('AccommodationBookingDetail')->with('rooms')->with('Invoice')->where('id', $request->booking_id)->first();
        }
        // else if ($booking_detail->module_name == "accommodationrooms") {

        //     $detail =  Booking::with('Provider')->with('User')->with('Accommodation')->with('AccommodationBookingDetail')->with('Invoice')->with('rooms')->where('id', $request->booking_id)->first();
        // }
        else if ($booking_detail->module_name == "meals") {
            $detail = Booking::with('Provider')->with('MealBookingDetail')->with('Invoice')->with('Provider')->with('User')->with('Meal')->where('id', $request->booking_id)->first();
        } else if ($booking_detail->module_name == "experiences") {
            $detail = Booking::with('Provider')->with('User')->with('ExperienceBookingDetail')->with('Experience')->with('slotBook.Slot')->with('Invoice')->where('id', $request->booking_id)->first();
        } else if ($booking_detail->module_name == "guides" || $booking_detail->module_name == "photographers" || $booking_detail->module_name == "movie_makers" || $booking_detail->module_name == "visa_consultants" || $booking_detail->module_name == "trip_operators") {

            $detail = Booking::with(['Provider', 'User', 'GuideBookingDetail', 'Guide', 'Invoice'])->where('id', $request->booking_id)->first();
        } else if ($booking_detail->module_name == "guideprofile") {

            $detail = Booking::with(['Provider', 'User', 'Invoice', 'GuideBookingDetail'])->where('id', $request->booking_id)->first();
        }

        if (!$detail) {
            $this->status = 200;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid booking id.';
            return response()->json($this->response, $this->status);
        }

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $detail;
        return response()->json($this->response, $this->status);
    }
    public function partialAmountCharged($booking_detail)
    {
        //return  ($booking_detail->grand_total - $booking_detail->partial_amt) * 100 ;
        return $booking_detail->partial_amt * 100;
    }
    public function remainingAmountCharged($booking_detail)
    {
        return ($booking_detail->grand_total - $booking_detail->partial_amt) * 100;
    }

    public function checkout(Request $request)
    {
        if (count($request->all()) > 0) {

            if ($request->card_id == 0) {
                $validator = Validator::make($request->all(), [
                    'holder_name' => 'required',
                    'card_number' => 'required',
                    'expiry_date' => 'required',
                    'cvc' => 'required',
                    'type' => 'required',
                    'booking_id' => 'required',
                ]);

                if ($validator->fails()) {
                    $this->status = 422;
                    $this->response['success'] = false;
                    $this->response['message'] = $validator->messages()->first();
                    return response()->json($this->response, $this->status);
                }
                $explodeDate = explode('-', date("Y-m-d", strtotime($request->expiry_date)));
                $year = $explodeDate[0];
                $month = $explodeDate[1];
                $booking_detail = Booking::with('provider')->where('id', $request->booking_id)->where('user_id', $request->user()->id)->first();
                if (!$booking_detail) {
                    $this->status = 422;
                    $this->response['success'] = false;
                    $this->response['message'] = 'Invalid booking id';
                    return response()->json($this->response, $this->status);
                }

                /* payment status
                0 for unpaid
                1 for full paid
                2 partial payment
                 */
                if ($booking_detail->payment_status == 1) {
                    $this->status = 422;
                    $this->response['success'] = false;
                    $this->response['message'] = 'Payment already paid';
                    return response()->json($this->response, $this->status);
                }

                $chargedAmt = $booking_detail->grand_total * 100;
                if ($booking_detail->partial_amt > 0 && $booking_detail->payment_status == 0) {
                    $chargedAmt = $this->partialAmountCharged($booking_detail);
                }
                if ($booking_detail->payment_status == 2) {
                    $chargedAmt = $this->remainingAmountCharged($booking_detail);
                }
                // number_format((float)$booking_detail->grand_total, 2, '.', '');
                //echo $booking_detail->grand_total;die;
                $stripe = new \Stripe\StripeClient(
                    config('services.stripe.secret')
                );
                // print_r($stripe);die;
                // $customer =   $stripe->customers->create([
                //     'description' => 'My First Test Customer (created for API docs)',
                // ]);
                try {
                    $tokenRequest = $stripe->tokens->create([
                        'card' => [
                            'number' => $request->card_number,
                            'exp_month' => $month,
                            'exp_year' => $year,
                            'cvc' => $request->cvc,
                        ],
                    ]);
                } catch (\Exception$e) {
                    $this->status = 422;
                    $this->response['success'] = false;
                    $this->response['message'] = $e->getMessage();
                    return response()->json($this->response, $this->status);
                } //number_format((float)$booking_detail->grand_total, 2, '.', '')
                try {
                    $checkout = $stripe->charges->create([
                        'amount' => $chargedAmt,
                        'currency' => 'pkr',
                        'source' => $tokenRequest,
                        'description' => 'This is testing payments',
                    ]);
                    setcookie("cart_price_info", null);
                    //echo $checkout->payment_method_details->fingerprint ;
                    $this->booking_gateway_details($checkout->balance_transaction, $checkout->payment_method, $checkout->id, $checkout->paid, $checkout->fingerprint, $checkout->amount, $request->booking_id, $request->user()->id);

                    //$request
                    $userObj = [
                        'email' => $request->user()->email,
                        'name' => $request->user()->name,
                    ];
                    $providerObj = [
                        'email' => $booking_detail->provider->email,
                        'name' => $booking_detail->provider->name,
                    ];

                    // event(new EmailShoot($userObj,$providerObj));

                } catch (\Exception$e) {
                    $this->status = 422;
                    $this->response['success'] = false;
                    $this->response['message'] = $e->getMessage();
                    return response()->json($this->response, $this->status);
                }

                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'Test payment from tripsconpro.';
                $this->response['data'] = $checkout; //remove will be later on for testing

            }
        } else {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Please Input Data Properly.';
        }
        return response()->json($this->response, $this->status);
    }
    public function booking_gateway_details($balance_transaction, $payment_method, $charged_id, $status, $fingerprint_id, $amount, $booking_id, $user_id)
    {
        $BookingPaymentGatewayDetail = new BookingPaymentGatewayDetail;

        $BookingPaymentGatewayDetail->booking_id = $booking_id;
        $BookingPaymentGatewayDetail->user_id = $user_id;
        $BookingPaymentGatewayDetail->transaction_id = $balance_transaction;
        $BookingPaymentGatewayDetail->fingerprint_id = $fingerprint_id;
        $BookingPaymentGatewayDetail->status = $status;
        $BookingPaymentGatewayDetail->payment_method = $payment_method;
        $BookingPaymentGatewayDetail->paid_amount = $amount;
        $BookingPaymentGatewayDetail->charged_id = $charged_id;

        $BookingPaymentGatewayDetail->save();

        $booking = Booking::where('id', $booking_id)->first();
        $invoice = Invoice::where('booking_id', $booking_id)->first();
        if ($booking->partial_amt > 0 && $booking->payment_status == 0) {
            $booking->payment_status = 2;
            $invoice->status = 2;
        } else {
            $booking->payment_status = 1;
            $invoice->status = 1;
        }
        $booking->save();
        $invoice->save();
    }

    public function postStripe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }
        $card = Card::where('user_id', $request->user()->id)->where('id', $request->card_id)->first();
        if (!$card) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid card id.';
            return response()->json($this->response, $this->status);
        }
        if ($card->delete()) {
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Card deleted successfully.';
            return response()->json($this->response, $this->status);
        }

        $this->status = 422;
        $this->response['success'] = false;
        $this->response['message'] = 'Invalid card id.';
        return response()->json($this->response, $this->status);
    }

    public function refundCharged($booking_id)
    {
        $booking = Booking::where('id', $booking_id)->first();
        if (!$booking) {
            $this->status = 200;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid booking id.';
            return response()->json($this->response, $this->status);
        }
        $transactions = BookingPaymentGatewayDetail::where('booking_id', $booking_id)->get();
        $refundPercentage = $this->refundPercentage($booking)['percentage'];
        if($refundPercentage == 0){
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = null;
            $this->response['message'] = 'Invoice not eligible for refund';
            return response()->json($this->response, $this->status);
        }
        foreach ($transactions as $bookingGatewayCharged) {
            $chargedAmt = $bookingGatewayCharged->paid_amount;
            $chargedId = $bookingGatewayCharged->charged_id;

            $stripe = new \Stripe\StripeClient(
                config('services.stripe.secret')
            );

            try {
                $refunded = $stripe->refunds->create([
                    'charge' => $chargedId,
                    // 'currency' => 'pkr',
                    'amount' => ($chargedAmt / 100) * $refundPercentage,
                ]);
            } catch (\Exception$e) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = $e->getMessage();
                return response()->json($this->response, $this->status);
            }

        }

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $refunded;
        $this->response['message'] = 'Refund payment successfully';

        return response()->json($this->response, $this->status);
    }

    public function refundPercentage($booking)
    {
        $service = new $booking->bookable();
        $service = $service->find($booking->module_id);
        $amountCharged = BookingPaymentGatewayDetail::where('booking_id', $booking->id)->sum('paid_amount');
        $cancellationPolicy = CancellationPolicy::where([
            'bookable' => $booking->bookable,
            'bookable_id' => $service->id
        ])->orderByDesc('cancellation_hour')->get();

        $timeRemaining = Carbon::create($booking->start_date)->diffInHours(date('Y-m-d H:i:s'));

        foreach($cancellationPolicy as $policy){
            if($timeRemaining > $policy->cancellation_hour){
                return [
                    'percentage' => $policy->refund_percentage,
                    'total_paid' => $amountCharged / 100,
                    'hours' => $policy->cancellation_hour,
                    'time_remaining' => $timeRemaining,
                    'refund_amount' => (($amountCharged/100) / 100) * $policy->refund_percentage
                ];
            }
        }
        return [
            'percentage' => 0,
            'total_paid' => $amountCharged /100,
            'hours' => 0,
            'time_remaining' => $timeRemaining,
            'refund_amount' => 0
        ];
    }

    public function refundDetails($stripeObj, $booking_id)
    {
        $bookingRefund = new BookingRefund;
        $bookingRefund->booking_id = $booking_id;
        $bookingRefund->charge_id = $stripeObj->charge;
        $bookingRefund->refund_id = $stripeObj->id;
        $bookingRefund->refunded_amount = $stripeObj->amount;
        $bookingRefund->transaction_id = $stripeObj->balance_transaction;
        $bookingRefund->save();
    }
    public function createPaymentIntent(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }
        $booking_detail = Booking::where('id', $request->booking_id)->where('user_id', $request->user()->id)->first();

        if (!$booking_detail) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid booking id';
            return response()->json($this->response, $this->status);
        }
        if ($booking_detail->payment_status == 1) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Payment already paid';
            return response()->json($this->response, $this->status);
        }
        $chargedAmt = $booking_detail->grand_total * 100;
        if ($booking_detail->partial_amt > 0 && $booking_detail->payment_status == 0) {
            $chargedAmt = $this->partialAmountCharged($booking_detail);
        }
        if ($booking_detail->payment_status == 2) {
            $chargedAmt = $this->remainingAmountCharged($booking_detail);
        }

        $stripe = new \Stripe\StripeClient(
            config('services.stripe.secret')
        );
        try {
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $chargedAmt,
                'currency' => 'pkr',
                'payment_method_types' => ['card'],
            ]);
        } catch (\Exception$e) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Payment intents created successfully.';
        $this->response['data'] = $paymentIntent; //remove will be later on for testing
        return response()->json($this->response, $this->status);
    }
    public function teststripe()
    {

        $stripe = new \Stripe\StripeClient(
            config('services.stripe.secret')
        );
        try {
            $stripe->webhookEndpoints->create([
                'url' => 'http://127.0.0.1:3000/api/stripeListen',
                'enabled_events' => [
                    'charge.failed',
                    'charge.succeeded',
                ],
            ]);
            print_r($stripe);
        } catch (\UnexpectedValueException$e) {
            // Invalid payload
            print_r($e);
            http_response_code(400);
            exit();
        }
    }
}
