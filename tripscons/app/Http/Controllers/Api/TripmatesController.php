<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlannedTrip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TripmatesController extends Controller
{
    public function uploadImage(Request $request)
    {
        $request->validate([
            'planned_trip_id' => 'required|exists:planned_trips,id',
            'imageFile' => 'required|image'
        ]);

        $trip = PlannedTrip::find($request->planned_trip_id);

        if(Auth::id() != $trip->user_id){
            abort(403);
        }

        $filename = 'assets/uploads/trips/' . uniqid() . '.jpg';

        $this->file('imageFile')->move(public_path($filename));

        $images = $trip->images;

        $images[] = [
            'id' => Str::uuid(),
            'path' => $filename
        ];

        $trip->images = $images;
        $trip->update();

    }
}
