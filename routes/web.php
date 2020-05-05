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

Route::group(['middleware' => ['auth', 'verified', 'Altorizado']], function() {

    Route::get('/home', 'HomeController@home'); //middleware email verificado 

    Route::get('/adm', 'AdminController@admin')->middleware('admin');//middleware nivel adm

        Route::post('/alt', 'AdminController@alt')->middleware('admin');

        Route::post('/del', 'AdminController@del')->middleware('admin');

        Route::post('/alterar', 'AdminController@alterar')->middleware('admin');

    Route::get('/ava', 'AdminController@ava')->middleware('avaliador');//middleware nivel avaliador

    Route::get('/conta', 'UserController@index')->name('conta');

    Route::post('atualizar-perfil', 'UserController@update')->name('profile.update');

});

