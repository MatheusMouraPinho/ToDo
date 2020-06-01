<?php if($rows['id_categoria'] == '1' ){ $categoria = "Desenvolvimento Web"; }elseif($rows['id_categoria'] == "2"){ $categoria = "Design & Criação"; }elseif($rows['id_categoria'] == "3"){$categoria = "Engenharia & Arquitetura";
}elseif($rows['id_categoria'] == "4"){$categoria = "Marketing";}elseif($rows['id_categoria'] == "5"){$categoria = "Fotografia & AudioVisual";}else{$categoria = "Sem categoria";}?>

<?php
    $nivel = Auth::user()->nivel;
    $id_nivel = 0; 
    if($nivel >= 2){$id_nivel = 1;}
?>

<!-- Área de detalhes de ideias postadas -->

<div class="painel-dados">
    <div class="modal fade id" id="post<?php echo $id_post ?>" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="popup-title">
              <span class="popup_sub bold">Título:</span>
              <p class="popup_cont"><?php echo $rows['titulo_postagem']; ?></p>
            </div>
            <div class="popup_desc">
              <span style="vertical-align: top" class="popup_sub bold">Descrição:</span>
              <textarea id="popup_cont_desc" cols="70" rows="5" disabled><?php echo $rows['descricao_postagem']; ?></textarea>
            </div>
            <div>
              <span class="popup_sub bold">Categoria:</span>
              <p class="popup_coment"><?php echo $categoria ?></p>
            </div>
            <?php
              $nome_file = "../public/storage/posts/".'1'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg';
              $nome_file_png = "../public/storage/posts/".'1'.$id_post.Str::kebab($rows['titulo_postagem']).'.png';
              $nome_file2 = "../public/storage/posts/".'2'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg';
              $nome_file_png2 = "../public/storage/posts/".'2'.$id_post.Str::kebab($rows['titulo_postagem']).'.png';
              $nome_file3 = "../public/storage/posts/".'3'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg';
              $nome_file_png3 = "../public/storage/posts/".'3'.$id_post.Str::kebab($rows['titulo_postagem']).'.png';
            ?>
            <div class="popup_img">
              <span class="popup_sub bold">Imagens:</span>
              @if(file_exists($nome_file))
                <img class="popup_imgs" id="img_post" data-toggle="modal" data-target="#img1<?php echo $id_post ?>" src="{{url('storage/posts/'.'1'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg')}}">
              @elseif(file_exists($nome_file_png))
                <img class="popup_imgs" id="img_post" data-toggle="modal" data-target="#img1<?php echo $id_post ?>" src="{{url('storage/posts/'.'1'.$id_post.Str::kebab($rows['titulo_postagem']).'.png')}}">
              @else
                <img class="popup_imgs_null" src="{{asset('img/semimagem.jpg')}}">
              @endif
              @if(file_exists($nome_file2))
                <img class="popup_imgs" id="img_post" data-toggle="modal" data-target="#img2<?php echo $id_post ?>" src="{{url('storage/posts/'.'2'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg')}}">
              @elseif(file_exists($nome_file_png2))
                <img class="popup_imgs" id="img_post" data-toggle="modal" data-target="#img2<?php echo $id_post ?>" src="{{url('storage/posts/'.'2'.$id_post.Str::kebab($rows['titulo_postagem']).'.png')}}">
              @else
                <img class="popup_imgs_null" src="{{asset('img/semimagem.jpg')}}">
              @endif
              @if(file_exists($nome_file3))
                <img class="popup_imgs" id="img_post" data-toggle="modal" data-target="#img3<?php echo $id_post ?>" src="{{url('storage/posts/'.'3'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg')}}">
              @elseif(file_exists($nome_file_png3))
                <img class="popup_imgs" id="img_post" data-toggle="modal" data-target="#img3<?php echo $id_post ?>" src="{{url('storage/posts/'.'3'.$id_post.Str::kebab($rows['titulo_postagem']).'.png')}}">
              @else
                <img class="popup_imgs_null" src="{{asset('img/semimagem.jpg')}}">
              @endif
            </div>


            


            <?php if($rows['id_categoria'] == 1){?>
              <div class="popup_aval">
                <span class="popup_sub bold">Avaliação:</span>
                @if(!empty($post['avaliacao'][0])) <!--  Verifica se a consulta sql de avaliações retorna algum valor  -->
                  @for($c=0; $c<sizeof($post['avaliacao']); $c++) <!-- enquanto a variável c não tiver o valor igualado ao tamanho do array de avaliação, uma avaliação por vez é mostrada -->
                    @if($post['avaliacao'][$c]->id_postagem == $id_post)  <!-- Mas a avaliação só é mostrada caso o id da postagem da avaliação for igual ao da postagem que está sendo visualizada -->
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
                        <span class="bold">Avaliador: {{ $post['avaliador'][$c]->usuario }}</span> 
                        <span class="underline">{{ date('d/m/Y', strtotime($post['avaliacao'][0]->data_avaliacao))}}</span><br>{{ $post['avaliacao'][$c]->comentario_avaliacao }}
                      </p>
                    @endif

                    <!-- Verifica se a avaliação está pendente ou não -->
                    <?php $cont = 0;?>
                    @for($d=0;$d<sizeof($post['avaliacao']);$d++)
                      @if($post['avaliacao'][$d]->id_postagem != $id_post)  <!-- Quando o for rodar todas as vezes e tbm todos questionamentos do if, e o cont não for igual ao tamanho de quantidade de avaliações , quer dizer q existe alguma avaliação que pertence a postagem atual, e portanto não está pendente -->
                        <?php 
                          $cont+= 1 ;
                        ?>
                      @endif
                    @endfor
                  @endfor
                  @if($cont === sizeof($post['avaliacao']))
                    @if($id_nivel == 1 && isset($rows['id']))
                      <a href="#" class="popup_coment" data-toggle="modal" data-target="#post<?php echo $id_post ?>_avaliar">Avaliar postagem</a>
                    @else
                      <p class="popup_coment">Pendente</p>
                    @endif
                  @endif
                @else
                  @if($id_nivel == 1 && isset($rows['id']))
                    <a href="#" class="popup_coment" data-toggle="modal" data-target="#post<?php echo $id_post ?>_avaliar">Avaliar postagem</a>
                  @else
                    <p class="popup_coment">Pendente</p>
                  @endif
                @endif
                
              </div>
            <?php }?>
            <div class="popup-aval">
              <span class="popup_sub bold">Comentários:</span>   
              <div style="margin-bottom: 15%">
                <form action="{{ route('comentario') }}" method="POST">
                  @csrf
                  <textarea required name="conteudo_comentarios" class="comentario" maxlength="255" cols="60" rows="2" placeholder="Digite aqui seu comentário"></textarea>
                  <input type="hidden" name="id_postagem" value="{{ $id_post }}">
                  <input type="submit" name="comentario" class="btn btn-primary button_coment" value="Enviar">
                </form>
              </div>
              @if(!empty($post['comentarios'][0]))  
                @for($f=0; $f<sizeof($post['comentarios']); $f++)
                  @if($post['comentarios'][$f]->id_postagem == $id_post)
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
                              <a id="edit" class="dropdown-item" onclick="ocultar_popup('popup{{$id_post}}', 'popup{{$post['comentarios'][$f]->id_comentarios }}_edit1')" href="#" style="cursor: pointer" data-toggle="modal" data-target="#popup{{$post['comentarios'][$f]->id_comentarios }}_edit1">Editar</a>
                              <a class="dropdown-item" href="#" style="cursor: pointer" data-toggle="modal" data-target="#popup{{$post['comentarios'][$f]->id_comentarios}}_apagar2">Apagar</a>
                            @else
                              <a class="dropdown-item" href="{{ url('/adm') }}">Denunciar</a>
                            @endif
                          </div>
                        </div> 
                        @if(empty($post['comentarios'][$f]->edit_comentarios))
                          <span class="underline data-coment">{{ Helper::tempo_corrido($post['comentarios'][$f]->data_comentarios)}}</span>
                        @else
                          <span class="underline data-coment"><?='(editado) '. Helper::tempo_corrido($post['comentarios'][$f]->edit_comentarios)?></span>
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
                          <form action="{{ route('comentario') }}" method="post">
                            @csrf
                            <input name="conteudo" maxlength="255" style="width: 100%" type="text" class="btn-popup mr-sm-2" placeholder="<?='Em resposta a '.'@'. $post['comentarios'][$f]->usuario?>">
                            <input type="hidden" name="id_coment" value="{{ $post['comentarios'][$f]->id_comentarios }}">
                            <input type="hidden" name="id_postagem" value="{{ $id_post }}">
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
                    @if($post['reply_coment'][$g]->id_comentarios === $post['comentarios'][$f]->id_comentarios && $post['comentarios'][$f]->id_postagem == $id_post)
                      <div class="linha"></div>
                      <div class="popup_coment_aval" id="respostas">
                        
                        
                        <div class="header-coment">
                          <form id="perfil" action="{{ route('perfil') }}" method="get">
                            @csrf
                            <input type="hidden" name="id_usuario" value="{{ $post['comentarios'][$f]->id }}">
                            <span>Em resposta a</span><input name="nome" class="link" type="submit" value="<?='@'. $post['comentarios'][$f]->usuario ?>">
                            {{-- <p class="respondendo">Em resposta a <span class="link"></span></p> --}}
                          </form>
                          <div class="dropdown dropdown1">

                            <!--Trigger-->
                           
                            <a class="btn-floating btn-lg black "type="button" id="dropdownMenu3" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                          
                          
                            <!--Menu-->
                            <div class="dropdown-menu dropdown-primary">
                              @if($post['reply_coment'][$g]->id === Auth::user()->id)
                                <a class="dropdown-item" data-toggle="modal" style="cursor: pointer" data-target="#popup{{$post['reply_coment'][$g]->id_subcomentarios }}_edit">Editar</a>
                                <a class="dropdown-item" style="cursor: pointer" data-toggle="modal" data-target="#popup{{$post['reply_coment'][$g]->id_subcomentarios }}_apagar1">Apagar</a>
                              @else
                                {{-- <form id="denunciar" action="{{ route('denunciar') }}" method="POST">
                                  @csrf
                                  <input type="hidden" name="id_subcomentario" value="{{$post['reply_coment'][$g]->id_subcomentarios}}"> --}}
                                  <a class="dropdown-item" href="#">Denunciar</a>
                                {{-- </form> --}}
                              @endif
                            </div>
                          </div>
                          @if(empty($post['reply_coment'][$g]->edit_subcomentarios))
                            <span class="underline data-coment">{{ Helper::tempo_corrido($post['reply_coment'][$g]->data_comentarios)}}</span>
                          @else
                            <span class="underline data-coment"><?='(editado) '. Helper::tempo_corrido($post['reply_coment'][$g]->edit_subcomentarios)?></span>
                          @endif
                          <div>
                            @if($post['reply_coment'][$g]->img_usuarios === null)
                              <img class="img-dados-coment" src="{{asset('img/semuser.png')}}">
                            @else
                              <img  alt="{{ $post['reply_coment'][$g]->img_usuarios }}" name="img_usuarios" class="img-dados-coment" src="{{asset('/storage/users/'.$post['reply_coment'][$g]->img_usuarios)}}">
                            @endif
                            <form id="perfil" action="{{ route('perfil') }}" method="get">
                              @csrf
                              <input type="hidden" name="id_usuario" value="{{ $post['reply_coment'][$g]->id }}">
                              <input alt="" class="bold user" type="submit" value="{{ $post['reply_coment'][$g]->usuario}}">
                            </form>
                          </div>
                          
                        </div>
                        <p class="conteudo-coment text-justify">{{ $post['reply_coment'][$g]->conteudo_comentarios }}</p>
                        <div class="footer-coment">
                          {{-- <span class="mostrar">Responder</span> --}}
                          <?php $resultados = Helper::verifica_like_subcoment($post['reply_coment'][$g]->id_subcomentarios)?>
                          @if($resultados == 0)
                            <span href="#" id="{{ $post['reply_coment'][$g]->id_subcomentarios }}" class="subcurtir fa-thumbs-o-up fa" data-id="{{ $post['reply_coment'][$g]->id_subcomentarios }}"></span> 
                            <span class="likes" id="likes_{{ $post['reply_coment'][$g]->id_subcomentarios }}">{{ $post['reply_coment'][$g]->likes_comentarios }}</span>
                          @else 
                            <span href="#" id="{{ $post['reply_coment'][$g]->id_subcomentarios }}" class="subcurtir fa-thumbs-up fa" data-id="{{ $post['reply_coment'][$g]->id_subcomentarios }}"></span>
                            <span class="likes" id="likes_{{ $post['reply_coment'][$g]->id_subcomentarios }}">{{$post['reply_coment'][$g]->likes_comentarios }}</span>
                          @endif

                          <div id="comentarios">
                            <form action="{{ route('comentario') }}" method="POST">
                              @csrf
                              <input name="conteudo_resposta" maxlength="255" style="width: 100%" type="text" class="btn-popup mr-sm-2" placeholder="<?='Em resposta a '.'@'. $post['reply_coment'][$g]->usuario?>">
                              <input type="hidden" name="id_coment" value="{{ $post['reply_coment'][$g]->id_comentarios }}">
                              <input type="hidden" name="id_resposta" value="{{ $post['reply_coment'][$g]->id_subcomentarios }}">
                              <input type="hidden" name="id_postagem" value="{{ $id_post }}">
                              <input type="submit" style="display: none" name="respostas">
                            </form>
                          </div>
                        </div>
                      </div>

                      <!--  Modal de edição de respostas de comentários -->
                      <div class="painel-dados">
                        <div class="modal fade id" id="popup{{$post['reply_coment'][$g]->id_subcomentarios}}_edit" role="dialog">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body"> 
                                <form action="{{ route('edit.coment') }}" method="POST"> 
                                  @csrf                   
                                  <div class="popup-title">
                                    <label style="vertical-align: top" for="editsubcomentario" class="bold subdados">Descrição:</label>
                                    <textarea name="editsubcomentario" id="edit_desc" cols="60" rows="1">{{$post['reply_coment'][$g]->conteudo_comentarios }}</textarea>
                                    <input type="hidden" name="id_subcoment" value="{{ $post['reply_coment'][$g]->id_subcomentarios }}">
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
                        <div class="modal fade id" id="popup{{$post['reply_coment'][$g]->id_subcomentarios}}_apagar1" role="dialog">
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
                                    <input name="id_subcomentario" type="hidden" value="{{ $post['reply_coment'][$g]->id_subcomentarios }}">
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
            <div class="modal-footer" style="margin-top: 10px">
              <div class="popup-like">
                <img width="30px" src="{{ asset('img/like.png') }}">
                <p class="num-like"><?php echo $rows['likes_postagem']; ?></p>
              </div>  
              <p class="data-post">
                Postado em <?php echo date('d/m/Y', strtotime($rows['data_postagem'])); ?> às  <?php echo date('H:i', strtotime($rows['data_postagem'])); ?> horas
              </p>       
            </div>
            </div>
        </div>
    </div>
