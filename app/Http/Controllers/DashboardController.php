<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function loadViewShutter(Request $request){
        return view('shutter');
    }
}
