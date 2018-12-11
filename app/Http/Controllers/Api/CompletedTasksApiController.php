<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompleteUserTask;
use App\Http\Requests\UpdateUserTask;
use App\Task;
use Illuminate\Http\Request;

class CompletedTasksApiController extends Controller
{


    public function store(CompleteUserTask $request, Task $task)
    {
        $task->completed = true;
        $task->save();
        return $task;
    }
    public function destroy(CompleteUserTask $request, Task $task)
    {
        $task->completed = false;
        $task->save();
        return $task;
    }
}
