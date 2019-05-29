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
/*
Route::get('/', function () {
    return view('home');
})->middleware('verified')->name('welcome');*/

Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->middleware('verified')->name('home');
//aeronaves
Route::get('/aeronaves', 'AeronaveController@index')->name('aeronaves.index');//->middleware('auth'); //vê se está autenticado
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
Route::get('movimentos', 'MovimentoController@index')->name("movimentos.index");
Route::get('movimentos/{movimento}/edit', 'MovimentoController@edit');
Route::put('movimentos/{movimento}', 'MovimentoController@update');
Route::delete('/movimentos/{movimento}', 'MovimentoController@destroy');
Route::get('/movimentos/create','MovimentoController@create');
Route::post('/movimentos', 'MovimentoController@store');
Route::get('/movimentos/estatisticas','MovimentoController@estatisticas');




//socios

Route::middleware('verified')->group(function () {
    Route::get('socios', 'UserController@index') ->name("socios.index");
    Route::get('socios/{socio}/edit', 'UserController@edit')->name("socios.edit");
    Route::get('socios/create', 'UserController@create')->name('socios.create');
    Route::post('socios', 'UserController@store')->name('socios.store');
    Route::put('socios/{socio}', 'UserController@update')->name('socios.update');
    Route::delete('socios/{socio}', 'UserController@destroy')->name('socios.delete');
    Route::patch('socios/{socio}/ativo','UserController@ativarDesativar')->name('socios.ativar');
    Route::patch('socios/{socio}/quota','UserController@quotaPaga')->name('socios.quota');
    Route::patch('/socios/reset_quotas', 'UserController@resetQuotas')->name('socios.resetQuota');
    Route::patch('/socios/desativar_sem_quotas', 'UserController@resetAtivosSemQuota')->name('socios.resetAtivosSemQuota');
    Route::post('socios/{socio}/send_reactivate_mail','UserController@sendReactivateEmail')->name('socios.sendEmail');

});




Route::get('/password', 'UserController@showEditPassword')->name('showEditPassword');
Route::patch('/password', 'UserController@editPassword')->name('editPassword');

Route::get('pilotos/{piloto}/certificado','UserController@certificado')->name('certificado');
Route::get('pilotos/{piloto}/licenca','UserController@licenca')->name('licenca');

Route::get('pilotos/{piloto}/licenca_pdf','UserController@licenca_pdf')->name('licenca_pdf');
Route::get('pilotos/{piloto}/certificado_pdf','UserController@certificado_pdf')->name('certificado_pdf');









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






