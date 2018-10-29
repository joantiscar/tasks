<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_can_login_a_user()
    {
        $user = factory(User::class)->create([
            'email' => 'astio@gmail.com'
        ]);

        $this->assertNull(Auth::user());

        $response = $this->post('/login', [

            'email' => 'astio@gmail.com',
            'password' => 'secret'
        ]);

        $response->assertRedirect('/home');
        $this->assertNotNull(Auth::user());
        $this->assertEquals('astio@gmail.com', Auth::user()->email);

    }
    public function test_cannot_login_a_user_with_a_wrong_password()
    {
        $user = factory(User::class)->create([
            'email' => 'astio@gmail.com'
        ]);

        $this->assertNull(Auth::user());

        $response = $this->post('/login', [

            'email' => 'astio@gmail.com',
            'password' => 'astio'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');
        $this->assertNull(Auth::user());

    }
    public function test_cannot_login_a_user_with_a_wrong_email()
    {
        $user = factory(User::class)->create([
            'email' => 'astio@gmail.com'
        ]);

        $this->assertNull(Auth::user());

        $response = $this->post('/login', [

            'email' => 'astiasdadadadao@gmail.com',
            'password' => 'secret'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');
        $this->assertNull(Auth::user());

    }
}
