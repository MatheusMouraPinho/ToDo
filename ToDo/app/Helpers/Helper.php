<?php

namespace App\Helpers;
use Auth;
use DB;
use Session;

class Helper
{
    public static function shout(string $string)
    {
        return strtoupper($string);
    }

    public static function tempo_corrido($time) {

        $now = strtotime(date('m/d/Y H:i:s'));
        $time = strtotime($time);
        $diff = $now - $time;
        
        $seconds = $diff;
        $minutes = round($diff / 60);
        $hours = round($diff / 3600);
        $days = round($diff / 86400);
        $weeks = round($diff / 604800);
        $months = round($diff / 2419200);
        $years = round($diff / 29030400);
        
        if ($seconds <= 60) return"Agora mesmo";
        else if ($minutes <= 60) return $minutes==1 ?'1 min':$minutes.' min';
        else if ($hours <= 24) return $hours==1 ?'1 hr':$hours.' hrs';
        else if ($days <= 7) return $days==1 ?'1 dia':$days.' dias';
        else if ($weeks <= 4) return $weeks==1 ?'1 sem':$weeks.' sem';
        else if ($months <= 12) return $months == 1 ?'1 mês':$months.' meses';
        else return $years == 1 ? '1 ano':$years.' anos';
    }

    public static function verifica_like_coment($id_comentario) {
        $id_usuario = Auth::user()->id;
        $resultado = DB::table('like_comentarios')
                ->where('id_comentarios', $id_comentario, 'and')
                ->where('id_usuarios', $id_usuario)
                ->value('id_likes');  
        
        $user_liked = (empty($resultado)) ? 0 : 1;
        return $user_liked;
    }

    
    public static function verifica_like_post($id_post) {
        $id_usuario = Auth::user()->id;
        $resultado = DB::table('like_postagens')
                ->where('id_postagens', $id_post, 'and')
                ->where('id_usuarios', $id_usuario)
                ->value('id_like');  
        
        $user_liked = (empty($resultado)) ? 0 : 1;
        return $user_liked;
    }
    
    public static function count_post($id_post) {
        $resultado = DB::table('comentarios')
                ->where('id_postagem', $id_post, 'and')
                ->where('id_comentarios_ref', null)
                ->count();  
        
        return $resultado;
    }

    public static function add_session($id_post) {
        $post_id = array('legal');
        array_push($post_id, $id_post);
        
        return $post_id;
    }

    public static function ordenar_post()
    {
        if(NULL !== Session::get('filtro_post')){$_SESSION['filtro_post'] = Session::get('filtro_post');}
        if(isset($_SESSION['filtro_post'])){$filtro_post = $_SESSION['filtro_post'];}
        if(!isset($filtro_post)){$filtro_post = "data_postagem";}

        

        if(NULL !== Session::get('selected_post')){$_SESSION['selected_post'] = Session::get('selected_post');}
        if(!isset($_SESSION['selected_post'])){$_SESSION['selected_post'] = '1';}
        

        $user_id = Auth::user()->id;

        if($_SESSION['selected_post'] == '4') {
            $post = DB::table('postagens')
            ->join('categoria_postagem','categoria_postagem.id_categoria', '=', 'postagens.id_categoria' )
            ->join('situacao_postagem','situacao_postagem.id_situacao_postagem', '=', 'postagens.id_situacao_postagem' )
            ->where('id_usuarios', $user_id)
            ->where('postagens.id_situacao_postagem', $filtro_post)
            ->select('categoria_postagem.*', 'postagens.*', 'situacao_postagem.*')
            ->orderBy('data_postagem', 'desc')
            ->get();
        } elseif($_SESSION['selected_post'] == '3') {
            $post = DB::table('postagens')
            ->join('categoria_postagem','categoria_postagem.id_categoria', '=', 'postagens.id_categoria' )
            ->join('situacao_postagem','situacao_postagem.id_situacao_postagem', '=', 'postagens.id_situacao_postagem' )
            ->where('id_usuarios', $user_id)
            ->where('postagens.id_situacao_postagem', $filtro_post)
            ->select('categoria_postagem.*', 'postagens.*', 'situacao_postagem.*')
            ->orderBy('data_postagem', 'desc')
            ->get();
        } else {
            $post = DB::table('postagens')
                    ->join('categoria_postagem','categoria_postagem.id_categoria', '=', 'postagens.id_categoria' )
                    ->join('situacao_postagem','situacao_postagem.id_situacao_postagem', '=', 'postagens.id_situacao_postagem' )
                    ->where('id_usuarios', $user_id)
                    ->select('categoria_postagem.*', 'postagens.*', 'situacao_postagem.*')
                    ->orderBy($filtro_post, 'desc')
                    ->get();
        }
        return $post;
    }

