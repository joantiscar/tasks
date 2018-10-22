<?php

use App\Task;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserText extends TestCase{


    use RefreshDatabase;

    public function test_can_add_task_to_user()
    {
        // 1 Prepare

        $user = factory(User::class)->create();
        $task = factory(Task::class)->create();



        //2 execute
        $user->addTask($task);
        $tasks = $user->tasks;


        //3 Comprovar
        $this->assertTrue($tasks[0]->is($task));
    }
    public function test_user_tasks_returns_null_when_no_tasks()
    {
        // 1 Prepare

        $user = factory(User::class)->create();



        //2 execute
        $tasks = $user->tasks;


        //3 Comprovar
        $this->assertEmpty($tasks);
    }


    public function test_user_can_have_tasks()
    {

        $user = factory(User::class)->create();

        $task1 = factory(Task::class)->create();
        $task2 = factory(Task::class)->create();
        $task3 = factory(Task::class)->create();
        $user->addTask($task1);
        $user->addTask($task2);
        $user->addTask($task3);

        //2 execute
        $tasks = $user->tasks;


        //3 Comprovar
        $this->assertTrue($tasks[0]->is($task1));
        $this->assertTrue($tasks[1]->is($task2));
        $this->assertTrue($tasks[2]->is($task3));


    }




}