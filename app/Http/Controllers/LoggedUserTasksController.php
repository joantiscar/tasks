<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoggedUserTasksController extends Controller
{
    public function index()
    {
        $tasks =  map_collection(Auth::user()->tasks);
        $users = User::all();
        $uri = '/api/v1/user/tasks';
        $tags =  map_collection(Tag::all());
        return view('tasques',compact('tasks','users', 'uri', 'tags'));
    }
}
