<?php
/**
 * Created by PhpStorm.
 * User: dios
 * Date: 20/11/18
 * Time: 20:01
 */

namespace Tests\Feature\Api;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;

    public function test_can_retrieve_users_list()
    {
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
        $this->actingAs($user1, 'api');
        $users = [$user1,$user2,$user3];

        $response = $this->json('GET', '/api/v1/users');
        $response->assertSuccessful();
        $result = json_decode($response->getContent());
        $this->assertEquals($result[0]->name, 'Pepe');
        $this->assertEquals($result[0]->id, 1);
        $this->assertEquals($result[0]->email, 'pepe@gmail.com');
        $this->assertEquals($result[0]->avatar, 'https://www.gravatar.com/avatar/' . md5('pepe@gmail.com'));
        $this->assertEquals($result[1]->name, 'Pepa');
        $this->assertEquals($result[1]->id, 2);
        $this->assertEquals($result[1]->email, 'pepa@gmail.com');
        $this->assertEquals($result[1]->avatar, 'https://www.gravatar.com/avatar/' . md5('pepa@gmail.com'));
        $this->assertEquals($result[2]->name, 'Pipo');
        $this->assertEquals($result[2]->id, 3);
        $this->assertEquals($result[2]->email, 'pipo@gmail.com');
        $this->assertEquals($result[2]->avatar, 'https://www.gravatar.com/avatar/' . md5('pipo@gmail.com'));


    }
}