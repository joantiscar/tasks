<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MultimediaController extends Controller
{
    public function index()
    {
        // MVC
        return view('multimedia');
    }
}
