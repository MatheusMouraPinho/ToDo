<?php if($rows['id_categoria'] == '1' ){ $categoria = "Web, Mobile & Software"; }elseif($rows['id_categoria'] == "2"){ $categoria = "Design & Criação"; }elseif($rows['id_categoria'] == "3"){$categoria = "Engenharia & Arquitetura";
}elseif($rows['id_categoria'] == "4"){$categoria = "Marketing";}elseif($rows['id_categoria'] == "5"){$categoria = "Outros";}else{$categoria = "Sem categoria";}?>

<?php
    $nivel = Auth::user()->nivel;
    $id_nivel = 0; 
    if($nivel >= 2){$id_nivel = 1;}
    

    if(NULL !== Session::get('filtro_coment')){$_SESSION['filtro_coment'] = Session::get('filtro_coment');}
    if(isset($_SESSION['filtro_coment'])){$filtro_coment = $_SESSION['filtro_coment'];}
    if(!isset($filtro_coment)){$filtro_coment = "data_comentarios";}


    if(NULL !== Session::get('selected')){$_SESSION['selected'] = Session::get('selected');}
    if(isset($_SESSION['selected'])){$selected = $_SESSION['selected'];}
    if(!isset($selected)){$selected = "1";}

    if(!isset($_SESSION['post_id'])){$_SESSION['post_id'] = array();}
    if(NULL !== Session::get('id_postagem_coment')){
      $id_postagem_coment = Session::get('id_postagem_coment'); 
      array_push($_SESSION['post_id'], $id_postagem_coment); 
    }
    
    //dd($_SESSION['post_id']);

    if(NULL !== Session::get('limit')){$_SESSION['limit'] = Session::get('limit');}
    if(isset($_SESSION['limit'])){$limit = $_SESSION['limit'];}

    if(!empty($_SESSION['post_id'])) {
      for($d=0;$d<sizeof($_SESSION['post_id']);$d++) {
        $cont = 0;
        if($_SESSION['post_id'][$d] != $id_post) {
          $cont+= 1 ;
        }
      }
      if($cont == sizeof($_SESSION['post_id'])) {
        $limit = 5;
      }
    }
    if(!isset($limit)){$limit = 5;}

    $comments = [
                'comentarios' => DB::table('comentarios')
                                    ->join('postagens', 'postagens.id_postagem', '=', 'comentarios.id_postagem')
                                    ->where('comentarios.id_mencionado', '=', null, 'and')
                                    ->where('comentarios.id_avaliacao', '=', null)
                                    ->join('usuarios', 'comentarios.id_usuarios', '=', 'usuarios.id')
                                    ->select('comentarios.*', 'postagens.id_usuarios', 'postagens.id_postagem', 'usuarios.*')
                                    ->orderBy($filtro_coment, 'desc')
                                    ->get(),


                'reply_coment' => DB::table('comentarios')
                                    ->join('postagens', 'postagens.id_postagem', '=', 'comentarios.id_postagem')
                                    ->where('comentarios.id_mencionado', '!=', null)
                                    ->leftJoin('usuarios as users', 'comentarios.id_usuarios', '=', 'users.id')
                                    ->select('comentarios.*', 'postagens.id_usuarios', 'postagens.id_postagem', 'users.*')                               
                                    ->orderBy($filtro_coment, 'desc')
                                    ->get(),
    ];


?>

<!-- Área de detalhes de ideias postadas -->

