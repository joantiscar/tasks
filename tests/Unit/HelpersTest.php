<?php

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class HelpersTest extends TestCase{


    use RefreshDatabase;

    public function test_create_primary_user()
    {
        //1
        //2
        create_primary_user();
        //3
        $user = User::where('email','joantiscar@iesebre.com')->first();
        $this->assertEquals($user->name, 'Joan Tíscar Verdiell');
        $this->assertEquals($user->email, 'joantiscar@iesebre.com');
        $this->assertTrue(Hash::check(env('PRIMARY_USER_PASSWORD', '123456'), $user->password));
    }



}