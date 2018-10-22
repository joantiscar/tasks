<?php
/**
 * Created by PhpStorm.
 * User: dios
 * Date: 19/10/18
 * Time: 16:17
 */

namespace Tests\Unit;


use App\File;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_task_can_have_one_file()
    {

        // 1 Prepare
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
    public function test_a_file_returns_null_when_no_file_is_assigned()
    {
        // 1 Prepare
        $task = Task::create([

            'name'=>'comprar pa',
            'completed' => false
        ]);
        // 2 Execute  -> Wishful Programming
        $file = $task->assignFile();

        // 3 Comprovar

        $this->assertNull($file);


    }
}