</div>
</div>

<!--  Modal de avaliação  -->

<div class="modal fade bd-example-modal-lg" id="post<?php echo $id_post ?>_avaliar" tabindex="-1" role="dialog" id="modalideia" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ url('/avaliar')}}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="notas">
                    <div style="margin: 10px">
                        <label for="inovacao" class="sub">Inovação:</label>
                        <input type="number" name="inovacao" id="inovacao" class="nota" step = "0.1" min="0" max="10" required>
                    </div>
                    <div style="margin: 10px">
                        <label for="complexidade" class="sub">Complexidade:</label>
                        <input type="number" name="complexidade" id="complexidade" class="nota" step = "0.1" min="0" max="10" required>
                    </div>
                    <div style="margin: 10px">
                        <label for="potencial" class="sub">Potencial de Mercado:</label>
                        <input type="number" name="potencial" id="potencial" class="nota" step = "0.1" min="0" max="10" onblur="calcular()" required>
                    </div>
                </div>
                <div class="media">
                    <div class="center_media">
                        <label for="media" class="sub_media">Média:</label>
                        <input class="nota" name="media" id="media" placeholder="Calculado pelo sistema" readonly>
                    </div>
                </div>
                <div class="coment_avaliador">
                    <label for="comentarios" style="vertical-align: top" class="sub_comentario">Comentários:</label>
                    <textarea name="comentarios" class="comentarios" cols="80" rows="4" placeholder="Digite seu comentário..." required></textarea>
                </div>
                <input type="hidden" name="id_postagem" value="{{ $id_post }}">
                <?php if(isset($rows['id'])){?><input type="hidden" name="id_usuario" value="{{ $rows['id'] }}"><?php }?>
                <input type="hidden" name="id_avaliador" value="{{ Auth::user()->id }}">
            </div>
            <div class="modal-footer-custom grey">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Finalizar avaliação</button>
            </div>
        </form>
    </div>
  </div>
