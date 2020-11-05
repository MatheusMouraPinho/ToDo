<!-- Área de detalhes de ideias postadas -->

<div class="painel-dados">
    <div class="modal fade id" id="popup{{$posts->id_postagem}}" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="popup-title">
              <p class="h4 title-popup" style="text-align: center; font-weight:bold">
                {{$posts->titulo_postagem}}
              </p>
            </div>
            <div class="popup_desc">
              <span style="vertical-align: top" class="popup_sub bold">
                <svg width="1.1em" height="1.1em" viewBox="0 0 16 16" class="bi bi-justify-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                </svg>&nbsp;
                Descrição:
              </span>
              <p id="popup_cont_desc" class="text-justify">{{ $posts->descricao_postagem }}</p>
            </div>
            <div>
              <span class="popup_sub bold">
                <svg width="1.1em" height="1.2em" viewBox="0 0 16 16" class="bi bi-list-ul" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                </svg>&nbsp;
                Categoria:
              </span>
              <p class="popup_coment" id="categoria">{{$dados['posts'][$i]->categoria_postagem}}</p>
            </div>

            @for($a=0; $a<sizeof($post['img_post']); $a++)
              @if($post['img_post'][$a]->id_postagem == $posts->id_postagem)
                <div class="popup_img">
                  <span class="popup_sub bold">
                    <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-link-45deg" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path d="M4.715 6.542L3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.001 1.001 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z"/>
                      <path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 0 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 0 0-4.243-4.243L6.586 4.672z"/>
                    </svg>
                    Imagens:
                  </span>
                  <div class="div_imgs">
                    @for($t=0; $t<sizeof($post['img_post']); $t++)
                      @if($post['img_post'][$t]->id_postagem === $posts->id_postagem)
                        @if(Str::substr($post['img_post'][$t]->img_post, 30, 1) == 1)
                          <img class="popup_imgs" id="<?php echo 'img1'.$posts->id_postagem ?>" onclick="show_modal('img1'+<?php echo $posts->id_postagem ?>)" src="{{url($post['img_post'][$t]->img_post)}}">
                        @endif
                        @if(Str::substr($post['img_post'][$t]->img_post, 30, 1) == 2)
                          <img class="popup_imgs" id="<?php echo 'img2'.$posts->id_postagem ?>" onclick="show_modal('img2'+<?php echo $posts->id_postagem ?>)" src="{{url($post['img_post'][$t]->img_post)}}">
                        @endif
                        @if(Str::substr($post['img_post'][$t]->img_post, 30, 1) == 3)
                          <img class="popup_imgs" id="<?php echo 'img3'.$posts->id_postagem ?>" onclick="show_modal('img3'+<?php echo $posts->id_postagem ?>)" src="{{url($post['img_post'][$t]->img_post)}}">
                        @endif
                      @endif
                    @endfor 
                  </div> 
                </div>
                <?php break; ?>
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
              @if(!empty($post['avaliacao'][0]))
                @for($c=0; $c<sizeof($post['avaliacao']); $c++)
                  @if($post['avaliacao'][$c]->id_postagem === $posts->id_postagem)
                    <div class="div_notas">
                      <p class="popup_avali">
                        <span class="bold d-block">Inovação: </span><span style="font-size: 1.1em">{{ $post['avaliacao'][$c]->inovacao_avaliacao }}</span>
                      </p>
                      <p class="popup_avali">
                        <span class="bold d-block">Potencial: </span><span style="font-size: 1.1em">{{ $post['avaliacao'][$c]->potencial_avaliacao }}</span>
                      </p>
                      <p class="popup_avali">
                        <span class="bold d-block">Complexidade: </span><span style="font-size: 1.1em">{{ $post['avaliacao'][$c]->complexidade_avaliacao }}</span>
                      </p>
                    </div>
                    <div class="popup_coment_aval" id="avaliacao">
                      <div class="header-coment">
                        @if($dados['avaliador'][$c]->nivel > 1)
                          <div class="p-1 w-50 show_selo">
                            <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-person-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zm4.854-7.85a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                            </svg>
                            <span>Avaliador</span>
                          </div>
                        @endif
                        @if($dados['avaliador'][$c]->img_usuarios === null)
                            <img class="img-dados-coment" src="{{asset('img/semuser.png')}}">
                          @else
                            <img  alt="{{ $dados['avaliador'][$c]->img_usuarios }}" name="img_usuarios" class="img-dados-coment" src="{{asset('/ToDo/storage/app/public/users/'.$dados['avaliador'][$c]->img_usuarios)}}">
                          @endif
                          <form id="perfil" action="{{ route('perfil') }}" method="get">
                            @csrf
                            <input type="hidden" name="id_usuario" value="{{ $dados['avaliador'][$c]->id }}">
                            <input class="bold user" type="submit" value="{{ $dados['avaliador'][$c]->usuario}}">
                          </form>
                          @if($dados['avaliador'][$c]->nivel > 1)
                            <div class="bola"> </div>
                            <div class="selo p-1 ml-2">
                              <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-person-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zm4.854-7.85a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                              </svg>
                              <span>Avaliador</span>
                            </div>
                          @endif
                        <span class="underline data-coment" style="margin-right: 10px">{{ Helper::tempo_corrido($post['avaliacao'][$c]->data_comentarios)}}</span>
                      </div>
                      
                      <p class="conteudo-coment text-justify" id="comentario">{{ $post['avaliacao'][$c]->conteudo_comentarios }}</p>
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
                  <?php $cont = 0;?>
                  @for($d=0;$d<sizeof($post['avaliacao']);$d++)
                    @if($post['avaliacao'][$d]->id_postagem !== $posts->id_postagem)
                      <?php 
                        $cont+= 1 ;
                      ?>
                    @endif
                  @endfor
                @endfor
                @if($cont === sizeof($post['avaliacao']))
                  <p class="popup_coment">Pendente</p>
                @endif
              @else
                <p class="popup_coment">Pendente</p>
              @endif
              
            </div>
            <hr>
            <div class="popup_aval">
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
                  <input type="hidden" name="id_postagem" value="{{ $posts->id_postagem }}">
                  <input type="submit" name="comentario" class="btn btn-primary button_coment" value="Enviar">
                </form>
              </div>

              @if(!empty($comments['comentarios'][0]))  
                @for($f=0; $f<sizeof($comments['comentarios']); $f++)
                  @if($comments['comentarios'][$f]->id_postagem === $posts->id_postagem)
                    <form action="{{ route('ordenar') }}" method="POST">
                      @csrf
                      <div class="div_ordenar">
                        <p class="font-weight-bold m-0 p-1">
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
                        <input type="hidden" name="id_postagem" value="{{ $posts->id_postagem }}">
                      </div>
                    </form>
                    <?php break; ?>
                  @endif
                @endfor
              @endif
              
              @if(!empty($comments['comentarios'][0]))  
                @for($f=0; $f<sizeof($comments['comentarios']); $f++)
                  @if($comments['comentarios'][$f]->id_postagem === $posts->id_postagem)
                    
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
                         
                          <a class="btn-floating btn-lg"type="button" id="dropdownMenu2" data-toggle="dropdown"
                          aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                        
                        
                          <!--Menu-->
                          <div class="dropdown-menu dropdown-primary">
                            @if($comments['comentarios'][$f]->id === Auth::user()->id)
                              <a id="edit" class="dropdown-item" href="#" style="cursor: pointer" data-toggle="modal" data-target="#popup{{$comments['comentarios'][$f]->id_comentarios }}_edit1">
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
                            <span href="#" id="btn_like" onclick="like(this)" class="curtir fa-thumbs-up fa" data-id="{{ $comments['comentarios'][$f]->id_comentarios }}"></span>
                            <span class="likes" id="likes_{{ $comments['comentarios'][$f]->id_comentarios }}">{{ $comments['comentarios'][$f]->likes_comentarios }}</span>
                          @endif
                        @if(empty($comments['comentarios'][$f]->edit_comentarios))
                          <span class="underline data-coment_foot">{{ Helper::tempo_corrido($comments['comentarios'][$f]->data_comentarios)}}</span>
                        @else
                          <span class="underline data-coment_foot"><?='(editado) '. Helper::tempo_corrido($comments['comentarios'][$f]->data_comentarios)?></span>
                        @endif
                  
                        <div id="comentarios">
                          <form action="{{ route('comentario') }}" method="POST">
                            @csrf
                            <input name="conteudo" maxlength="255" style="width: 100%" type="text" class="btn-popup mr-sm-2" placeholder="<?='Em resposta a '.'@'. $comments['comentarios'][$f]->usuario?>">
                            <input type="hidden" name="id_coment" value="{{ $comments['comentarios'][$f]->id_comentarios }}">
                            <input type="hidden" name="id_postagem" value="{{ $posts->id_postagem }}">
                            <input type="hidden" name="id_mencionado" value="{{ $comments['comentarios'][$f]->id }}">
                            <input type="submit" style="display: none" name="respostas">
                          </form>
                        </div>
                      </div>
                      
                    </div> 
                    
                  @endif
                  @for($g=0; $g<sizeof($comments['reply_coment']); $g++)
                    @if($comments['reply_coment'][$g]->id_postagem === $posts->id_postagem && $comments['comentarios'][$f]->id_comentarios === $comments['reply_coment'][$g]->id_comentarios_ref)
                      <div class="popup_coment_aval" id="respostas">
                        
                        <div class="header-coment">
                          <div class="dropdown dropdown1">

                            <!--Trigger-->
                           
                            <a class="btn-floating btn-lg"type="button" id="dropdownMenu3" data-toggle="dropdown"
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
                        </div>
                          <div>
                            @if($comments['reply_coment'][$g]->nivel > 1)
                              <div class="p-1 w-50 show_selo">
                                <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-person-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zm4.854-7.85a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                </svg>
                                <span>Avaliador</span>
                              </div>
                            @endif
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
                          
                        @if(empty($comments['reply_coment'][$g]->edit_comentarios))
                          <span class="underline data-coment">{{ Helper::tempo_corrido($comments['reply_coment'][$g]->data_comentarios)}}</span>
                        @else
                          <span class="underline data-coment clearfix"><?='(editado) '. Helper::tempo_corrido($comments['reply_coment'][$g]->data_comentarios)?></span>
                        @endif
                      </div>
                        <div class="body_coment d-block>
                          @for($k=0; $k<sizeof($post['mencionado']);$k++)
                            @if($post['mencionado'][$k]->id_comentarios === $comments['reply_coment'][$g]->id_comentarios)
                              <form id="perfil" action="{{ route('perfil') }}" method="get">
                                @csrf
                                <input type="hidden" name="id_usuario" value="{{ $post['mencionado'][$k]->id }}">
                                <input class="mencionado" type="submit" value="{{'@'. $post['mencionado'][$k]->usuario }}">
                              </form>
                            @endif
                          @endfor
                          <p class="conteudo-coment">{{ $comments['reply_coment'][$g]->conteudo_comentarios }}</p>
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
                              <input type="hidden" name="id_postagem" value="{{ $posts->id_postagem }}">
                              <input type="hidden" name="id_mencionado" value="{{ $comments['reply_coment'][$g]->id }}">
                              <input type="submit" style="display: none" name="respostas">
                            </form>
                          </div>
                        </div>

                      </div>
                      
                    @endif
                  @endfor
                @endfor
              @endif
            </div>  
                
            <div class="modal-footer mt-2"> 
              <p class="data-post">
                Postado em {{date('d/m/Y', strtotime($posts->data_postagem))}} às  {{date('H:i:s', strtotime($posts->data_postagem))}} horas
              </p>
              <div class="popup-like">
                <img width="30px" src="{{ asset('img/like.png') }}">
                <p class="num-like">{{$posts->likes_postagem}}</p>
              </div>     
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php $i = $i + 1?>

  <!-- Fim área de detalhes de ideias postadas-->

