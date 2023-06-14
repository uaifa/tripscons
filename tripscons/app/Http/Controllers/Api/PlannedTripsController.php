<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlannedTrip;
use Illuminate\Http\Request;

class PlannedTripsController extends Controller
{
    public function create(Request $request)
    {
        $trip = PlannedTrip::forceCreate([
            'user_id' => $request->user()->id,
            'title' => 'Your trip title',
        ]);

        return response([
            'message' => 'Draft trip created successfully',
            'status' => 200,
            'success' => true,
            'data' => $trip->id
        ]);
    }

    public function update(Request $request)
    {
        # code...
    }

    public function delete(Request $request)
    {
        # code...
    }

    public function get()
    {
        # code...
    }
}
