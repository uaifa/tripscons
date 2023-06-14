<?php

namespace App\Libs\Gateway;

use App\Libs\Gateway\Interfaces\Gateway;
use App\Models\Reservation;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class PaymobCard implements Gateway
{

    private $amount;
    private $currency;
    private $booking;
    private $handler = 4952;
    private $orderId;
    private $oauthToken = null;
    public $token;
    private $iframeId = 11858;

    public function __construct($amount = null, $booking = null, $currency = 'PKR')
    {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->booking = $booking;
        if(!request()->has('success')){
            $this->generateToken();
            $this->createOrder();
            $this->createPaymentKeys();
            if($this->booking){
                if($this->booking->processor_order_details) {
                    return $this->booking->processor_order_details;
                }
            }
        }
    }

    public function generateToken()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://pakistan.paymob.com/api/auth/tokens',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "api_key":"ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2ljSEp2Wm1sc1pWOXdheUk2TkRjd015d2libUZ0WlNJNkltbHVhWFJwWVd3aWZRLnhKT2Q0VWZfenpCMU0xSDJnTE5RQ3d1NzdOellZczhmT0o5QWZLUkZtWHZoS2NYWncwVmF2VGRQTVJZdHd1SWt0NExVdi0wMEVaOXd3Z1pBQWVoVjd3",
                "username":"Naeemtripscon",
                "password":"Tripscon00.?"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);
        $this->oauthToken = $response['token'];
    }

    public function createOrder()
    {
        $curl = curl_init();

        $js = '{
            "auth_token":  "' . $this->oauthToken . '",
            "delivery_needed": "false",
            "amount_cents": "' . intval($this->amount * 100) . '",
            "currency": "'.$this->currency.'",
            "merchant_order_id": "' . uniqid() . '"
        }';

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://pakistan.paymob.com/api/ecommerce/orders',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $js,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $this->orderId = json_decode($response, true)['id'];
    }

    public function createPaymentKeys()
    {
        $curl = curl_init();

        $user = Auth::user();
        $phone = trim($user->phone) != "" ? $user->phone : "+923401577777";
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://pakistan.paymob.com/api/acceptance/payment_keys',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "auth_token": "' . $this->oauthToken . '",
            "amount_cents": "' . intval($this->amount * 100) . '",
            "expiration": 3600,
            "order_id": "' . $this->orderId . '",
            "billing_data": {
                "apartment": "NA",
                "email": "' . $user->email . '",
                "floor": "NA",
                "first_name": "' . $user->name . '",
                "street": "NA",
                "building": "NA",
                "phone_number": "' . $phone . '",
                "shipping_method": "NA",
                "postal_code": "NA",
                "city": "NA",
                "country": "NA",
                "last_name": "' . $user->name . '",
                "state": "NA"
            },
            "currency": "'.$this->currency.'",
            "integration_id": ' . $this->handler . ',
            "lock_order_when_paid": "false"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        // dd(json_decode($response, true)['token']);
        $this->token = json_decode($response, true)['token'];
    }

    public function response()
    {
        $transactions = Transaction::forceCreate([
            'reservation_id' => $this->booking->id,
            'payment_processor' => self::class,
            'amount' => $this->amount,
            'order_id' => $this->orderId,
            'processor_order_details' => [
                'orderId' => $this->orderId,
                'token' => $this->token,
                'redirect_url' => 'https://pakistan.paymob.com/api/acceptance/iframes/' . $this->iframeId . '?payment_token=' . $this->token,
                'iframe' => "<iframe src='https://pakistan.paymob.com/api/acceptance/iframes/" . $this->iframeId . "?payment_token=" . $this->token . "'>",
                "success_url" => config('app.HOME_PAGE_URL') . 'payment/confirmation',
                "error_url" => config('app.HOME_PAGE_URL') . 'payment/error',
            ]
        ]);
        return $transactions;
    }

    public function handleRedirect($data)
    {
        $transaction = Transaction::where('order_id', $data['order'])->first();
        if($data['success'] != 'false' && $transaction->paid != true){
            $transaction->paid = true;
            $transaction->payment_date = date('Y-m-d');
            // $transaction->transaction_id = $data['id'];
            $transaction->update();

            $reservation = Reservation::find($transaction->reservation_id);
            $reservation->minimum_payable_amount = $reservation->remaining_amount - $transaction->amount;
            $reservation->remaining_amount = $reservation->remaining_amount - $transaction->amount;
            $reservation->update();
            return redirect()->to(config('app.HOME_PAGE_URL') . 'payment/confirmation')->send();
        }
        else {
            return redirect()->to(config('app.HOME_PAGE_URL') . 'payment/error')->send();
        }
    }

    public function refund($transactionId, $amount)
    {
        $curl = curl_init();
        $js = '{
            "auth_token":  "' . $this->oauthToken . '",
            "transaction_id": '.$transactionId.',
            "amount_cents": '.intval($amount) .'
        }';

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://pakistan.paymob.com/api/acceptance/void_refund/refund',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $js,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);

    }
}
