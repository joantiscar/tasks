<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserTaskShow;
use App\Http\Requests\UserTasksIndex;
use App\Tag;
use App\Task;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TasquesController extends Controller
{

    public function index(UserTasksIndex $request)
    {
        // MVC
        if (Auth::user()->can('tasks.manage')) {
            $tasks = Cache::rememberForever(Task::TASKS_CACHE_KEY, function () {
                return map_collection(Task::with('user', 'tags')
                  ->orderBy('created_at', 'desc')
                  ->get());
            });
            //$tasks = map_collection(Task::with('user', 'tags')
            //  ->orderBy('created_at', 'desc')->get());
            $uri = '/api/v1/tasks';
        } else {
            $tasks = map_collection(Auth::user()->tasks);
            $uri = '/api/v1/user/tasks';
        }
        $users = map_simple_collection(User::with('roles', 'permissions')->get());
        $tags = map_collection(Tag::all());
        return view('tasques', compact('tasks', 'users', 'uri', 'tags'));
    }

    public function show(UserTaskShow $request)
    {
        // MVC
            $task = Task::where('id', '=', $request->id )->with('user')->first()->toJson();
        $tags = map_collection(Tag::all());

        return view('tasks.user.show', compact('task', 'tags'));
    }
}
