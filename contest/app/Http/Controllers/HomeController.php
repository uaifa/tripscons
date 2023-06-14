<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $contests = Contest::where('status', 'active')->get();
        return view('home', [
            'contests' => $contests
        ]);
    }
}
