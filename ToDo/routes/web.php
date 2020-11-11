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

Route::get('/IE', 'Controller@IE');

Route::post('/password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/logout', 'HomeController@logout')->middleware('auth');

Route::group(['middleware' => ['auth', 'verified']], function() { //grupo middleware

    Route::get('/home', 'HomeController@home');
        Route::post('/filtro', 'HomeController@filtro');
        Route::post('/filtro2', 'HomeController@filtro2');
        Route::get('/reset', 'HomeController@reset');
        Route::post('/pesquisa', 'HomeController@pesquisa');
        Route::get('/reset_search', 'HomeController@reset_search');
        Route::post('/apagar_post', 'HomeController@apagar_post');
        Route::post('/denunciar_post', 'HomeController@denunciar_post');
        Route::post('/like_post', 'HomeController@like_post');

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

    Route::post('/mostrar_coments', 'ComentController@MostrarComents');

    Route::post('/buscar_cidades', 'UserController@buscar_cidades');

    Route::get('/sobre', 'HomeController@sobre');

    Route::post('/solicitacao', 'UserController@solicitacao');

    Route::post('/ordenar_post', 'UserController@order_post')->name('order_post');

    Route::post('/ordenar_solicitacao', 'UserController@order_solicitacao')->name('order_solicit');

    Route::get('/notificacoes', 'HomeController@notificacoes');

    Route::post('/remov_notificacoes', 'HomeController@remov_notificacoes');

    Route::get('/wipe_recentes', 'HomeController@wipe_recentes');

});

Route::group(['middleware' => ['auth', 'verified', 'admin']], function() {

    Route::get('/admin/historico', 'AdminController@admin');
        Route::post('/alt', 'AdminController@altorizar');
        Route::post('/del', 'AdminController@recusar');

    Route::get('/admin/usuarios', 'AdminController@admin2');
        Route::post('/alterar', 'AdminController@alterar');
        Route::post('/pesquisa_user', 'AdminController@pesquisa');
        Route::post('/del_usu', 'AdminController@del_usu');
        Route::get('/reset_search2', 'AdminController@reset_search');

    Route::get('/admin/denuncias/postagem', 'AdminController@admin3');
        Route::post('/option', 'AdminController@option');
    
    Route::get('/admin/denuncias/comentario', 'AdminController@admin4');
        Route::post('/option2', 'AdminController@option2');

    Route::get('/admin/denuncias', 'AdminController@admin5');

    Route::get('/admin/solicitacoes', 'AdminController@admin6');
        Route::post('/option3', 'AdminController@option3');

    Route::get('/admin/bloqueados', 'AdminController@admin7');
        Route::post('/option4', 'AdminController@option4');

    Route::post('/avaliar', 'AdminController@avaliar');
    
});

