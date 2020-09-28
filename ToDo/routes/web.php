<?php

use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/mobile', 'Controller@mobile'); 

Route::post('/password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/logout', 'HomeController@logout')->middleware('auth');

Route::group(['middleware' => ['auth', 'verified', 'Altorizado']], function() { //grupo middleware

    Route::get('/home', 'HomeController@home');
        Route::post('/filtro', 'HomeController@filtro');
        Route::post('/filtro2', 'HomeController@filtro2');
        Route::get('/reset', 'HomeController@reset');
        Route::post('/pesquisa', 'HomeController@pesquisa');
        Route::get('/reset_search', 'HomeController@reset_search');
        Route::post('/apagar_post', 'HomeController@apagar_post');
        Route::post('/denunciar_post', 'HomeController@denunciar_post');
        //Route::post('/like_post', 'HomeController@like_post');
        Route::post('/remov_like_post', 'HomeController@remov_like_post');
        Route::post('/like_post2', 'HomeController@like_post2');

    Route::post('/denunciar_comentario', 'HomeController@denunciar_comentario');

    Route::post('/cria', 'HomeController@cria');

    Route::get('/conta', 'UserController@index')->name('conta');

    Route::post('atualizar-perfil', 'UserController@update')->name('profile.update');

    Route::post('/comentario', 'ComentController@create')->name('comentario');

    Route::post('/resposta', 'ComentController@store')->name('resposta');

    Route::post('/editar-comentario', 'ComentController@update')->name('edit.coment');

    Route::post('deletar-comentario', 'ComentController@destroy')->name('apagar-coment');

    Route::GET('/perfil', 'UserController@perfil')->name('perfil');

    Route::post('/denunciar', 'AdminController@denunciar')->name('denunciar');

    Route::post('/like', 'ComentController@like')->name('like');

    Route::post('/ordenar', 'ComentController@ordenar')->name('ordenar');

    Route::post('/avaliar_aval', 'AdminController@avaliar')->middleware('avaliador');

    Route::get('/remove_capa', 'UserController@destroy_capa')->name('remove_capa');

    Route::get('/remove_perfil', 'UserController@destroy_perfil')->name('remove_perfil');

});

Route::group(['middleware' => ['auth', 'verified', 'Altorizado', 'admin']], function() {

    Route::get('/adm', 'AdminController@admin');
        Route::post('/alt', 'AdminController@altorizar');
        Route::post('/del', 'AdminController@recusar');

    Route::get('/adm2', 'AdminController@admin2');
        Route::post('/alterar', 'AdminController@alterar');
        Route::post('/pesquisa_user', 'AdminController@pesquisa');
        Route::post('/del_usu', 'AdminController@del_usu');
        Route::get('/reset_search2', 'AdminController@reset_search');

    Route::get('/adm3', 'AdminController@admin3');
        Route::post('/option', 'AdminController@option');
    
    Route::get('/adm4', 'AdminController@admin4');
        Route::post('/option2', 'AdminController@option2');

    Route::post('/avaliar', 'AdminController@avaliar');
    
});

