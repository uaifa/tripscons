<?php

namespace App\Libs\Gateway;

use App\Libs\Gateway\Interfaces\Gateway;
use App\Libs\Gateway\Traits\ValidationTrait;
use App\Models\Reservation;
use App\Models\Transaction;

class Alfalah implements Gateway
{
    use ValidationTrait;

    private $amount;
    private $booking;
    public $token;
    private $orderId;

    public function __construct($amount = null, $booking = null, $currency = 'PKR')
    {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->booking = $booking;
        if (!request()->has('O')) {
            $this->validateBooking($this->booking);
            if ($this->booking) {
                if ($this->booking->processor_order_details) {
                    return $this->booking->processor_order_details;
                }
            }
        }
    }

    public function checks()
    {

    }

    public function handShake()
    {
        $this->orderId = uniqid();
        $KeyOne = "5hZarefCcZ28hajk";
        $KeyTwo = "5569585607688392";
        $post_data = array(
            "HS_IsRedirectionRequest" => "0",
            "HS_ChannelId" => "1001",
            "HS_ReturnURL" => url('/payment/success/alfalah'),
            "HS_MerchantId" => "20779",
            "HS_StoreId" => "026654",
            "HS_MerchantHash" => "OUU362MB1uquxVjfnXBx5X6W2mRdXuubL1+K4ASpJ6UdR+coJVZZIS0vyoHuioTop04+fSoA45C2oI/q0jfQog==",
            "HS_MerchantUsername" => "ruloxi",
            "HS_MerchantPassword" => "UIWx8cr+6NNvFzk4yqF7CA==",
            "HS_TransactionReferenceNumber" => $this->orderId,
        );

        $data = [];
        foreach ($post_data as $k => $v) {
            $data[] = implode("=", [$k, $v]);
        }

        $curl = curl_init();
        $cipher = "aes-128-cbc";
        $mapString = implode('&', $data);
        $cipher_text = openssl_encrypt(utf8_encode($mapString), $cipher, utf8_encode($KeyOne), OPENSSL_RAW_DATA, utf8_encode($KeyTwo));
        $cipher_text64 = base64_encode($cipher_text);

        $post_data['HS_RequestHash'] = $cipher_text64;
        $postRequest = json_encode($post_data);
        $ch = curl_init('https://payments.bankalfalah.com/HS/HS/HS');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postRequest);
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($postRequest)),
        );

        $response = curl_exec($ch);

        curl_close($curl);

        $response = json_decode($response);

        $authToken = $response->AuthToken;
        $returnUrl = $response->ReturnURL;
        $postData = array(
            "AuthToken" => $authToken,
            "RequestHash" => $cipher_text64,
            "ChannelId" => "1001",
            "Currency" => "PKR",
            "ReturnURL" => $returnUrl,
            "MerchantId" => "20779",
            "StoreId" => "026654",
            "MerchantHash" => "OUU362MB1uquxVjfnXBx5X6W2mRdXuubL1+K4ASpJ6UdR+coJVZZIS0vyoHuioTop04+fSoA45C2oI/q0jfQog==",
            "MerchantUsername" => "ruloxi",
            "MerchantPassword" => "UIWx8cr+6NNvFzk4yqF7CA==",
            "TransactionTypeId" => "3",
            "TransactionReferenceNumber" => $this->orderId,
            "TransactionAmount" => $this->amount,
        );

        $data = [];
        foreach ($postData as $k => $v) {
            $data[] = implode("=", [$k, $v]);
        }

        $curl = curl_init();
        $cipher = "aes-128-cbc";
        $mapString = implode('&', $data);
        $cipher_text = openssl_encrypt(utf8_encode($mapString), $cipher, utf8_encode($KeyOne), OPENSSL_RAW_DATA, utf8_encode($KeyTwo));
        $cipher_text64 = base64_encode($cipher_text);

        $postData['RequestHash'] = $cipher_text64;

        $html_fields = array();

        foreach ($postData as $key => $value) {
            $html_fields[] = "<input id='$key' type='hidden' name='$key' value='$value'/>";
        }

        $html_form = '<form action="https://payments.bankalfalah.com/SSO/SSO/SSO" method="post" id="PageRedirectionForm" novalidate="novalidate">'
        . implode('', $html_fields). '<input type="submit" class="button" id="run" value="Pay" /></form>';
        $this->booking->update([
            'order_id' => $this->orderId
        ]);
        return str_replace('"', "'", $html_form);
    }

    public function response()
    {
        $transactions = [
            'reservation_id' => $this->booking->id,
            'payment_processor' => self::class,
            'amount' => $this->amount,
            'order_id' => $this->orderId,
            'processor_order_details' => [
                'orderId' => $this->orderId,
                'token' => null,
                'redirect_url' => url('/payment/iframe/alfalah/' . $this->booking->id),
                'iframe' => "<iframe src='" .  url('/payment/iframe/alfalah/' . $this->booking->id) . "'>",
                "success_url" => config('app.HOME_PAGE_URL') . 'payment/confirmation',
                "error_url" => config('app.HOME_PAGE_URL') . 'payment/error',
            ]
        ];
        return $transactions;
    }

    public function handleRedirect($data)
    {
        $booking = Reservation::where('order_id', $data['O'])->first();
        $url = "https://payments.bankalfalah.com/HS/api/IPN/OrderStatus/20779/026654/" . $data['O'];

        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL,  $url);
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

        $jsonData = json_decode(curl_exec($curlSession));
        curl_close($curlSession);

        $result =  json_decode($jsonData);
        $success = $result->TransactionStatus == 'Paid' ? true : false;
        if($success){
            $transaction = Transaction::where('transaction_id', $result->TransactionId)->first();
            if($transaction){
                return redirect()->to(config('app.HOME_PAGE_URL') . 'payment/confirmation')->send();
            }

            $transaction = Transaction::forceCreate([
                'reservation_id' => $booking->id,
                'payment_processor' => self::class,
                'amount' => $result->TransactionAmount,
                'order_id' => $booking,
                'processor_order_details' => (array)$result,
                'transaction_id' => $result->TransactionId
            ]);

            $booking->minimum_payable_amount = $booking->remaining_amount - $transaction->amount;
            $booking->remaining_amount = $booking->remaining_amount - $transaction->amount;
            $booking->order_id = null;
            $booking->update();
            return redirect()->to(config('app.HOME_PAGE_URL') . 'payment/confirmation')->send();
        }
        else {
            return redirect()->to(config('app.HOME_PAGE_URL') . 'payment/error')->send();
        }
    }

    public function refund($transactionId, $amount)
    {
        // $curl = curl_init();
        // $js = '{
        //     "auth_token":  "' . $this->oauthToken . '",
        //     "transaction_id": ' . $transactionId . ',
        //     "amount_cents": ' . intval($amount) . '
        // }';

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://pakistan.paymob.com/api/acceptance/void_refund/refund',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS => $js,
        //     CURLOPT_HTTPHEADER => array(
        //         'Content-Type: application/json',
        //     ),
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);

        // return json_decode($response, true);

    }

    public function iframe()
    {
        return $this->handShake();
    }
}
