<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use datetime;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use intval;
use Mail;
use App\Mail\solicitacao_aceita;
use App\Mail\solicitacao_recusada;
use App\Mail\desbloqueio;
use Config;
use Storage;
use Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function admin()
    {
        return view('/admin/historico');
    }

    public function admin2()
    {
        return view('/admin/usuarios');
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
                                ->leftJoin('postagens', 'postagens.id_postagem', '=', 'img_postagem.id_img')
                                ->select('img_postagem.id_postagem', 'img_postagem.img_post')
                                ->distinct()
                                ->get()
        ];

        return view('/admin/denuncias/postagem', compact('post'));
    }

    public function admin4()
    {   
        return view('/admin/denuncias/comentario');
    }

    public function admin5()
    {   
        return view('/admin/denuncias');
    }

    public function admin6()
    {   
        return view('/admin/solicitacoes');
    }

    public function admin7()
    {   
        return view('/admin/bloqueados');
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

        $sql = "DELETE FROM usuarios WHERE id = $id_sql";
        mysqli_query($conn, $sql);

        return redirect()->back()->with(['notific' =>  $notific])->with(['usu' => $usu]); 
    }
    
    public function alterar()
    {  
        $db_config = Config::get('database.connections.'.Config::get('database.default'));
        $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
        mysqli_set_charset($conn, 'utf8');

        $id_sql = $_POST ['alterar'];
        $usu = $_POST ['nome'];
        $registro = $_POST ['registro'];
        $email = $_POST ['email'];
        $notific = 1;

        if(isset($_POST ['tipo'])){
            $tipo = $_POST ['tipo'];
        
            if($tipo =='Admin'){$result = '3';}
            else if($tipo == 'Avaliador'){ $result = '2';}
            else{ $result = '1';}

            $sql = "UPDATE usuarios SET nivel = $result WHERE id = $id_sql";
            mysqli_query($conn, $sql);
        }

        $sql = "UPDATE usuarios SET registro = '$registro' WHERE id = $id_sql";
        mysqli_query($conn, $sql);

        $sql = "UPDATE usuarios SET email = '$email' WHERE id = $id_sql";
        mysqli_query($conn, $sql);

        $sql = "INSERT INTO notificacoes (titulo_notificacao, conteudo_notificacao, usuario_notificacao) VALUES ('Dados alterados', 'Seus dados foram alterados por um administrador', '$id_sql') ";
        mysqli_query($conn, $sql);

        return redirect()->back()->with(['notific' =>  $notific])->with(['usu' => $usu]);

    }

    public function del_usu()
    { 
        $db_config = Config::get('database.connections.'.Config::get('database.default'));
        $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
        mysqli_set_charset($conn, 'utf8');

        $id_usu =  $_POST ['id'];
        $id_sql = $_POST ['del_usu'];
        $usu = $_POST ['nome'];
        $mail = $_POST ['email'];

        if($_POST['option'] == 'del'){
            $notific = 2;
        }elseif($_POST['option'] == 'ban'. $id_usu){
            $notific = 3;
            $motivo = $_POST ['motivo'];
            if($motivo == NULL){
                $motivo = "motivo não adicionado.";
            }
            $sql = "INSERT INTO bloqueados (email, motivo_bloqueio, data_bloqueio) VALUES ('$mail', '$motivo', CURRENT_TIMESTAMP() )";
            mysqli_query($conn, $sql);
        }else{
            return redirect()->back();
        }
        
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
            
            $sql = "SELECT * FROM img_postagem WHERE id_postagem = $id";
            $result = mysqli_query($conn, $sql);
            while($rows = mysqli_fetch_assoc($result)){
                $file_img = $rows['img_post'];
                unlink("$file_img");
            }
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

        $sql = "DELETE FROM solicitacoes WHERE usuario_solicitacao = $id_sql";
        mysqli_query($conn, $sql);
        
        $sql = "DELETE FROM usuarios WHERE id = $id_sql";
        mysqli_query($conn, $sql);

        return redirect()->back()->with(['notific' =>  $notific])->with(['usu' => $usu]);
    }

    public function pesquisa()
    {   
        if(isset($_POST['pesquisa_user'])){
            $pesquisa2 = $_POST['pesquisa_user'];
            return redirect()->back()->with(['pesquisa2' =>  $pesquisa2]);
        }
    }

    public function reset_search()
    {   
        session_start();
        unset($_SESSION["pesquisa2"]);
        return redirect()->back(); 
    }

    public function option(){  //denuncia postagem
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

            return redirect()->back()->with(['notific' =>  $notific])->with(['nom' => $nom]);
        }
        if($_POST['option'] == 'del_post'){
            $db_config = Config::get('database.connections.'.Config::get('database.default'));
            $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
            mysqli_set_charset($conn, 'utf8');

            $id_den = $_POST ['id_denuncia'];
            $id_post = $_POST ['id_postagem'];
            $nom = $_POST ['nome_post'];
            $id_usu = $_POST ['id_usu'];
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
            
            $sql = "SELECT * FROM img_postagem WHERE id_postagem = $id_post";
            $result = mysqli_query($conn, $sql);
            while($rows = mysqli_fetch_assoc($result)){
                $file_img = $rows['img_post'];
                unlink("$file_img");
            }

            $sql = "DELETE FROM img_postagem WHERE id_postagem = $id_post";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM like_postagens WHERE id_postagens = $id_post";
            mysqli_query($conn, $sql);
            
            $sql = "DELETE FROM postagens WHERE id_postagem = $id_post";
            mysqli_query($conn, $sql);
            
            $sql = "INSERT INTO notificacoes (titulo_notificacao, conteudo_notificacao, usuario_notificacao) VALUES ('Postagem apagada', 'Sua postagem <b>$nom</b> foi apagada devido a denuncias', '$id_usu') ";
            mysqli_query($conn, $sql);

            return redirect()->back()->with(['notific' =>  $notific])->with(['nom' => $nom]);
        }
    }

    public function option2(){ //denuncia comentario
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

            return redirect()->back()->with(['notific' =>  $notific])->with(['nom' => $nom]);
        }
        if($_POST['option'] == 'del_comen'){
            $db_config = Config::get('database.connections.'.Config::get('database.default'));
            $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
            mysqli_set_charset($conn, 'utf8');
            
            $id_den = $_POST ['id_denuncia'];
            $id_com = $_POST ['id_comentario'];
            $nom = $_POST ['autor_coment'];
            $id_usu = $_POST ['id_usu'];
            $id_post = $_POST ['id_post'];
            $notific = 2;

            $sql = "DELETE FROM denuncias_comentarios WHERE id_denunciacomentario = $id_den";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM check_denuncia_comentarios WHERE id_comentario = $id_com";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM like_comentarios WHERE id_comentarios = $id_com";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM comentarios WHERE id_comentarios = $id_com";
            mysqli_query($conn, $sql);
            
            $query = "SELECT * FROM postagens WHERE id_postagem = $id_post";
            $result = mysqli_query($conn, $query);
            if($rows = mysqli_fetch_assoc($result)){
                $post = $rows['titulo_postagem'];
                
                $sql = "INSERT INTO notificacoes (titulo_notificacao, conteudo_notificacao, usuario_notificacao) VALUES ('Comentario apagado', 'Seu comentario foi apagado na postagem <b>$post</b> devido a denuncias', '$id_usu') ";
                mysqli_query($conn, $sql);
            }

            return redirect()->back()->with(['notific' =>  $notific])->with(['nom' => $nom]);
        }
    }
    public function option3(){ //solicitacao
        if($_POST['option'] == 'aceita'){
            $db_config = Config::get('database.connections.'.Config::get('database.default'));
            $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
            mysqli_set_charset($conn, 'utf8');

            $id_soli = $_POST ['id_soli'];
            $nom = $_POST ['usu'];
            $id_usu = $_POST ['id_usu'];
            $tipo = $_POST ['tipo'];
            $notific = 1;

            $sql = "INSERT INTO notificacoes (titulo_notificacao, conteudo_notificacao, usuario_notificacao) VALUES ('Solicitação aceita', 'Sua solicitação <b>$tipo</b> foi aceita', '$id_usu') ";
            mysqli_query($conn, $sql);

            $sql = "UPDATE solicitacoes SET status_solicitacao = 1 WHERE id_solicitacao = $id_soli";
            mysqli_query($conn, $sql);

            return redirect()->back()->with(['notific' =>  $notific])->with(['nom' => $nom]);
        }
        if($_POST['option'] == 'recusada'){
            $db_config = Config::get('database.connections.'.Config::get('database.default'));
            $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
            mysqli_set_charset($conn, 'utf8');
            
            $id_soli = $_POST ['id_soli'];
            $nom = $_POST ['usu'];
            $id_usu = $_POST ['id_usu'];
            $tipo = $_POST ['tipo'];
            $notific = 2;

            $sql = "INSERT INTO notificacoes (titulo_notificacao, conteudo_notificacao, usuario_notificacao) VALUES ('Solicitação recusada', 'Sua solicitação <b>$tipo</b> foi recusada', '$id_usu') ";
            mysqli_query($conn, $sql);

            $sql = "UPDATE solicitacoes SET status_solicitacao = 2 WHERE id_solicitacao = $id_soli";
            mysqli_query($conn, $sql);

            return redirect()->back()->with(['notific' =>  $notific])->with(['nom' => $nom]);
        }
    }

    public function option4(){  //bloqueios
        if($_POST['option'] == 'notif'){
            $db_config = Config::get('database.connections.'.Config::get('database.default'));
            $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
            mysqli_set_charset($conn, 'utf8');

            $id = $_POST ['id'];
            $mail = $_POST ['mail'];
            $notific = 1;

            Mail::to($mail)->send(new desbloqueio());

            $sql = "DELETE FROM bloqueados WHERE id = $id";
            mysqli_query($conn, $sql);

            return redirect()->back()->with(['notific' =>  $notific])->with(['mail' => $mail]);
        }
        if($_POST['option'] == 'no'){
            $db_config = Config::get('database.connections.'.Config::get('database.default'));
            $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
            mysqli_set_charset($conn, 'utf8');
            
            $id = $_POST ['id'];
            $mail = $_POST ['mail'];
            $notific = 2;

            $sql = "DELETE FROM bloqueados WHERE id = $id";
            mysqli_query($conn, $sql);

            return redirect()->back()->with(['notific' =>  $notific])->with(['mail' => $mail]);
        }
    }
        
    public function avaliar(Request $request) {
        $data = $request->all();
        $user = Auth::user();
        $datetime = new DateTime();
        $datetime->format('d-m-Y H:i:s');
        $data['data_postagem'] = $datetime;
        $soma = $data['inovacao'] + $data['complexidade'] + $data['potencial'];
        $media = $soma / 3;
        $id_postagem = $data['id_postagem'];
        if(!empty($data)) {
            $id_avaliador = $data['id_avaliador'];
            $id_usuario = $data['id_usuario'];
            $insert = DB::insert('insert into avaliacao_postagem (
                id_postagem, id_usuario, inovacao_avaliacao, complexidade_avaliacao, potencial_avaliacao, media_avaliacao, id_avaliador
            )  
            values (?, ?, ?, ?, ?, ?, ?)', [
                $data['id_postagem'], $id_usuario, $data['inovacao'], $data['complexidade'], $data['potencial'], $media, $id_avaliador
            ]);

            $query = DB::table('avaliacao_postagem')
                            ->where('id_postagem', $data['id_postagem'])
                            ->select('id_avaliacao')
                            ->get();

            $query = intval($query[0]->id_avaliacao);

            $insert_coment = DB::insert('insert into comentarios (id_avaliacao, id_usuarios, id_postagem, conteudo_comentarios, data_comentarios)
            values (?, ?, ?, ?, ?)', [$query, $id_avaliador, $data['id_postagem'], $data['comentarios'], $data['data_postagem']]);

            $update = DB::update('update postagens set media = ?, id_situacao_postagem = ? where id_postagem = ?', [$media, 1, $data['id_postagem']]);

            $nome_avaliador = $data['nome_avaliador'];
            $name_post = $data['name_post'];

            $notific = DB::insert("insert into notificacoes (
                titulo_notificacao, conteudo_notificacao, usuario_notificacao
            ) values (?, ?, ?)", ['Postagem avaliada', "Sua postagem <b>$name_post</b> foi avaliada por $nome_avaliador", $id_usuario]);
        }

        if(!$insert or !$update ) {
            return redirect()->back()->with('error', 'Erro ao processar avaliação');
        }

        return back()->with('id_postagem', $id_postagem);
    }
}