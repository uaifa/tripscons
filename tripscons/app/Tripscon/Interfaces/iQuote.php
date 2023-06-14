<?php


namespace App\Tripscon\Interfaces;


use Illuminate\Http\Request;

interface iQuote
{
    /**
     * @Description Send Message
     *
     * @param Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function sendMessage(Request $request);
}
