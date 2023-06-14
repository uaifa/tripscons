<?php

namespace App\Libs\Gateway;

use App\Libs\Gateway\Interfaces\Gateway;
use App\Models\Reservation;
use App\Models\Transaction;

class Cod implements Gateway {

    public function __construct($amount = null, $booking = null, $currency = 'PKR')
    {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->booking = $booking;

        if($this->booking){
            if($this->booking->processor_order_details) {
                return $this->booking->processor_order_details;
            }
        }
    }

    public function refund($transactionId, $amount)
    {

    }

    public function response()
    {
        $orderId = hexdec(uniqid());
        $transactions = Transaction::forceCreate([
            'reservation_id' => $this->booking->id,
            'payment_processor' => self::class,
            'amount' => $this->amount,
            'order_id' => $orderId,
            'processor_order_details' => [
                'orderId' => null,
                'token' => null,
                'redirect_url' => url("/payment/success/Cod?success=true&order=" . $orderId . "&id=" . uniqid()),
                'iframe' => "<iframe src='https://pakistan.paymob.com/api/acceptance/iframes/?payment_token='>",
                "success_url" => config('app.HOME_PAGE_URL') . 'payment/confirmation',
                "error_url" => config('app.HOME_PAGE_URL') . 'payment/error',
            ]
        ]);
        return $transactions;
    }

    public function handleRedirect($data)
    {
        $transaction = Transaction::where('order_id', $data['order'])->first();
        if($data['success'] && $transaction->paid != true){
            $transaction->paid = true;
            $transaction->payment_date = date('Y-m-d');
            $transaction->transaction_id = $data['id'];
            $transaction->update();

            $reservation = Reservation::find($transaction->reservation_id);
            $reservation->minimum_payable_amount = $reservation->remaining_amount - $transaction->amount;
            $reservation->remaining_amount = $reservation->remaining_amount - $transaction->amount;
            $reservation->update();
            return redirect()->to(config('app.HOME_PAGE_URL') . 'payment/confirmation')->send();
        }
    }

}