<div class="painel-dados">
    <div class="modal fade id" id="post<?php echo $id_post ?>" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="popup-title">
              <p class="h4 text-center" style="text-align: center; font-weight:bold">
                <?php echo $rows['titulo_postagem']; ?>
              </p>
            </div>
            <div class="popup_desc">
              <span style="vertical-align: top" class="popup_sub bold">
                <svg width="1.1em" height="1.1em" viewBox="0 0 16 16" class="bi bi-justify-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                </svg>&nbsp;
                Descrição:
              </span>
              <p id="popup_cont_desc" class="text-justify"><?php echo $rows['descricao_postagem']; ?></p>
            </div>
            <div>
              <span class="popup_sub bold">
                <svg width="1.1em" height="1.2em" viewBox="0 0 16 16" class="bi bi-list-ul" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                </svg>&nbsp;
                Categoria:
              </span>
              <p class="popup_coment"><?php echo $categoria ?></p>
            </div>
            <?php
              $nome_file = "ToDo/storage/app/public/posts/" .'1'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg';
              $nome_file_png = "ToDo/storage/app/public/posts/".'1'.$id_post.Str::kebab($rows['titulo_postagem']).'.png';
              $nome_file2 = "ToDo/storage/app/public/posts/".'2'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg';
              $nome_file_png2 = "ToDo/storage/app/public/posts/".'2'.$id_post.Str::kebab($rows['titulo_postagem']).'.png';
              $nome_file3 = "ToDo/storage/app/public/posts/".'3'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg';
              $nome_file_png3 = "ToDo/storage/app/public/posts/".'3'.$id_post.Str::kebab($rows['titulo_postagem']).'.png';
            ?>
            @for($t=0; $t<sizeof($post['img_post']); $t++)
              @if($post['img_post'][$t]->id_postagem == $id_post)
                <div class="popup_img">
                  <span class="popup_sub bold">
                    <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-link-45deg" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path d="M4.715 6.542L3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.001 1.001 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z"/>
                      <path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 0 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 0 0-4.243-4.243L6.586 4.672z"/>
                    </svg>
                    Imagens:
                  </span>
                  <div class="div_imgs">
                    @if(file_exists($nome_file))
                      <img class="popup_imgs" id="img_post" data-toggle="modal" data-target="#img1<?php echo $id_post ?>" src="{{url('/ToDo/storage/app/public/posts/'.'1'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg')}}">
                    @elseif(file_exists($nome_file_png))
                      <img class="popup_imgs" id="img_post" data-toggle="modal" data-target="#img1<?php echo $id_post ?>" src="{{url('/ToDo/storage/app/public/posts/'.'1'.$id_post.Str::kebab($rows['titulo_postagem']).'.png')}}">
                    @endif
                    @if(file_exists($nome_file2))
                      <img class="popup_imgs" id="img_post" data-toggle="modal" data-target="#img2<?php echo $id_post ?>" src="{{url('/ToDo/storage/app/public/posts/'.'2'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg')}}">
                    @elseif(file_exists($nome_file_png2))
                      <img class="popup_imgs" id="img_post" data-toggle="modal" data-target="#img2<?php echo $id_post ?>" src="{{url('/ToDo/storage/app/public/posts/'.'2'.$id_post.Str::kebab($rows['titulo_postagem']).'.png')}}">
                    @endif
                    @if(file_exists($nome_file3))
                      <img class="popup_imgs" id="img_post" data-toggle="modal" data-target="#img3<?php echo $id_post ?>" src="{{url('/ToDo/storage/app/public/posts/'.'3'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg')}}">
                    @elseif(file_exists($nome_file_png3))
                      <img class="popup_imgs" id="img_post" data-toggle="modal" data-target="#img3<?php echo $id_post ?>" src="{{url('/ToDo/storage/app/public/posts/'.'3'.$id_post.Str::kebab($rows['titulo_postagem']).'.png')}}">
                    @endif
                  </div>
                </div>
              @endif
            @endfor
            <div class="popup_aval">
              <span class="popup_sub bold">
                <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-award" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M9.669.864L8 0 6.331.864l-1.858.282-.842 1.68-1.337 1.32L2.6 6l-.306 1.854 1.337 1.32.842 1.68 1.858.282L8 12l1.669-.864 1.858-.282.842-1.68 1.337-1.32L13.4 6l.306-1.854-1.337-1.32-.842-1.68L9.669.864zm1.196 1.193l-1.51-.229L8 1.126l-1.355.702-1.51.229-.684 1.365-1.086 1.072L3.614 6l-.25 1.506 1.087 1.072.684 1.365 1.51.229L8 10.874l1.356-.702 1.509-.229.684-1.365 1.086-1.072L12.387 6l.248-1.506-1.086-1.072-.684-1.365z"/>
                  <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z"/>
                </svg>
                Avaliação:
              </span>
              @if(!empty($post['avaliacao'][0])) <!--  Verifica se a consulta sql de avaliações retorna algum valor  -->
                @for($c=0; $c<sizeof($post['avaliacao']); $c++) <!-- enquanto a variável c não tiver o valor igualado ao tamanho do array de avaliação, uma avaliação por vez é mostrada -->
                  @if($post['avaliacao'][$c]->id_postagem == $id_post)  <!-- Mas a avaliação só é mostrada caso o id da postagem da avaliação for igual ao da postagem que está sendo visualizada -->
                    <p class="popup_avali">
                      <span class="bold d-block">Inovação: </span>{{ $post['avaliacao'][$c]->inovacao_avaliacao }}
                    </p>
                    <p class="popup_avali">
                      <span class="bold d-block">Potencial: </span>{{ $post['avaliacao'][$c]->potencial_avaliacao }}
                    </p>
                    <p class="popup_avali">
                      <span class="bold d-block">Complexidade: </span>{{ $post['avaliacao'][$c]->complexidade_avaliacao }}
                    </p>
                    <div class="popup_coment_aval" id="avaliacao">
                      <div class="header-coment">
                        @if($post['avaliador'][$c]->nivel > 1)
                            <div class="p-1 w-50 show_selo">
                              <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-person-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zm4.854-7.85a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                              </svg>
                              <span>Avaliador</span>
                            </div>
                          @endif
                        @if($post['avaliador'][$c]->img_usuarios === null)
                            <img class="img-dados-coment" src="{{asset('img/semuser.png')}}">
                          @else
                            <img  alt="{{ $post['avaliador'][$c]->img_usuarios }}" name="img_usuarios" class="img-dados-coment" src="{{asset('/ToDo/storage/app/public/users/'.$post['avaliador'][$c]->img_usuarios)}}">
                          @endif
                          <form id="perfil" action="{{ route('perfil') }}" method="get">
                            @csrf
                            <input type="hidden" name="id_usuario" value="{{ $post['avaliador'][$c]->id }}">
                            <input class="bold user" type="submit" value="{{ $post['avaliador'][$c]->usuario}}">
                          </form>
                          @if($post['avaliador'][$c]->nivel > 1)
                            <div class="bola"></div>
                            <div class="selo p-1 ml-2">
                              <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-person-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zm4.854-7.85a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                              </svg>
                              <span>Avaliador</span>
                            </div>
                          @endif
                        <span class="underline data-coment" style="margin-right: 10px">{{ Helper::tempo_corrido($post['avaliacao'][$c]->data_comentarios)}}</span>
                      </div>
                      <div class="body_coment">
                        <p class="conteudo-coment" id="comentario">{{ $post['avaliacao'][$c]->conteudo_comentarios }}</p>
                      </div>
                      <div class="footer-coment">
                        <?php $resultados = Helper::verifica_like_coment($post['avaliacao'][$c]->id_comentarios)?>
                          @if($resultados == 0)
                            <span href="#" id="btn_like" class="curtir fa-thumbs-o-up fa" onclick="like(this)" data-id="{{ $post['avaliacao'][$c]->id_comentarios }}"></span> 
                            <span class="likes" id="likes_{{ $post['avaliacao'][$c]->id_comentarios }}">{{ $post['avaliacao'][$c]->likes_comentarios }}</span>
                          @else 
                          <span href="#" id="btn_like" class="curtir fa-thumbs-up fa" onclick="like(this)" data-id="{{ $post['avaliacao'][$c]->id_comentarios }}"></span>
                          <span class="likes" id="likes_{{ $post['avaliacao'][$c]->id_comentarios }}">{{ $post['avaliacao'][$c]->likes_comentarios }}</span>
                          @endif
                          <span class="underline data-coment_foot" style="margin-right: 10px">{{ Helper::tempo_corrido($post['avaliacao'][$c]->data_comentarios)}}</span>
                      </div>
                    </div>
                  @endif

                  <!-- Verifica se a avaliação está pendente ou não -->
                  <!-- Quando o for rodar todas as vezes e tbm todos questionamentos do if, e o cont não for igual ao tamanho de quantidade de avaliações , quer dizer q existe alguma avaliação que pertence a postagem atual, e portanto não está pendente -->
                  <?php $cont = 0;?>
                  @for($d=0;$d<sizeof($post['avaliacao']);$d++)
                    @if($post['avaliacao'][$d]->id_postagem != $id_post)  
                      <?php 
                        $cont+= 1 ;
                      ?>
                    @endif
                  @endfor
                @endfor
                @if($cont === sizeof($post['avaliacao']))
                  @if($id_nivel == 1 && isset($rows['id']) && $user_post != $user)
                    <a href="#" class="popup_coment" data-toggle="modal" data-target="#post<?php echo $id_post ?>_avaliar">Avaliar postagem</a>
                  @else
                    <p class="popup_coment">Pendente</p>
                  @endif
                @endif
              @else
                @if($id_nivel == 1 && isset($rows['id']) && $user_post != $user)
                  <a href="#" class="popup_coment" data-toggle="modal" data-target="#post<?php echo $id_post ?>_avaliar">Avaliar postagem</a>
                @else
                  <p class="popup_coment">Pendente</p>
                @endif
              @endif
              
            </div>
            <hr>
            <div class="popup-aval">
              <span class="popup_sub bold">
                <svg width="1.1em" height="1.1em" viewBox="0 0 16 16" class="bi bi-chat-right-text" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M2 1h12a1 1 0 0 1 1 1v11.586l-2-2A2 2 0 0 0 11.586 11H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zm12-1a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12z"/>
                  <path fill-rule="evenodd" d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                </svg>&nbsp;
                Comentários:
              </span>   
              <div style="margin-bottom: 50px">
                <form action="{{ route('comentario') }}" method="POST">
                  @csrf
                  <textarea required name="conteudo_comentarios" onkeypress="auto_grow(this)" maxlength="255" onkeyup="auto_grow(this)" class="comentario" cols="60" rows="1" placeholder="Digite aqui seu comentário"></textarea>
                  <input type="hidden" name="id_postagem" value="{{ $id_post }}">
                  <input type="submit" name="comentario" class="btn btn-primary button_coment" value="Enviar">
                </form>
              </div>

              <?php $count = Helper::count_post($id_post); $count1 = 0 ?>
              @if(!empty($comments['comentarios'][0]))  
                @for($f=0; $f<sizeof($comments['comentarios']); $f++)
                  @if($comments['comentarios'][$f]->id_postagem == $id_post)
                    <form action="{{ route('ordenar') }}" method="POST">
                      @csrf
                      <div class="div_ordenar">
                        <p class="font-weight-bold h-6 m-0 p-1">
                          <svg width="1.4em" height="1.4em" viewBox="0 0 16 16" class="bi bi-sliders" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3h9.05zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8h2.05zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1h9.05z"/>
                          </svg>&nbsp;
                          Ordenar por:
                        </p>
                        <select name="ordenar" onchange="this.form.submit()" class="custom-select bg-transparent" title="Selecione uma opção">
                          @if($selected == 1)
                            <option value="Recentes" selected>Recentes</option>
                            <option value="Populares" >Populares</option>
                          @else
                            <option value="Populares" selected>Populares</option>
                            <option value="Recentes">Recentes</option>
                          @endif
                        </select>
                        <input type="hidden" name="id_postagem" value="{{ $id_post }}">
                      </div>
                    </form>
                    <?php break; ?>
                  @endif
                @endfor
              @endif

              
              @if(!empty($comments['comentarios'][0]))  
                @for($f=0; $f<sizeof($comments['comentarios']); $f++)
                  @if($comments['comentarios'][$f]->id_postagem == $id_post)
                    
                    <div class="popup_coment_aval" id="id_comentario{{ $comments['comentarios'][$f]->id_comentarios }}">
                      <div class="header-coment">
                        @if($comments['comentarios'][$f]->nivel > 1)
                          <div class="p-1 w-50 show_selo">
                            <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-person-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zm4.854-7.85a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                            </svg>
                            <span>Avaliador</span>
                          </div>
                        @endif
                        @if($comments['comentarios'][$f]->img_usuarios === null)
                          <img class="img-dados-coment" src="{{asset('img/semuser.png')}}">
                        @else
                          <img  alt="{{ $comments['comentarios'][$f]->img_usuarios }}" name="img_usuarios" class="img-dados-coment" src="{{asset('/ToDo/storage/app/public/users/'.$comments['comentarios'][$f]->img_usuarios)}}">
                        @endif
                        <form id="perfil" action="{{ route('perfil') }}" method="get">
                          @csrf
                          <input type="hidden" name="id_usuario" value="{{ $comments['comentarios'][$f]->id }}">
                          <input class="bold user" type="submit" value="{{ $comments['comentarios'][$f]->usuario}}">
                        </form>
                        @if($comments['comentarios'][$f]->nivel > 1)
                          <div class="bola"> </div>
                          <div class="selo p-1 ml-2">
                            <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-person-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zm4.854-7.85a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                            </svg>
                            <span>Avaliador</span>
                          </div>
                        @endif
                        <div class="dropdown dropdown1">

                          <!--Trigger-->
                         
                          <a class="btn-floating btn-lg "type="button" id="dropdownMenu2" data-toggle="dropdown"
                          aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                        
                        
                          <!--Menu-->
                          <div class="dropdown-menu dropdown-primary">
                            @if($comments['comentarios'][$f]->id === Auth::user()->id)
                              <a id="edit" class="dropdown-item" href="#" style="cursor: pointer" data-id="#popup{{$comments['comentarios'][$f]->id_comentarios }}_edit1" data-toggle="modal" data-target="#popup{{$comments['comentarios'][$f]->id_comentarios }}_edit1">
                                <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                                  <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                                </svg>&nbsp;
                                Editar
                              </a>
                              <a class="dropdown-item" href="#" style="cursor: pointer" data-toggle="modal" data-target="#popup{{$comments['comentarios'][$f]->id_comentarios}}_apagar2">
                                <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>&nbsp;
                                Apagar
                              </a>
                            @else
                              <a class="dropdown-item" href="#" style="cursor: pointer" data-toggle="modal" data-target="#den_comen{{$comments['comentarios'][$f]->id_comentarios}}">
                                <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-exclamation-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                  <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                </svg>&nbsp;
                                Denunciar
                              </a>
                            @endif
                          </div>
                        </div>
                        <!-- Modal denunciar comentario -->
                        <div class="modal fade id" id="den_comen{{$comments['comentarios'][$f]->id_comentarios}}" role="dialog">
                            <div class="modal-dialog modal-content">
                                <div class="modal-header"></div>
                                <form action="{{url('denunciar_comentario')}}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <h3><p>Denunciar Comentario por:</p></h3><br>
                                        <h6>
                                            <label class="radio-custom">Conteúdo Inadequado
                                                <input type="radio" id="radio1" type="radio" name="option" value="3" required>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-custom">Spam
                                                <input type="radio" id="radio3" type="radio" name="option" value="1" required>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-custom">Copia
                                                <input type="radio" id="radio3" type="radio" name="option" value="2" required>
                                                <span class="checkmark"></span>
                                            </label>
                                        </h6>
                                        <input type="hidden" value="{{$id_post}}" name="id_postagem">
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                            <input name="id_comentario" type="hidden" value="{{$comments['comentarios'][$f]->id_comentarios}}">
                                            <input name="id_usuario" type="hidden" value="<?php echo $user;?>">
                                            <input data-toggle="modal" type="submit" class="btn btn-primary" value="Confirmar">
                                        </div> 
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- FIM Modal denunciar comentario -->
                        @if(empty($comments['comentarios'][$f]->edit_comentarios))
                          <span class="underline data-coment">{{ Helper::tempo_corrido($comments['comentarios'][$f]->data_comentarios)}}</span>
                        @else
                          <span class="underline data-coment"><?='(editado) '. Helper::tempo_corrido($comments['comentarios'][$f]->data_comentarios)?></span>
                        @endif
                      </div>
                      <div class="body_coment">
                        <p class="conteudo-coment" id="comentario">{{ $comments['comentarios'][$f]->conteudo_comentarios }}</p>
                      </div>
                      <div class="footer-coment">
                        <span class="mostrar">Responder</span>
                        <?php $resultados = Helper::verifica_like_coment($comments['comentarios'][$f]->id_comentarios);$id_comentario = $comments['comentarios'][$f]->id_comentarios;?>
                          @if($resultados == 0)
                            <span href="#" id="btn_like" class="curtir fa-thumbs-o-up fa" onclick="like(this)" data-id="{{ $comments['comentarios'][$f]->id_comentarios }}"></span> 
                            <span class="likes" id="likes_{{ $comments['comentarios'][$f]->id_comentarios }}">{{ $comments['comentarios'][$f]->likes_comentarios }}</span>
                          @else 
                          <span href="#" id="btn_like" class="curtir fa-thumbs-up fa" onclick="like(this)" data-id="{{ $comments['comentarios'][$f]->id_comentarios }}"></span>
                          <span class="likes" id="likes_{{ $comments['comentarios'][$f]->id_comentarios }}">{{ $comments['comentarios'][$f]->likes_comentarios }}</span>
                          @endif
                          @if(empty($comments['comentarios'][$f]->edit_comentarios))
                            <span class="underline data-coment_foot">{{ Helper::tempo_corrido($comments['comentarios'][$f]->data_comentarios)}}</span>
                          @else
                            <span class="underline data-coment_foot"><?='(editado) '. Helper::tempo_corrido($comments['comentarios'][$f]->data_comentarios)?></span>
                          @endif

                        <!--  Modal de edição de comentários -->
                          <div class="painel-dados">
                            <div class="modal fade id" id="popup{{$comments['comentarios'][$f]->id_comentarios}}_edit1" role="dialog">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  </div>
                                  <div class="modal-body"> 
                                    <form action="{{ route('edit.coment') }}" method="POST"> 
                                      @csrf                   
                                      <div class="popup-title">
                                        <label style="vertical-align: top" for="editcomentario" class="bold subdados">Descrição:</label>
                                        <textarea name="editcomentario" id="edit_desc" cols="60" rows="1">{{$comments['comentarios'][$f]->conteudo_comentarios }}</textarea>
                                        <input type="hidden" name="id_coment" value="{{ $comments['comentarios'][$f]->id_comentarios }}">
                                        <input type="hidden" value="{{$id_post}}" name="id_postagem">
                                      </div>
                                    

                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                      <input data-toggle="modal" data-target="#hiddenDiv" type="submit" class="btn btn-primary dropright" value="Salvar Alterações">
                                      
                                    </div> 
                                  </form> 

                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                  
                        <div id="comentarios">
                          <form action="{{ route('comentario') }}" method="POST">
                            @csrf
                            <input name="conteudo" maxlength="255" style="width: 100%" type="text" class="btn-popup mr-sm-2" placeholder="<?='Em resposta a '.'@'. $comments['comentarios'][$f]->usuario?>">
                            <input type="hidden" name="id_coment" value="{{ $comments['comentarios'][$f]->id_comentarios }}">
                            <input type="hidden" name="id_postagem" value="{{ $id_post }}">
                            <input type="hidden" name="id_mencionado" value="{{ $comments['comentarios'][$f]->id }}">
                            <input type="submit" style="display: none" name="respostas">
                          </form>
                        </div>
                      </div>
                      
                    </div> 
                    
                    <!--  Modal para apagar comentários -->
                    <div class="painel-dados">
                      <div class="modal fade id" id="popup{{$comments['comentarios'][$f]->id_comentarios}}_apagar2" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                            </div>
                            <div class="modal-body"> 
                              <p>Deseja realmente apagar este comentário?</p>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <form action="{{route('apagar-coment')}}" method="POST">
                                  @csrf
                                  <input name="id_comentario" type="hidden" value="{{ $comments['comentarios'][$f]->id_comentarios }}">
                                  <input type="hidden" value="{{$id_post}}" name="id_postagem">
                                  <input data-toggle="modal" type="submit" class="btn btn-primary dropright" value="Apagar comentário">
                                </form>
                              </div> 
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>         
                  
                    @for($g=0; $g<sizeof($comments['reply_coment']); $g++)
                      @if($comments['reply_coment'][$g]->id_postagem == $id_post && $comments['comentarios'][$f]->id_comentarios === $comments['reply_coment'][$g]->id_comentarios_ref)
                        <div class="popup_coment_aval" id="respostas" style="margin-top: 10px; width: 95%;margin-left:5%">
                          
                          <div class="header-coment">
                            @if($comments['reply_coment'][$g]->nivel > 1)
                              <div class="p-1 w-50 show_selo">
                                <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-person-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zm4.854-7.85a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                </svg>
                                <span>Avaliador</span>
                              </div>
                            @endif
                            <div class="dropdown dropdown1">

                              <!--Trigger-->
                            
                              <a class="btn-floating btn-lg black"type="button" id="dropdownMenu3" data-toggle="dropdown"
                              aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                            
                            
                              <!--Menu-->
                              <div class="dropdown-menu dropdown-primary">
                                @if($comments['reply_coment'][$g]->id === Auth::user()->id)
                                  <a class="dropdown-item" data-toggle="modal" style="cursor: pointer" data-target="#popup{{$comments['reply_coment'][$g]->id_comentarios }}_edit">
                                    <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                                      <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                                    </svg>&nbsp;
                                    Editar
                                  </a>
                                  <a class="dropdown-item" style="cursor: pointer" data-toggle="modal" data-target="#popup{{$comments['reply_coment'][$g]->id_comentarios }}_apagar1">
                                    <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                      <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                      <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>&nbsp;
                                    Apagar
                                  </a>
                                @else
                                  <a class="dropdown-item" href="#" style="cursor: pointer" data-toggle="modal" data-target="#den_comen_reply{{$comments['reply_coment'][$g]->id_comentarios }}">
                                    <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-exclamation-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                      <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                    </svg>&nbsp;
                                    Denunciar
                                  </a>
                                @endif
                              </div>
                            </div>
                            <!-- Modal denunciar comentario Reply -->
                            <div class="modal fade id" id="den_comen_reply{{$comments['reply_coment'][$g]->id_comentarios }}" role="dialog">
                                <div class="modal-dialog modal-content">
                                    <div class="modal-header"></div>
                                    <form action="{{url('denunciar_comentario')}}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <h3><p>Denunciar Comentario por:</p></h3><br>
                                            <h6>
                                                <label class="radio-custom">Conteúdo Inadequado
                                                    <input type="radio" id="radio1" type="radio" name="option" value="3" required>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="radio-custom">Spam
                                                    <input type="radio" id="radio3" type="radio" name="option" value="1" required>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="radio-custom">Copia
                                                    <input type="radio" id="radio3" type="radio" name="option" value="2" required>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </h6>
                                            <input type="hidden" value="{{$id_post}}" name="id_postagem">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                                <input name="id_comentario" type="hidden" value="{{$comments['reply_coment'][$g]->id_comentarios }}">
                                                <input name="id_usuario" type="hidden" value="<?php echo $user;?>">
                                                <input data-toggle="modal" type="submit" class="btn btn-primary" value="Confirmar">
                                            </div> 
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- FIM Modal denunciar comentario reply -->
                            @if(empty($comments['reply_coment'][$g]->edit_comentarios))
                              <span class="underline data-coment">{{ Helper::tempo_corrido($comments['reply_coment'][$g]->data_comentarios)}}</span>
                            @else
                              <span class="underline data-coment"><?='(editado) '. Helper::tempo_corrido($comments['reply_coment'][$g]->data_comentarios)?></span>
                            @endif
                            <div>
                              @if($comments['reply_coment'][$g]->img_usuarios === null)
                                <img class="img-dados-coment" src="{{asset('img/semuser.png')}}">
                              @else
                                <img alt="{{ $comments['reply_coment'][$g]->img_usuarios }}" name="img_usuarios" class="img-dados-coment" src="{{asset('/ToDo/storage/app/public/users/'.$comments['reply_coment'][$g]->img_usuarios)}}">
                              @endif
                              <form id="perfil" action="{{ route('perfil') }}" method="get">
                                @csrf
                                <input type="hidden" name="id_usuario" value="{{ $comments['reply_coment'][$g]->id }}">
                                <input alt="" class="bold user" type="submit" value="{{ $comments['reply_coment'][$g]->usuario}}">
                              </form>
                              @if($comments['reply_coment'][$g]->nivel > 1)
                                <div class="bola"> </div>
                                <div class="selo p-1 ml-2">
                                  <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-person-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zm4.854-7.85a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                  </svg>
                                  <span>Avaliador</span>
                                </div>
                              @endif
                            </div>
                            
                          </div>
                          <div class="body_coment">
                            @for($k=0; $k<sizeof($post['mencionado']);$k++)
                              @if($post['mencionado'][$k]->id_comentarios === $comments['reply_coment'][$g]->id_comentarios)
                                <form id="perfil" action="{{ route('perfil') }}" method="get">
                                  @csrf
                                  <input type="hidden" name="id_usuario" value="{{ $post['mencionado'][$k]->id }}">
                                  <input class="mencionado" type="submit" value="{{'@'. $post['mencionado'][$k]->usuario }}">
                                </form>
                              @endif
                            @endfor
                            <p class="conteudo-coment">
                              {{ $comments['reply_coment'][$g]->conteudo_comentarios }}
                            </p>
                          </div>
                          <div class="footer-coment">
                            <span class="mostrar">Responder</span>
                            <?php $resultados = Helper::verifica_like_coment($comments['reply_coment'][$g]->id_comentarios)?>
                            @if($resultados == 0)
                              <span href="#" id="{{ $comments['reply_coment'][$g]->id_comentarios }}" onclick="like(this)" class="curtir fa-thumbs-o-up fa" data-id="{{ $comments['reply_coment'][$g]->id_comentarios }}"></span> 
                              <span class="likes" id="likes_{{ $comments['reply_coment'][$g]->id_comentarios }}">{{ $comments['reply_coment'][$g]->likes_comentarios }}</span>
                            @else 
                              <span href="#" id="{{ $comments['reply_coment'][$g]->id_comentarios }}" onclick="like(this)" class="curtir fa-thumbs-up fa" data-id="{{ $comments['reply_coment'][$g]->id_comentarios }}"></span>
                              <span class="likes" id="likes_{{ $comments['reply_coment'][$g]->id_comentarios }}">{{$comments['reply_coment'][$g]->likes_comentarios }}</span>
                            @endif
                            @if(empty($comments['reply_coment'][$g]->edit_comentarios))
                              <span class="underline data-coment_foot">{{ Helper::tempo_corrido($comments['reply_coment'][$g]->data_comentarios)}}</span>
                            @else
                              <span class="underline data-coment_foot"><?='(editado) '. Helper::tempo_corrido($comments['reply_coment'][$g]->data_comentarios)?></span>
                            @endif
                            <div id="comentarios">
                              <form action="{{ route('comentario') }}" method="POST">
                                @csrf
                                <input name="conteudo" maxlength="255" style="width: 100%" type="text" class="btn-popup mr-sm-2" placeholder="<?='Em resposta a '.'@'. $comments['reply_coment'][$g]->usuario?>">
                                <input type="hidden" name="id_coment" value="{{ $comments['comentarios'][$f]->id_comentarios }}">
                                <input type="hidden" name="id_postagem" value="{{ $id_post }}">
                                <input type="hidden" name="id_mencionado" value="{{ $comments['reply_coment'][$g]->id }}">
                                <input type="submit" style="display: none" name="respostas">
                              </form>
                            </div>
                          </div>

                        </div>

                        <!--  Modal de edição de respostas de comentários -->
                        <div class="painel-dados">
                          <div class="modal fade id" id="popup{{$comments['reply_coment'][$g]->id_comentarios}}_edit" role="dialog">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body"> 
                                  <form action="{{ route('edit.coment') }}" method="POST"> 
                                    @csrf                   
                                    <div class="popup-title">
                                      <label style="vertical-align: top" for="editcomentario" class="bold subdados">Descrição:</label>
                                      <textarea name="editcomentario" id="edit_desc" cols="60" rows="1">{{$comments['reply_coment'][$g]->conteudo_comentarios }}</textarea>
                                      <input type="hidden" name="id_coment" value="{{ $comments['reply_coment'][$g]->id_comentarios }}">
                                      <input type="hidden" value="{{$id_post}}" name="id_postagem">
                                    </div>
                                  

                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    <input data-toggle="modal" data-target="#hiddenDiv" type="submit" class="btn btn-primary dropright" value="Salvar Alterações">
                                    
                                  </div> 
                                </form> 

                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!--  Modal para apagar subcomentários -->
                        <div class="painel-dados">
                          <div class="modal fade id" id="popup{{$comments['reply_coment'][$g]->id_comentarios}}_apagar1" role="dialog">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                </div>
                                <div class="modal-body"> 
                                  <p>Deseja realmente apagar este comentário?</p>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    <form action="{{route('apagar-coment')}}" method="POST">
                                      @csrf
                                      <input name="id_comentario" type="hidden" value="{{ $comments['reply_coment'][$g]->id_comentarios }}">
                                      <input data-toggle="modal" type="submit" class="btn btn-primary dropright" value="Apagar comentário">
                                      <input type="hidden" value="{{$id_post}}" name="id_postagem">
                                    </form>
                                  </div> 
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                      @endif
                    @endfor   
                    
                    <?php $count1 = $count1 + 1; ?>
                    @if($count > $limit && $count1 == $limit)
                      <?php break; ?>
                    @endif
                    

                  @endif
                @endfor
                @if($count > $limit && $count1 == $limit)
                  <form action="{{ url('/mostrar_coments') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_postagem" value="{{ $id_post }}">
                    <input name="count" type="hidden" value="{{ $count }}">
                    <button type="submit" class="hide btn btn-block btn-outline-primary" onclick="MostrarComents(this)">Mostrar mais comentários</button>
                  </form>
                @endif
              @endif
            </div>         
            <div class="modal-footer" style="margin-top: 10px"> 
              <p class="data-post">
                Postado em <?php echo date('d/m/Y', strtotime($rows['data_postagem'])); ?> às  <?php echo date('H:i', strtotime($rows['data_postagem'])); ?> horas
              </p>     
              <div class="popup-like">
                <img width="30px" src="{{ asset('img/like.png') }}">
                <p class="num-like"><?php echo $rows['likes_postagem']; ?></p>
              </div>   
            </div>
            </div>
        </div>
    </div>
