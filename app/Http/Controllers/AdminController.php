<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use datetime;
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

    public function admin5()
    {   
        return view('adm5');
    }

    public function alt()
    {  
        $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
        $id_sql = $_POST ['alt'];
        $sql = "UPDATE usuarios SET id_situacao = 1 WHERE id = $id_sql";
        mysqli_query($conn, $sql);

        return redirect('adm');
    }

    public function del()
    {  
        $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
        $id_sql = $_POST ['del'];
        $sql = "DELETE FROM usuarios WHERE id = $id_sql";
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

        $sql = "UPDATE usuarios SET nivel = $result WHERE id = $id_sql";
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

            $sql = "DELETE FROM denuncias WHERE id_denuncia = $id_sql";
            mysqli_query($conn, $sql);

            return redirect('adm3');
        }
        if($_POST['option'] == 'del_post'){
            $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
            $id_den = $_POST ['id_denuncia'];
            $id_post = $_POST ['id_postagem'];

            $sql = "DELETE FROM denuncias WHERE id_denuncia = $id_den";
            mysqli_query($conn, $sql);

            $query = "SELECT * FROM comentarios WHERE id_postagem = $id_post";
            $result = mysqli_query($conn, $query);
            while($rows = mysqli_fetch_assoc($result)){
                $id_com = $rows['id_comentarios'];
                $sql = "DELETE FROM denuncias_comentarios WHERE id_comentario = $id_com";
                mysqli_query($conn, $sql);
            }

            $sql = "DELETE FROM avaliacao_postagem WHERE id_postagem = $id_post";
            mysqli_query($conn, $sql);

            $query2 = "SELECT * FROM subcomentarios WHERE id_postagem = $id_post";
            $result2 = mysqli_query($conn, $query2);
            while($rows = mysqli_fetch_assoc($result2)){
                $id_subcomen = $rows['id_subcomentarios'];
                $sql = "DELETE FROM like_subcomentarios WHERE id_comentarios = $id_subcomen";
                mysqli_query($conn, $sql);
            }

            $sql = "DELETE FROM subcomentarios WHERE id_postagem = $id_post";
            mysqli_query($conn, $sql);
            
            $query3 = "SELECT * FROM comentarios WHERE id_postagem = $id_post";
            $result3 = mysqli_query($conn, $query3);
            while($rows = mysqli_fetch_assoc($result3)){
                $id_com = $rows['id_comentarios'];
                $sql = "DELETE FROM like_comentarios WHERE id_comentarios = $id_com";
                mysqli_query($conn, $sql);
            }

            $sql = "DELETE FROM comentarios WHERE id_postagem = $id_post";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM img_postagem WHERE id_postagem = $id_post";
            mysqli_query($conn, $sql);
            
            $sql = "DELETE FROM postagens WHERE id_postagem = $id_post";
            mysqli_query($conn, $sql);

            return redirect('adm3');
        }
    }

    public function option2(){  
        if($_POST['option'] == 'rem_den'){
            $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
            $id_sql = $_POST ['id_denuncia'];

            $sql = "DELETE FROM denuncias_comentarios WHERE id_denunciacomentario = $id_sql";
            mysqli_query($conn, $sql);

            return redirect('adm4');
        }
        if($_POST['option'] == 'del_comen'){
            $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
            $id_den = $_POST ['id_denuncia'];
            $id_com = $_POST ['id_comentario'];

            $sql = "DELETE FROM denuncias_comentarios WHERE id_denunciacomentario = $id_den";
            mysqli_query($conn, $sql);

            $query = "SELECT * FROM subcomentarios WHERE id_comentarios = $id_com";
            $result = mysqli_query($conn, $query);
            while($rows = mysqli_fetch_assoc($result)){
                $id_subcom = $rows['id_subcomentarios'];
                $sql = "DELETE FROM denuncias_subcomentarios WHERE id_subcomentario = $id_subcom";
                mysqli_query($conn, $sql);
            }

            $sql = "DELETE FROM like_subcomentarios WHERE id_comentarios = $id_com";
            mysqli_query($conn, $sql);
            
            $sql = "DELETE FROM subcomentarios WHERE id_comentarios = $id_com";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM like_comentarios WHERE id_comentarios = $id_com";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM comentarios WHERE id_comentarios = $id_com";
            mysqli_query($conn, $sql);

            return redirect('adm4');
        }
    }
        
    public function avaliar(Request $request) {
        $data = $request->all();
        $datetime = new DateTime();
        $datetime->format('d-m-Y H:i:s');
        $data['data_postagem'] = $datetime;
        $soma = $data['inovacao'] + $data['complexidade'] + $data['potencial'];
        $media = $soma / 3;
        if(!empty($data)) {
            $insert = DB::insert('insert into avaliacao_postagem (
                id_postagem, id_usuario, inovacao_avaliacao, complexidade_avaliacao, potencial_avaliacao, comentario_avaliacao, media_avaliacao, id_avaliador, data_avaliacao
            )  
            values (?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $data['id_postagem'], $data['id_usuario'], $data['inovacao'], $data['complexidade'], $data['potencial'], $data['comentarios'], $media, $data['id_avaliador'], $data['data_postagem']
            ]);

            $update = DB::update('update postagens set media = ?, id_situacao_postagem = ? where id_postagem = ?', [$media, 1, $data['id_postagem']]);
        }

        if(!$insert or !$update ) {
            return redirect()
                            ->back()
                            ->with('error', 'Erro ao processar avaliação');
        }

        return back();
    }
}