</div>

<!-- Fim  Modal de avaliação  -->

<!-- Popup de visualização de imagens -->
<div class="popup_img_post">
  <div class="modal modal_img fade" id="img1<?php echo $id_post ?>" role="dialog">
      <button type="button" class="close btn_fechar" data-dismiss="modal">&times;</button>
    <div class="modal-dialog">
      <div class="modal-content modal_content">
          <div class="modal-body">
              <button type="button" class="close btn_fechar_body" data-dismiss="modal">&times;</button>
              <?php 
                  $nome_file = "../public/storage/posts/".'1'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg';
                  $nome_file_png = "../public/storage/posts/".'1'.$id_post.Str::kebab($rows['titulo_postagem']).'.png';  
              ?>
              @if(file_exists($nome_file))
                  <img id="img_post1" src="{{url('storage/posts/'.'1'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg')}}">
              @elseif(file_exists($nome_file_png))
                  <img id="img_post1" src="{{url('storage/posts/'.'1'.$id_post.Str::kebab($rows['titulo_postagem']).'.png')}}">
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
              $nome_file2 = "../public/storage/posts/".'2'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg';
              $nome_file_png2 = "../public/storage/posts/".'2'.$id_post.Str::kebab($rows['titulo_postagem']).'.png';  
          ?>
          @if(file_exists($nome_file2))
              <img id="img_post1" src="{{url('storage/posts/'.'2'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg')}}">
          @elseif(file_exists($nome_file_png2))
              <img id="img_post1" src="{{url('storage/posts/'.'2'.$id_post.Str::kebab($rows['titulo_postagem']).'.png')}}">
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
                  $nome_file3 = "../public/storage/posts/".'3'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg';
                  $nome_file_png3 = "../public/storage/posts/".'3'.$id_post.Str::kebab($rows['titulo_postagem']).'.png';  
              ?>
              @if(file_exists($nome_file3))
                  <img id="img_post1" src="{{url('storage/posts/'.'3'.$id_post.Str::kebab($rows['titulo_postagem']).'.jpeg')}}">
              @elseif(file_exists($nome_file_png3))
                  <img id="img_post1" src="{{url('storage/posts/'.'3'.$id_post.Str::kebab($rows['titulo_postagem']).'.png')}}">
              @endif
          </div>
      </div>
      </div>
  </div>
</div>


<!-- Fim Popup de visualização de imagens3 -->


