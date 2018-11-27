<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasquesController extends Controller
{
    public function index()
    {
        // MVC
        $tasks = map_collection(Auth::user()->tasks);
        $users = map_collection(User::all());
        return view('tasques', compact('tasks', 'users'));
    }
}
