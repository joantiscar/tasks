<?php

namespace App\Http\Controllers;


use App\Task;
use Illuminate\Http\Request;

class PagesController extends Controller
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

    public function destroy(Request $request)
    {
        $task = Task::findorfail($request->id);
        $task = delete();

        return redirect()->back();
    }
}
