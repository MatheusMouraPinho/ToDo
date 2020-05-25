<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function registro() //nome função do web.php
    {
        return view('auth.register'); //retorna da pasta view ('pasta.arquivo');
    }

    public function logout()
    {   session_start();
        session_destroy();
        Auth::logout();
        return redirect('/');
    }
      
    public function home()
    {
        $post = [ 
            'avaliador' => DB::table('postagens')
                            ->join('avaliacao_postagem', 'postagens.id_postagem', '=', 'avaliacao_postagem.id_postagem')
                            ->join('usuarios', 'usuarios.id', '=', 'avaliacao_postagem.id_avaliador')
                            ->select('usuarios.usuario')
                            ->get(),
            
            'avaliacao' => DB::table('postagens')
                            ->join('avaliacao_postagem', 'postagens.id_postagem', '=', 'avaliacao_postagem.id_postagem')
                            ->select('avaliacao_postagem.*', 'postagens.id_usuarios', 'postagens.id_postagem')
                            ->get(),
            
            'comentarios' => DB::table('comentarios')
                                ->join('postagens', 'postagens.id_postagem', '=', 'comentarios.id_postagem')
                                ->join('usuarios', 'comentarios.id_usuarios', '=', 'usuarios.id')
                                ->select('comentarios.*', 'postagens.id_usuarios', 'postagens.id_postagem', 'usuarios.*')
                                ->orderBy('data_comentarios', 'desc')
                                ->get(),

            'reply_coment' => DB::table('subcomentarios')
                                ->join('postagens', 'postagens.id_postagem', '=', 'subcomentarios.id_postagem')
                                ->where('subcomentarios.id_resposta', '=', null)
                                ->join('usuarios', 'subcomentarios.id_usuarios', '=', 'usuarios.id')
                                ->select('subcomentarios.*', 'postagens.id_usuarios', 'postagens.id_postagem', 'usuarios.*')
                                ->orderBy('data_comentarios', 'desc')
                                ->get(),

            'reply_reply' => DB::table('subcomentarios')
                            ->where('id_resposta', '!=', null)
                            ->orderBy('data_comentarios', 'desc')
                            ->get()
        ];

        return view('home', compact('post')); 
    }

    public function pesquisa()
    {   
        if(isset($_POST['pesquisa'])){
            $pesquisa = $_POST['pesquisa'];
            return redirect('home')->with(['pesquisa' =>  $pesquisa]);
        }
    }


    public function filtro()
    {
        if(isset($_POST['filtro'])){
            $var = $_POST['filtro'];
            if($var == "popu"){
                $filtro = "likes_postagem"; 
            }elseif($var == "melh"){
                $filtro = "media";
            }else{
                $filtro = "data_postagem";
            }
            return redirect('home')->with(['filtro' =>  $filtro]);
        }
        
        if(isset($_POST['tipo'])){
            $var2 = $_POST['tipo'];
            if($var2 == "1"){
                $tipo = "1"; 
            }elseif($var2 == "2"){
                $tipo = "2";
            }else{
                $tipo = "1 OR 2";
            }
            return redirect('home')->with(['tipo' =>  $tipo]);
        }

        if(isset($_POST['periodo'])){
            $var3 = $_POST['periodo'];
            if($var3 == "1"){
                $periodo = "DATE(NOW()) - INTERVAL 7 DAY";
            }elseif($var3 == "2"){
                $periodo = "DATE(NOW()) - INTERVAL 30 DAY"; 
            }elseif($var3 == "3"){
                $periodo = "DATE(NOW()) - INTERVAL 365 DAY"; 
            }else{
                $periodo = "data_postagem";
            }
            return redirect('home')->with(['periodo' =>  $periodo]);
        }

        if(isset($_POST['avalia'])){
            $var2 = $_POST['avalia'];
            if($var2 == "1"){
                $avalia = "1"; 
            }elseif($var2 == "2"){
                $avalia = "2";
            }else{
                $avalia = "1 OR 2";
            }
            return redirect('home')->with(['avalia' =>  $avalia]);
        }

    }

    public function reset()
    {   
        session_start();
        unset($_SESSION['filtro'], $_SESSION['tipo'], $_SESSION['periodo'], $_SESSION['avalia']);
        return redirect('home'); 
    }

    public function reset_search()
    {   
        session_start();
        unset($_SESSION["pesquisa"]);
        return redirect('home'); 
    }
    
}