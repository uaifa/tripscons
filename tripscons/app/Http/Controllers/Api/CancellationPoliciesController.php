<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CancellationPoliciesController extends Controller
{
    public function get(Request $request)
    {
        $request->validate([
            'bookable_id' => 'required',
            'cancellation_hour' => 'required|integer',
            'refund_percentage' =>'required|integer'
        ]);
    }
}