</div>
</div>

    <!-- Popup de visualização de imagens -->
    <div class="popup_img_post">
      <div class="modal modal_img fade" id="img1<?php echo $id_post ?>" role="dialog">
          <button type="button" class="close btn_fechar" data-dismiss="modal">&times;</button>
        <div class="modal-dialog">
          <div class="modal-content modal_content">
              <div class="modal-body">
                  <button type="button" class="close btn_fechar_body" data-dismiss="modal">&times;</button>
                  <?php 
                      $nome_file = "ToDo/storage/app/public/posts/".'1'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg';
                      $nome_file_png = "ToDo/storage/app/public/posts/".'1'.$id_post.Str::kebab($rows['titulo_postagem']).'.png';  
                  ?>
                  @if(file_exists($nome_file))
                      <img id="img_post1" src="{{url('/ToDo/storage/app/public/posts/'.'1'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg')}}">
                  @elseif(file_exists($nome_file_png))
                      <img id="img_post1" src="{{url('/ToDo/storage/app/public/posts/'.'1'.$id_post.Str::kebab($rows['titulo_postagem']).'.png')}}">
                  @endif
              </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Fim Popup de visualização de imagens -->
    
    <!-- Popup de visualização de imagens2 -->
    <div class="popup_img_post">
    <div class="modal modal_img fade" id="img2<?php echo $id_post ?>" role="dialog">
      <button type="button" class="close btn_fechar" data-dismiss="modal">&times;</button>
      <div class="modal-dialog">
          
        <div class="modal-content modal_content">
            <div class="modal-body">
              <button type="button" class="close btn_fechar_body" data-dismiss="modal">&times;</button>
    
              <?php 
                  $nome_file2 = "ToDo/storage/app/public/posts/".'2'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg';
                  $nome_file_png2 = "ToDo/storage/app/public/posts/".'2'.$id_post.Str::kebab($rows['titulo_postagem']).'.png';  
              ?>
              @if(file_exists($nome_file2))
                  <img id="img_post1" src="{{url('/ToDo/storage/app/public/posts/'.'2'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg')}}">
              @elseif(file_exists($nome_file_png2))
                  <img id="img_post1" src="{{url('/ToDo/storage/app/public/posts/'.'2'.$id_post.Str::kebab($rows['titulo_postagem']).'.png')}}">
              @endif
          </div>
        </div>
      </div>
    </div>
    </div>
    <!-- Fim Popup de visualização de imagens2 -->
    
    <!-- Popup de visualização de imagens3 -->
    <div class="popup_img_post">
      <div class="modal modal_img fade" id="img3<?php echo $id_post ?>" role="dialog">
          <button type="button" class="close btn_fechar" data-dismiss="modal">&times;</button>
          <div class="modal-dialog">
          <div class="modal-content modal_content">
              <div class="modal-body">
                  <button type="button" class="close btn_fechar_body" data-dismiss="modal">&times;</button>
                  <?php 
                      $nome_file3 = "ToDo/storage/app/public/posts/".'3'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg';
                      $nome_file_png3 = "ToDo/storage/app/public/posts/".'3'.$id_post.Str::kebab($rows['titulo_postagem']).'.png';  
                  ?>
                  @if(file_exists($nome_file3))
                      <img id="img_post1" src="{{url('/ToDo/storage/app/public/posts/'.'3'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg')}}">
                  @elseif(file_exists($nome_file_png3))
                      <img id="img_post1" src="{{url('/ToDo/storage/app/public/posts/'.'3'.$id_post.Str::kebab($rows['titulo_postagem']).'.png')}}">
                  @endif
              </div>
          </div>
          </div>
      </div>
    </div>
    <!-- Fim Popup de visualização de imagens3 -->


