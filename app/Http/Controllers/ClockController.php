<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClockController extends Controller
{
    public function index()
    {
        // MVC
        return view('clock');
    }
}
