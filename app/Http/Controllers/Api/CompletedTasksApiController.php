<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompleteUserTask;
use App\Http\Requests\UpdateUserTask;
use App\Log;
use App\Mail\TaskUncompleted;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CompletedTasksApiController extends Controller
{


    public function store(CompleteUserTask $request, Task $task)
    {
        $task->completed = true;
        $task->save();

        return $task;
    }

    /**
     * @param CompleteUserTask $request
     * @param Task $task
     * @return Task
     */
    public function destroy(CompleteUserTask $request, Task $task)
    {
        $task->completed = false;
        $task->save();

        // HOOK -> EVENT

        event(new TaskUncompleted($task));

//        // EXEMPLE DE COM NO FER
//
//        Log::create([
//            'text' => "S'ha marcat com a pendent la tasca 'comprar pa'",
//            'time' =>  Carbon::now(),
//            'action_type' => 'descompletar',
//            'module_type' => 'Tasques',
//            'icon' => 'lock_open',
//            'color' => 'primary',
//            'user_id' => $request->user()->id,
//            'loggable_id' => $task->id,
//            'loggable_type' => Task::class,
//            'new_value' => json_encode(false),
//            'old_value' => json_encode(true),
//
//        ]);
//        Mail::to($request->user())->cc(config('tasks.manager_email'))->send(new TaskUncompleted($task))
//        ->subject($this->subject($task));

        return $task;
    }
}
