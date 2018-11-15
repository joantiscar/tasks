<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoggedUserTasksController extends Controller
{
    public function index()
    {

//        return Task::where('user_id', Auth::user()->id);
        return Auth::user()->tasks;
    }
    public function store(Request $request)
    {



//        return Task::where('user_id', Auth::user()->id);
        $task = Request::create($request->only(['name','completed']));
//        return Auth::user()->tasks->save($task);

        return Auth::user()->tasks;
    }
    public function destroy(Request $request, Task $task)
    {

//        return Task::where('user_id', Auth::user()->id);
        Auth::user()->tasks()->findOrFail($task->id);
        $task->delete();

    }
    public function update(Request $request, Task $task)
    {
//        return Task::where('user_id', Auth::user()->id);


        Auth::user()->tasks()->findOrFail($task->id);
        $task->name = $request->name;
        $task->completed = $request->completed;
        $task->description = $request->description;
        $task->save();
        return $task;
//        if (Auth::user()->haveTask($task) ){
//            $task->name = $request->name;
//            $task->completed = $request->completed;
//            $task->save();
//        }


    }
}
