<?php

namespace App\Tripscon\Services\Inquiry\Trip;

use App\Tripscon\Interfaces\iInquiry;
use App\Tripscon\Services\Inquiry\Trip\Custom;

class TripInquiryService
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
