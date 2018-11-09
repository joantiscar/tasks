<?php

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


    Route::get('/v1/tags','Api\TagsController@index');            //BROWSE
    Route::get('/v1/tags/{tag}','Api\TagsController@show');      //READ
    Route::delete('/v1/tags/{tag}','Api\TagsController@destroy');//DELETE
    Route::post('/v1/tags','Api\TagsController@store');           //CREATE
    Route::put('/v1/tags/{tag}','Api\TagsController@update');      //EDIT
Route::get('/v1/tasks', function() {
        //Connectar base de dades, obtindre llista de tasques i pasarles a JSON

        return Task::all();

    });
Route::put('/v1/user/tasks','Api\LoggedUserTasksController@index');      //EDIT
});


//
//Route::get('/v1/completed_task','Api\CompletedTasksController@index');            //BROWSE
//Route::get('/v1/completed_task/{task}','Api\CompletedTasksController@show');      //READ
//Route::delete('/v1/completed_task/{task}','Api\CompletedTasksController@destroy');//DELETE
//Route::post('/v1/completed_task','Api\CompletedTasksController@store');           //CREATE
//Route::put('/v1/completed_task/{task}','Api\CompletedTasksController@update');      //EDIT
//
