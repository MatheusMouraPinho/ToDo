<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use datetime;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use intval;
use Mail;
use App\Mail\cadastro_aceito;
use App\Mail\cadastro_recusado;
use App\Mail\usuario_deletado;
use Config;
use Storage;

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
                            ->select('usuarios.*')
                            ->get(),
            
            'avaliacao' => DB::table('postagens')
                            ->join('avaliacao_postagem', 'postagens.id_postagem', '=', 'avaliacao_postagem.id_postagem')
                            ->join('comentarios', 'comentarios.id_avaliacao', 'avaliacao_postagem.id_avaliacao')
                            ->select('avaliacao_postagem.*', 'postagens.id_usuarios', 'postagens.id_postagem', 'comentarios.*')
                            ->get(),
            
            'comentarios' => DB::table('comentarios')
                                ->join('postagens', 'postagens.id_postagem', '=', 'comentarios.id_postagem')
                                ->where('comentarios.id_mencionado', '=', null, 'and')
                                ->where('comentarios.id_avaliacao', '=', null)
                                ->join('usuarios', 'comentarios.id_usuarios', '=', 'usuarios.id')
                                ->select('comentarios.*', 'postagens.id_usuarios', 'postagens.id_postagem', 'usuarios.*')
                                ->orderBy('comentarios.data_comentarios', 'desc')
                                ->get(),



            'reply_coment' => DB::table('comentarios')
                                ->join('postagens', 'postagens.id_postagem', '=', 'comentarios.id_postagem')
                                ->where('comentarios.id_mencionado', '!=', null)
                                ->leftJoin('usuarios as users', 'comentarios.id_usuarios', '=', 'users.id')
                                ->select('comentarios.*', 'postagens.id_usuarios', 'postagens.id_postagem', 'users.*')                               
                                ->orderBy('data_comentarios', 'asc')
                                ->get(),

            'mencionado' => DB::table('comentarios')
                                ->leftJoin('usuarios as user', 'comentarios.id_mencionado', '=', 'user.id') 
                                ->join('postagens', 'postagens.id_postagem', '=', 'comentarios.id_postagem')
                                ->where('comentarios.id_mencionado', '!=', null)
                                ->select('comentarios.id_comentarios','postagens.id_usuarios', 'postagens.id_postagem', 'user.*')                               
                                ->orderBy('data_comentarios', 'asc')
                                ->get(),

            'img_post' => DB::table('img_postagem')
                                ->select('id_img', 'id_postagem')
                                ->get()
        ];

        return view('adm3', compact('post'));
    }

    public function admin4()
    {   
        return view('adm4');
    }

    public function altorizar()
    {  
        $db_config = Config::get('database.connections.'.Config::get('database.default'));
        $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
        mysqli_set_charset($conn, 'utf8');

        $id_sql = $_POST ['alt'];
        $mail = $_POST ['email'];
        $usu = $_POST ['nome'];
        $notific = 1;

        $sql = "UPDATE usuarios SET id_situacao = 1 WHERE id = $id_sql";
        mysqli_query($conn, $sql);
 
        Mail::to($mail)->send(new cadastro_aceito());

        return redirect('adm')->with(['notific' =>  $notific])->with(['usu' => $usu]);
    }

    public function recusar()
    {  
        $db_config = Config::get('database.connections.'.Config::get('database.default'));
        $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
        mysqli_set_charset($conn, 'utf8');

        $id_sql = $_POST ['del'];
        $mail = $_POST ['email'];
        $usu = $_POST ['nome'];
        $notific = 2;

        Mail::to($mail)->send(new cadastro_recusado());

        $sql = "DELETE FROM usuarios WHERE id = $id_sql";
        mysqli_query($conn, $sql);

        return redirect('adm')->with(['notific' =>  $notific])->with(['usu' => $usu]); 
    }
    
    public function alterar()
    {  
        $db_config = Config::get('database.connections.'.Config::get('database.default'));
        $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
        mysqli_set_charset($conn, 'utf8');

        $id_sql = $_POST ['alterar'];
        $tipo = $_POST ['tipo'];
        $usu = $_POST ['nome'];
        $notific = 1;

        if($tipo =='Admin'){$result = '3';}
        else if($tipo == 'Avaliador'){ $result = '2';}
        else{ $result = '1';}

        $sql = "UPDATE usuarios SET nivel = $result WHERE id = $id_sql";
        mysqli_query($conn, $sql);

        return redirect('adm2')->with(['notific' =>  $notific])->with(['usu' => $usu]);

    }

    public function del_usu()
    { 
        $db_config = Config::get('database.connections.'.Config::get('database.default'));
        $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
        mysqli_set_charset($conn, 'utf8');

        $id_sql = $_POST ['del_usu'];
        $usu = $_POST ['nome'];
        $mail = $_POST ['email'];
        $notific = 2;
        
        $sql = "DELETE FROM check_denuncia WHERE id_usuario = $id_sql";
        mysqli_query($conn, $sql);

        $sql = "DELETE FROM check_denuncia_comentarios WHERE id_usuario = $id_sql";
        mysqli_query($conn, $sql);

        $query = "SELECT * FROM postagens WHERE id_usuarios = $id_sql";
        $result = mysqli_query($conn, $query);
        while($rows = mysqli_fetch_assoc($result)){
            $id_post = $rows['id_postagem'];
            $sql = "DELETE FROM check_denuncia WHERE id_postagem = $id_post";
            mysqli_query($conn, $sql);
        }

        $query = "SELECT * FROM postagens WHERE id_usuarios = $id_sql";
        $result = mysqli_query($conn, $query);
        while($rows = mysqli_fetch_assoc($result)){
            $id_post = $rows['id_postagem'];
            $sql = "DELETE FROM denuncias WHERE id_postagem = $id_post";
            mysqli_query($conn, $sql);
        }

        $sql = "DELETE FROM like_comentarios WHERE id_usuarios = $id_sql";
        mysqli_query($conn, $sql);

        $query = "SELECT * FROM comentarios WHERE id_usuarios = $id_sql";
        $result = mysqli_query($conn, $query);
        while($rows = mysqli_fetch_assoc($result)){
            $id_com = $rows['id_comentarios'];
            $sql = "DELETE FROM check_denuncia_comentarios WHERE id_comentario = $id_com";
            mysqli_query($conn, $sql);
        }

        $query = "SELECT * FROM comentarios WHERE id_usuarios = $id_sql";
        $result = mysqli_query($conn, $query);
        while($rows = mysqli_fetch_assoc($result)){
            $id_com = $rows['id_comentarios'];
            $sql = "DELETE FROM denuncias_comentarios WHERE id_comentario = $id_com";
            mysqli_query($conn, $sql);
        }

        $query3 = "SELECT * FROM comentarios WHERE id_usuarios = $id_sql";
        $result3 = mysqli_query($conn, $query3);
        while($rows = mysqli_fetch_assoc($result3)){
            $id_com = $rows['id_comentarios'];
            $sql = "DELETE FROM like_comentarios WHERE id_comentarios = $id_com";
            mysqli_query($conn, $sql);
        }

        $sql = "DELETE FROM comentarios WHERE id_usuarios = $id_sql";
        mysqli_query($conn, $sql);
        
        $query = "SELECT * FROM avaliacao_postagem WHERE id_avaliador = $id_sql";
        $result = mysqli_query($conn, $query);
        while($rows = mysqli_fetch_assoc($result)){
            $id = $rows['id_usuario'];
            $sql = "DELETE FROM comentarios WHERE id_usuarios = $id";
            mysqli_query($conn, $sql);
        }

        $sql = "DELETE FROM avaliacao_postagem WHERE id_avaliador = $id_sql";
        mysqli_query($conn, $sql);

        $sql = "DELETE FROM avaliacao_postagem WHERE id_usuario = $id_sql";
        mysqli_query($conn, $sql);

        $sql = "DELETE FROM like_postagens WHERE id_usuarios = $id_sql";
        mysqli_query($conn, $sql);

        $query4 = "SELECT * FROM postagens WHERE id_usuarios = $id_sql";
        $result4 = mysqli_query($conn, $query4);
        while($rows = mysqli_fetch_assoc($result4)){
            $id = $rows['id_postagem'];
            $titulo = $rows['titulo_postagem'];
            storage::disk('public')->delete("posts/1$id$titulo.png");
            storage::disk('public')->delete("posts/2$id$titulo.png");
            storage::disk('public')->delete("posts/3$id$titulo.png");
            storage::disk('public')->delete("posts/1$id$titulo.jpg");
            storage::disk('public')->delete("posts/2$id$titulo.jpg");
            storage::disk('public')->delete("posts/3$id$titulo.jpg");
        }

        $query = "SELECT * FROM postagens WHERE id_usuarios = $id_sql";
        $result = mysqli_query($conn, $query);
        while($rows = mysqli_fetch_assoc($result)){
            $id_post = $rows['id_postagem'];
            $sql = "DELETE FROM img_postagem WHERE id_postagem = $id_post";
            mysqli_query($conn, $sql);
        }

        $query = "SELECT * FROM postagens WHERE id_usuarios = $id_sql";
        $result = mysqli_query($conn, $query);
        while($rows = mysqli_fetch_assoc($result)){
            $id_post = $rows['id_postagem'];
            $sql = "DELETE FROM like_postagens WHERE id_postagens = $id_post";
            mysqli_query($conn, $sql);
        }

        $sql = "DELETE FROM postagens WHERE id_usuarios = $id_sql";
        mysqli_query($conn, $sql);
        
        $sql = "DELETE FROM usuarios WHERE id = $id_sql";
        mysqli_query($conn, $sql);

        return redirect('adm2')->with(['notific' =>  $notific])->with(['usu' => $usu]);
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
            $db_config = Config::get('database.connections.'.Config::get('database.default'));
            $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
            mysqli_set_charset($conn, 'utf8');

            $id_post = $_POST ['id_postagem'];
            $nom = $_POST ['nome_post'];
            $notific = 1;

            $sql = "DELETE FROM denuncias WHERE id_postagem = $id_post";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM check_denuncia WHERE id_postagem = $id_post";
            mysqli_query($conn, $sql);

            return redirect('adm3')->with(['notific' =>  $notific])->with(['nom' => $nom]);
        }
        if($_POST['option'] == 'del_post'){
            $db_config = Config::get('database.connections.'.Config::get('database.default'));
            $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
            mysqli_set_charset($conn, 'utf8');

            $id_den = $_POST ['id_denuncia'];
            $id_post = $_POST ['id_postagem'];
            $nom = $_POST ['nome_post'];
            $notific = 2;

            $sql = "DELETE FROM check_denuncia WHERE id_postagem = $id_post";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM denuncias WHERE id_denuncia = $id_den";
            mysqli_query($conn, $sql);

            $query = "SELECT * FROM comentarios WHERE id_postagem = $id_post";
            $result = mysqli_query($conn, $query);
            while($rows = mysqli_fetch_assoc($result)){
                $id_com = $rows['id_comentarios'];
                $sql = "DELETE FROM check_denuncia_comentarios WHERE id_comentario = $id_com";
                mysqli_query($conn, $sql);
            }

            $query = "SELECT * FROM comentarios WHERE id_postagem = $id_post";
            $result = mysqli_query($conn, $query);
            while($rows = mysqli_fetch_assoc($result)){
                $id_com = $rows['id_comentarios'];
                $sql = "DELETE FROM denuncias_comentarios WHERE id_comentario = $id_com";
                mysqli_query($conn, $sql);
            }
            
            $query3 = "SELECT * FROM comentarios WHERE id_postagem = $id_post";
            $result3 = mysqli_query($conn, $query3);
            while($rows = mysqli_fetch_assoc($result3)){
                $id_com = $rows['id_comentarios'];
                $sql = "DELETE FROM like_comentarios WHERE id_comentarios = $id_com";
                mysqli_query($conn, $sql);
            }

            $sql = "DELETE FROM comentarios WHERE id_postagem = $id_post";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM avaliacao_postagem WHERE id_postagem = $id_post";
            mysqli_query($conn, $sql);
            
            $query4 = "SELECT * FROM postagens WHERE id_postagem = $id_post";
            $result4 = mysqli_query($conn, $query4);
            while($rows = mysqli_fetch_assoc($result4)){
                $id = $rows['id_postagem'];
                $titulo = $rows['titulo_postagem'];
                storage::disk('public')->delete("posts/1$id$titulo.png");
                storage::disk('public')->delete("posts/2$id$titulo.png");
                storage::disk('public')->delete("posts/3$id$titulo.png");
                storage::disk('public')->delete("posts/1$id$titulo.jpg");
                storage::disk('public')->delete("posts/2$id$titulo.jpg");
                storage::disk('public')->delete("posts/3$id$titulo.jpg");
            }

            $sql = "DELETE FROM img_postagem WHERE id_postagem = $id_post";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM like_postagens WHERE id_postagens = $id_post";
            mysqli_query($conn, $sql);
            
            $sql = "DELETE FROM postagens WHERE id_postagem = $id_post";
            mysqli_query($conn, $sql);

            return redirect('adm3')->with(['notific' =>  $notific])->with(['nom' => $nom]);
        }
    }

    public function option2(){
        if($_POST['option'] == 'rem_den'){
            $db_config = Config::get('database.connections.'.Config::get('database.default'));
            $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
            mysqli_set_charset($conn, 'utf8');

            $id_com = $_POST ['id_comentario'];
            $nom = $_POST ['autor_coment'];
            $notific = 1;

            $sql = "DELETE FROM denuncias_comentarios WHERE id_comentario = $id_com";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM check_denuncia_comentarios WHERE id_comentario = $id_com";
            mysqli_query($conn, $sql);

            return redirect('adm4')->with(['notific' =>  $notific])->with(['nom' => $nom]);
        }
        if($_POST['option'] == 'del_comen'){
            $db_config = Config::get('database.connections.'.Config::get('database.default'));
            $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
            mysqli_set_charset($conn, 'utf8');
            
            $id_den = $_POST ['id_denuncia'];
            $id_com = $_POST ['id_comentario'];
            $nom = $_POST ['autor_coment'];
            $notific = 2;

            $sql = "DELETE FROM denuncias_comentarios WHERE id_denunciacomentario = $id_den";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM check_denuncia_comentarios WHERE id_comentario = $id_com";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM like_comentarios WHERE id_comentarios = $id_com";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM comentarios WHERE id_comentarios = $id_com";
            mysqli_query($conn, $sql);

            return redirect('adm4')->with(['notific' =>  $notific])->with(['nom' => $nom]);
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
                id_postagem, id_usuario, inovacao_avaliacao, complexidade_avaliacao, potencial_avaliacao, media_avaliacao, id_avaliador
            )  
            values (?, ?, ?, ?, ?, ?, ?)', [
                $data['id_postagem'], $data['id_usuario'], $data['inovacao'], $data['complexidade'], $data['potencial'], $media, $data['id_avaliador']
            ]);

            $query = DB::table('avaliacao_postagem')
                            ->where('id_postagem', $data['id_postagem'])
                            ->select('id_avaliacao')
                            ->get();

            $query = intval($query[0]->id_avaliacao);

            $insert_coment = DB::insert('insert into comentarios (id_avaliacao, id_usuarios, id_postagem, conteudo_comentarios, data_comentarios)
            values (?, ?, ?, ?, ?)', [$query, $data['id_avaliador'], $data['id_postagem'], $data['comentarios'], $data['data_postagem']]);

            $update = DB::update('update postagens set media = ?, id_situacao_postagem = ? where id_postagem = ?', [$media, 1, $data['id_postagem']]);
        }

        $id_postagem = $data['id_postagem'];

        if(!$insert or !$update ) {
            return redirect()->back()->with('error', 'Erro ao processar avaliação');
        }

        return back()->with('id_postagem', $id_postagem);
    }
}