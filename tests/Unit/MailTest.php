<?php

namespace Tests\Unit;

use App\Mail\TestDinamicEmail;
use App\Mail\TestEmail;
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
        $this->assertTrue(true);
    }

    public function test_markdown_send_email_dinamic()
    {
        $user = $this->login();

        Mail::to($user)->send(new TestDinamicEmail($user));
        $this->assertTrue(true);
    }
}
