<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use datetime;
use DB;
use Config;

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

            $id_postagem = $data['id_postagem'];

            if(!$insert)
                return redirect()
                                ->back()
                                ->with('error', 'Erro ao processar comentário');

            return back()->with('id_postagem', $id_postagem);
        }

        if(isset($data['conteudo'])) {
            $data['id_usuario'] = Auth::user()->id;
            $insert = DB::table('comentarios')->insert([
                [
                    'id_usuarios' => $data['id_usuario'],
                    'id_postagem' => $data['id_postagem'],
                    'conteudo_comentarios' => $data['conteudo'],
                    'data_comentarios' => $data['data_comentarios'],
                    'id_mencionado' => $data['id_mencionado'],
                    'id_comentarios_ref' => $data['id_coment']                    
                ]
            ]);

            $id_postagem = $data['id_postagem'];

            if(!$insert)
                return redirect()
                                ->back()
                                ->with('error', 'Erro ao processar comentário');

            return back()->with('id_postagem', $id_postagem);
        }
            
    }


    public function like(Request $request) {
        $db_config = Config::get('database.connections.'.Config::get('database.default'));
        $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
        mysqli_set_charset($conn, 'utf8');

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
    }

    public function ordenar() {
        if(isset($_POST['ordenar'])){
            if($_POST['ordenar'] == 'Recentes') {
                $filtro_coment = 'data_comentarios';
                $selected = 1;

            } elseif ($_POST['ordenar'] == 'Populares') {
                $filtro_coment = 'likes_comentarios';
                $selected = 2;
                
            }

            $id_postagem = $_POST['id_postagem'];
        }

        
        
        return back()->with(compact('filtro_coment', 'selected', 'id_postagem'));
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
                $edit = DB::table('comentarios')
                        ->where('id_comentarios', $data['id_coment'])
                        ->update(
                            [
                                'conteudo_comentarios' => $data['editcomentario'],
                                'edit_comentarios' => $data['data_comentarios']
                            ]
                        );
            
            $id_postagem = $data['id_postagem'];
            
            if(!$edit)
                        return redirect()
                                    ->back()
                                    ->with('error', 'Erro ao editar comentário');

            return back()->with('id_postagem', $id_postagem);
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
        
        if(!empty($id_comentario)){
            $search['id_comentario'] = DB::table('comentarios')
                                    ->where('id_comentarios_ref', $id_comentario)
                                    ->get();
            if($search['id_comentario'] != null) {
                for($c=0; $c<sizeof($search['id_comentario']); $c++) {
                    $delete_like = DB::delete('delete from like_comentarios where id_comentarios = ?', [$search['id_comentario'][$c]->id_comentarios]);
                }
            }
            $delete = DB::delete('delete from like_comentarios where id_comentarios = ?', [$id_comentario]);
            $deletando = DB::delete('delete from comentarios where id_comentarios = ?', [$id_comentario]);
            $deletando_ref = DB::delete('delete from comentarios where id_comentarios_ref = ?', [$id_comentario]);
        }

        $id_postagem = $id['id_postagem'];

        if(!$delete && !$deletando && !$deletando_ref && !$delete_like)
                        return redirect()
                                    ->back()
                                    ->with('error', 'Erro ao apagar comentário');

        return back()->with('id_postagem', $id_postagem);
    }
}
