<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DestroyTask;
use App\Http\Requests\IndexTask;
use App\Http\Requests\StoreTask;
use App\Http\Requests\TaskShow;
use App\Http\Requests\UpdateTask;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TasksController extends Controller
{
    //
    public function show(TaskShow $request, Task $task) // Route Model Binding
    {

        return $task->map();

//        return Task::findOrFail($request->task);
    }
    public function destroy(DestroyTask $request, Task $task) // Route Model Binding
    {
        $task->delete();

//        return Task::findOrFail($request->task);
    }



    public function edit(UpdateTask $request, Task $task) // Route Model Binding
    {

        $task->name = $request->name;
        $task->completed = $request->completed;
        $task->description = $request->description;
        $task->user_id = $request->user_id;
        $task->save();

        return $task->map();


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
        $task->completed = $request->completed;
        $task->description = $request->description;
        $task->user_id = $request->user_id;
        $task->save();
        return $task->map();
//        return Task::findOrFail($request->task);
    }
    public function index(IndexTask $request)
    {
        return map_collection(Task::orderBy('created_at)')->get());
    }
}
