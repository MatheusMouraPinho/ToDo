<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
        $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
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
            $img = addslashes(file_get_contents($_FILES['img_post']['tmp_name']));
            $img_post = DB::table('postagens')
                        ->where('id_postagem', $id_postagem)
                        ->get();            
            $sql = "INSERT INTO img_postagem (id_postagem, img_post) VALUES ('$id_postagem', '$img')";            
            mysqli_query($conn, $sql);

            $codFile = '1'.$img_post[0]->id_postagem.Str::kebab($img_post[0]->titulo_postagem);
            $extenstion = $request->img_post->extension();
            $nameFile = "{$codFile}.{$extenstion}";
            
            $upload = $request->img_post->storeAs('posts', $nameFile);

        }
        if($_FILES['img_post2']['error'] == 0){
            $img2 = addslashes(file_get_contents($_FILES['img_post2']['tmp_name']));
            $img_post = DB::table('postagens')
                        ->where('id_postagem', $id_postagem)
                        ->get();
            $sql = "INSERT INTO img_postagem (id_postagem, img_post) VALUES ('$id_postagem', '$img2')";
            mysqli_query($conn, $sql);

            $codFile = '2'.$img_post[0]->id_postagem.Str::kebab($img_post[0]->titulo_postagem);
            $extenstion = $request->img_post2->extension();
            $nameFile = "{$codFile}.{$extenstion}";
            
            $upload = $request->img_post2->storeAs('posts', $nameFile);
        }
        if($_FILES['img_post3']['error'] == 0){
            $img3 = addslashes(file_get_contents($_FILES['img_post3']['tmp_name']));
            $img_post = DB::table('postagens')
                        ->where('id_postagem', $id_postagem)
                        ->get();
            $sql = "INSERT INTO img_postagem (id_postagem, img_post) VALUES ('$id_postagem', '$img3')";
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
        $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
        mysqli_set_charset($conn, 'utf8');

        $id = $_POST['id_postagem'];

        $sql = "DELETE FROM denuncias WHERE id_postagem = $id";
        mysqli_query($conn, $sql);

        $query = "SELECT * FROM comentarios WHERE id_postagem = $id";
        $result = mysqli_query($conn, $query);
        while($rows = mysqli_fetch_assoc($result)){
            $id_com = $rows['id_comentarios'];
            $sql = "DELETE FROM denuncias_comentarios WHERE id_comentario = $id_com";
            mysqli_query($conn, $sql);
        }

        $sql = "DELETE FROM avaliacao_postagem WHERE id_postagem = $id";
        mysqli_query($conn, $sql);
        
        $query3 = "SELECT * FROM comentarios WHERE id_postagem = $id";
        $result3 = mysqli_query($conn, $query3);
        while($rows = mysqli_fetch_assoc($result3)){
            $id_com = $rows['id_comentarios'];
            $sql = "DELETE FROM like_comentarios WHERE id_comentarios = $id_com";
            mysqli_query($conn, $sql);
        }

        $sql = "DELETE FROM comentarios WHERE id_postagem = $id";
        mysqli_query($conn, $sql);

        $sql = "DELETE FROM img_postagem WHERE id_postagem = $id";
        mysqli_query($conn, $sql);

        $sql = "DELETE FROM postagens WHERE id_postagem = $id";
        mysqli_query($conn, $sql);

        return redirect('home'); 
    }

    public function denunciar_post()
    {   
        $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
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

            $sql = "INSERT INTO denuncias (id_denuncia, id_postagem, id_motivo) VALUES ($id ,$id, $motivo) ON DUPLICATE KEY UPDATE quantidade = quantidade + 1";
            mysqli_query($conn, $sql);

            $denuncia = 1;
        }else{
            $denuncia = 2;
        }
        
        return back()->with(['denuncia' =>  $denuncia]);
    }
    public function denunciar_comentario()
    {   
        $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
        mysqli_set_charset($conn, 'utf8');

        $motivo = $_POST['option'];
        $id = $_POST ['id_comentario'];
        $id2 = $_POST ['id_usuario'];
        $id_postagem = $_POST['id_postagem'];
        
        $sql = "SELECT * FROM check_denuncia_comentarios WHERE id_comentario = $id AND id_usuario = $id2";
        $result = mysqli_query($conn, $sql);
        $check = mysqli_num_rows($result);//consulta se ja existe esse like

        if($check == 0){
            $sql = "INSERT INTO check_denuncia_comentarios (id_comentario, id_usuario) VALUES ($id, $id2)";
            mysqli_query($conn, $sql);

            $sql = "INSERT INTO denuncias_comentarios (id_denunciacomentario, id_comentario, id_motivo) VALUES ($id ,$id, $motivo) ON DUPLICATE KEY UPDATE quantidade = quantidade + 1";
            mysqli_query($conn, $sql);

            $denuncia = 1;
        }else{
            $denuncia = 2;
        }
        
        return back()->with(['denuncia' =>  $denuncia])->with(['id_postagem' => $id_postagem]);
    }
    public function like_post()
    {   
        $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
        mysqli_set_charset($conn, 'utf8');

        $id = $_POST['id_post'];
        $id2 = $_POST['id_usuario'];
        $id3 = $_POST['scroll'];

        $sql = "SELECT * FROM like_postagens WHERE id_postagens = $id AND id_usuarios = $id2";
        $result = mysqli_query($conn, $sql);
        $check = mysqli_num_rows($result);//consulta se ja existe esse like

        if($check == 0){
            $sql = "INSERT INTO like_postagens (id_postagens, id_usuarios) VALUES ($id, $id2)";
            mysqli_query($conn, $sql);

            $sql = "UPDATE postagens SET likes_postagem = likes_postagem + 1 WHERE id_postagem = $id";
            mysqli_query($conn, $sql);
        }//executa se não ouver like do usuario nesse post
        
        return redirect(url()->previous().'#scroll'. $id3);
    }
    public function remov_like_post()
    {   
        $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
        mysqli_set_charset($conn, 'utf8');
        
        $id = $_POST['id_post'];
        $id2 = $_POST['id_usuario'];
        $id3 = $_POST['scroll'];

        $sql = "DELETE FROM like_postagens WHERE id_postagens = $id AND id_usuarios = $id2";
        mysqli_query($conn, $sql);

        $sql = "UPDATE postagens SET likes_postagem = (SELECT COUNT(id_like) FROM like_postagens WHERE id_postagens = $id) WHERE id_postagem = $id";
        mysqli_query($conn, $sql);//subquery pra não dar update varias vezes

        return redirect(url()->previous().'#scroll'. $id3);
    }
}