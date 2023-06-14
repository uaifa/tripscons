<?php


namespace App\Tripscon\Services\Quote;


use App\Tripscon\Interfaces\iQuote;

class QuoteService
{
    /**
     * @Description Get a Quote Service
     *
     * @param iQuote $iQuote
     * @param $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function sendMessage(iQuote $iQuote, $request)
    {
        return $iQuote->sendMessage($request);
    }
}
