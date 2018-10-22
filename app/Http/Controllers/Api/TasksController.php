<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreTask;
use App\Http\Requests\UpdateTask;
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



    public function update(UpdateTask $request, Task $task) // Route Model Binding
    {
        $task->name = $request->name;
        $task->completed = $request->completed;
        $task->save();




//        return Task::findOrFail($request->task);
    }
    public function store(StoreTask $request) // Route Model Binding
    {
//        Task::create();

//          $request->validate([
//            'name' => 'required',
//        ]);


        $task = new Task();
        $task->name = $request->name;
        $task->completed = false;
        $task->save();
        return $task;
//        return Task::findOrFail($request->task);
    }
    public function index(Request $request)
    {
        return Task::orderBy('created_at','desc')->get();
    }
}