<!-- Popup de visualização de imagens -->
  <div class="modal_imgs" id="img_modal">
    <div class="modal_content">
      <button type="button" class="close btnClose" onclick="hide_modal(); getWidth()" data-dismiss="modal">&times;</button>
      <img id="img_post1" class="modal_img" src="" onclick="">
    </div>
  </div>
<!-- Fim Popup de visualização de imagens -->

@for($v=0; $v < sizeof($comments['comentarios']); $v++)
  @if($comments['comentarios'][$v]->id == $user && $comments['comentarios'][$v]->id_postagem == $posts->id_postagem)
  <!--  Modal para apagar comentários -->
  <div class="painel-dados">
    <div class="modal fade id " id="popup{{$comments['comentarios'][$v]->id_comentarios}}_apagar2" role="dialog" style="background-color: rgb(0, 0, 0, .7);">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body"> 
            <p>Deseja realmente apagar este comentário?</p>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
              <form action="{{route('apagar-coment')}}" method="POST">
                @csrf
                <input name="id_comentario" type="hidden" value="{{ $comments['comentarios'][$v]->id_comentarios }}">
                <input type="hidden" value="{{$comments['comentarios'][$v]->id_postagem}}" name="id_postagem">
                <button type="submit" class="btn btn-primary">Confirmar</button>
              </form>
            </div> 
          </div>
        </div>
      </div>
    </div>
  </div>      
  
  <!--  Modal de edição de comentários -->
  <div class="painel-dados">
    <div class="modal fade id" id="popup{{$comments['comentarios'][$v]->id_comentarios}}_edit1" role="dialog" style="background-color: rgb(0, 0, 0, .7);">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body"> 
            <form action="{{ route('edit.coment') }}" method="POST"> 
              @csrf                   
              <div class="div-edit">
                <label style="vertical-align: top" for="editcomentario" class="bold subedit">Descrição:</label>
                <textarea name="editcomentario" id="edit_desc" cols="60" rows="1" required maxlength="255">{{$comments['comentarios'][$v]->conteudo_comentarios }}</textarea>
                <input type="hidden" name="id_coment" value="{{ $comments['comentarios'][$v]->id_comentarios }}">
                <input type="hidden" value="{{$comments['comentarios'][$v]->id_postagem}}" name="id_postagem">
              </div>
            

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
              <button data-toggle="modal" type="submit" class="btn btn-primary">Salvar Alterações</button>
            </div> 
          </form> 

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Fim modal de edição de comentarios -->
  
  @elseif($comments['comentarios'][$v]->id != $user && $comments['comentarios'][$v]->id_postagem == $posts->id_postagem)
  <!-- Modal denunciar comentario -->
  <div class="modal fade id" id="den_comen{{$comments['comentarios'][$v]->id_comentarios}}" role="dialog" style="background-color: rgb(0, 0, 0, .7);">
    <div class="modal-dialog modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
          </button>
      </div>
        <form action="{{url('/denunciar_comentario')}}" method="POST">
            @csrf
            <div class="modal-body">
                <h3><p>Denunciar Comentario por:</p></h3><br>
                <h6>
                    <label class="radio-custom">Conteúdo Inadequado
                        <input type="radio" id="radio1" type="radio" name="option" value="3" required>
                        <span class="checkmark"></span>
                    </label>
                    <label class="radio-custom">Spam
                        <input type="radio" id="radio2" type="radio" name="option" value="1" required>
                        <span class="checkmark"></span>
                    </label>
                    <label class="radio-custom">Copia
                        <input type="radio" id="radio3" type="radio" name="option" value="2" required>
                        <span class="checkmark"></span>
                    </label>
                </h6>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <input name="id_comentario" type="hidden" value="{{$comments['comentarios'][$v]->id_comentarios}}">
                    <input name="id_usuario" type="hidden" value="<?php echo $user;?>">
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div> 
            </div>
        </form>
    </div>
  </div>
  <!-- FIM Modal denunciar comentario -->
  @endif

  @endfor  
  
  @for($r=0; $r<sizeof($comments['reply_coment']); $r++)

    @if($comments['reply_coment'][$r]->id == $user && $comments['reply_coment'][$r]->id_postagem == $posts->id_postagem)
      <!--  Modal de edição de respostas de comentários -->
      <div class="painel-dados">
        <div class="modal fade id" id="popup{{$comments['reply_coment'][$r]->id_comentarios}}_edit" role="dialog" style="background-color: rgb(0, 0, 0, .7);">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body"> 
                <form action="{{ route('edit.coment') }}" method="POST"> 
                  @csrf                   
                  <div class="div-edit">
                    <label style="vertical-align: top" for="editcomentario" class="bold subedit">Descrição:</label>
                    <textarea name="editcomentario" id="edit_desc" cols="60" rows="1" required maxlength="255">{{$comments['reply_coment'][$r]->conteudo_comentarios }}</textarea>
                    <input type="hidden" name="id_coment" value="{{ $comments['reply_coment'][$r]->id_comentarios }}">
                    <input type="hidden" value="{{$comments['reply_coment'][$r]->id_postagem}}" name="id_postagem">
                  </div>
                

                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                      <button data-toggle="modal" data-target="#hiddenDiv" type="submit" class="btn btn-primary">Salvar Alterações</button>
                  
                </div> 
              </form> 

              </div>
            </div>
          </div>
        </div>
      </div>
      <!--  Fim modal de edição de respostas de comentários -->

      <!--  Modal para apagar subcomentários -->
      <div class="painel-dados">
        <div class="modal fade id" id="popup{{$comments['reply_coment'][$r]->id_comentarios}}_apagar1" role="dialog" style="background-color: rgb(0, 0, 0, .7);">
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
                    <input name="id_comentario" type="hidden" value="{{ $comments['reply_coment'][$r]->id_comentarios }}">
                    <input data-toggle="modal" type="submit" class="btn btn-primary dropright" value="Apagar comentário">
                    <input type="hidden" value="{{$comments['reply_coment'][$r]->id_postagem}}" name="id_postagem">
                  </form>
                </div> 
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--  Modal para apagar subcomentários -->
    
      @elseif($comments['reply_coment'][$r]->id != $user && $comments['reply_coment'][$r]->id_postagem == $posts->id_postagem)
      <!-- Modal denunciar comentario Reply -->
      <div class="modal fade id" id="den_comen_reply{{$comments['reply_coment'][$r]->id_comentarios }}" role="dialog" style="background-color: rgb(0, 0, 0, .7);">
        <div class="modal-dialog modal-content">
            <div class="modal-header"></div>
            <form action="/denunciar_comentario" method="POST">
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <input name="id_comentario" type="hidden" value="{{$comments['reply_coment'][$r]->id_comentarios }}">
                        <input name="id_usuario" type="hidden" value="<?php echo $user;?>">
                        <input data-toggle="modal" type="submit" class="btn btn-primary" value="Confirmar">
                    </div> 
                </div>
            </form>
        </div>
    </div>
    <!-- FIM Modal denunciar comentario reply -->
    @endif
  @endfor

@if(!empty(Session::get('id_postagem')))
  <script>
      var id_post = "<?php echo Session::get('id_postagem') ?>";
      $(function() {
          $('#popup'+id_post).modal('show')
          $('.modal')
          .on({
              'show.bs.modal': function() {
                  var idx = $('.modal:visible').length;
                  $(this).css('z-index', 1040 + (10 * idx));
              },
              'shown.bs.modal': function() {
                  var idx = ($('.modal:visible').length) - 1; // raise backdrop after animation.
                  $('.modal-backdrop').not('.stacked')
                  .css('z-index', 1039 + (10 * idx))
                  .addClass('stacked');
              },
              'hidden.bs.modal': function() {
                  if ($('.modal:visible').length > 0) {
                      // restore the modal-open class to the body element, so that scrolling works
                      // properly after de-stacking a modal.
                      setTimeout(function() {
                          $(document.body).addClass('modal-open');
                      }, 0);
                  }
              }
          });
      })
      
  </script>
@endif