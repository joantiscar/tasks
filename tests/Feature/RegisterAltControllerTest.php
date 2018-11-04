<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterAltControllerTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_can_register_a_user()
    {
        $this->withoutExceptionHandling();
        $this->assertNull(Auth::user());
//        $response = $this->post('/register', []);
        $response = $this->post('/register_alt', $user = [
            'name' => 'astiooo',
            'email' => 'astiooo@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/home');
        $this->assertNotNull(User::where('email', 'astiooo@gmail.com')->first());
//        $usuaris = User::all();
//        $this->assertDatabaseHas('users', $usuari);
//        $this->assertEquals(Auth::user()->email, 'astiooo@gmail.com');



    }

    public function test_created_user_can_login()
    {
        $this->withoutExceptionHandling();
        $this->assertNull(Auth::user());
//        $response = $this->post('/register', []);
        $this->post('/register_alt', $user = [
            'name' => 'astiooo',
            'email' => 'astiooo@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);


        $response = $this->post('/login', [

            'email' => 'astiooo@gmail.com',
            'password' => '123456'
        ]);

        $response->assertRedirect('/home');
        $this->assertNotNull(Auth::user());
        $this->assertEquals('astiooo@gmail.com', Auth::user()->email);
    }
//    public function test_cannot_register_a_user_with_a_wrong_email()
//    {
//        $this->assertNull(Auth::user());
//
//        $response = $this->post('/register', [
//
//            'email' => 'astiooo',
//            'password' => 'astio'
//        ]);
//
//        $response->assertStatus(302);
//        $response->assertRedirect('/');
//        $this->assertNull(Auth::user());
//        }

//    public function test_cannot_register_a_user_with_a_wrong_password()
//    {
//
//        $this->assertNull(Auth::user());
//
//        $response = $this->post('/register', [
//
//            'email' => 'astiasdadadadao@gmail.com',
//            'password' => 'a',
//            'password_confirmation' => 'a'
//        ]);
//        $response->assertStatus(302);
//        $response->assertRedirect('/');
//        $this->assertNull(Auth::user());
//        self::assertEquals($response->exception->getMessage(), 'The given data was invalid.');
//
//    }
//    public function test_cannot_register_a_user_with_a_wrong_password_confirmation()
//    {
//
////        $this->withoutExceptionHandling();
//        $this->assertNull(Auth::user());
////        $response = $this->post('/register', []);
//        $response = $this->post('/register', [
//            'name' => 'astiooo',
//            'email' => 'astiooo@gmail.com',
//            'password' => '123456',
//            'password_confirmation' => '1'
//        ]);
//        $response->assertStatus(302);
//        $response->assertRedirect('/');
////        $this->assertNull(Auth::user());
////        $this->assertNotContains('astiooo@gmail.com', User::all());
//    }
}
