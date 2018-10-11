<?php


use App\Task;

if (!function_exists('create_example_tasks')){
    function create_Example_tasks(){
        $task = Task::create([
            'name' => 'Comprar pa',
            'completed' => false
        ]);
        $task = Task::create([
            'name' => 'Comprar llet',
            'completed' => false
        ]);
        $task = task::create([
            'name' => 'Estudiar PHP',
            'completed' => true
        ]);
    }
}