<?php

use App\Http\Controllers\Api\Changelog\ChangelogController;
use App\Http\Controllers\Api\GitController;
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
    Route::get('/v1/tasks/{task}','Api\TasksController@show');      //READ
    Route::delete('/v1/tasks/{task}','Api\TasksController@destroy');//DELETE
    Route::post('/v1/tasks','Api\TasksController@store');           //CREATE
    Route::put('/v1/tasks/{task}','Api\TasksController@edit');      //EDIT
    //EDIT
    Route::post('/v1/completed_task/{task}','Api\CompletedTasksApiController@store');      //EDIT
    Route::delete('/v1/completed_task/{task}','Api\CompletedTasksApiController@destroy');      //EDIT


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


    Route::post('/v1/task/{task}/tags/multiple','Api\TaskTagsController@addMultipleTags');
    Route::delete('/v1/task/{task}/tags/{tag}','Api\TaskTagsController@removeTag');


    Route::get('/v1/users/','Api\UsersController@index');
    Route::get('/v1/git/info','\\' . GitController::class . '@index');

    //Changelog
    Route::get('/v1/changelog','\\' . ChangelogController::class . '@index');
    Route::get('/v1/changelog/module/{module}','Api\Changelog\ChangelogModuleController@index');
    Route::get('/v1/changelog/user/{user}','Api\Changelog\ChangelogUserController@index');
    Route::get('/v1/changelog/loggable/{loggable}/{loggableId}','Api\Changelog\ChangelogLoggableController@index');



});


//
//Route::get('/v1/completed_task','Api\CompletedTasksController@index');            //BROWSE
//Route::get('/v1/completed_task/{task}','Api\CompletedTasksController@show');      //READ
//Route::delete('/v1/completed_task/{task}','Api\CompletedTasksController@destroy');//DELETE
//Route::post('/v1/completed_task','Api\CompletedTasksController@store');           //CREATE
//Route::put('/v1/completed_task/{task}','Api\CompletedTasksController@update');      //EDIT
//
