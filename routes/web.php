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

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
//aeronaves
Route::get('aeronaves', 'AeronaveController@index');//->middleware('auth'); //vê se está autenticado
Route::get('aeronaves/create', 'AeronaveController@create');
Route::post('aeronaves', 'AeronaveController@store');
Route::get('aeronaves/{aeronave}/edit','AeronaveController@edit');
Route::put('/aeronaves/{aeronave}','AeronaveController@update');
Route::delete('/aeronaves/{aeronave}', 'AeronaveController@destroy');
Route::get('/aeronaves/{aeronave}/pilotos', 'AeronaveController@pilotosAutorizados');
Route::post('/aeronaves/{aeronave}/pilotos/{piloto}', 'AeronaveController@addPilotoAutorizado');
Route::delete('/aeronaves/{aeronave}/pilotos/{piloto}', 'AeronaveController@removePilotoAutorizado');
Route::get('/aeronaves/{aeronave}/precos_tempos', 'AeronaveController@precosTempos');



//movimentos
Route::get('movimentos', 'MovimentoController@index');
Route::get('movimentos/{movimento}/edit', 'MovimentoController@edit');
Route::put('movimentos/{movimento}', 'MovimentoController@update');
Route::delete('/movimentos/{movimento}', 'MovimentoController@destroy');
Route::get('/movimentos/create', 'MovimentoController@create');
Route::post('/movimentos', 'MovimentoController@store');




//socios
Route::get('socios','UserController@index');
Route::get('socios/{socio}/edit','UserController@edit');
Route::get('socios/create','UserController@create');
Route::post('socios','UserController@store');
Route::put('socios/{socio}','UserController@update');
Route::delete('socios/{socio}','UserController@destroy');







