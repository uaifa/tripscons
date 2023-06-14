<?php

namespace App\Tripscon\Interfaces;

use Illuminate\Http\Request;

interface iSearch
{

    /**
     * @Description Search
     *
     * @param Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function find(Request $request);
}
