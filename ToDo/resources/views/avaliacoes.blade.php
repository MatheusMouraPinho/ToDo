@extends('layouts.app')
<?php

$db_config = Config::get('database.connections.'.Config::get('database.default'));
$conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
mysqli_set_charset($conn, 'utf8');

$user = Auth::user()->id;

$_SESSION['id_post'] = $postagem[0]->id_postagem;
$id_post = $_SESSION['id_post'];

$rows = array();
$post = array();
$post['avaliacao'] = $avaliacao;
$post['avaliador'] = $avaliador;
$post['mencionado'] = $mencionado;
$count = count($avaliacao);
$post['avaliou'] = $avaliou;
$user_post = $postagem[0]->id_usuarios;
$name = $postagem[0]->usuario;
#dd($media);

?>
@section('content')

<!-- Container (About Section) -->

<div id="area_principal_aval">
  <div class="container justify-center">
    <h2 class="text-center" style="margin-top:30px;"><b style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">Avaliações</b></h2><br>
    <hr class="rgba-white-light" style="margin-top:10px;">
  </div>
  <div class="row justify-content-start align-items-start my-4 p-4">
    <div class="col-3 align-self-start">
      <div class="elipse align-items-start">
        <div class="text_div align-self-start">
          <p class="text_media"><span class="m-0" style="padding-left: 4px">Média Geral</span><br><span class="p-0 m-0" style="font-size: 3em; font-weight: bolder"><?php echo number_format((float)$media[0]->media, 1, '.', ''); ?></span><br><span class="m-0 pl-1" style="font-size: 0.6em">{{ $count_aval }} Avaliações</span>
          </p>
        
        </div>
      </div>
    </div>
    <div class="col-12 align-self-end p-0">
      <button class="btn_show btn align-items-end align-self-end mt-3" data-toggle="modal" onclick="modal({{ $id_post }})" data-target="#post{{ $id_post }}">Visualizar postagem</button>
    </div>
    
  </div>
  <?php foreach($avaliacao as $index => $avaliacoes){
    $rows['id_categoria'] = $postagem[0]->id_categoria;  
    $rows['titulo_postagem'] = $postagem[0]->titulo_postagem;
    $rows['descricao_postagem'] = $postagem[0]->descricao_postagem;
    $post['img_post'] = $img_post;
    $rows['likes_postagem'] = $postagem[0]->likes_postagem;
    $rows['data_postagem'] = $postagem[0]->data_postagem;

    $cont = 0;
    for($q=0; $q<sizeof($post['img_post']); $q++){
        if($post['img_post'][$q]->id_postagem == $id_post) {
            if(Str::substr($post['img_post'][$q]->img_post, 30, 1) == 2) {
                $cont = $cont + 1;
            }
        }
    }

    
  ?>
      
    <div class="card_aval">
      <div class="header-coment" style="font-size:1.1em;">
        @if($avaliador[$index]->nivel > 1)
            <div class="p-1 w-50 show_selo">
              <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-person-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zm4.854-7.85a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
              </svg>
              <span>Avaliador</span>
            </div>
          @endif
        @if($avaliador[$index]->img_usuarios == null)
            <img class="img-dados-coment" src="{{asset('img/semuser.png')}}">
          @else
            <img  alt="{{ $avaliador[$index]->img_usuarios }}" name="img_usuarios" class="img-dados-coment" src="{{asset('/ToDo/storage/app/public/users/'.$avaliador[$index]->img_usuarios)}}">
          @endif
          <form id="perfil" action="{{ route('perfil') }}" method="get">
            @csrf
            <input type="hidden" name="id_usuario" value="{{ $avaliador[$index]->id }}">
            <input class="bold user" type="submit" value="{{ $avaliador[$index]->usuario}}">
          </form>
          @if($avaliador[$index]->nivel > 1)
            <div class="bola"></div>
            <div class="selo p-1 ml-2">
              <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-person-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zm4.854-7.85a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
              </svg>
              <span>Avaliador</span>
            </div>
          @endif
        <span class="underline data-coment" style="margin-right: 10px">{{ Helper::tempo_corrido($avaliacoes->data_comentarios)}}</span>
        
      </div>
      <div class="p-0">
        <div class="container_aval p-2">
          <div class="div_spans mt-0">
            <p class="w-100 m-1">
              <img src="{{asset('img/inovacao.png')}}" style="width: 30px" alt="">
              <span class="bold">Inovação:</span>
            </p>
            <p class="w-100 m-1">
              <img src="{{asset('/img/potencial.png')}}" class="m-0 p-0" style="width: 27px" alt="">
              <span class="bold">Potencial:</span>
            </p>
            <p class="w-100 m-1">
              <svg width="1.4em" height="1.4em" viewBox="0 0 16 16" class="bi bi-diagram-3" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 2 7h5.5V6A1.5 1.5 0 0 1 6 4.5v-1zM8.5 5a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1zM0 11.5A1.5 1.5 0 0 1 1.5 10h1A1.5 1.5 0 0 1 4 11.5v1A1.5 1.5 0 0 1 2.5 14h-1A1.5 1.5 0 0 1 0 12.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm4.5.5A1.5 1.5 0 0 1 7.5 10h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm4.5.5a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"/>
              </svg>
              <span class="bold">Complexidade:</span>
            </p>
          </div>
          <div class="d-inline-block" style="font-size:1.3em; margin-left: 0px; vertical-align: top;position: relative;">
            <p class="w-100 m-1">
              {{ $avaliacoes->inovacao_avaliacao }}
            </p>
            <p class="w-100 m-1">
              {{ $avaliacoes->potencial_avaliacao }}
            </p>
            <p class="w-100 m-1">
              {{ $avaliacoes->complexidade_avaliacao }}
            </p>
          </div>
        </div>
        
        <div class="body_aval">
          <p class="" style="font-size: 1.05em">{{ $avaliacoes->conteudo_comentarios }}</p>
        </div>
      </div>
      <div class="footer-coment mb-2">
        <?php $resultados = Helper::verifica_like_coment($avaliacoes->id_comentarios)?>
          @if($resultados == 0)
            <span href="#" id="btn_like" class="curtir fa-thumbs-o-up fa" onclick="like(this)" data-id="{{ $avaliacoes->id_comentarios }}"></span> 
            <span class="likes" id="likes_{{ $avaliacoes->id_comentarios }}">{{ $avaliacoes->likes_comentarios }}</span>
          @else 
            <span href="#" id="btn_like" class="curtir fa-thumbs-up fa" onclick="like(this)" data-id="{{ $avaliacoes->id_comentarios }}"></span>
            <span class="likes" id="likes_{{ $avaliacoes->id_comentarios }}">{{ $avaliacoes->likes_comentarios }}</span>
          @endif
          <span class="underline data-coment_foot" style="margin-right: 10px">{{ Helper::tempo_corrido($avaliacoes->data_comentarios) }}</span>
          
      </div>
    </div>
    
        
  <?php } ?>

  @include('layouts.post')

  <?php echo $avaliacao->appends(array("id_post" => $id_post))->render(); ?>

</div>

@endsection