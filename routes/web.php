<?php

use Illuminate\Support\Facades\Route;

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


//pagina inicial na view/auth/login
Route::get('/', function () {
    return view('auth.login');
});

//HomeController.php fica em app/http/controllers

//'nome mascara da pagina' e 'controlador@nomeFunção' 

Route::get('/registro', 'HomeController@registro');  

Route::get('/logout1', 'HomeController@logout');

Route::post('/password/reset', 'Auth\ResetPasswordController@reset');

Auth::routes(['verify' => true]);

//rotas só para quem esta logado
Route::group(['middleware' => ['auth', 'verified']], function() {

    Route::get('/home', 'HomeController@home');

    Route::get('/pagina', 'HomeController@pagina'); 

    Route::get('/logout2', 'HomeController@logout');

    Route::get('/conta', 'UserController@index')->name('conta');

    Route::post('atualizar-perfil', 'UserController@update')->name('profile.update');

});