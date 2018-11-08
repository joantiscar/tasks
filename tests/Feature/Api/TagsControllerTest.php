<?php
/**
 * Created by PhpStorm.
 * User: dios
 * Date: 11/10/18
 * Time: 19:24
 */

namespace Tests\Feature\Api;


use App\Tag;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;

class TagsControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;
    
    public function test_can_show_a_tag()
    {
    $user = factory(User::class)->create();
            $this->actingAs($user, "api");
        // http://tags.test/api/v1/tags

        //CRUD -> CRU -> CREATE RETRIEVE UPDATE DELETE
        //BREAD -> PA -> BROWSE READ EDIT ADD DELETE

        //HTTP -> GET / POST / PUT / DELETE


//        Tag::create([]);
        $tag = factory(Tag::class)->create();


        $this->withoutExceptionHandling();



        $response = $this->get('/api/v1/tags/' . $tag->id);

        $result = json_decode($response->getContent());

        $response->assertSuccessful();
        $this->assertEquals($tag->name, $result->name);
    }

    public function test_can_delete_tag()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, "api");
        $tag = factory(Tag::class)->create();

        $response = $this->DELETE('/api/v1/tags/' . $tag->id);

//        $this->assertNotContains('')
        $result = json_decode($response->getContent());
        $this->assertEquals('', $result);
//        $this->assertDatabaseMissing('tags', $tag);
        $this->assertNull(Tag::find($tag->id));
    }
    public function test_can_create_tag()
    {

        $user = factory(User::class)->create();
        $this->actingAs($user, "api");
        $tag = factory(Tag::class)->create();

        $response = $this->post('/api/v1/tags/',[
            'name' => 'Comprar pa'
        ]);

//        $this->assertNotContains('')
        $result = json_decode($response->getContent());


        $this->assertNotNull($tag = Tag::find($result->id));

        $this->assertEquals('Comprar pa', $result->name);

    }
    public function test_can_edit_a_tag()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, "api");
        //1
        $tag = Tag::create([
            'name' => 'Comprar lejia',
            'description' => 'Text aleatori',
            'color' => 'blue'
        ]);
        //2
        $response = $this->put('/api/v1/tags/' . $tag->id,$newTag = [
            'name' => 'Comprar pa',
            'description' => 'El pantano es de La Sénia, perque el pantano es troba a la pobla, que com tots sabem forma part de lo imperi senienc',
            'color' => 'red'
        ]);

        // 2 opcions
//        $this->assertDatabaseHas('tags',$newTag);
//        $this->assertDatabaseMissing('tags',$tag);

        $tag = $tag->fresh();
        $this->assertEquals($tag->name,'Comprar pa');
        $this->assertEquals($tag->description,'El pantano es de La Sénia, perque el pantano es troba a la pobla, que com tots sabem forma part de lo imperi senienc');
        $this->assertEquals($tag->color,'red');

    }

    public function test_can_browse_tags()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, "api");

        $tag1 = factory(Tag::class)->create();
        $tag2 = factory(Tag::class)->create();
        $tag3 = factory(Tag::class)->create();


        $this->post('/api/v1/tags/'.$tag1);
        $this->post('/api/v1/tags/'.$tag2);
        $this->post('/api/v1/tags/'.$tag3);

        $response = $this->get('/api/v1/tags');
        $response->assertSuccessful();

        $result = json_decode($response->getContent());

        $this->assertCount(3,$result);
        

    }

    public function test_cannot_create_tags_without_name()
    {

        $user = factory(User::class)->create();
        $this->actingAs($user, "api");
        // XHR -> JSON
        $response = $this->json('POST', '/api/v1/tags',[
            'name' => ''
        ]);


//        $this->withoutExceptionHandling();
//        $response = $this->post('/api/v1/tags/', [
//            'name' => ''
//            ])
        $response->assertStatus(422);



    }
    public function test_cannot_edit_tags_without_name()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, "api");
        //1
        $tag = Tag::create([
            'name' => 'Comprar lejia',
        ]);
        //2
        $response = $this->json('PUT','/api/v1/tags/' . $tag->id,$newTag = [
            'name' => '',
        ]);


//        $this->withoutExceptionHandling();
//        $response = $this->post('/api/v1/tags/', [
//            'name' => ''
//            ])
        $response->assertStatus(422);



    }

}