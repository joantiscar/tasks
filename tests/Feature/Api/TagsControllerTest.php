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

    public function test_can_superAdmin_show_a_tag()
    {
        $user = $this->login('api');
        $user->admin = true;
        $user->save();
        $tag = factory(Tag::class)->create();

        $this->withoutExceptionHandling();

        $response = $this->get('/api/v1/tags/' . $tag->id);

        $result = json_decode($response->getContent());

        $response->assertSuccessful();
        $this->assertEquals($tag->name, $result->name);
    }

    public function test_can_manager_show_a_tag()
    {
        initialize_roles();
        $this->withoutExceptionHandling();
        $user = $this->loginAsTagManager('api');
        $tag = factory(Tag::class)->create();

        $response = $this->get('/api/v1/tags/' . $tag->id);

        $result = json_decode($response->getContent());

        $response->assertSuccessful();
        $this->assertEquals($tag->name, $result->name);
    }

    public function test_regular_user_cannot_show_a_tag()
    {
        $user = $this->login('api');
        $tag = factory(Tag::class)->create();
        $response = $this->get('/api/v1/tags/' . $tag->id);
        $response->assertStatus(403);
    }

    public function test_superUser_can_delete_tag()
    {
        $user = $this->login('api');
        $user->admin = true;
        $user->save();
        $tag = factory(Tag::class)->create();

        $response = $this->DELETE('/api/v1/tags/' . $tag->id);

        //        $this->assertNotContains('')
        $result = json_decode($response->getContent());
        $this->assertEquals('', $result);
        //        $this->assertDatabaseMissing('tags', $tag);
        $this->assertNull(Tag::find($tag->id));
    }

    public function test_manager_can_delete_tag()
    {
        initialize_roles();
        $user = $this->login('api');
        $tag = factory(Tag::class)->create();

        $response = $this->DELETE('/api/v1/tags/' . $tag->id);

        //        $this->assertNotContains('')
        $result = json_decode($response->getContent());
        $this->assertEquals('', $result);
        //        $this->assertDatabaseMissing('tags', $tag);
        $this->assertNull(Tag::find($tag->id));
    }

    public function test_regular_user_cannot_delete_tag()
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

    public function test_superAdmin_can_create_tag()
    {

        $user = $this->login('api');
        $user->admin = true;
        $user->save();
        $tag = factory(Tag::class)->create();

        $response = $this->post('/api/v1/tags/', [
          'name' => 'Comprar pa',
        ]);

        //        $this->assertNotContains('')
        $result = json_decode($response->getContent());

        $this->assertNotNull($tag = Tag::find($result->id));

        $this->assertEquals('Comprar pa', $result->name);
    }

    public function test_manager_can_create_tag()
    {

        initialize_roles();
        $user = $this->login('api');
        $tag = factory(Tag::class)->create();

        $response = $this->post('/api/v1/tags/', [
          'name' => 'Comprar pa',
        ]);

        //        $this->assertNotContains('')
        $result = json_decode($response->getContent());

        $this->assertNotNull($tag = Tag::find($result->id));

        $this->assertEquals('Comprar pa', $result->name);
    }

    public function test_regular_user_cannot_create_tag()
    {

        $user = factory(User::class)->create();
        $this->actingAs($user, "api");
        $tag = factory(Tag::class)->create();

        $response = $this->post('/api/v1/tags/', [
          'name' => 'Comprar pa',
        ]);

        //        $this->assertNotContains('')
        $result = json_decode($response->getContent());

        $this->assertNotNull($tag = Tag::find($result->id));

        $this->assertEquals('Comprar pa', $result->name);
    }

    public function test_superUser_can_edit_a_tag()
    {
        $user = $this->login('api');
        $user->admin = true;
        $user->save();
        //1
        $tag = Tag::create([
          'name'        => 'Comprar lejia',
          'description' => 'Text aleatori',
          'color'       => 'blue',
        ]);
        //2
        $response = $this->put('/api/v1/tags/' . $tag->id, $newTag = [
          'name'        => 'Comprar pa',
          'description' => 'El pantano es de La Sénia, perque el pantano es troba a la pobla, que com tots sabem forma part de lo imperi senienc',
          'color'       => 'red',
        ]);

        $tag = $tag->fresh();
        $this->assertEquals($tag->name, 'Comprar pa');
        $this->assertEquals($tag->description,
          'El pantano es de La Sénia, perque el pantano es troba a la pobla, que com tots sabem forma part de lo imperi senienc');
        $this->assertEquals($tag->color, 'red');
    }

    public function test_manager_can_edit_a_tag()
    {
        initialize_roles();
        $user = $this->login('api');
        //1
        $tag = Tag::create([
          'name'        => 'Comprar lejia',
          'description' => 'Text aleatori',
          'color'       => 'blue',
        ]);
        //2
        $response = $this->put('/api/v1/tags/' . $tag->id, $newTag = [
          'name'        => 'Comprar pa',
          'description' => 'El pantano es de La Sénia, perque el pantano es troba a la pobla, que com tots sabem forma part de lo imperi senienc',
          'color'       => 'red',
        ]);

        $tag = $tag->fresh();
        $this->assertEquals($tag->name, 'Comprar pa');
        $this->assertEquals($tag->description,
          'El pantano es de La Sénia, perque el pantano es troba a la pobla, que com tots sabem forma part de lo imperi senienc');
        $this->assertEquals($tag->color, 'red');
    }

    public function test_regular_user_cannot_edit_a_tag()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, "api");
        //1
        $tag = Tag::create([
          'name'        => 'Comprar lejia',
          'description' => 'Text aleatori',
          'color'       => 'blue',
        ]);
        //2
        $response = $this->put('/api/v1/tags/' . $tag->id, $newTag = [
          'name'        => 'Comprar pa',
          'description' => 'El pantano es de La Sénia, perque el pantano es troba a la pobla, que com tots sabem forma part de lo imperi senienc',
          'color'       => 'red',
        ]);

        $tag = $tag->fresh();
        $this->assertEquals($tag->name, 'Comprar pa');
        $this->assertEquals($tag->description,
          'El pantano es de La Sénia, perque el pantano es troba a la pobla, que com tots sabem forma part de lo imperi senienc');
        $this->assertEquals($tag->color, 'red');
    }

    public function test_superAdmin_can_browse_tags()
    {
        $user = $this->login('api');
        $user->admin = true;
        $user->save();

        $tag1 = factory(Tag::class)->create();
        $tag2 = factory(Tag::class)->create();
        $tag3 = factory(Tag::class)->create();

        $this->post('/api/v1/tags/' . $tag1);
        $this->post('/api/v1/tags/' . $tag2);
        $this->post('/api/v1/tags/' . $tag3);

        $response = $this->get('/api/v1/tags');
        $response->assertSuccessful();

        $result = json_decode($response->getContent());

        $this->assertCount(3, $result);
    }

    public function test_manager_can_browse_tags()
    {
        initialize_roles();
        $user = $this->loginAsTagManager('api');

        $tag1 = factory(Tag::class)->create();
        $tag2 = factory(Tag::class)->create();
        $tag3 = factory(Tag::class)->create();

        $this->post('/api/v1/tags/' . $tag1);
        $this->post('/api/v1/tags/' . $tag2);
        $this->post('/api/v1/tags/' . $tag3);

        $response = $this->get('/api/v1/tags');
        $response->assertSuccessful();

        $result = json_decode($response->getContent());

        $this->assertCount(3, $result);
    }

    public function test_regular_user_cannot_browse_tags()
    {
        $user = $this->loginAsTagManager('api');

        $tag1 = factory(Tag::class)->create();
        $tag2 = factory(Tag::class)->create();
        $tag3 = factory(Tag::class)->create();

        $this->post('/api/v1/tags/' . $tag1);
        $this->post('/api/v1/tags/' . $tag2);
        $this->post('/api/v1/tags/' . $tag3);

        $response = $this->get('/api/v1/tags');
        $response->assertSuccessful();

        $result = json_decode($response->getContent());

        $this->assertCount(3, $result);
    }

    public function test_cannot_create_tags_without_name()
    {

        $user = $this->login('api');
        $user->admin = true;
        $user->save();
        // XHR -> JSON
        $response = $this->json('POST', '/api/v1/tags', [
          'name' => '',
        ]);

        //        $this->withoutExceptionHandling();
        //        $response = $this->post('/api/v1/tags/', [
        //            'name' => ''
        //            ])
        $response->assertStatus(422);
    }

    public function test_cannot_edit_tags_without_name()
    {
        $user = $this->login('api');
        $user->admin = true;
        $user->save();
        //1
        $tag = Tag::create([
          'name' => 'Comprar lejia',
        ]);
        //2
        $response = $this->json('PUT', '/api/v1/tags/' . $tag->id, $newTag = [
          'name' => '',
        ]);

        //        $this->withoutExceptionHandling();
        //        $response = $this->post('/api/v1/tags/', [
        //            'name' => ''
        //            ])
        $response->assertStatus(422);
    }
}
