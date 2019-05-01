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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('aeronaves', 'AeronaveController@index');
Route::get('aeronaves/create', 'AeronaveController@create');
Route::post('aeronaves', 'AeronaveController@store');
Route::get('aeronaves/{aeronave}/edit','AeronaveController@edit');
Route::get('utilizadores','UserController@index');
Route::get('utilizadores/{user}/edit','UserController@edit');
Route::put('/aeronaves/{aeronave}','AeronaveController@update');
Route::delete('/aeronaves/{aeronave}', 'AeronaveController@destroy');
Route::get('movimentos', 'MovimentoController@index');
Route::get('movimentos/{movimento}/edit', 'MovimentoController@edit');
Route::put('/movimento/{movimento}','MovimentoController@update');