    public static function ordenar_solicit()
    {
        if(NULL !== Session::get('filtro_solicit')){$_SESSION['filtro_solicit'] = Session::get('filtro_solicit');}
        if(isset($_SESSION['filtro_solicit'])){$filtro_solicit = $_SESSION['filtro_solicit'];}
        if(!isset($filtro_solicit)){$filtro_solicit = "data_solicitacao";}

        

        if(NULL !== Session::get('selected_solicit')){$_SESSION['selected_solicit'] = Session::get('selected_solicit');}
        if(!isset($_SESSION['selected_solicit'])){$_SESSION['selected_solicit'] = '1';}
        

        $user_id = Auth::user()->id;

        if($_SESSION['selected_solicit'] == '4') {
            $solicit = DB::table('solicitacoes')
            ->where('usuario_solicitacao', $user_id)
            ->join('tipo_solicitacoes', 'solicitacoes.tipo_solicitacao', '=', 'tipo_solicitacoes.id_tipo_solicitacao')
            ->join('status_solicitacoes', 'solicitacoes.status_solicitacao', '=', 'status_solicitacoes.id_status')
            ->where('solicitacoes.status_solicitacao', $filtro_solicit)
            ->select('solicitacoes.*', 'tipo_solicitacoes.nome_tipo_solicitacao', 'status_solicitacoes.nome_status')
            ->get();

        } elseif($_SESSION['selected_solicit'] == '3') {
            $solicit = DB::table('solicitacoes')
            ->where('usuario_solicitacao', $user_id)
            ->join('tipo_solicitacoes', 'solicitacoes.tipo_solicitacao', '=', 'tipo_solicitacoes.id_tipo_solicitacao')
            ->join('status_solicitacoes', 'solicitacoes.status_solicitacao', '=', 'status_solicitacoes.id_status')
            ->where('solicitacoes.status_solicitacao', $filtro_solicit)
            ->select('solicitacoes.*', 'tipo_solicitacoes.nome_tipo_solicitacao', 'status_solicitacoes.nome_status')
            ->get();

        }elseif($_SESSION['selected_solicit'] == '2') {
            $solicit = DB::table('solicitacoes')
            ->where('usuario_solicitacao', $user_id)
            ->join('tipo_solicitacoes', 'solicitacoes.tipo_solicitacao', '=', 'tipo_solicitacoes.id_tipo_solicitacao')
            ->join('status_solicitacoes', 'solicitacoes.status_solicitacao', '=', 'status_solicitacoes.id_status')
            ->where('solicitacoes.status_solicitacao', $filtro_solicit)
            ->select('solicitacoes.*', 'tipo_solicitacoes.nome_tipo_solicitacao', 'status_solicitacoes.nome_status')
            ->get();

        } else {
            $solicit = DB::table('solicitacoes')
            ->where('usuario_solicitacao', $user_id)
            ->join('tipo_solicitacoes', 'solicitacoes.tipo_solicitacao', '=', 'tipo_solicitacoes.id_tipo_solicitacao')
            ->join('status_solicitacoes', 'solicitacoes.status_solicitacao', '=', 'status_solicitacoes.id_status')
            ->select('solicitacoes.*', 'tipo_solicitacoes.nome_tipo_solicitacao', 'status_solicitacoes.nome_status')
            ->orderBy($filtro_solicit, 'desc')
            ->get();
        }
        return $solicit;
    }

    public static function ordenar_post_perfil($user_id)
    {
        if(NULL !== Session::get('filtro_post_perfil')){$_SESSION['filtro_post_perfil'] = Session::get('filtro_post_perfil');}
        if(isset($_SESSION['filtro_post_perfil'])){$filtro_post = $_SESSION['filtro_post_perfil'];}
        if(!isset($filtro_post)){$filtro_post = "data_postagem";}

        

        if(NULL !== Session::get('selected_post_perfil')){$_SESSION['selected_post_perfil'] = Session::get('selected_post_perfil');}
        if(!isset($_SESSION['selected_post_perfil'])){$_SESSION['selected_post_perfil'] = '1';}

        if($_SESSION['selected_post_perfil'] == '4') {
            $post = DB::table('postagens')
            ->join('categoria_postagem','categoria_postagem.id_categoria', '=', 'postagens.id_categoria' )
            ->join('situacao_postagem','situacao_postagem.id_situacao_postagem', '=', 'postagens.id_situacao_postagem' )
            ->where('id_usuarios', $user_id)
            ->where('postagens.id_situacao_postagem', $filtro_post)
            ->select('categoria_postagem.*', 'postagens.*', 'situacao_postagem.*')
            ->orderBy('data_postagem', 'desc')
            ->get();
        } elseif($_SESSION['selected_post_perfil'] == '3') {
            $post = DB::table('postagens')
            ->join('categoria_postagem','categoria_postagem.id_categoria', '=', 'postagens.id_categoria' )
            ->join('situacao_postagem','situacao_postagem.id_situacao_postagem', '=', 'postagens.id_situacao_postagem' )
            ->where('id_usuarios', $user_id)
            ->where('postagens.id_situacao_postagem', $filtro_post)
            ->select('categoria_postagem.*', 'postagens.*', 'situacao_postagem.*')
            ->orderBy('data_postagem', 'desc')
            ->get();
        } else {
            $post = DB::table('postagens')
                    ->join('categoria_postagem','categoria_postagem.id_categoria', '=', 'postagens.id_categoria' )
                    ->join('situacao_postagem','situacao_postagem.id_situacao_postagem', '=', 'postagens.id_situacao_postagem' )
                    ->where('id_usuarios', $user_id)
                    ->select('categoria_postagem.*', 'postagens.*', 'situacao_postagem.*')
                    ->orderBy($filtro_post, 'desc')
                    ->get();
        }
        return $post;
    }

