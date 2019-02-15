<?php

namespace App\Http\Controllers\Api;

use App\Events\TaskCreated;
use App\Events\TaskDeleted;
use App\Events\TaskUpdated;
use App\Http\Requests\DestroyTask;
use App\Http\Requests\IndexTask;
use App\Http\Requests\StoreTask;
use App\Http\Requests\TaskShow;
use App\Http\Requests\UpdateTask;
use App\Task;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class TasksController extends Controller
{

    //
    public function show(TaskShow $request, Task $task) // Route Model Binding
    {
        return $task->map();
    }

    public function destroy(DestroyTask $request, Task $task) // Route Model Binding
    {
        $oldTask = $task->mapSimple();
        $task->delete();
        event(new TaskDeleted($oldTask));

    }

    public function edit(UpdateTask $request, Task $task) // Route Model Binding
    {
        $oldTask = $task->mapSimple();
        $task->update($request->all());
        $task->save();
        $data = (array)$request->only('tags');
        $task->syncTags($data['tags']);
        $task->save();
        event(new TaskUpdated($oldTask, $task));
        return $task->map();
    }

    public function store(StoreTask $request) // Route Model Binding
    {
        //        return $request->all();
        $task = new Task($request->all());
        $task->save();
        //        $data = (array) $request->only('tags');
        //        $task->syncTags($data['tags']);

        $tags = $request->only('tags');
        if (sizeof($tags) > 0) {
            $task->syncTags($tags['tags']);
        }
        $task->save();

        event(new TaskCreated($task));

        return $task->map();
    }

    public function index(IndexTask $request)
    {

        return Cache::rememberForever(Task::TASKS_CACHE_KEY, function () {
            return map_collection(Task::with('user', 'tags')
              ->orderBy('created_at', 'desc')
              ->get());
        });
    }

    public function refresh(IndexTask $request)
    {
        return map_collection(Task::with('user', 'tags')
          ->orderBy('created_at', 'desc')
          ->get());
    }
}

