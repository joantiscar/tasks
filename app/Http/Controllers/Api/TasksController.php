<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DestroyTask;
use App\Http\Requests\IndexTask;
use App\Http\Requests\StoreTask;
use App\Http\Requests\TaskShow;
use App\Http\Requests\UpdateTask;
use App\Http\Requests\UpdateTaskTags;
use App\Tag;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TasksController extends Controller
{
    //
    public function show(TaskShow $request, Task $task) // Route Model Binding
    {
        return $task->map();
    }
    public function destroy(DestroyTask $request, Task $task) // Route Model Binding
    {
        $task->delete();
    }
    public function edit(UpdateTask $request, Task $task) // Route Model Binding
    {
        $task->update($request->all());
        $task->save();
        $data = (array) $request->only('tags');
        $task->syncTags($data['tags']);
        $task->save();
        return $task->map();
    }
    public function store(StoreTask $request) // Route Model Binding
    {
//        return $request->all();
        $task = new Task($request->all());
        $task->save();
//        $data = (array) $request->only('tags');
//        $task->syncTags($data['tags']);

        $task->save();
        return $task->map();
    }
    public function index(IndexTask $request)
    {
        return map_collection(Task::orderBy('created_at', 'desc')->get());
    }
}
