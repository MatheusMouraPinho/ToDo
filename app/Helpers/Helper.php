<?php

namespace App\Helpers;
use Auth;
use DB;

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
        else if ($minutes <= 60) return $minutes==1 ?'1 min atrás':$minutes.' min atrás';
        else if ($hours <= 24) return $hours==1 ?'1 hrs atrás':$hours.' hrs atrás';
        else if ($days <= 7) return $days==1 ?'1 dia atras':$days.' dias atrás';
        else if ($weeks <= 4) return $weeks==1 ?'1 semana atrás':$weeks.' semanas atrás';
        else if ($months <= 12) return $months == 1 ?'1 mês atrás':$months.' meses atrás';
        else return $years == 1 ? 'um ano atrás':$years.' anos atrás';
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

    function add_like($id_comentario) {
        $id_usuario = Auth::user()->id;
        $insert = DB::table('like_comentarios')->insert(
            ['id_usuario' => $id_usuario, 'id_comentario', $id_comentario]
        );

        if($insert){
            $update = DB::table('comentarios')
                    ->where('id_comentarios', $id_comentario)
                    ->update(['likes_comentarios', 'likes_comentarios'+1]);
            if($update){
                return 'Sucesso no update';
            }else{
                return 'Erro no update';
            }
        }else{
            return 'Erro no insert';
        }
    }

    function unlike($id_comentarios) {
        $id_usuario = Auth::user()->id;
        $delete = DB::table('like_comentarios')
                ->where('id_comentarios', 'id_comentarios', 'and')
                ->where('id_usuarios', $id_usuario)
                ->delete();

        if($delete){
            $update = DB::table('comentarios')
                    ->where('id_comentarios', $id_comentarios)
                    ->update(['likes_comentarios', 'likes_comentarios'-1]);
            if($update){
                return 'Sucesso no update';
            }else{
                return 'Erro no update';
            }
        }else{
            return 'Erro no delete';
        }

    }
}