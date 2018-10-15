<?php

namespace App\Http\Controllers\Api;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TasksController extends Controller
{
    //
    public function show(Request $request, Task $task) // Route Model Binding
    {

        return $task;

//        return Task::findOrFail($request->task);
    }
    public function destroy(Request $request, Task $task) // Route Model Binding
    {
        $task->delete();

//        return Task::findOrFail($request->task);
    }



    public function edit(Request $request, Task $task) // Route Model Binding
    {
        $task->name = $request->name;
        $task->completed = $request->completed;
        $task->save();




//        return Task::findOrFail($request->task);
    }
    public function store(Request $request) // Route Model Binding
    {
//        Task::create();

        $task = new Task();
        $task->name = $request->name;
        $task->completed = false;
        $task->save();
        return $task;
//        return Task::findOrFail($request->task);
    }
    public function index(Request $request)
    {
        return Task::all();
    }
}
