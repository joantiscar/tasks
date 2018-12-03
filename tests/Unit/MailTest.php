<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Mail;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MailTest extends TestCase
{
    use RefreshDatabase, CanLogin;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_send_email()
    {
        $user = $this->login();

        Mail::to($user)->send(new TestEmail());
    }
}
