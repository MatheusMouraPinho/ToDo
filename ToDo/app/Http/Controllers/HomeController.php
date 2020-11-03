<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Config;

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
                            ->select('usuarios.*')
                            ->get(),
            
            'avaliacao' => DB::table('postagens')
                            ->join('avaliacao_postagem', 'postagens.id_postagem', '=', 'avaliacao_postagem.id_postagem')
                            ->join('comentarios', 'comentarios.id_avaliacao', 'avaliacao_postagem.id_avaliacao')
                            ->select('avaliacao_postagem.*', 'postagens.id_usuarios', 'postagens.id_postagem', 'comentarios.*')
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
            }elseif($var2 == "3"){
                $tipo = "3";
            }elseif($var2 == "4"){
                $tipo = "4";
            }elseif($var2 == "5"){
                $tipo = "5";
            }else{
                $tipo = "1 OR 2 OR 3 OR 4 OR 5";
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

    public function filtro2()
    {
        if(isset($_POST['tipo'])){
            $var2 = $_POST['tipo'];
            if($var2 == "1"){
                $tipo = "1"; 
            }elseif($var2 == "2"){
                $tipo = "2";
            }elseif($var2 == "3"){
                $tipo = "3";
            }elseif($var2 == "4"){
                $tipo = "4";
            }elseif($var2 == "5"){
                $tipo = "5";
            }else{
                $tipo = "1 OR 2 OR 3 OR 4 OR 5";
            }
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
        }

        if(isset($_POST['avalia'])){
            $var4 = $_POST['avalia'];
            if($var4 == "1"){
                $avalia = "1"; 
            }elseif($var4 == "2"){
                $avalia = "2";
            }else{
                $avalia = "1 OR 2";
            }
        }
        
        if(isset($_POST['tipo'], $_POST['periodo'], $_POST['avalia'])){
            return redirect('home')->with(['avalia' =>  $avalia ,'periodo' =>  $periodo ,'tipo' =>  $tipo]);
        
        }elseif(isset($_POST['tipo'], $_POST['periodo'])){
            return redirect('home')->with(['periodo' =>  $periodo ,'tipo' =>  $tipo]);
        
        }elseif(isset($_POST['tipo'], $_POST['avalia'])){
            return redirect('home')->with(['avalia' =>  $avalia ,'tipo' =>  $tipo]);
        
        }elseif(isset($_POST['periodo'], $_POST['avalia'])){
            return redirect('home')->with(['periodo' =>  $periodo ,'avalia' =>  $avalia]);
            
        }elseif(isset($_POST['tipo'])){
            return redirect('home')->with(['tipo' =>  $tipo]);
        
        }elseif(isset($_POST['periodo'])){
            return redirect('home')->with(['periodo' =>  $periodo]);
        
        }elseif(isset($_POST['avalia'])){
            return redirect('home')->with(['avalia' =>  $avalia]);
        }else{
            echo "ERRO";
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
    
    public function cria(Request $request)
    {
        $db_config = Config::get('database.connections.'.Config::get('database.default'));
        $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
        mysqli_set_charset($conn, 'utf8');

        $id = $_POST['id_usuario'];
        $title = $_POST['titulo'];
        $descri = $_POST['descricao'];
        $categoria = $_POST['categoria'];

        $sql = "INSERT INTO postagens (id_usuarios, id_situacao_postagem, id_categoria, titulo_postagem, descricao_postagem, data_postagem) VALUES ('$id', 2, '$categoria', '$title', '$descri', NOW())";
        mysqli_query($conn, $sql);

        $sql = "SELECT * FROM postagens WHERE id_usuarios = $id ORDER BY id_postagem DESC";
        $result = mysqli_query($conn, $sql);
        if($row = mysqli_fetch_assoc($result)){
            $id_postagem = $row['id_postagem'];
        }
        
        if($_FILES['img_post']['error'] == 0){
            $img_post = DB::table('postagens')
                        ->where('id_postagem', $id_postagem)
                        ->get();  
            $extenstion = $request->img_post->extension();          
            $Filename = 'ToDo/storage/app/public/posts/'.'1'.$img_post[0]->id_postagem.Str::kebab($img_post[0]->titulo_postagem).'.'.$extenstion;
            $sql = "INSERT INTO img_postagem (id_postagem, img_post) VALUES ('$id_postagem', '$Filename')";            
            mysqli_query($conn, $sql);
            $codFile = '1'.$img_post[0]->id_postagem.Str::kebab($img_post[0]->titulo_postagem);
            $nameFile = "{$codFile}.{$extenstion}";
            
            $upload = $request->img_post->storeAs('posts', $nameFile);

        }
        if($_FILES['img_post2']['error'] == 0){
            $img_post = DB::table('postagens')
                        ->where('id_postagem', $id_postagem)
                        ->get();
            $extenstion = $request->img_post2->extension();
            $Filename2 = 'ToDo/storage/app/public/posts/'.'2'.$img_post[0]->id_postagem.Str::kebab($img_post[0]->titulo_postagem).'.'.$extenstion;
            $sql = "INSERT INTO img_postagem (id_postagem, img_post) VALUES ('$id_postagem', '$Filename2')";
            mysqli_query($conn, $sql);

            $codFile = '2'.$img_post[0]->id_postagem.Str::kebab($img_post[0]->titulo_postagem);
            $extenstion = $request->img_post2->extension();
            $nameFile = "{$codFile}.{$extenstion}";
            
            $upload = $request->img_post2->storeAs('posts', $nameFile);
        }
        if($_FILES['img_post3']['error'] == 0){
            $img_post = DB::table('postagens')
                        ->where('id_postagem', $id_postagem)
                        ->get();
            $extenstion = $request->img_post3->extension();
            $Filename3 = 'ToDo/storage/app/public/posts/'.'3'.$img_post[0]->id_postagem.Str::kebab($img_post[0]->titulo_postagem).'.'.$extenstion;
            $sql = "INSERT INTO img_postagem (id_postagem, img_post) VALUES ('$id_postagem', '$Filename3')";
            mysqli_query($conn, $sql);

            $codFile = '3'.$img_post[0]->id_postagem.Str::kebab($img_post[0]->titulo_postagem);
            $extenstion = $request->img_post3->extension();
            $nameFile = "{$codFile}.{$extenstion}";
            
            $upload = $request->img_post3->storeAs('posts', $nameFile);
        }

        return redirect('home');
    }

    public function apagar_post()
    {   
        $db_config = Config::get('database.connections.'.Config::get('database.default'));
        $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
        mysqli_set_charset($conn, 'utf8');

        $id = $_POST['id_postagem'];
        $filename = $_POST['filename'];

        $sql = "DELETE FROM check_denuncia WHERE id_postagem = $id";
        mysqli_query($conn, $sql);

        $sql = "DELETE FROM denuncias WHERE id_postagem = $id";
        mysqli_query($conn, $sql);

        $query = "SELECT * FROM comentarios WHERE id_postagem = $id";
        $result = mysqli_query($conn, $query);
        while($rows = mysqli_fetch_assoc($result)){
            $id_com = $rows['id_comentarios'];
            $sql = "DELETE FROM check_denuncia_comentarios WHERE id_comentario = $id_com";
            mysqli_query($conn, $sql);
        }

        $query = "SELECT * FROM comentarios WHERE id_postagem = $id";
        $result = mysqli_query($conn, $query);
        while($rows = mysqli_fetch_assoc($result)){
            $id_com = $rows['id_comentarios'];
            $sql = "DELETE FROM denuncias_comentarios WHERE id_comentario = $id_com";
            mysqli_query($conn, $sql);
        }
        
        $query3 = "SELECT * FROM comentarios WHERE id_postagem = $id";
        $result3 = mysqli_query($conn, $query3);
        while($rows = mysqli_fetch_assoc($result3)){
            $id_com = $rows['id_comentarios'];
            $sql = "DELETE FROM like_comentarios WHERE id_comentarios = $id_com";
            mysqli_query($conn, $sql);
        }

        $sql = "DELETE FROM comentarios WHERE id_postagem = $id";
        mysqli_query($conn, $sql);

        $sql = "DELETE FROM avaliacao_postagem WHERE id_postagem = $id";
        mysqli_query($conn, $sql);

        storage::disk('public')->delete("posts/1$filename.png");
        storage::disk('public')->delete("posts/2$filename.png");
        storage::disk('public')->delete("posts/3$filename.png");
        storage::disk('public')->delete("posts/1$filename.jpg");
        storage::disk('public')->delete("posts/2$filename.jpg");
        storage::disk('public')->delete("posts/3$filename.jpg");

        $sql = "DELETE FROM img_postagem WHERE id_postagem = $id";
        mysqli_query($conn, $sql);

        $sql = "DELETE FROM like_postagens WHERE id_postagens = $id";
        mysqli_query($conn, $sql);

        $sql = "DELETE FROM postagens WHERE id_postagem = $id";
        mysqli_query($conn, $sql);

        if($_POST['identificador'] == 1) {
            return redirect('conta'); 
        }else {
            return redirect('home'); 
        }
    }

    public function denunciar_post()
    {   
        $db_config = Config::get('database.connections.'.Config::get('database.default'));
        $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
        mysqli_set_charset($conn, 'utf8');

        $motivo = $_POST['option'];
        $id = $_POST ['id_postagem'];
        $id2 = $_POST ['id_usuario'];
        
        $sql = "SELECT * FROM check_denuncia WHERE id_postagem = $id AND id_usuario = $id2";
        $result = mysqli_query($conn, $sql);
        $check = mysqli_num_rows($result);//consulta se ja existe esse like

        if($check == 0){
            $sql = "INSERT INTO check_denuncia (id_postagem, id_usuario) VALUES ($id, $id2)";
            mysqli_query($conn, $sql);

            $sql = "INSERT INTO denuncias (id_denuncia, id_postagem, id_motivo) VALUES ($id ,$id, $motivo) ON DUPLICATE KEY UPDATE id_motivo = $motivo , quantidade = quantidade + 1";
            mysqli_query($conn, $sql);

            $denuncia = 1;
        }else{
            $denuncia = 2;
        }
        
        return back()->with(['denuncia' =>  $denuncia]);
    }
    public function denunciar_comentario()
    {   
        $db_config = Config::get('database.connections.'.Config::get('database.default'));
        $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
        mysqli_set_charset($conn, 'utf8');

        $motivo = $_POST['option'];
        $id = $_POST ['id_comentario'];
        $id2 = $_POST ['id_usuario'];
        
        $sql = "SELECT * FROM check_denuncia_comentarios WHERE id_comentario = $id AND id_usuario = $id2";
        $result = mysqli_query($conn, $sql);
        $check = mysqli_num_rows($result);//consulta se ja existe esse like

        if($check == 0){
            $sql = "INSERT INTO check_denuncia_comentarios (id_comentario, id_usuario) VALUES ($id, $id2)";
            mysqli_query($conn, $sql);

            $sql = "INSERT INTO denuncias_comentarios (id_denunciacomentario, id_comentario, id_motivo) VALUES ($id ,$id, $motivo) ON DUPLICATE KEY UPDATE id_motivo = $motivo , quantidade = quantidade + 1";
            mysqli_query($conn, $sql);

            $denuncia = 1;
        }else{
            $denuncia = 2;
        }
        
        return back()->with(['denuncia' =>  $denuncia]);
    }

    public function like_post(Request $request) {
        $db_config = Config::get('database.connections.'.Config::get('database.default'));
        $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
        mysqli_set_charset($conn, 'utf8');

        $id_user = Auth::user()->id;
        if(isset($request->post_id)) {
            $post_id = $request->post_id;
            $action = $request->action;

            switch($action){
                case 'like':
                    $sql = "SELECT * FROM like_postagens WHERE id_postagens = $post_id AND id_usuarios = $id_user";
                    $result = mysqli_query($conn, $sql);
                    $check = mysqli_num_rows($result);//consulta se ja existe esse like

                    if($check == 0){
                        $sql = "INSERT INTO like_postagens (id_postagens, id_usuarios) values ($post_id, $id_user)";
                        $sql1 = "UPDATE postagens SET likes_postagem = likes_postagem + 1 WHERE id_postagem = $post_id";
                        break;
                    }//executa se não ouver like do usuario nesse post
                case 'unlike':
                    $sql = "DELETE FROM like_postagens WHERE id_usuarios = $id_user AND id_postagens = $post_id";
                    
                    $sql1 = "UPDATE postagens SET likes_postagem = (SELECT COUNT(id_like) FROM like_postagens WHERE id_postagens = $post_id) 
                    WHERE id_postagem = $post_id";
                    break;
                default:
                    break;
            }

            mysqli_query($conn, $sql);
            mysqli_query($conn, $sql1);

            $sql_count = "SELECT likes_postagem from postagens where id_postagem = $post_id";
            $count_likes = mysqli_query($conn, $sql_count);
            $likes = mysqli_fetch_array($count_likes);

            $rating = [
                'likes' => $likes[0]
            ];

            echo json_encode($rating);

        }
    }
}