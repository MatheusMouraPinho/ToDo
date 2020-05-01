<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;


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
                    ->where('id_usuarios', $user_id)
                    ->paginate(5),

            'date' => DB::table('postagens')
                    ->where('id_usuarios', $user_id)
                    ->pluck('data_postagem'),

            'categoria' => DB::table('categoria_postagem')
                        ->join('postagens','categoria_postagem.id_categoria', '=', 'postagens.id_categoria' )
                        ->where('id_usuarios', $user_id)
                        ->select('categoria_postagem.*', 'postagens.id_categoria')
                        ->get(),

            'situacao' => DB::table('situacao_postagem')
                        ->join('postagens','situacao_postagem.id_situacao_postagem', '=', 'postagens.id_situacao_postagem' )
                        ->where('id_usuarios', $user_id)
                        ->select('situacao_postagem.*', 'postagens.id_situacao_postagem')
                        ->get(),

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
                        ->get()
        ];

        //$situacao = $dados['situacao']->situacao_postagem;
        

        $post = [
            'situacao' => DB::table('situacao_postagem')
                                ->join('postagens','situacao_postagem.id_situacao_postagem', '=', 'postagens.id_situacao_postagem' )
                                ->select('situacao_postagem.*', 'postagens.id_situacao_postagem')
                                ->get(),
            'titulo' => DB::table('postagens')
                            ->where('id_usuarios', $dados['id'])
                            ->get(),
            'id' => DB::table('postagens')
                            ->where('id_usuarios', $user_id)
                            ->value('id_postagem'),
                
            'avaliacao' => DB::table('postagens')
                            ->join('avaliacao_postagem', 'postagens.id_postagem', '=', 'avaliacao_postagem.id_postagem')
                            ->where('id_usuario', $user_id)
                            ->select('avaliacao_postagem.*', 'postagens.id_usuarios', 'postagens.id_postagem')
                            ->get()
        ];

        //dd($dados['areas']);

        
        return view('conta', compact('dados', 'post'));
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
        $id = Auth::user()->id;
        return view('layouts.edit');
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

        if ($data['senha'] != null)
            $data['senha'] = bcrypt($data['senha']);
        else 
            unset($data['senha']);



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
