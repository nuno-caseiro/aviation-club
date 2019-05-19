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
})->name('welcome');



Route::get('/home', 'HomeController@index')->middleware('auth')->name('home');
//aeronaves
Route::get('/aeronaves', 'AeronaveController@index');//->middleware('auth'); //vê se está autenticado
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

Route::middleware('verified')->group(function () {
    Route::get('socios', 'UserController@index') ->name("socios.index");
    Route::get('socios/{socio}/edit', 'UserController@edit')->name("socios.edit");
    Route::get('socios/create', 'UserController@create')->name('socios.create');
    Route::post('socios', 'UserController@store')->name('socios.store');
    Route::put('socios/{socio}', 'UserController@update')->name('socios.update');
    Route::delete('socios/{socio}', 'UserController@destroy')->name('socios.delete');

});




Route::get('/password', 'UserController@showEditPassword')->name('showEditPassword');
Route::patch('/password', 'UserController@editPassword')->name('editPassword');

//Route::get('pilotos/{piloto}/certificado','');
//Route::get('pilotos/{piloto}/certificado','');


Route::get('/home', 'HomeController@index')->name('home');

Auth::routes(['verify' => true]);


// Authentication Routes... -- penso q o auth faz isto tudo internamente
//$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
//$this->post('login', 'Auth\LoginController@login');
//$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
//$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
//$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
//$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
//$this->post('password/reset', 'Auth\ResetPasswordController@reset');






