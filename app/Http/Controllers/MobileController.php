<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserTasksIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MobileController extends Controller
{
    public function index(Request $request)
    {
        return view('mobile');
    }
}