    public static function ordenar_solicit_perfil($user_id)
    {
        if(NULL !== Session::get('filtro_solicit_perfil')){$_SESSION['filtro_solicit_perfil'] = Session::get('filtro_solicit_perfil');}
        if(isset($_SESSION['filtro_solicit_perfil'])){$filtro_solicit = $_SESSION['filtro_solicit_perfil'];}
        if(!isset($filtro_solicit)){$filtro_solicit = "data_solicitacao";}

        

        if(NULL !== Session::get('selected_solicit_perfil')){$_SESSION['selected_solicit_perfil'] = Session::get('selected_solicit_perfil');}
        if(!isset($_SESSION['selected_solicit_perfil'])){$_SESSION['selected_solicit_perfil'] = '1';}

        if($_SESSION['selected_solicit_perfil'] == '4') {
            $solicit = DB::table('solicitacoes')
            ->where('usuario_solicitacao', $user_id)
            ->join('tipo_solicitacoes', 'solicitacoes.tipo_solicitacao', '=', 'tipo_solicitacoes.id_tipo_solicitacao')
            ->join('status_solicitacoes', 'solicitacoes.status_solicitacao', '=', 'status_solicitacoes.id_status')
            ->where('solicitacoes.status_solicitacao', $filtro_solicit)
            ->select('solicitacoes.*', 'tipo_solicitacoes.nome_tipo_solicitacao', 'status_solicitacoes.nome_status')
            ->get();

        } elseif($_SESSION['selected_solicit_perfil'] == '3') {
            $solicit = DB::table('solicitacoes')
            ->where('usuario_solicitacao', $user_id)
            ->join('tipo_solicitacoes', 'solicitacoes.tipo_solicitacao', '=', 'tipo_solicitacoes.id_tipo_solicitacao')
            ->join('status_solicitacoes', 'solicitacoes.status_solicitacao', '=', 'status_solicitacoes.id_status')
            ->where('solicitacoes.status_solicitacao', $filtro_solicit)
            ->select('solicitacoes.*', 'tipo_solicitacoes.nome_tipo_solicitacao', 'status_solicitacoes.nome_status')
            ->get();

        }elseif($_SESSION['selected_solicit_perfil'] == '2') {
            $solicit = DB::table('solicitacoes')
            ->where('usuario_solicitacao', $user_id)
            ->join('tipo_solicitacoes', 'solicitacoes.tipo_solicitacao', '=', 'tipo_solicitacoes.id_tipo_solicitacao')
            ->join('status_solicitacoes', 'solicitacoes.status_solicitacao', '=', 'status_solicitacoes.id_status')
            ->where('solicitacoes.status_solicitacao', $filtro_solicit)
            ->select('solicitacoes.*', 'tipo_solicitacoes.nome_tipo_solicitacao', 'status_solicitacoes.nome_status')
            ->get();

        } else {
            $solicit = DB::table('solicitacoes')
            ->where('usuario_solicitacao', $user_id)
            ->join('tipo_solicitacoes', 'solicitacoes.tipo_solicitacao', '=', 'tipo_solicitacoes.id_tipo_solicitacao')
            ->join('status_solicitacoes', 'solicitacoes.status_solicitacao', '=', 'status_solicitacoes.id_status')
            ->select('solicitacoes.*', 'tipo_solicitacoes.nome_tipo_solicitacao', 'status_solicitacoes.nome_status')
            ->orderBy($filtro_solicit, 'desc')
            ->get();
        }
        return $solicit;
    }
}