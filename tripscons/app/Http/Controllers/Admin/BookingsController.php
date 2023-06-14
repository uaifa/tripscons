<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Booking\BulkDestroyBooking;
use App\Http\Requests\Admin\Booking\DestroyBooking;
use App\Http\Requests\Admin\Booking\IndexBooking;
use App\Http\Requests\Admin\Booking\StoreBooking;
use App\Http\Requests\Admin\Booking\UpdateBooking;
use App\Libs\Booking\Services\TripInquiry;
use App\Libs\Booking\Services\Accommodation;
use App\Libs\Booking\Services\Experience;
use App\Libs\Booking\Services\Meal;
use App\Libs\Booking\Services\Package;
use App\Libs\Booking\Services\RoomAccommodation;
use App\Libs\Booking\Services\Transport;
use App\Libs\Booking\Services\User as ServicesUser;
use App\Mail\CustomerSupportBookingEmail;
use App\Models\Booking;
use App\Models\BookingActivityLog;
use App\Models\Reservation;
use App\Models\User;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class BookingsController extends Controller
{

    /**
     * @var array
     */
    protected $response = [];
    protected $status = 200;



    public $classBindings = [
        'accommodation' => Accommodation::class,
        'roomAccommodation' => RoomAccommodation::class,
        'transport' => Transport::class,
        'meal' => Meal::class,
        'profile' => ServicesUser::class,
        'package' => Package::class,
        'experience' => Experience::class,
        'inquiry' => TripInquiry::class,
    ];

    public function refresh(Request $request)
    {
        $class = $this->classBindings[$request->type];
        $class = new $class($request->id, $request->data, $request->currency ?? 'PKR');
        return [
            'success' => true,
            'data' => $class->results()
        ];
    }

    public function book(Request $request)
    {   
        // $extras = $request->data['extras'];
        // $email = (isset($extras['guestEmail']) && !empty($extras['guestEmail'])) ? $extras['guestEmail'] : '';
        // $name = (isset($extras['guestName']) && !empty($extras['guestName'])) ? $extras['guestName'] : '';
        // $phone = (isset($extras['guestPhone']) && !empty($extras['guestPhone'])) ? $extras['guestPhone'] : '';
        // $data['users'] = [];
        // if(isset($email) && !empty($email)){
        //     $user = User::where('email', $email)->first();

        //     if(isset($user) && !empty($user)){
        //         if (!is_null(auth()->user())) {
        //             $this->status = 422;
        //             $this->response['success'] = false;
        //             $this->response['message'] = 'Unauthenticated, Please login';
        //             return response()->json($this->response, $this->status);
        //         }
        //     }else{
        //         $user = new User();
        //         $user->email = $email;
        //         $user->name = $name;
        //         $user->phone = $phone;
        //         $user->password = bcrypt('12345');
        //         $user->save();
        //         Auth::login($user);
        //         $token = $user->createToken('TripsCon')->accessToken;
        //         $user->update(['api_token' => $token]);
        //         $user->makeVisible('api_token');
        //         $data['users'] = $user;
        //     }
        // }

        // // Auth::login(request()->user());

        // // $header = request()->user();
        // $token = $request->bearerToken();

        // return $token;
        // if (!$header) {
        //     $this->status = 422;
        //     $this->response['success'] = false;
        //     $this->response['message'] = 'Unauthenticated, Please login sdfsdf sfsdf';
        //     return response()->json($this->response, $this->status);
        // }else{
            
            $class = $this->classBindings[$request->type];
            $class = new $class($request->id, $request->data, $request->currency ?? 'PKR');
            
            // $data['booking'] = $class->book();
            return [
                'success' => true,
                'data' => $class->book()
            ];
        // }
    }

    public function details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:reservations,id',
        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = Reservation::find($request->id)->load('provider')
        ->load(['bookable.singleImage', 'user']);
        return response()->json($this->response, $this->status);
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexBooking $request
     * @return array|Factory|View
     */
    public function index(IndexBooking $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Booking::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['id', 'user_id', 'provider_id', 'module_name', 'module_id', 'price', 'start_date', 'end_date', 'no_of_nights', 'total', 'discount', 'grand_total', 'status', 'payment_status', 'sub_total', 'booking_number', 'partial_amt', 'partial_amt_in_percentage', 'provider_name', 'booking_type', 'bookable'],

            // set columns to searchIn
            ['id', 'module_name', 'no_of_nights', 'booking_number', 'provider_name', 'booking_type', 'bookable']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.booking.index', ['data' => $data]);
    }

    public function bookingList(IndexBooking $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Booking::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['id', 'user_id', 'provider_id', 'module_name', 'module_id', 'price', 'start_date', 'end_date', 'no_of_nights', 'total', 'discount', 'grand_total', 'status', 'payment_status', 'sub_total', 'booking_number', 'partial_amt', 'partial_amt_in_percentage', 'provider_name', 'booking_type', 'bookable'],

            // set columns to searchIn
            ['id', 'user_id', 'provider_id', 'module_name', 'module_id', 'price', 'start_date', 'end_date', 'no_of_nights', 'total', 'discount', 'grand_total', 'status', 'payment_status', 'sub_total', 'booking_number', 'partial_amt', 'partial_amt_in_percentage', 'provider_name', 'booking_type', 'bookable'],
            function ($query){
                $query->where('status',0)
                    ->orderBy('id','DESC');
                //                $query->with(['User','Provider']);
            }
        );
//dd($data);
        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.booking.list', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.booking.create');

        return view('admin.booking.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBooking $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreBooking $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Booking
        $booking = Booking::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/bookings'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/bookings');
    }

    /**
     * Display the specified resource.
     *
     * @param Booking $booking
     * @throws AuthorizationException
     * @return void
     */
    public function show(Booking $booking)
    {
        $this->authorize('admin.booking.show', $booking);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Booking $booking
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Booking $booking)
    {
        $this->authorize('admin.booking.edit', $booking);


        return view('admin.booking.edit', [
            'booking' => $booking,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBooking $request
     * @param Booking $booking
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateBooking $request, Booking $booking)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Booking
        $booking->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/bookings'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/bookings');
    }

    public function approve(Request $request)
    {
        $booking= Booking::find($request->booking_id);
        $booking->status = $request->status;
        $booking->save();

        $booking_activity_log =BookingActivityLog::create([
            "booking_id"=>$request->booking_id,
            "admin_user_id"=>Auth::user()->id,
            "status"=>$request->status,
            "comments"=>$request->comment
        ]);

        $client = User::find($booking->user_id);
        $vendor = User::find($booking->provider_id);
        try{
            Mail::to($client)->send(new CustomerSupportBookingEmail($booking, [
                'subject' => 'Booking Received',
                'message' => 'We have Confirmed your booking #' . $booking->booking_number . ".",
                'title' => 'Booking Received'
            ]));
        }catch(Exception $ex){

        }
        try{
            Mail::to($vendor)->send(new CustomerSupportBookingEmail($booking, [
                'subject' => 'Booking Received',
                'message' => 'Your booking is confirmed from tripscon Support team #' . $booking->booking_number . ".",
                'title' => 'Booking Received'
            ]));
        }catch(Exception $ex){

        }

        return response()->json([
            'message'=>'Success',
        ]);
    }

    public function reject(UpdateBooking $request, Booking $booking)
    {

        $this->authorize('admin.booking.edit', $booking);
        $booking->status = 5;
        $booking->save();

        return redirect('admin/bookings/booking-list');
    }

    public function bookingDetail(Booking $booking)
    {
        return view('admin.booking.detailedView', [
            'booking' => $booking,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyBooking $request
     * @param Booking $booking
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyBooking $request, Booking $booking)
    {
        $booking->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyBooking $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyBooking $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('bookings')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
