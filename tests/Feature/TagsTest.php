<?php

namespace Tests\Feature;

use App\Tag;
use App\Task;
use App\User;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagsTest extends TestCase
{
    use RefreshDatabase, CanLogin;
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function can_index_tags()
    {

        $this->login();
        $this->withExceptionHandling();

        $tag1 = factory(Tag::class)->create();
        $tag2 = factory(Tag::class)->create();
        $tag3 = factory(Tag::class)->create();



        $response = $this->get('/tags');


//        dd($response);
        $response->assertSuccessful();
        $response->assertSee($tag1->name);
        $response->assertSee($tag2->name);
        $response->assertSee($tag3->name);


        //comprovar que es veuen les tasques que hi ha a la base de dades
    }

}
