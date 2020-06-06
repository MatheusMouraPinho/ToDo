<!-- Área de detalhes de ideias postadas -->

<div class="painel-dados">
    <div class="modal fade id" id="popup{{$posts->id_postagem}}" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="popup-title">
              <span class="popup_sub bold">Título:</span>
              <p class="popup_cont">{{$posts->titulo_postagem}}</p>
            </div>
            <div class="popup_desc">
              <span style="vertical-align: top" class="popup_sub bold">Descrição:</span>
              <textarea id="popup_cont_desc" cols="70" rows="5" disabled>{{ $posts->descricao_postagem }}</textarea>
            </div>
            <div>
              <span class="popup_sub bold">Categoria:</span>
              <p class="popup_coment">{{$dados['posts'][$i]->categoria_postagem}}</p>
            </div>
            <?php
              $nome_file = "../public/storage/posts/".'1'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.jpeg';
              $nome_file_png = "../public/storage/posts/".'1'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.png';
              $nome_file2 = "../public/storage/posts/".'2'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.jpeg';
              $nome_file_png2 = "../public/storage/posts/".'2'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.png';
              $nome_file3 = "../public/storage/posts/".'3'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.jpeg';
              $nome_file_png3 = "../public/storage/posts/".'3'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.png';
            ?>
            <div class="popup_img">
              <span class="popup_sub bold">Imagens:</span>
              @if(file_exists($nome_file))
                <img class="popup_imgs" id="img_post" data-toggle="modal" data-target="#img1<?php echo $posts->id_postagem ?>" src="{{url('storage/posts/'.'1'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.jpeg')}}">
              @elseif(file_exists($nome_file_png))
                <img class="popup_imgs" id="img_post" data-toggle="modal" data-target="#img1<?php echo $posts->id_postagem ?>" src="{{url('storage/posts/'.'1'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.png')}}">
              @else
                <img class="popup_imgs_null" src="{{asset('img/semimagem.jpg')}}">
              @endif
              @if(file_exists($nome_file2))
                <img class="popup_imgs" id="img_post" data-toggle="modal" data-target="#img2<?php echo $posts->id_postagem ?>" src="{{url('storage/posts/'.'2'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.jpeg')}}">
              @elseif(file_exists($nome_file_png2))
                <img class="popup_imgs" id="img_post" data-toggle="modal" data-target="#img2<?php echo $posts->id_postagem ?>" src="{{url('storage/posts/'.'2'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.png')}}">
              @else
                <img class="popup_imgs_null" src="{{asset('img/semimagem.jpg')}}">
              @endif
              @if(file_exists($nome_file3))
                <img class="popup_imgs" id="img_post" data-toggle="modal" data-target="#img3<?php echo $posts->id_postagem ?>" src="{{url('storage/posts/'.'3'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.jpeg')}}">
              @elseif(file_exists($nome_file_png3))
                <img class="popup_imgs" id="img_post" data-toggle="modal" data-target="#img3<?php echo $posts->id_postagem ?>" src="{{url('storage/posts/'.'3'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.png')}}">
              @else
                <img class="popup_imgs_null" src="{{asset('img/semimagem.jpg')}}">
              @endif
            </div>
            <div class="popup_aval">
              <span class="popup_sub bold">Avaliação:</span>
              @if(!empty($post['avaliacao'][0]))
                @for($c=0; $c<sizeof($post['avaliacao']); $c++)
                  @if($post['avaliacao'][$c]->id_postagem === $posts->id_postagem)
                    <p class="popup_avali">
                      <span class="bold">Inovação: </span>{{ $post['avaliacao'][$c]->inovacao_avaliacao }}
                    </p>
                    <p class="popup_avali">
                      <span class="bold">Potencial: </span>{{ $post['avaliacao'][$c]->potencial_avaliacao }}
                    </p>
                    <p class="popup_avali">
                      <span class="bold">Complexidade: </span>{{ $post['avaliacao'][$c]->complexidade_avaliacao }}
                    </p>
                    <p class="popup_avaliador">
                      <span class="bold">Avaliador: {{ $dados['avaliador'][$c]->usuario }}</span> 
                      <span class="underline">{{ date('d/m/Y', strtotime($post['avaliacao'][0]->data_avaliacao))}}</span><br>{{ $post['avaliacao'][$c]->comentario_avaliacao }}
                    </p>
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
            <div class="popup-aval">
              <span class="popup_sub bold">Comentários:</span>   
              <div style="margin-bottom: 15%">
                <form action="{{ route('comentario') }}" method="POST">
                  @csrf
                  <textarea required name="conteudo_comentarios" class="comentario" maxlength="255" cols="60" rows="2" placeholder="Digite aqui seu comentário"></textarea>
                  <input type="hidden" name="id_postagem" value="{{ $posts->id_postagem }}">
                  <input type="submit" name="comentario" class="btn btn-primary button_coment" value="Enviar">
                </form>
              </div>
              
              @if(!empty($post['comentarios'][0]))  
                @for($f=0; $f<sizeof($post['comentarios']); $f++)
                  @if($post['comentarios'][$f]->id_postagem === $posts->id_postagem)
                    <hr>
                    <div class="popup_coment_aval" id="id_comentario{{ $post['comentarios'][$f]->id_comentarios }}">
                      <div class="header-coment">
                        @if($post['comentarios'][$f]->img_usuarios === null)
                          <img class="img-dados-coment" src="{{asset('img/semuser.png')}}">
                        @else
                          <img  alt="{{ $post['comentarios'][$f]->img_usuarios }}" name="img_usuarios" class="img-dados-coment" src="{{asset('/storage/users/'.$post['comentarios'][$f]->img_usuarios)}}">
                        @endif
                        <form id="perfil" action="{{ route('perfil') }}" method="get">
                          @csrf
                          <input type="hidden" name="id_usuario" value="{{ $post['comentarios'][$f]->id }}">
                          <input class="bold user" type="submit" value="{{ $post['comentarios'][$f]->usuario}}">
                        </form>
                        <div class="dropdown dropdown1">

                          <!--Trigger-->
                         
                          <a class="btn-floating btn-lg "type="button" id="dropdownMenu2" data-toggle="dropdown"
                          aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                        
                        
                          <!--Menu-->
                          <div class="dropdown-menu dropdown-primary">
                            @if($post['comentarios'][$f]->id === Auth::user()->id)
                              <a id="edit" class="dropdown-item" href="#" style="cursor: pointer" data-toggle="modal" data-target="#popup{{$post['comentarios'][$f]->id_comentarios }}_edit1">Editar</a>
                              <a class="dropdown-item" href="#" style="cursor: pointer" data-toggle="modal" data-target="#popup{{$post['comentarios'][$f]->id_comentarios}}_apagar2">Apagar</a>
                            @else
                              <a class="dropdown-item" href="{{ url('/adm') }}">Denunciar</a>
                            @endif
                          </div>
                        </div> 
                        @if(empty($post['comentarios'][$f]->edit_comentarios))
                          <span class="underline data-coment">{{ Helper::tempo_corrido($post['comentarios'][$f]->data_comentarios)}}</span>
                        @else
                          <span class="underline data-coment"><?='(editado) '. Helper::tempo_corrido($post['comentarios'][$f]->data_comentarios)?></span>
                        @endif
                      </div>
                      <p class="conteudo-coment text-justify">{{ $post['comentarios'][$f]->conteudo_comentarios }}</p>
                      <div class="footer-coment">
                        <span class="mostrar">Responder</span>
                        <?php $resultados = Helper::verifica_like_coment($post['comentarios'][$f]->id_comentarios);$id_comentario = $post['comentarios'][$f]->id_comentarios;?>
                          @if($resultados == 0)
                            <span href="#" id="btn_like" class="curtir fa-thumbs-o-up fa" data-id="{{ $post['comentarios'][$f]->id_comentarios }}"></span> 
                            <span class="likes" id="likes_{{ $post['comentarios'][$f]->id_comentarios }}">{{ $post['comentarios'][$f]->likes_comentarios }}</span>
                          @else 
                          <span href="#" id="btn_like" class="curtir fa-thumbs-up fa" data-id="{{ $post['comentarios'][$f]->id_comentarios }}"></span>
                          <span class="likes" id="likes_{{ $post['comentarios'][$f]->id_comentarios }}">{{ $post['comentarios'][$f]->likes_comentarios }}</span>
                          @endif

                        <!--  Modal de edição de comentários -->
                          <div class="painel-dados">
                            <div class="modal fade id" id="popup{{$post['comentarios'][$f]->id_comentarios}}_edit1" role="dialog">
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
                                        <textarea name="editcomentario" id="edit_desc" cols="60" rows="1">{{$post['comentarios'][$f]->conteudo_comentarios }}</textarea>
                                        <input type="hidden" name="id_coment" value="{{ $post['comentarios'][$f]->id_comentarios }}">
                                      </div>
                                    

                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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
                            <input name="conteudo" maxlength="255" style="width: 100%" type="text" class="btn-popup mr-sm-2" placeholder="<?='Em resposta a '.'@'. $post['comentarios'][$f]->usuario?>">
                            <input type="hidden" name="id_coment" value="{{ $post['comentarios'][$f]->id_comentarios }}">
                            <input type="hidden" name="id_postagem" value="{{ $posts->id_postagem }}">
                            <input type="hidden" name="id_mencionado" value="{{ $post['comentarios'][$f]->id }}">
                            <input type="submit" style="display: none" name="respostas">
                          </form>
                        </div>
                      </div>
                      
                    </div> 
                    
                    <!--  Modal para apagar comentários -->
                  <div class="painel-dados">
                    <div class="modal fade id" id="popup{{$post['comentarios'][$f]->id_comentarios}}_apagar2" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                          </div>
                          <div class="modal-body"> 
                            <p>Deseja realmente apagar este comentário?</p>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                              <form action="{{route('apagar-coment')}}" method="POST">
                                @csrf
                                <input name="id_comentario" type="hidden" value="{{ $post['comentarios'][$f]->id_comentarios }}">
                                <input data-toggle="modal" type="submit" class="btn btn-primary dropright" value="Apagar comentário">
                              </form>
                            </div> 
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>         
                  @endif
                  @for($g=0; $g<sizeof($post['reply_coment']); $g++)
                    @if($post['reply_coment'][$g]->id_postagem === $posts->id_postagem && $post['comentarios'][$f]->id_comentarios === $post['reply_coment'][$g]->id_comentarios_ref)
                      <div class="popup_coment_aval" id="respostas" style="margin-top: 10px; width: 95%;margin-left:5%">
                        
                        <div class="header-coment">
                          <div class="dropdown dropdown1">

                            <!--Trigger-->
                           
                            <a class="btn-floating btn-lg black"type="button" id="dropdownMenu3" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                          
                          
                            <!--Menu-->
                            <div class="dropdown-menu dropdown-primary">
                              @if($post['reply_coment'][$g]->id === Auth::user()->id)
                                <a class="dropdown-item" data-toggle="modal" style="cursor: pointer" data-target="#popup{{$post['reply_coment'][$g]->id_comentarios }}_edit">Editar</a>
                                <a class="dropdown-item" style="cursor: pointer" data-toggle="modal" data-target="#popup{{$post['reply_coment'][$g]->id_comentarios }}_apagar1">Apagar</a>
                              @else
                                {{-- <form id="denunciar" action="{{ route('denunciar') }}" method="POST">
                                  @csrf
                                  <input type="hidden" name="id_subcomentario" value="{{$post['reply_coment'][$g]->id_subcomentarios}}"> --}}
                                  <a class="dropdown-item" href="#">Denunciar</a>
                                {{-- </form> --}}
                              @endif
                            </div>
                          </div>
                          @if(empty($post['reply_coment'][$g]->edit_comentarios))
                            <span class="underline data-coment">{{ Helper::tempo_corrido($post['reply_coment'][$g]->data_comentarios)}}</span>
                          @else
                            <span class="underline data-coment"><?='(editado) '. Helper::tempo_corrido($post['reply_coment'][$g]->data_comentarios)?></span>
                          @endif
                          <div>
                            @if($post['reply_coment'][$g]->img_usuarios === null)
                              <img class="img-dados-coment" src="{{asset('img/semuser.png')}}">
                            @else
                              <img alt="{{ $post['reply_coment'][$g]->img_usuarios }}" name="img_usuarios" class="img-dados-coment" src="{{asset('/storage/users/'.$post['reply_coment'][$g]->img_usuarios)}}">
                            @endif
                            <form id="perfil" action="{{ route('perfil') }}" method="get">
                              @csrf
                              <input type="hidden" name="id_usuario" value="{{ $post['reply_coment'][$g]->id }}">
                              <input alt="" class="bold user" type="submit" value="{{ $post['reply_coment'][$g]->usuario}}">
                            </form>
                          </div>
                          
                        </div>
                        @for($k=0; $k<sizeof($post['mencionado']);$k++)
                          @if($post['mencionado'][$k]->id_comentarios === $post['reply_coment'][$g]->id_comentarios)
                            <form id="perfil" action="{{ route('perfil') }}" method="get">
                              @csrf
                              <input type="hidden" name="id_usuario" value="{{ $post['mencionado'][$k]->id }}">
                              <input class="mencionado" type="submit" value="{{'@'. $post['mencionado'][$k]->usuario }}">
                            </form>
                          @endif
                        @endfor
                        <p class="conteudo-coment">{{ $post['reply_coment'][$g]->conteudo_comentarios }}</p>
                      
                        <div class="footer-coment">
                          <span class="mostrar">Responder</span>
                          <?php $resultados = Helper::verifica_like_coment($post['reply_coment'][$g]->id_comentarios)?>
                          @if($resultados == 0)
                            <span href="#" id="{{ $post['reply_coment'][$g]->id_comentarios }}" class="curtir fa-thumbs-o-up fa" data-id="{{ $post['reply_coment'][$g]->id_comentarios }}"></span> 
                            <span class="likes" id="likes_{{ $post['reply_coment'][$g]->id_comentarios }}">{{ $post['reply_coment'][$g]->likes_comentarios }}</span>
                          @else 
                            <span href="#" id="{{ $post['reply_coment'][$g]->id_comentarios }}" class="curtir fa-thumbs-up fa" data-id="{{ $post['reply_coment'][$g]->id_comentarios }}"></span>
                            <span class="likes" id="likes_{{ $post['reply_coment'][$g]->id_comentarios }}">{{$post['reply_coment'][$g]->likes_comentarios }}</span>
                          @endif
                          <div id="comentarios">
                            <form action="{{ route('comentario') }}" method="POST">
                              @csrf
                              <input name="conteudo" maxlength="255" style="width: 100%" type="text" class="btn-popup mr-sm-2" placeholder="<?='Em resposta a '.'@'. $post['reply_coment'][$g]->usuario?>">
                              <input type="hidden" name="id_coment" value="{{ $post['comentarios'][$f]->id_comentarios }}">
                              <input type="hidden" name="id_postagem" value="{{ $posts->id_postagem }}">
                              <input type="hidden" name="id_mencionado" value="{{ $post['reply_coment'][$g]->id }}">
                              <input type="submit" style="display: none" name="respostas">
                            </form>
                          </div>
                        </div>

                      </div>

                      <!--  Modal de edição de respostas de comentários -->
                      <div class="painel-dados">
                        <div class="modal fade id" id="popup{{$post['reply_coment'][$g]->id_comentarios}}_edit" role="dialog">
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
                                    <textarea name="editcomentario" id="edit_desc" cols="60" rows="1">{{$post['reply_coment'][$g]->conteudo_comentarios }}</textarea>
                                    <input type="hidden" name="id_coment" value="{{ $post['reply_coment'][$g]->id_comentarios }}">
                                  </div>
                                

                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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
                        <div class="modal fade id" id="popup{{$post['reply_coment'][$g]->id_comentarios}}_apagar1" role="dialog">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                              </div>
                              <div class="modal-body"> 
                                <p>Deseja realmente apagar este comentário?</p>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                  <form action="{{route('apagar-coment')}}" method="POST">
                                    @csrf
                                    <input name="id_comentario" type="hidden" value="{{ $post['reply_coment'][$g]->id_comentarios }}">
                                    <input data-toggle="modal" type="submit" class="btn btn-primary dropright" value="Apagar comentário">
                                  </form>
                                </div> 
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                    @endif
                  @endfor
                @endfor
              @endif
            </div>           
            <div class="modal-footer" style="margin-top: 20px">
              <div class="popup-like">
                <img width="30px" src="{{ asset('img/like.png') }}">
                <p class="num-like">{{$posts->likes_postagem}}</p>
              </div>   
              <p class="data-post">
                Postado em {{date('d/m/Y', strtotime($posts->data_postagem))}} às  {{date('H:i:s', strtotime($posts->data_postagem))}} horas
              </p>
                     
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php $i = $i + 1?>
  <!-- Fim área de detalhes de ideias postadas-->

  <!-- Popup de visualização de imagens -->
  <div class="popup_img_post">
    <div class="modal modal_img fade" id="img1<?php echo $posts->id_postagem ?>" role="dialog">
        <button type="button" class="close btn_fechar" data-dismiss="modal">&times;</button>
      <div class="modal-dialog">
        <div class="modal-content modal_content">
            <div class="modal-body">
                <button type="button" class="close btn_fechar_body" data-dismiss="modal">&times;</button>
                <?php 
                    $nome_file = "../public/storage/posts/".'1'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.jpeg';
                    $nome_file_png = "../public/storage/posts/".'1'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.png';  
                ?>
                @if(file_exists($nome_file))
                    <img id="img_post1" src="{{url('storage/posts/'.'1'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.jpeg')}}">
                @elseif(file_exists($nome_file_png))
                    <img id="img_post1" src="{{url('storage/posts/'.'1'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.png')}}">
                @endif
            </div>
        </div>
      </div>
    </div>
