<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserTaskShow;
use App\Http\Requests\UserTasksIndex;
use App\Tag;
use App\Task;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class GamepadController extends Controller
{

    public function index(Request $request)
    {

        return view('gamepad');

    }
}
