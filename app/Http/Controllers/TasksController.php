<?php

namespace App\Http\Controllers;


use App\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{


    public function index()
    {
        $tasks = Task::all();

        return view('tasks',['tasks' => $tasks]);
    }
    //
    public function store(Request $request)
    {

//        dd($request->name);

        // Request::

        Task::create([

            'name'=>$request->name,
            'completed'=> false

        ]);
        //Retornar a /tasks
            return redirect('/tasks');
        ;
    }

    public function delete(Request $request)
    {
        $task = Task::findorfail($request->id);
        $task->delete();

        return redirect('/tasks');
    }
    public function update(Request $request)
    {
        // Models -> Eloquent -> ORM (HIVERNATE De Java) Object Relation Model




        $task = Task::findorfail($request->id);
        $task->name = $request->name;
        $task->completed = $request->completed;
        $task->save();


//        if ($task->completed == true){
//            $task->completed = false;
//        }else{
//            $task->completed = true;
//        }
//
//        $task->save();

        return redirect('/tasks');


    }

    public function edit(Request $request)
    {
        $task = Task::findorfail($request->id);
        return view('tasks_edit', compact('task'));
    }
    public function completar(Request $request){

        $task = Task::findorfail($request->id);

        if ($task->completed == true){
            $task->completed = false;
        }else{
            $task->completed = true;
        }

        $task->save();
        return redirect('/tasks');


    }
}
