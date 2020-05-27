<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function admin()
    {
        return view('adm');
    }

    public function admin2()
    {
        return view('adm2');
    }

    public function admin3()
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

        return view('adm3', compact('post'));
    }

    public function admin4()
    {   
        return view('adm4');
    }

    public function alt()
    {  
        $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
        $id_sql = $_POST ['alt'];
        $sql = "UPDATE usuarios SET id_situacao = 1 WHERE id ='$id_sql'";
        mysqli_query($conn, $sql);

        return redirect('adm');
    }

    public function del()
    {  
        $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
        $id_sql = $_POST ['del'];
        $sql = "DELETE FROM usuarios WHERE id ='$id_sql'";
        mysqli_query($conn, $sql);

        return redirect('adm');
    }
    
    public function alterar()
    {  
        $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
        $id_sql = $_POST ['alterar'];
        $tipo = $_POST ['tipo'];

        if($tipo =='Admin'){$result = '3';}
        else if($tipo == 'Avaliador'){ $result = '2';}
        else{ $result = '1';}

        $sql = "UPDATE usuarios SET nivel = '$result' WHERE id ='$id_sql'";
        mysqli_query($conn, $sql);

        return redirect('adm2');
    }

    public function pesquisa()
    {   
        if(isset($_POST['pesquisa_user'])){
            $pesquisa2 = $_POST['pesquisa_user'];
            return redirect('adm2')->with(['pesquisa2' =>  $pesquisa2]);
        }
    }

    public function reset_search()
    {   
        session_start();
        unset($_SESSION["pesquisa2"]);
        return redirect('adm2'); 
    }

    public function option(){  
        
        if($_POST['option'] == 'rem_den'){
            $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
            $id_sql = $_POST ['id_denuncia'];

            $sql = "DELETE FROM denuncias WHERE id_denuncia ='$id_sql'";
            mysqli_query($conn, $sql);

            return redirect('adm3');
        }
        if($_POST['option'] == 'del_post'){
            $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
            $id1 = $_POST ['id_denuncia'];
            $id2 = $_POST ['id_postagem'];

            $sql = "SELECT * FROM comentarios WHERE id_postagem ='$id2'";
            $result = mysqli_query($conn, $sql);
            if($row = mysqli_fetch_assoc($result)){
                $id_comen = $row['id_comentarios'];
            }

            $sql = "DELETE FROM denuncias WHERE id_denuncia ='$id1'";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM subcomentarios WHERE id_postagem ='$id2'";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM like_comentarios WHERE id_comentarios ='$id_comen'";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM comentarios WHERE id_postagem ='$id2'";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM postagens WHERE id_postagem ='$id2'";
            mysqli_query($conn, $sql);

            return redirect('adm3');
        }
        if($_POST['option'] =='barrar'){
            $id1 = $_POST ['id_denuncia'];
            $id2 = $_POST ['id_postagem'];
            echo $id1 . " e " .  $id2;
        }
    }

    public function option2(){  
        if($_POST['option'] == 'rem_den'){
            $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
            $id_sql = $_POST ['id_denuncia'];

            $sql = "DELETE FROM denuncias_comentarios WHERE id_denunciacomentario ='$id_sql'";
            mysqli_query($conn, $sql);

            return redirect('adm4');
        }
        if($_POST['option'] == 'del_comen'){
            $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
            $id1 = $_POST ['id_denuncia'];
            $id2 = $_POST ['id_comentario'];

            $sql = "DELETE FROM denuncias_comentarios WHERE id_denunciacomentario ='$id1'";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM subcomentarios WHERE id_comentarios ='$id2'";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM like_comentarios WHERE id_comentarios ='$id2'";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM comentarios WHERE id_comentarios ='$id2'";
            mysqli_query($conn, $sql);

            return redirect('adm4');
        }
    }
}