</div>
  <!-- Fim Popup de visualização de imagens -->

  <!-- Popup de visualização de imagens2 -->
<div class="popup_img_post">
  <div class="modal modal_img fade" id="img2<?php echo $posts->id_postagem ?>" role="dialog">
    <button type="button" class="close btn_fechar" data-dismiss="modal">&times;</button>
    <div class="modal-dialog">
        
      <div class="modal-content modal_content">
          <div class="modal-body">
            <button type="button" class="close btn_fechar_body" data-dismiss="modal">&times;</button>

            <?php 
                $nome_file2 = "../public/storage/posts/".'2'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.jpeg';
                $nome_file_png2 = "../public/storage/posts/".'2'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.png';  
            ?>
            @if(file_exists($nome_file2))
                <img id="img_post1" src="{{url('storage/posts/'.'2'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.jpeg')}}">
            @elseif(file_exists($nome_file_png2))
                <img id="img_post1" src="{{url('storage/posts/'.'2'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.png')}}">
            @endif
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Fim Popup de visualização de imagens2 -->

<!-- Popup de visualização de imagens3 -->
<div class="popup_img_post">
    <div class="modal modal_img fade" id="img3<?php echo $posts->id_postagem ?>" role="dialog">
        <button type="button" class="close btn_fechar" data-dismiss="modal">&times;</button>
        <div class="modal-dialog">
        <div class="modal-content modal_content">
            <div class="modal-body">
                <button type="button" class="close btn_fechar_body" data-dismiss="modal">&times;</button>
                <?php 
                    $nome_file3 = "../public/storage/posts/".'3'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.jpeg';
                    $nome_file_png3 = "../public/storage/posts/".'3'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.png';  
                ?>
                @if(file_exists($nome_file3))
                    <img id="img_post1" src="{{url('storage/posts/'.'3'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.jpeg')}}">
                @elseif(file_exists($nome_file_png3))
                    <img id="img_post1" src="{{url('storage/posts/'.'3'.$posts->id_postagem.Str::kebab($posts->titulo_postagem).'.png')}}">
                @endif
            </div>
        </div>
        </div>
    </div>
</div>

<!-- Fim Popup de visualização de imagens3 -->