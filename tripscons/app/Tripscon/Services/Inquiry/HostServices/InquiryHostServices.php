<?php


namespace App\Tripscon\Services\Inquiry\HostServices;


use App\Tripscon\Interfaces\iInquiry;

class InquiryHostServices
{

    /**
     * @Description Save Inquiry Data
     *
     * @param iInquiry $inquiry
     * @param $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function save(iInquiry $inquiry, $request)
    {
        return $inquiry->save($request);
    }

}
