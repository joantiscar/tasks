<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\ChangelogController;

Auth::routes( ['verify' => true]);
Route::post('/login_alt','Auth\LoginAltController@login');
Route::post('/register_alt','Auth\RegisterAltController@register');



Route::get('/', function () {
    return view('welcome');
});

//Route::get('/prova','ProvaController@show');
Route::get('/prova',function(){
    $prova ='aidfnaofnaofafa';
    dd($prova);
});
Route::get('/prova_cua', function () {
    App\Jobs\SleepJob::dispatch();
});

// Middleware

//GRUP DE URLS PER USUARIS AUTENTICATS

Route::middleware((['auth', 'verified']))->group(function () {

    Route::post('/photo', 'PhotoController@store');
    Route::post('/avatar', 'AvatarController@store');
    Route::delete('/tasks/{id}', 'TasksController@delete');
    Route::get('/tasks','TasksController@index');
    Route::post('/tasks','TasksController@store');
    Route::put('/tasks/{id}', 'TasksController@update');
    Route::get('/tasks_edit/{id}','TasksController@edit');
    Route::patch('/tasks/{id}','TasksController@completar');
    Route::get('/home','TasquesController@index');
    Route::get('/tasks_vue', 'TasksVueController@index');
    Route::get('/clock', 'ClockController@index');
    Route::get('/multimedia', 'MultimediaController@index');
    Route::get('/tasques', 'TasquesController@index');
    Route::get('/tasques/{id}', 'TasquesController@show');
    Route::get('/tags', 'TagsController@index');
    Route::get('/profile', 'ProfileController@show');
    Route::delete('/completed_task/{task}','CompletedTasksController@destroy');//DELETE
    Route::post('/completed_task/{task}','CompletedTasksController@store');           //CREATE
    Route::get('/user/tasks','LoggedUserTasksController@index');
    Route::get('/user/photo', 'LoggedUserPhotoController@show');
    Route::get('/user/avatar', 'LoggedUserAvatarController@show');
    Route::get('/notifications', 'NotificationController@index');
    Route::get('/mobile', 'MobileController@index');
    Route::get('/chat', 'ChatController@index');
    Route::get('/users', 'UsersController@index');
    Route::get('/gamepad', 'GamepadController@index');
    Route::get('/changelog','\\'. ChangelogController::class . '@index');
    Route::get('/verificar_mobil','\\' . \App\Http\Controllers\PhoneVerificationController::class . '@index');

    Route::impersonate();

});

    
Route::view('about','about');
Route::view('contact','contact');

Route::view('about','about');



