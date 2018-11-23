<?php

use App\Task;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
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


    public function test_can_add_tasks_to_user()
    {
        // 1 Prepare

        $user = factory(User::class)->create();
        $task1 = factory(Task::class)->create();
        $task2 = factory(Task::class)->create();
        $task3 = factory(Task::class)->create();
        $tasks = [$task1, $task2, $task3];


        //2 execute
        $user->addTasks($tasks);
        $tasks = $user->tasks;


        //3 Comprovar
        $this->assertTrue($tasks[0]->is($task1));
        $this->assertTrue($tasks[1]->is($task2));
        $this->assertTrue($tasks[2]->is($task3));
    }

    public function test_have_task()
    {

        $user = factory(User::class)->create();
        $task = factory(Task::class)->create();



        //2 execute
        $user->addTask($task);


        $tascaRetornada = $user->haveTask($task);

        assertEquals($task, $tascaRetornada);

    }
    public function test_remove_task()
    {

        $user->removeTask();
    }

    public function test_is_Super_Admin()
    {
        $user = factory(User::class)->create();

        $this->assertFalse($user->isSuperAdmin());

        $user->admin = true;
        $user->save();
        $this->assertTrue($user->isSuperAdmin());
    }

    public function test_user_map()
    {

        $user = factory(User::class)->create([
            'name' => 'pepe',
            'email' => 'pepe@gmail.com',
            // Accessors i mutators
        ]);
        $mappedUser = $user->map();
        $this->assertEquals($mappedUser['name'], 'pepe');
        $this->assertEquals($mappedUser['email'], 'pepe@gmail.com');
        $this->assertEquals($mappedUser['avatar'], 'https://www.gravatar.com/avatar/6b0becddecd5a06042b3f8078c97f2e0');
        $this->assertEquals($mappedUser['admin'], 0);
        $this->assertCount(0, $mappedUser['permissions']);
        $this->assertCount(0, $mappedUser['roles']);
        $user->admin = true;
        $user->save();
        $user = $user->fresh();
        $mappedUser = $user->map();
        $this->assertEquals($mappedUser['admin'], true);



        $per1 = Permission::create([
            'name' => 'per1'
        ]);
        $per2 = Permission::create([
            'name' => 'per2'
        ]);
        $per3 = Permission::create([
            'name' => 'per3'
        ]);

        $rol1 = Role::create([
            'name' => 'rol1'
        ]);
        $rol2= Role::create([
            'name' => 'rol2'
        ]);
        $rol3 = Role::create([
            'name' => 'rol3'
        ]);

        $user->givePermission($per1);
        $user->givePermission($per2);
        $user->givePermission($per3);
        $user->giveRole($rol1);
        $user->giveRole($rol2);
        $user->giveRole($rol3);
        $this->assertEquals($mappedUser['roles'][0], $rol1);
        $this->assertEquals($mappedUser['roles'][1], $rol2);
        $this->assertEquals($mappedUser['roles'][2], $rol2);
        $this->assertEquals($mappedUser['permissions'][0], $per1);
        $this->assertEquals($mappedUser['permissions'][1], $per2);
        $this->assertEquals($mappedUser['permissions'][2], $per2);

    }

    public function test_regulars()
    {
        $this->assertCount(0, User::regular()->get());

        $user1 = factory(User::class)->create([
            'name' => 'Pepe',
            'email' => 'pepe@gmail.com'
        ]);
        $user2 = factory(User::class)->create([
            'name' => 'Pepa',
            'email' => 'pepa@gmail.com'
        ]);
        $user3 = factory(User::class)->create([
            'name' => 'Pipo',
            'email' => 'pipo@gmail.com'
        ]);
        $user3->admin = true;
        $user3->save();
        $this->assertCount(2, $regularUsers = User::regular()->get());
        $this->assertEquals($regularUsers[0]->name,  $user1->name);
        $this->assertEquals($regularUsers[1]->name,  $user2->name);
        try{
            $this->assertNull($regularUsers[2]);
        }catch(Exception $e){
//            $this->assert
        }

    }

}