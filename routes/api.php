<?php

use App\Http\Controllers\Api\Changelog\ChangelogController;
use App\Http\Controllers\Api\GitController;
use App\Http\Controllers\Api\Newsletter\NewsletterController;
use App\Task;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth:api'])->group(function () {

    Route::get('/v1/tasks','Api\TasksController@index');            //BROWSE
    Route::get('/v1/tasks/refresh','Api\TasksController@refresh');            //BROWSE
    Route::get('/v1/tasks/{task}','Api\TasksController@show');      //READ
    Route::delete('/v1/tasks/{task}','Api\TasksController@destroy');//DELETE
    Route::post('/v1/tasks','Api\TasksController@store');           //CREATE
    Route::put('/v1/tasks/{task}','Api\TasksController@edit');      //EDIT
    //EDIT
    Route::post('/v1/completed_task/{task}','Api\CompletedTasksApiController@store');      //EDIT
    Route::delete('/v1/completed_task/{task}','Api\CompletedTasksApiController@destroy');      //EDIT

    Route::post('/newsletter', '\\' . NewsletterController::class . '@store');

    Route::get('/v1/tags','Api\TagsController@index');            //BROWSE
    Route::get('/v1/tags/{tag}','Api\TagsController@show');      //READ
    Route::delete('/v1/tags/{tag}','Api\TagsController@destroy');//DELETE
    Route::post('/v1/tags','Api\TagsController@store');           //CREATE
    Route::put('/v1/tags/{tag}','Api\TagsController@update');      //EDIT

Route::get('/v1/user/tasks','Api\LoggedUserTasksController@index');
Route::get('/v1/regular_users','Api\RegularUsersController@index');
Route::post('/v1/user/tasks','Api\LoggedUserTasksController@store');
Route::put('/v1/user/tasks/{task}','Api\LoggedUserTasksController@update');
Route::delete('/v1/user/tasks/{task}','Api\LoggedUserTasksController@destroy');

    Route::post('/v1/user/photo', 'PhotoController@store');
    Route::post('/v1/user/avatar', 'AvatarController@store');


    Route::post('/v1/task/{task}/tags/multiple','Api\TaskTagsController@addMultipleTags');
    Route::delete('/v1/task/{task}/tags/{tag}','Api\TaskTagsController@removeTag');


    Route::get('/v1/users/','Api\UsersController@index');
    Route::get('/v1/git/info','\\' . GitController::class . '@index');

    //Changelog
    Route::get('/v1/changelog','\\' . ChangelogController::class . '@index');
    Route::get('/v1/changelog/module/{module}','Api\Changelog\ChangelogModuleController@index');
    Route::get('/v1/changelog/user/{user}','Api\Changelog\ChangelogUserController@index');
    Route::get('/v1/changelog/loggable/{loggable}/{loggableId}','Api\Changelog\ChangelogLoggableController@index');

    // Notifications
    Route::get('/v1/notifications', 'Api\Notifications\NotificationsController@index');
    Route::post('/v1/notifications/multiple', 'Api\Notifications\NotificationsController@destroyMultiple');
    Route::delete('/v1/notifications/{notification}', 'Api\Notifications\NotificationsController@destroy');
    Route::get('/v1/user/notifications', 'Api\Notifications\UserNotificationsController@index');
    Route::get('/v1/user/unread_notifications', 'Api\Notifications\UserUnreadNotificationsController@index');
    Route::delete('/v1/user/unread_notifications/all', 'Api\Notifications\UserUnreadNotificationsController@destroyAll');
    Route::delete('/v1/user/unread_notifications/{notification}', 'Api\Notifications\UserUnreadNotificationsController@destroy');


    // Simple notifications
    Route::post('/v1/simple_notifications/', 'Api\Notifications\SimpleNotificationsController@store');


    Route::get('/v1/channel/{channel}/messages', 'Api\Chat\ChatMessagesController@index');
    Route::post('/v1/channel/{channel}/messages', 'Api\Chat\ChatMessagesController@store');
    Route::delete('/v1/channel/{channel}/messages/{message}', 'Api\Chat\ChatMessagesController@destroy');

    Route::post('v1/notifications/hello', 'Api\Notifications\HelloNotificationsController@store');


    // Push Subscriptions
    Route::put('/v1/subscriptions', 'PushSubscriptionController@update');
    Route::post('/v1/subscriptions/delete', 'PushSubscriptionController@destroy');

    Route::post('/v1/mobile/{user}/requestCode', 'Auth\VerifyPhoneController@requestCode');
    Route::post('/v1/mobile/{user}/verifyMail', 'Auth\UsersController@verifyMail');
    Route::post('/v1/mobile/{user}/verify', 'Auth\VerifyPhoneController@verify');
});

// Newsletter

Route::post('/v1/newsletter', 'Api\Newsletter\NewsletterController@store');
//
//Route::get('/v1/completed_task','Api\CompletedTasksController@index');            //BROWSE
//Route::get('/v1/completed_task/{task}','Api\CompletedTasksController@show');      //READ
//Route::delete('/v1/completed_task/{task}','Api\CompletedTasksController@destroy');//DELETE
//Route::post('/v1/completed_task','Api\CompletedTasksController@store');           //CREATE
//Route::put('/v1/completed_task/{task}','Api\CompletedTasksController@update');      //EDIT
//
