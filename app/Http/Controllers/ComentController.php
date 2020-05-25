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


    public function like(Request $request) {
        $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
        $id_user = Auth::user()->id;
        if(isset($request->coment_id)) {
            $coment_id = $request->coment_id;
            $action = $request->action;

            switch($action){
                case 'like':
                    $sql = "insert into like_comentarios(id_comentarios, id_usuarios)
                            values($coment_id, $id_user)";
                    $sql1 = "update comentarios set likes_comentarios = likes_comentarios+1 
                            where id_comentarios = $coment_id";
                    break;
                case 'unlike':
                    $sql = "delete from like_comentarios
                    where id_usuarios=$id_user and id_comentarios=$coment_id";
                    $sql1 = "update comentarios set likes_comentarios = likes_comentarios-1 
                    where id_comentarios = $coment_id";
                    break;
                default:
                    break;
            }

            mysqli_query($conn, $sql);
            mysqli_query($conn, $sql1);

            $sql_count = "select likes_comentarios from comentarios where id_comentarios = $coment_id";
            $count_likes = mysqli_query($conn, $sql_count);
            $likes = mysqli_fetch_array($count_likes);

            $rating = [
                'likes' => $likes[0]
            ];

            echo json_encode($rating);

        }

        else if(isset($request->subcoment_id)) {
            $subcoment_id = $request->subcoment_id;
            $action = $request->action;

            switch($action){
                case 'like':
                    $sql = "insert into like_subcomentarios(id_subcomentarios, id_usuarios)
                            values($subcoment_id, $id_user)";
                    $sql1 = "update subcomentarios set likes_comentarios = likes_comentarios+1 
                            where id_subcomentarios = $subcoment_id";
                    break;
                case 'unlike':
                    $sql = "delete from like_subcomentarios
                            where id_usuarios=$id_user and id_subcomentarios=$subcoment_id";
                    $sql1 = "update subcomentarios set likes_comentarios = likes_comentarios-1 
                            where id_subcomentarios = $subcoment_id";
                    break;
                default:
                    break;
            }

            mysqli_query($conn, $sql);
            mysqli_query($conn, $sql1);

            $sql_count = "select likes_comentarios from subcomentarios where id_subcomentarios = $subcoment_id";
            $count_likes = mysqli_query($conn, $sql_count);
            $likes = mysqli_fetch_array($count_likes);

            $rating = [
                'likes' => $likes[0]
            ];

            echo json_encode($rating);

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
            $delete = DB::delete('delete from like_subcomentarios where id_subcomentarios = ?', [$id_subcomentario]);
            $deletar = DB::delete('delete from subcomentarios where id_subcomentarios = ?', [$id_subcomentario]);
        }else{
            $procurando['id_subcomentario'] = DB::table('subcomentarios')
                            ->where('id_comentarios', $id_comentario)
                            ->get();
            if($procurando['id_subcomentario'] != null) {
                for($c=0; $c<sizeof($procurando['id_subcomentario']);$c++){
                    $procurando1['id_subcomentario'] = DB::table('like_subcomentarios')
                            ->where('id_subcomentarios', $procurando['id_subcomentario'][$c]->id_subcomentarios)
                            ->get();
                    if($procurando1['id_subcomentario'] != null){
                        $del_sublike = DB::delete('delete from like_subcomentarios where id_subcomentarios = ?', [$procurando['id_subcomentario'][$c]->id_subcomentarios]);
                    }
                }
            }
            $delete = DB::delete('delete from like_comentarios where id_comentarios = ?', [$id_comentario]);
            $deletar = DB::delete('delete from subcomentarios where id_comentarios = ?', [$id_comentario]);
            $deletando = DB::delete('delete from comentarios where id_comentarios = ?', [$id_comentario]);
        }

        return back();
    }
}
