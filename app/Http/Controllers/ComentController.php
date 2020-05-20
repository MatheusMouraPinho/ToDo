<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use datetime;
use DB;

class ComentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $datetime = new DateTime();
        $datetime->format('d-m-Y H:i:s');
        $data['data_comentarios'] = $datetime;
        if(isset($data['conteudo_comentarios'])) {
            $data['id_usuario'] = Auth::user()->id;
            $insert = DB::table('comentarios')->insert([
                [
                    'id_usuarios' => $data['id_usuario'],
                    'id_postagem' => $data['id_postagem'],
                    'conteudo_comentarios' => $data['conteudo_comentarios'],
                    'data_comentarios' => $data['data_comentarios']
                ]
            ]);

            if(!$insert)
                return redirect()
                                ->back()
                                ->with('error', 'Erro ao processar comentário');

            return back();
        }

        if(isset($data['conteudo'])) {
            $data['id_usuario'] = Auth::user()->id;
            $insert = DB::table('subcomentarios')->insert([
                [
                    'id_usuarios' => $data['id_usuario'],
                    'id_postagem' => $data['id_postagem'],
                    'conteudo_comentarios' => $data['conteudo'],
                    'id_comentarios' => $data['id_coment'],
                    'data_comentarios' => $data['data_comentarios'],
                    
                ]
            ]);

            if(!$insert)
                return redirect()
                                ->back()
                                ->with('error', 'Erro ao processar comentário');

            return back();
        }

        if(isset($data['id_resposta'])) {
            $data['id_usuario'] = Auth::user()->id;
            $insert = DB::table('subcomentarios')->insert([
                [
                    'id_usuarios' => $data['id_usuario'],
                    'id_postagem' => $data['id_postagem'],
                    'conteudo_comentarios' => $data['conteudo_resposta'],
                    'id_comentarios' => $data['id_coment'],
                    'data_comentarios' => $data['data_comentarios'],
                    'id_resposta' => $data['id_resposta']                        
                ]
            ]);

            if(!$insert)
                return redirect()
                                ->back()
                                ->with('error', 'Erro ao processar comentário');
                                
            return back(); 
        }
            
        

        

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $data = $request->all();
        if($data){
            $datetime = new DateTime();
            $datetime->format('d-m-Y H:i:s');
            $data['data_comentarios'] = $datetime;
            if(isset($data['editcomentario']))
                DB::table('comentarios')
                        ->where('id_comentarios', $data['id_coment'])
                        ->update(
                            [
                                'conteudo_comentarios' => $data['editcomentario'],
                                'edit_comentarios' => $data['data_comentarios']
                            ]
                        );
            else if(isset($data['editsubcomentario']))
                DB::table('subcomentarios')
                ->where('id_subcomentarios', $data['id_subcoment'])
                ->update(
                    [
                        'conteudo_comentarios' => $data['editsubcomentario'],
                        'edit_subcomentarios' => $data['data_comentarios']
                    ]
                );

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $id = request()->all();
        $id_comentario = $id['id_comentario'];
        

        if(!empty($id['id_subcomentario'])){
            $id_subcomentario = $id['id_subcomentario'];
            $delete = DB::delete('delete from like_comentarios where id_comentarios = ?', [$id_comentario]);
            $deletar = DB::delete('delete from subcomentarios where id_subcomentarios = ?', [$id_subcomentario]);
        }else{
            $delete = DB::delete('delete from like_comentarios where id_comentarios = ?', [$id_comentario]);
            $deletar = DB::delete('delete from subcomentarios where id_comentarios = ?', [$id_comentario]);
            $deletando = DB::delete('delete from comentarios where id_comentarios = ?', [$id_comentario]);
        }

        return back();
    }
}
