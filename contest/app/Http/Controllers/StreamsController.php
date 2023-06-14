<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StreamsController extends Controller
{
    public function index(Request $request, $filePath)
    {
        if(Storage::disk('media')->exists($filePath)){
            $file = Storage::disk('media')->get($filePath);
            $mimeType = Storage::disk('media')->mimeType($filePath);

            return response($file, 200, [
                'Content-Type' => $mimeType
            ]);
        }
        else {
            abort(404);
        }
    }
}
