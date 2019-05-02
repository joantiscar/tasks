<?php

namespace Tests\Feature\Tenants\Api\Notifications;

use App\User;
use App\Notifications\LogCreatedPushNotification;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Notification;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;

/**
 * Class HelloNotificationControllerTest.
 *
 * @package Tests\Feature
 */
class HelloNotificationControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;


    /**
     * @test
     * @group notifications
     */
    public function user_can_send_hello_notification_to_himself()
    {
        $user = $this->loginAsSuperAdmin('api');

        Notification::fake();

        $response = $this->json('POST','/api/v1/notifications/hello');
        $response->assertSuccessful();

        Notification::assertSentTo($user,LogCreatedPushNotification::class);
    }

    /**
     * @test
     * @group notifications
     */
    public function guest_user_can_send_hello_notification_to_himself()
    {
        Notification::fake();
        $response = $this->json('POST','/api/v1/notifications/hello');
        $response->assertStatus(401);
        Notification::assertNothingSent();
    }

}
