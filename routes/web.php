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