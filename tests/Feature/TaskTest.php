<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function todo()
    {
        $this->withExceptionHandling();
        $response = $this->get('/tasks');


//        dd($response);
        $response->assertSuccessful();
        $response->assertSee('Tasques');
    }
}
