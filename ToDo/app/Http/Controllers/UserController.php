<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    
      

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;        
        $user_instituicao = Auth::user()->id_instituicao;
        $user_cidade = Auth::user()->id_regiao_cidade;
        $user_area = Auth::user()->id_area;
        $dados = [
            'id' => $user_id,
            'nome' => Auth::user()->usuario,
            'email' => Auth::user()->email,
            'rgm' => Auth::user()->registro,
            'telefone' => Auth::user()->telefone_usuario,
            'instituicao' => DB::table('instituicao_ensino')
                                ->where('id_instituicao', $user_instituicao)
                                ->value('nome_instituicao'),

            'cidade' => DB::table('regiao_cidade')
                                ->where('id_regiao_cidade', $user_cidade)
                                ->value('nome_cidade'),

            'estado' => DB::select('SELECT nome_estado, id_regiao_estado from regiao_estado where id_regiao_estado = (
                SELECT id_estado from regiao_cidade where id_regiao_cidade = :cidade
                )' , ['cidade' => $user_cidade]),

            'estados' => DB::table('regiao_estado')
                            ->select('nome_estado', 'id_regiao_estado')
                            ->get(),

            'area' => DB::table('area_estudo')
                                ->where('id_area', $user_area)
                                ->value('nome_area'),

            'uf' => DB::select('SELECT uf_regiao_estado from regiao_estado where id_regiao_estado = (
                SELECT id_estado from regiao_cidade where id_regiao_cidade = :cidade
                )' , ['cidade' => $user_cidade]),

            'img_perfil' => Auth::user()->img_usuarios,

            'img_capa' => Auth::user()->img_capa,

            'date' => DB::table('postagens')
                    ->where('id_usuarios', $user_id)
                    ->pluck('data_postagem'),

            'avaliador' => DB::table('postagens')
                        ->join('avaliacao_postagem', 'postagens.id_postagem', '=', 'avaliacao_postagem.id_postagem')
                        ->where('id_usuario', $user_id)
                        ->join('usuarios', 'usuarios.id', '=', 'avaliacao_postagem.id_avaliador')
                        ->select('usuarios.*')
                        ->get(),

            'cidades' => DB::table('regiao_cidade')
                        ->where('id_estado', Auth::user()->id_regiao_estado)
                        ->orderBy('nome_cidade' ,'asc')
                        ->get(),
           

            'instituicoes' => DB::table('instituicao_ensino')
                            ->select('nome_instituicao', 'id_instituicao')
                            ->orderBy('nome_instituicao', 'asc')
                            ->get(),

            'areas' => DB::table('area_estudo')
                        ->select('id_area', 'nome_area')
                        ->orderBy('nome_area', 'asc')
                        ->get(),

            'img_post' => DB::table('img_postagem'),

            'show_registro' => DB::table('usuarios')
                            ->where('id', $user_id)
                            ->value('show_registro'),

            'show_email' => DB::table('usuarios')
                            ->where('id', $user_id)
                            ->value('show_email'),

        ];
        

        $post = [  
            
            
            'avaliacao' => DB::table('postagens')
                            ->join('avaliacao_postagem', 'postagens.id_postagem', '=', 'avaliacao_postagem.id_postagem')
                            ->where('postagens.id_usuarios', $user_id)
                            ->join('comentarios', 'comentarios.id_avaliacao', 'avaliacao_postagem.id_avaliacao')
                            ->select('avaliacao_postagem.*', 'postagens.id_usuarios', 'postagens.id_postagem', 'comentarios.*')
                            ->get(),

            'mencionado' => DB::table('comentarios')
                                ->leftJoin('usuarios as user', 'comentarios.id_mencionado', '=', 'user.id') 
                                ->join('postagens', 'postagens.id_postagem', '=', 'comentarios.id_postagem')
                                ->where('postagens.id_usuarios', $user_id, 'and')
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

        
        
        
        return view('conta', compact('dados', 'post'));
    }


    public function perfil() {
        $_SESSION['id_usuario'] = $_GET['id_usuario'];
        $id_usuario = $_SESSION['id_usuario'];
        $dados_user = DB::table('usuarios')
                    ->where('id', $id_usuario)
                    ->get();
        

        foreach($dados_user as $dados_usr) {

            $dados = [
                'id' => $dados_usr->id,
                'nome' => $dados_usr->usuario,
                'email' => $dados_usr->email,
                'rgm' => $dados_usr->registro,
                'telefone' => $dados_usr->telefone_usuario,
                'instituicao' => DB::table('instituicao_ensino')
                                    ->where('id_instituicao', $dados_usr->id_instituicao)
                                    ->value('nome_instituicao'),

                'cidade' => DB::table('regiao_cidade')
                                    ->where('id_regiao_cidade',$dados_usr->id_regiao_cidade)
                                    ->value('nome_cidade'),

                'estado' => DB::select('SELECT nome_estado, id_regiao_estado from regiao_estado where id_regiao_estado = (
                                    SELECT id_estado from regiao_cidade where id_regiao_cidade = :cidade
                                    )' , ['cidade' => $dados_usr->id_regiao_cidade]),
                    
                'estados' => DB::table('regiao_estado')
                                    ->select('nome_estado', 'id_regiao_estado')
                                    ->get(),

                'area' => DB::table('area_estudo')
                                    ->where('id_area', $dados_usr->id_area)
                                    ->value('nome_area'),

                'uf' => DB::select('SELECT uf_regiao_estado from regiao_estado where id_regiao_estado = (
                    SELECT id_estado from regiao_cidade where id_regiao_cidade = :cidade
                    )' , ['cidade' => $dados_usr->id_regiao_cidade]),

                'img_perfil' => $dados_usr->img_usuarios,

                'img_capa' => $dados_usr->img_capa,

                'date' => DB::table('postagens')
                        ->where('id_usuarios', $dados_usr->id)
                        ->pluck('data_postagem'),

                'avaliador' => DB::table('postagens')
                            ->join('avaliacao_postagem', 'postagens.id_postagem', '=', 'avaliacao_postagem.id_postagem')
                            ->where('id_usuario', $dados_usr->id)
                            ->join('usuarios', 'usuarios.id', '=', 'avaliacao_postagem.id_avaliador')
                            ->select('usuarios.*')
                            ->get(),

                'cidades' => DB::table('regiao_cidade')
                                ->select('nome_cidade', 'id_regiao_cidade')
                                ->orderBy('nome_cidade' ,'asc')
                                ->get(),

                'instituicoes' => DB::table('instituicao_ensino')
                                ->select('nome_instituicao', 'id_instituicao')
                                ->orderBy('nome_instituicao', 'asc')
                                ->get(),

                'areas' => DB::table('area_estudo')
                            ->select('id_area', 'nome_area')
                            ->orderBy('nome_area', 'asc')
                            ->get(),

                'img_post' => DB::table('img_postagem'),

                'show_registro' => DB::table('usuarios')
                            ->where('id', $dados_usr->id)
                            ->value('show_registro'),

                'show_email' => DB::table('usuarios')
                            ->where('id', $dados_usr->id)
                            ->value('show_email'),
            ];

            $post = [                
                'avaliacao' => DB::table('postagens')
                                ->join('avaliacao_postagem', 'postagens.id_postagem', '=', 'avaliacao_postagem.id_postagem')
                                ->where('id_usuario', $dados_usr->id)
                                ->join('comentarios', 'comentarios.id_avaliacao', 'avaliacao_postagem.id_avaliacao')
                                ->select('avaliacao_postagem.*', 'postagens.id_usuarios', 'postagens.id_postagem', 'comentarios.*')
                                ->get(),

                'mencionado' => DB::table('comentarios')
                                    ->leftJoin('usuarios as user', 'comentarios.id_mencionado', '=', 'user.id') 
                                    ->join('postagens', 'postagens.id_postagem', '=', 'comentarios.id_postagem')
                                    ->where('postagens.id_usuarios', $dados_usr->id, 'and')
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
        }

        if($id_usuario == Auth::user()->id) {
            return view('conta', compact('dados', 'post'));
        }

        return view('perfil', compact('dados', 'post'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->all();

        if(isset($data['show_registro'])) {
          $data['show_registro'] = true;
        }else {
            $data['show_registro'] = false;
        }

        if(isset($data['show_email'])) {
            $data['show_email'] = true;
        }else {
            $data['show_email'] = false;
        }

        unset($data['senha']);
        unset($data['img_capa']);
        unset($data['img_usuarios']);

        if($data['id_instituicao'] === null)
            unset($data['id_instituicao']);

        if($data['id_area'] === null)
            unset($data['id_area']);

        if($data['id_regiao_cidade'] === null)
            unset($data['id_regiao_cidade']);

        if($data['id_regiao_estado'] === null)
            unset($data['id_regiao_cidade']);


        $update = $user->update($data);

        if($update)
            return redirect()
                        ->route('conta')
                        ->with('success', 'Sucesso ao atualizar!');
            
        return redirect()
                    ->back()
                    ->with('error', 'Erro ao atualizar perfil!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_perfil()
    {
        $user = Auth::user()->id;

        $search = DB::table('usuarios')
                        ->where('id', $user)
                        ->pluck('img_usuarios');

        $delete = Storage::disk('public')->delete('users/'.Auth::user()->img_usuarios);

        $remove = DB::table('usuarios')
                            ->where('id', $user)
                            ->update(['img_usuarios' => null]);

        if($remove)
            return redirect()
                        ->route('conta');

        if($search[0] === null)
            return redirect()
                    ->route('conta')
                    ->with('error', 'O usuário não tem foto para apagar!');
    }

    public function destroy_capa()
    {
        $user = Auth::user()->id;

        $search = DB::table('usuarios')
                        ->where('id', $user)
                        ->pluck('img_capa');

        $delete = Storage::disk('public')->delete('users_capa/'.Auth::user()->img_capa);
        
        $remove = DB::table('usuarios')
                            ->where('id', $user)
                            ->update(['img_capa' => null]);

        if($remove)
            return redirect()
                        ->route('conta');

        if($search[0] === null)
            return redirect()
                    ->route('conta')
                    ->with('error', 'O usuário não tem capa para apagar!');
    }

    public function buscar_cidades(Request $request) {
        $id_estado = $request->id_estado;
        $buscando = [
            DB::table('regiao_cidade')
                ->where('id_estado', $id_estado)
                ->select('nome_cidade', 'id_regiao_cidade')
                ->orderBy('nome_cidade','asc')
                ->get()
        ];

        echo json_encode($buscando);
    }

    public function solicitacao(Request $request) {
        $data = $request->all();

        $insert = DB::insert('insert into solicitacoes (
            tipo_solicitacao,
            usuario_solicitacao,
            conteudo_solicitacao,
            status_solicitacao
        ) values (?, ?, ?, ?)', [$data['motivo'], $data['id_usuario'], $data['conteudo_solicitacao'], 3]);

        $nav_selected = $data['nav_selected']; 
        $success = 'Solicitação enviada com sucesso!';

        if(!$insert){
            return redirect()
                    ->route('conta')
                    ->with('error', 'Erro ao enviar solicitação!');
        } else {
            return redirect()
                    ->route('conta')
                    ->with(compact('success', 'nav_selected'));
        }
    }

    public function order_post() {
        if(isset($_POST['ordenar_post'])){
            if($_POST['ordenar_post'] == 'Recentes') {
                $filtro_post = 'data_postagem';
                $selected_post = '1';

            } elseif ($_POST['ordenar_post'] == 'Populares') {
                $filtro_post = 'likes_postagem';
                $selected_post = '2'; 
            } elseif ($_POST['ordenar_post'] == 'Avaliados') {
                $filtro_post = '1';
                $selected_post = '3'; 
            }elseif ($_POST['ordenar_post'] == 'Pendentes') {
                $filtro_post = '2';
                $selected_post = '4'; 
            }
        }

        
        
        return back()->with(compact('filtro_post', 'selected_post'));
    }

    public function order_solicitacao() {
        if(isset($_POST['ordenar_solicit'])){
            if($_POST['ordenar_solicit'] == 'Recentes') {
                $filtro_solicit = 'data_solicitacao';
                $selected_solicit = '1';

            } elseif ($_POST['ordenar_solicit'] == 'Aprovadas') {
                $filtro_solicit = '1';
                $selected_solicit = '2'; 
            } elseif ($_POST['ordenar_solicit'] == 'Recusadas') {
                $filtro_solicit = '2';
                $selected_solicit = '3'; 
            }elseif ($_POST['ordenar_solicit'] == 'Pendentes') {
                $filtro_solicit = '3';
                $selected_solicit = '4'; 
            }
        }
        $nav_selected = $_POST['nav_selected'];        
        
        return back()->with(compact('filtro_solicit', 'selected_solicit', 'nav_selected'));
    }

    public function order_post_perfil() {
        if(isset($_POST['ordenar_post'])){
            if($_POST['ordenar_post'] == 'Recentes') {
                $filtro_post_perfil = 'data_postagem';
                $selected_post_perfil = '1';

            } elseif ($_POST['ordenar_post'] == 'Populares') {
                $filtro_post_perfil = 'likes_postagem';
                $selected_post_perfil = '2'; 
            } elseif ($_POST['ordenar_post'] == 'Avaliados') {
                $filtro_post_perfil = '1';
                $selected_post_perfil = '3'; 
            }elseif ($_POST['ordenar_post'] == 'Pendentes') {
                $filtro_post_perfil = '2';
                $selected_post_perfil = '4'; 
            }
        }   
        
        return back()->with(compact('filtro_post_perfil', 'selected_post_perfil'));
    }

    public function order_solicitacao_perfil() {
        if(isset($_POST['ordenar_solicit'])){
            if($_POST['ordenar_solicit'] == 'Recentes') {
                $filtro_solicit_perfil = 'data_solicitacao';
                $selected_solicit_perfil = '1';

            } elseif ($_POST['ordenar_solicit'] == 'Aprovadas') {
                $filtro_solicit_perfil = '1';
                $selected_solicit_perfil = '2'; 
            } elseif ($_POST['ordenar_solicit'] == 'Recusadas') {
                $filtro_solicit_perfil = '2';
                $selected_solicit_perfil = '3'; 
            }elseif ($_POST['ordenar_solicit'] == 'Pendentes') {
                $filtro_solicit_perfil = '3';
                $selected_solicit_perfil = '4'; 
            }
        }
        $nav_selected_perfil = $_POST['nav_selected'];    
        
        return back()->with(compact('filtro_solicit_perfil', 'selected_solicit_perfil', 'nav_selected_perfil'));
    }

    public function cropp_image() {
        if(isset($_POST['image']))
        {
            $data = $_POST['image'];

            $user = Auth::user();

            $name = $user->id.Str::kebab($user->usuario).'.png';

            Storage::disk('public')->delete('users/'.$name);

            $nameFile = "ToDo/storage/app/public/users/$name";

            $fileName = $name;

            $image_array_1 = explode(";", $data);

            $image_array_2 = explode(",", $image_array_1[1]);

            $data = base64_decode($image_array_2[1]);

            $data_uploaded = file_put_contents($nameFile, $data);

            $insert = DB::update('update usuarios set img_usuarios = ? where id = ?', [$name, $user->id]);

            return $nameFile;
        }
    }

    public function cropp_image_capa() {
        if(isset($_POST['image']))
        {
            $data = $_POST['image'];

            $user = Auth::user();

            $name = $user->id.Str::kebab($user->usuario).'.png';

            Storage::disk('public')->delete('users_capa/'.$name);

            $nameFile = "ToDo/storage/app/public/users_capa/$name";

            $fileName = $name;

            $image_array_1 = explode(";", $data);

            $image_array_2 = explode(",", $image_array_1[1]);

            $data = base64_decode($image_array_2[1]);

            $data_uploaded = file_put_contents($nameFile, $data);

            $upload = DB::update('update usuarios set img_capa = ? where id = ?', [$name, $user->id]);

            return $nameFile;
        }
    }
}
