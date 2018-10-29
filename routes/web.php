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
Auth::routes();
Route::post('/login_alt','Auth\LoginAltController@login');



Route::get('/', function () {
    return view('welcome');
});

//Route::get('/prova','ProvaController@show');
Route::get('/prova',function(){
    $prova ='aidfnaofnaofafa';
    dd($prova);
});

Route::delete('/tasks/{id}', 'TasksController@delete');
Route::get('/tasks','TasksController@index');
Route::post('/tasks','TasksController@store');
Route::put('/tasks/{id}', 'TasksController@update');

Route::view('about','about');
Route::view('contact','contact');

Route::view('about','about');
Route::get('/tasks_edit/{id}','TasksController@edit');
Route::patch('/tasks/{id}','TasksController@completar');

Route::get('/tasks_vue', 'TasksVueController@index');
Route::delete('/completed_task/{task}','CompletedTasksController@destroy');//DELETE
Route::post('/completed_task','CompletedTasksController@store');           //CREATE
// Index -> LIST
// store -> create
// delete -> destroy
// edit -> PUT