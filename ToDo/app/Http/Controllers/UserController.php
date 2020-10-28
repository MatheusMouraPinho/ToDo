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

            'posts' => DB::table('postagens')
                    ->join('categoria_postagem','categoria_postagem.id_categoria', '=', 'postagens.id_categoria' )
                    ->join('situacao_postagem','situacao_postagem.id_situacao_postagem', '=', 'postagens.id_situacao_postagem' )
                    ->where('id_usuarios', $user_id)
                    ->select('categoria_postagem.*', 'postagens.*', 'situacao_postagem.*')
                    ->orderBy('postagens.id_postagem', 'asc')
                    ->get(),

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

            'img_post' => DB::table('img_postagem')
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
                            ->select('img_postagem.id_postagem')
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

                'area' => DB::table('area_estudo')
                                    ->where('id_area', $dados_usr->id_area)
                                    ->value('nome_area'),

                'uf' => DB::select('SELECT uf_regiao_estado from regiao_estado where id_regiao_estado = (
                    SELECT id_estado from regiao_cidade where id_regiao_cidade = :cidade
                    )' , ['cidade' => $dados_usr->id_regiao_cidade]),

                'img_perfil' => $dados_usr->img_usuarios,

                'img_capa' => $dados_usr->img_capa,

                'posts' => DB::table('postagens')
                        ->join('categoria_postagem','categoria_postagem.id_categoria', '=', 'postagens.id_categoria' )
                        ->join('situacao_postagem','situacao_postagem.id_situacao_postagem', '=', 'postagens.id_situacao_postagem' )
                        ->where('id_usuarios', $dados_usr->id)
                        ->select('categoria_postagem.*', 'postagens.*', 'situacao_postagem.*')
                        ->orderBy('postagens.id_postagem', 'asc')
                        ->get(),

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

                'img_post' => DB::table('img_postagem')
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
                                    ->select('img_postagem.id_postagem')
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

        if($data['id_instituicao'] === null)
            unset($data['id_instituicao']);

        if($data['id_area'] === null)
            unset($data['id_area']);

        if($data['id_regiao_cidade'] === null)
            unset($data['id_regiao_cidade']);

        if($data['id_regiao_estado'] === null)
            unset($data['id_regiao_cidade']);
    /*
        if ($data['senha'] != null)
            $data['senha'] = bcrypt($data['senha']);
        else 
            unset($data['senha']);
    */


        $data['img_usuarios'] = $user->img_usuarios;
        if($request->hasFile('img_usuarios') && $request->file('img_usuarios')->isValid()) {
            if($user->img_usuarios)
                $name = $user->img_usuarios;
            else
                $name = $user->id.Str::kebab($user->usuario);
            
            $extenstion = $request->img_usuarios->extension();
            $nameFile = "{$name}.{$extenstion}";

            $data['img_usuarios'] = $nameFile;

            $upload = $request->img_usuarios->storeAs('users', $nameFile);

            Storage::disk('public')->delete('users/'.Auth::user()->img_usuarios);

            if(!$upload)
                return redirect()
                                ->back()
                                ->with('error', 'Erro ao fazer upload de imagem');
        }

        $data['img_capa'] = $user->img_capa;
        if($request->hasFile('img_capa') && $request->file('img_capa')->isValid()) {
            if($user->img_capa)
                $name = $user->img_capa;
            else
                $name = $user->id.Str::kebab($user->usuario);
            
            $extenstion = $request->img_capa->extension();
            $nameFile = "{$name}.{$extenstion}";

            $data['img_capa'] = $nameFile;

            $upload = $request->img_capa->storeAs('users_capa', $nameFile);

            Storage::disk('public')->delete('users_capa/'.Auth::user()->img_capa);

            if(!$upload)
                return redirect()
                                ->back()
                                ->with('error', 'Erro ao fazer upload de imagem');
        }

        //dd($data);

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
}
