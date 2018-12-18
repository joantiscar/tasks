<?php

namespace Tests\Unit;

use App\File;
use App\Tag;
use App\Task;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_assign_user_to_task()
    {
        $user = factory(User::class)->create();
                $this->actingAs($user);
        $task = Task::create([
            'name' => 'Comprar pa'
        ]);

        $userOriginal = factory(User::class)->create();

        $task->assignUser($userOriginal);

        $user = $task->user;

        $this->assertTrue($user->is($userOriginal));
    }

    public function test_can_assign_tag_to_task() {
        // 1 Prepare
        $user = factory(User::class)->create();
                $this->actingAs($user);
        $task = factory(Task::class)->create();

        $tag = Tag::create([
            'name' => 'home'
        ]);
        // execució
        $task->addTag($tag);

        // Assertion
        $tags = $task->tags;
        $this->assertTrue($tags[0]->is($tag));


    }

    public function test_a_task_can_have_tags() {
        // 1 Prepare
        $user = factory(User::class)->create();
                $this->actingAs($user);
        $task = Task::create([
            'name' => 'Comprar pa'
        ]);

        $tag1 = Tag::create([
            'name' => 'home'
        ]);
        $tag2 = Tag::create([
            'name' => 'work'
        ]);

        $tag3 = Tag::create([
            'name' => 'studies'
        ]);

        $tags = [$tag1, $tag2, $tag3];

        // execució
        $task->addTags($tags);

        // Assertion
        $tags = $task->tags;

        $this->assertTrue($tags[0]->is($tag1));
        $this->assertTrue($tags[1]->is($tag2));
        $this->assertTrue($tags[2]->is($tag3));


    }


    /**
     * @test
     */
    public function a_task_can_have_one_file()
    {
        // 1 Prepare
        $user = factory(User::class)->create();
                $this->actingAs($user);
        $task = Task::create([
            'name' => 'Comprar pa'
        ]);

        $fileOriginal = File::create([
            'path' => 'fitxer1.pdf'
        ]);

//        add_file_to_task($file, $task);
        $task->assignFile($fileOriginal);

        // 2 Executo -> Wishful programming

        // IMPORTANT 2 maneres
        // 1 Aixó torna tota la relació, treball extra
//        $file = $task->files()->where('path','');
        // 2 Això retorna el object:
        $file = $task->file;

        // 3 Comprovo
        // $file
        $this->assertTrue($file->is($fileOriginal));

    }

    /**
     * @test
     */
    public function a_task_file_returns_null_when_no_file_is_assigned()
    {
        $user = factory(User::class)->create();
                $this->actingAs($user);
        // 1 Prepare
        $task = Task::create([
            'name' => 'Comprar pa'
        ]);
        // 2 Executo -> Wishful programming
        $file = $task->file;

        // 3 Comprovo
        // $file
        $this->assertNull($file);

    }

    public function test_can_toggle_completed()
    {
        $user = factory(User::class)->create();
                $this->actingAs($user);
        $task = factory(Task::class)->create([
            'completed' => false
        ]);
        $task->toggleCompleted();
        $this->assertTrue($task->completed);
    }
    public function test_can_toggle_uncompleted()
    {
        $task = factory(Task::class)->create([
            'completed' => true
        ]);
        $task->toggleCompleted();
        $this->assertFalse($task->completed);
    }

    public function test_map()
    {
        $user = factory(User::class)->create();
        $task = create_example_task_with_tags($user);

        $mappedTask = $task->map();

        $this->assertEquals($mappedTask['id'],1);
        $this->assertEquals($mappedTask['name'],'Comprar pa');
        $this->assertEquals($mappedTask['completed'],false);
        $this->assertEquals($mappedTask['user_id'],$user->id);
        $this->assertEquals($mappedTask['user_name'],$user->name);
        $this->assertEquals($mappedTask['user_email'], $user->email);
        $this->assertTrue($user->is($mappedTask['user']));
        $this->assertEquals($mappedTask['tags'][0]->name, 'Astio'); //Todo
        $this->assertEquals($mappedTask['tags'][0]->color, 'blue'); //Todo
        $this->assertEquals($mappedTask['tags'][0]->description, 'astio'); //Todo
        $this->assertEquals($mappedTask['tags'][1]->name, 'asdada'); //Todo
        $this->assertEquals($mappedTask['tags'][1]->color, 'red'); //Todo
        $this->assertEquals($mappedTask['tags'][1]->description, 'asdada'); //Todo

        //3

    }
}
