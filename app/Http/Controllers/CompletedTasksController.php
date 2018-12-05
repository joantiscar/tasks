<?php

namespace App\Http\Controllers;

use App\CompletedTask;
use App\Task;
use Illuminate\Http\Request;

class CompletedTasksController extends Controller
{

    public function store(Request $request, Task $task)
    {
        $task->completed = true;
        $task->save();
    }
    public function update(Request $request, CompletedTask $completedTask)
    {
    }


    public function destroy(Request $request, Task $task)
    {
        $task->completed = false;
        $task->save();
    }
}
