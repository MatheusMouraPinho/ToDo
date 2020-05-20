<?php

$id_usuario = Auth::user()->id;
$id_comentario = $_POST['id'];
dd($verifica = Helper::verifica_like_coment($id_comentario));
if($verifica == 0){
    $insert = DB::table('like_comentarios')->insert(
        ['id_usuario' => $id_usuario, 'id_comentario', $id_comentario]
    );
    if($insert){
        $update = DB::update('update comentarios set likes_comentarios = likes_comentarios+1 where id_comentarios = ?', [$id_comentario]);
        if($update){
            return 'Sucesso no update';
        }else{
            return 'Erro no update';
        }
    }else{
        return 'Erro no insert';
    }
}else{
    $delete = DB::table('like_comentarios')
                ->where('id_comentarios', 'id_comentarios', 'and')
                ->where('id_usuarios', $id_usuario)
                ->delete();

    if($delete){
        $update1 = DB::update('update comentarios set likes_comentarios = likes_comentarios-1 where id_comentarios = ?', [$id_comentario]);
        if($update1){
            return 'Sucesso no update';
        }else{
            return 'Erro no update';
        }
    }else{
        return 'Erro no delete';
    }
}

$likes = DB::table('comentarios')
        ->where('id_comentarios', $id_comentario)
        ->value('likes_comentarios');

if($verifica >= 1){
    $curtir = "Curtir";
    $likes = $likes++;
}else {
    $curtir = "Descurtir";
    $likes = $likes--;
}

$dados = array('likes' => $likes, 'text' => $curtir);

echo json_encode($dados);

?>