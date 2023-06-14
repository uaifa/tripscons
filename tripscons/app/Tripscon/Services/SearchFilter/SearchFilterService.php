<?php


namespace App\Tripscon\Services\SearchFilter;


use App\Tripscon\Interfaces\iSearchFilter;
use Illuminate\Http\Request;

class SearchFilterService
{
    /**
     * @Description Search Filter
     * @param iSearchFilter $iSearchFilter
     * @param Request $request
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public static function filter(iSearchFilter $iSearchFilter, Request $request)
    {
        return $iSearchFilter->filter($request);
    }
}
