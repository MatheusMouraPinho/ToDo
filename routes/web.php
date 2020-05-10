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

Auth::routes(['verify' => true]);

Route::get('/registro', 'HomeController@registro');  

Route::post('/password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/logout', 'HomeController@logout')->middleware('auth');

Route::group(['middleware' => ['auth', 'verified', 'Altorizado']], function() { //grupo middleware

    Route::get('/home', 'HomeController@home');

    Route::get('/ava', 'AdminController@ava')->middleware('avaliador');//middleware nivel avaliador

    Route::get('/conta', 'UserController@index')->name('conta');

    Route::post('atualizar-perfil', 'UserController@update')->name('profile.update');

});

Route::group(['middleware' => ['auth', 'verified', 'Altorizado', 'admin']], function() {

    Route::get('/adm', 'AdminController@admin');
        Route::post('/alt', 'AdminController@alt');
        Route::post('/del', 'AdminController@del');

    Route::get('/adm2', 'AdminController@admin2');
        Route::post('/alterar', 'AdminController@alterar');

    Route::get('/adm3', 'AdminController@admin3');
        Route::post('/rem_den', 'AdminController@rem_den');
        Route::post('/barrar', 'AdminController@barrar');
        Route::post('/del_post', 'AdminController@del_post');

});

