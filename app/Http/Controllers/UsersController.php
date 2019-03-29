<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersIndex;
use App\Http\Requests\UserTaskShow;
use App\Http\Requests\UserTasksIndex;
use App\Tag;
use App\Task;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UsersController extends Controller
{

    public function index(UsersIndex $request)
    {
        $users = map_simple_collection(User::with('roles', 'permissions')->get());
        return view('users', compact('users'));
    }

}
