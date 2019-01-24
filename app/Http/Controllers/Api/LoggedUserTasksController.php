<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DestroyUserTask;
use App\Http\Requests\IndexUserTask;
use App\Http\Requests\StoreUserTask;
use App\Http\Requests\UpdateUserTask;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoggedUserTasksController extends Controller
{
    public function index(IndexUserTask $request)
    {
        //                                                                                                                                                                                                                                                                                                                                     Fet per lo de La Sénia

//        return Task::where('user_id', Auth::user()->id);
        return map_collection(Auth::user()->tasks);
    }
    public function store(StoreUserTask $request)
    {

//        $task = new Task();
//        $task->name = $request->name;
//        $task->completed = false;
//        $task->save();
//        return $task->map();
//

//        return Task::where('user_id', Auth::user()->id);
        $task = Task::create($request->only(['name','completed', 'description', 'user_id']));
//        return Auth::user()->tasks->save($task);


        return $task->map();
    }
    public function update(UpdateUserTask $request, Task $task)
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
    public function destroy(DestroyUserTask $request, Task $task)
    {

//        return Task::where('user_id', Auth::user()->id);
        Auth::user()->tasks()->findOrFail($task->id);
        $task->delete();

    }
}
