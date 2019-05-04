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
//aeronaves
Route::get('aeronaves', 'AeronaveController@index');
Route::get('aeronaves/create', 'AeronaveController@create');
Route::post('aeronaves', 'AeronaveController@store');
Route::get('aeronaves/{aeronave}/edit','AeronaveController@edit');
Route::put('/aeronaves/{aeronave}','AeronaveController@update');
Route::delete('/aeronaves/{aeronave}', 'AeronaveController@destroy');

//utilizadores
Route::get('utilizadores/create','UserController@create');
Route::post('utilizadores','UserController@store');
Route::put('utilizadores/{utilizador}','UserController@update');
Route::delete('utilizadores{utilizador}','UserController@delete');
Route::get('utilizadores','UserController@index');
Route::get('utilizadores/{utilizador}/edit','UserController@edit');


//movimentos
Route::get('movimentos', 'MovimentoController@index');
Route::get('movimentos/{movimento}/edit', 'MovimentoController@edit');
Route::put('movimentos/{movimento}', 'MovimentoController@update');
Route::delete('/movimentos/{movimento}', 'MovimentoController@destroy');
Route::get('/movimentos/create', 'MovimentoController@create');
Route::post('/movimentos', 'MovimentoController@store');