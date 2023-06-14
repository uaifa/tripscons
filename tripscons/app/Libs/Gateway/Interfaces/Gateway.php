<?php
namespace App\Libs\Gateway\Interfaces;

interface Gateway {
    public function refund ($transactionId, $amount);
    public function handleRedirect($data);
    public function response();
}