<!--  Modal de avaliação  -->
<div class="modal fade bd-example-modal-lg" id="post<?php echo $id_post ?>_avaliar" tabindex="-1" role="dialog" id="modalideia" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @if($nivel == 3)
          <form action="{{ url('avaliar')}}" method="POST">
        @elseif($nivel == 2)
          <form action="{{ url('avaliar_aval')}}" method="POST">
        @endif
            @csrf
            <div class="modal-body">
                <div class="notas">
                  <div class="mb-2 ml-2 mt-2 mr-0">
                      <label for="inovacao" class="sub">
                        <img src="{{asset('img/inovacao.png')}}" style="width: 30px" alt="">
                        Inovação:
                      </label>
                      <input type="number" name="inovacao" id="inovacao{{$id_post}}" class="nota" step = "0.1" min="0" max="10" required>
                  </div>
                  <div class="mb-2 ml-2 mt-2 mr-0">
                      <label for="complexidade" class="sub">
                        <svg width="1.4em" height="1.4em" viewBox="0 0 16 16" class="bi bi-diagram-3" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 2 7h5.5V6A1.5 1.5 0 0 1 6 4.5v-1zM8.5 5a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1zM0 11.5A1.5 1.5 0 0 1 1.5 10h1A1.5 1.5 0 0 1 4 11.5v1A1.5 1.5 0 0 1 2.5 14h-1A1.5 1.5 0 0 1 0 12.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm4.5.5A1.5 1.5 0 0 1 7.5 10h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm4.5.5a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"/>
                        </svg>
                        Complexidade:
                      </label>
                      <input type="number" name="complexidade" id="complexidade{{$id_post}}" class="nota" step = "0.1" min="0" max="10" required>
                  </div>
                  <div class="mb-2 ml-2 mt-2 mr-0">
                      
                      <label for="potencial" class="sub">
                        <img src="{{asset('/img/potencial.png')}}" class="m-0 p-0" style="width: 27px" alt="">
                        Potencial de Mercado:
                      </label>
                      <input type="number" name="potencial" id="potencial{{$id_post}}" class="nota" step = "0.1" min="0" max="10"  required>
                  </div>
                </div>
                <div class="media container">
                    <div class="center_media">
                        <label for="media" class="sub_media no-gutters">
                          <img src="{{asset('img/avaliacao.png')}}" class="m-0 mb-1 p-0" width="27px">
                          Média:
                        </label>
                        <input class="nota nota_media" name="media" id="media{{$id_post}}" placeholder="Calculado pelo sistema" readonly>
                        <button type="button" class="calcular btn btn-primary" onclick="calcular({{$id_post}})">Calcular Média</button>
                    </div>
                    
                </div>
                <div class="coment_avaliador">
                    <label for="comentarios" style="vertical-align: top" class="sub_comentario">
                      <svg width="1.1em" height="1.1em" viewBox="0 0 16 16" class="bi bi-chat-right-text" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M2 1h12a1 1 0 0 1 1 1v11.586l-2-2A2 2 0 0 0 11.586 11H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zm12-1a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12z"/>
                        <path fill-rule="evenodd" d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                      </svg>&nbsp;
                      Comentário:
                    </label>
                    <textarea name="comentarios" class="comentarios" cols="80" rows="4" placeholder="Digite seu comentário..." required></textarea>
                </div>
                <input type="hidden" name="id_postagem" id="id_postagem1" value="{{ $id_post }}">
                <?php if(isset($rows['id'])){?><input type="hidden" name="id_usuario" value="{{ $rows['id'] }}"><?php }?>
                <input type="hidden" name="id_avaliador" value="{{ Auth::user()->id }}">
            </div>
            <div class="modal-footer-custom" style="border-top: 1px solid #ccc">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Finalizar avaliação</button>
            </div>
        </form>
    </div>
  </div>
</div>
<!-- Fim  Modal de avaliação  -->

@if(!empty(Session::get('id_postagem')))
  <script>
    var id_post = "<?php echo Session::get('id_postagem')?>"
    $(function() {
        $('#post'+id_post).modal('show');
    });
  </script>
@endif

{{-- <script>
  function ocultar(data) {
    var coment_id = $(data).data('id');
      // Requisição.
      
      
      window.open('#post'+75);
        
  };
</script> --}}
