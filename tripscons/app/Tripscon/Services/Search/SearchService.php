<?php


namespace App\Tripscon\Services\Search;


use App\Tripscon\Interfaces\iSearch;

class SearchService
{
    /**
     * @Description
     *
     * @param iSearch $iSearch
     * @param $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function search(iSearch $iSearch,$request)
    {
       
        //print_r($iSearch);exit;
        return $iSearch->find($request);
    }
}
