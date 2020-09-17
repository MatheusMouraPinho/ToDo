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
        else if ($minutes <= 60) return $minutes==1 ?'1min':$minutes.'min';
        else if ($hours <= 24) return $hours==1 ?'1h':$hours.'h';
        else if ($days <= 7) return $days==1 ?'1d':$days.'d';
        else if ($weeks <= 4) return $weeks==1 ?'1 semana':$weeks.' semanas';
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
}