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

            'area' => DB::table('area_estudo')
                                ->where('id_area', $user_area)
                                ->value('nome_area'),

            'uf' => DB::select('SELECT uf_regiao_estado from regiao_estado where id_regiao_estado = (
                SELECT id_estado from regiao_cidade where id_regiao_cidade = :cidade
                )' , ['cidade' => $user_cidade]),

            'img' => Auth::user()->img_usuarios,

            'posts' => DB::table('postagens')
                    ->join('categoria_postagem','categoria_postagem.id_categoria', '=', 'postagens.id_categoria' )
                    ->join('situacao_postagem','situacao_postagem.id_situacao_postagem', '=', 'postagens.id_situacao_postagem' )
                    ->where('id_usuarios', $user_id)
                    ->select('categoria_postagem.*', 'postagens.*', 'situacao_postagem.*')
                    ->orderBy('postagens.id_postagem', 'asc')
                    ->paginate(5),

            'date' => DB::table('postagens')
                    ->where('id_usuarios', $user_id)
                    ->pluck('data_postagem'),

            'avaliador' => DB::table('postagens')
                        ->join('avaliacao_postagem', 'postagens.id_postagem', '=', 'avaliacao_postagem.id_postagem')
                        ->where('id_usuario', $user_id)
                        ->join('usuarios', 'usuarios.id', '=', 'avaliacao_postagem.id_avaliador')
                        ->select('usuarios.usuario')
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
                            ->where('id_usuario', $user_id)
                            ->select('avaliacao_postagem.*', 'postagens.id_usuarios', 'postagens.id_postagem')
                            ->get(),
            
            'comentarios' => DB::table('comentarios')
                                ->join('postagens', 'postagens.id_postagem', '=', 'comentarios.id_postagem')
                                ->where('postagens.id_usuarios', $user_id)
                                ->join('usuarios', 'comentarios.id_usuarios', '=', 'usuarios.id')
                                ->select('comentarios.*', 'postagens.id_usuarios', 'postagens.id_postagem', 'usuarios.*')
                                ->orderBy('comentarios.data_comentarios', 'desc')
                                ->get(),

            'reply_coment' => DB::table('subcomentarios')
                                ->join('postagens', 'postagens.id_postagem', '=', 'subcomentarios.id_postagem')
                                ->where('postagens.id_usuarios', $user_id)
                                ->where('subcomentarios.id_resposta', '=', null)
                                ->join('usuarios', 'subcomentarios.id_usuarios', '=', 'usuarios.id')
                                ->select('subcomentarios.*', 'postagens.id_usuarios', 'postagens.id_postagem', 'usuarios.*')
                                ->orderBy('subcomentarios.data_comentarios', 'desc')
                                ->get(),

            'reply_reply' => DB::table('subcomentarios')
                            ->where('id_resposta', '!=', null)
                            ->orderBy('subcomentarios.data_comentarios', 'desc')
                            ->get(),

        ];


        
        return view('conta', compact('dados', 'post'));
    }


    public function perfil(Request $request) {
        $data = $request->all();
        $dados_user = DB::table('usuarios')
                    ->where('id', $data['id_usuario'])
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

                'img' => $dados_usr->img_usuarios,

                'posts' => DB::table('postagens')
                        ->join('categoria_postagem','categoria_postagem.id_categoria', '=', 'postagens.id_categoria' )
                        ->join('situacao_postagem','situacao_postagem.id_situacao_postagem', '=', 'postagens.id_situacao_postagem' )
                        ->where('id_usuarios', $dados_usr->id)
                        ->select('categoria_postagem.*', 'postagens.*', 'situacao_postagem.*')
                        ->orderBy('postagens.id_postagem', 'asc')
                        ->paginate(5),

                'date' => DB::table('postagens')
                        ->where('id_usuarios', $dados_usr->id)
                        ->pluck('data_postagem'),

                'avaliador' => DB::table('postagens')
                            ->join('avaliacao_postagem', 'postagens.id_postagem', '=', 'avaliacao_postagem.id_postagem')
                            ->where('id_usuario', $dados_usr->id)
                            ->join('usuarios', 'usuarios.id', '=', 'avaliacao_postagem.id_avaliador')
                            ->select('usuarios.usuario')
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
                                ->select('avaliacao_postagem.*', 'postagens.id_usuarios', 'postagens.id_postagem')
                                ->get(),
                
                'comentarios' => DB::table('comentarios')
                                    ->join('postagens', 'postagens.id_postagem', '=', 'comentarios.id_postagem')
                                    ->where('postagens.id_usuarios', $dados_usr->id)
                                    ->join('usuarios', 'comentarios.id_usuarios', '=', 'usuarios.id')
                                    ->select('comentarios.*', 'postagens.id_usuarios', 'postagens.id_postagem', 'usuarios.*')
                                    ->orderBy('data_comentarios', 'desc')
                                    ->get(),
    
                'reply_coment' => DB::table('subcomentarios')
                                    ->join('postagens', 'postagens.id_postagem', '=', 'subcomentarios.id_postagem')
                                    ->where('postagens.id_usuarios', $dados_usr->id)
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
        }

        if($data['id_usuario'] == Auth::user()->id) {
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
    public function destroy($id)
    {
        //
    }
}
