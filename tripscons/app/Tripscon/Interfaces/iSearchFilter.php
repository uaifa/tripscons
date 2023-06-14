<?php


namespace App\Tripscon\Interfaces;


use Illuminate\Http\Request;

interface iSearchFilter
{
    /**
     * @Description Search Filter
     * @param Request $request
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public function filter(Request $request);
}
