<?php

namespace App\Http\Controllers\Api;

use App\Events\Booking\BookingCanceled;
use App\Http\Controllers\Controller;
use App\Libs\Gateway\Alfalah;
use App\Libs\Gateway\Cod;
use App\Libs\Gateway\PaymobCard;
use App\Models\CancelBookingDetail;
use App\Models\CancellationPolicy;
use App\Models\Invoice;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Models\User;
use App\Models\RefundRequest;
use App\Notifications\PushNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentsController extends Controller
{
    private $handlers = [
        'paymobCard' => Alfalah::class,
        'alfalah' => Alfalah::class,
        'Cod' => Cod::class,
        'cod' => Cod::class,
    ];

    public function pay(Request $request)
    {
        $request->validate([
            'handler' => 'required',
        ]);
        $reservation = Reservation::find($request->id);

        $handler = $this->handlers[$request->handler];
        $processor = new $handler($request->amount, Reservation::find($request->id), $reservation->booking_detail['cart']['currency']);
        $response = $processor->response();

        return [
            'success' => true,
            'message' => 'Payment url generated successfully',
            'data' => $response
        ];
    }

    public function iframe(Request $request, $handler, Reservation $reservation)
    {
        $handler = $this->handlers[$request->handler];
        $processor = new $handler($reservation->minimum_payable_amount, $reservation, $reservation->booking_detail['cart']['currency']);
        $html = $processor->iframe();
        return view("gateway.iframe", [
            'html' => $html
        ]);
    }

    public function success(Request $request, $handler)
    {
        $handler = $this->handlers[$request->handler];
        $processor = new $handler();
        $processor->handleRedirect($request->all());
    }

    public function refund(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',
            'reason' => 'required',
            'handler' => 'required',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }
        $requestedBy='';
        $refundAmount=0;
        $booking = Reservation::where('id', $request->booking_id)->first();
        // $CancelBookingDetail = new CancelBookingDetail();
        if (!$booking) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid booking id.';
            return response()->json($this->response, $this->status);
        }

        // 0 is used for pending
        // 1  is used for cancel
        // 2 used for complete
        $date = Carbon::now()->format("Y-m-d");
        $date = Carbon::create(Carbon::now()->format("Y-m-d"));
        if ($booking->status != 2 && $booking->status != 1 && Carbon::create($booking->date_from)->gte($date)) {

            if ($booking->provider_user_id == $request->user()->id) {

                $processor = null;
                // $handler = $this->handlers[$request->handler];
                // $processor = new $handler(null, $booking, 'PKR');
                // $processor->generateToken();
                Transaction::where('reservation_id', $booking->id)->where('paid', 1)->each(function ($item) use ($processor) {
                    $refundAmount +=$item->amount;
                    // $response = $processor->refund($item->transaction_id, $item->amount * 100);
                    // $item->refund_data = $response;
                    // $item->update();

                });
                $booking->status = 1;

                $booking->update();

            $title      = "Booking Cancel";
            $userMessage    = "Your booking is cancelled. Booking No.# ". $booking->bookable_id;
            $action     = "user/setting";
            $vendor = User::where('id',$booking->provider_user_id)->first();
            $user = User::where('id',$booking->user_id)->first();
            PushNotification::createNotification($vendor,$user->id,$title,$userMessage,User::TYPE_BOOKING_CANCEL,$action,$booking->id);
            PushNotification::createNotification($user,$vendor->id,$title,$userMessage,User::TYPE_BOOKING_CANCEL,$action,$booking->id);
            $requestedBy=$vendor->email;

            } else {
                if ($booking->grandtotal == $booking->remaining_amount) {
                    $booking->status = 1;
                    $booking->update();
                    
                } else {
                    $refundAmount = $this->refundPercentage($booking)['refund_amount'];
                    // $handler = $this->handlers[$request->handler];
                    // $processor = new $handler(null, $booking, 'PKR');
                    // $processor->generateToken();
                    $transactions = Transaction::where('reservation_id', $booking->id)->where('paid', 1)->get();
                    foreach($transactions as $item) {
                        if ($refundAmount != 0) {
                            if ($item->amount < $refundAmount) {
                                $refundAmount -= $item->amount;
                                // $response = $processor->refund($item->transaction_id, $item->amount * 100);
                                // $item->refund_data = $response;
                                // $item->update();
                            } else {
                                if ($refundAmount != 0) {
                                    // $response = $processor->refund($item->transaction_id, $refundAmount * 100);
                                    // $item->refund_data = $response;
                                    // $item->update();
                                }
                            }
                        }
                    };

                    $booking->status = 1;
                    $booking->update();
                    
                }
                $user = User::where('id',$booking->user_id)->first();
                $requestedBy=$user->email;
            }
            $rquestData=[
                'reservation_id'=>$booking->reference_no,
                'refund_amount'=>$refundAmount,
                'payment_method'=>$request->handler,
                'processing_date'=>$date,
                'requested_by'=>$requestedBy,
            ];
            
            RefundRequest::create($rquestData);

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Booking cancelled successfully';
            $this->response['data'] = null;
            return response()->json($this->response, $this->status);

            // $CancelBookingDetail->booking_id = $request->booking_id;
            // $CancelBookingDetail->user_id = $request->user()->id;
            // $CancelBookingDetail->reason = $request->reason;
            // $CancelBookingDetail->save();
            // $this->status = 200;
            // $this->response['success'] = true;
            // $this->response['message'] = 'Booking cancelled successfully.';
            // //refund amount temprary here ....
            // if ($booking->payment_status != 0) {
            //     $refundPercentage = $this->refundPercentage($booking)['percentage'];
            //     if ($refundPercentage != 0) {
            //         $refund_response = $this->refundCharged($request->booking_id);
            //         if ($refund_response->original['success'] == true) {
            //             $stripeObj = $refund_response->getData()->data;
            //             $this->refundDetails($stripeObj, $request->booking_id);
            //             $invoice = Invoice::where('booking_id', $request->booking_id)->first();
            //             $booking->payment_status = 4;
            //             $invoice->status = 4; // its represent to refund
            //             $booking->save();
            //             $invoice->save();
            //             $this->response['message'] = 'Booking cancelled successfully and payment has been revert.';
            //         }
            //     }
            // }
            // BookingCanceled::dispatch($booking);
            // return response()->json($this->response, $this->status);
        } else {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Sorry, this booking cannot be cancelled';
            return response()->json($this->response, $this->status);
        }
    }

    public function refundPercentage($booking)
    {
        $amountCharged = $booking->paid_ammount;
        $currency = $booking->booking_detail['cart']['currency'] ?? 'PKR';
        $cancellationPolicy = CancellationPolicy::where([
            'bookable' => $booking->bookable,
            'bookable_id' => $booking->bookable_id
        ])->orderByDesc('cancellation_hour')->get();
        $timeRemaining = Carbon::create($booking->date_from)->diffInHours(date('Y-m-d H:i:s'));
        foreach ($cancellationPolicy as $policy) {
            if ($timeRemaining > $policy->cancellation_hour) {
                return [
                    'percentage' => $policy->refund_percentage,
                    'total_paid' => $amountCharged,
                    'hours' => $policy->cancellation_hour,
                    'time_remaining' => $timeRemaining,
                    'refund_amount' => (($amountCharged / 100)) * $policy->refund_percentage,
                    'currency' => $currency,
                ];
            }
        }
        return [
            'percentage' => 0,
            'total_paid' => $amountCharged,
            'hours' => 0,
            'time_remaining' => $timeRemaining,
            'refund_amount' => 0,
            'currency' => $currency,
        ];
    }

    public function refundDetails(Request $request)
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

        $booking = Reservation::where('id', $request->booking_id)->first();
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['data'] = $this->refundPercentage($booking);
        return response()->json($this->response, $this->status);
    }
}
