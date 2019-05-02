<?php

namespace App\Http\Controllers\Api\Notifications;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notifications\HelloNotificationStore;
use App\Notifications\LogCreatedPushNotification;

/**
 * Class HelloNotificationsController.
 *
 * @package App\Http\Controllers\Tenant\Api\Changelog
 */
class HelloNotificationsController extends Controller
{
    /**
     * Index.
     *
     * @param HelloNotificationStore $request
     * @return mixed
     */
    public function store(HelloNotificationStore $request)
    {
        $request->user()->notify(new LogCreatedPushNotification);

        return response()->json('Notification sent.', 201);
    }


}
