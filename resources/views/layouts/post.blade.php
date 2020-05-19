<?php if($rows['id_categoria'] = "1" ){$categoria = "Ideia";}else{$categoria = "Sugestão";} ?>

<!-- Modal visualizar ideias modificado-->
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
                    <span class="popup_sub bold">Descrição:</span>
                    <p id="popup_cont_desc"><?php echo $rows['descricao_postagem']; ?></p>
                </div>
                <div>
                    <span class="popup_sub bold">Categoria:</span>
                    <p class="popup_coment"><?php echo $categoria ?></p>
                </div>
                <div class="popup_img">
                    <span class="popup_sub bold">Imagens:</span>
                    <img class="popup_imgs" src="{{asset('img/semimagem.jpg')}}">
                    <img class="popup_imgs" src="{{asset('img/semimagem.jpg')}}">
                    <img class="popup_imgs" src="{{asset('img/semimagem.jpg')}}">
                </div>
                <div class="popup_aval">
                    <span class="popup_sub bold">Avaliação:</span>
                    @if(!empty($post['avaliacao'][0]))
                    @for($c=0; $c<sizeof($post['avaliacao']); $c++)
                        @if($post['avaliacao'][$c]->id_postagem === $posts ?? ''->id_postagem)
                        <p class="popup_avali">
                            <span class="bold">Inovação: </span>{{ $post['avaliacao'][$c]->inovacao_avaliacao }}
                        </p>
                        <p class="popup_avali">
                            <span class="bold">Potencial de Mercado: </span>{{ $post['avaliacao'][$c]->potencial_avaliacao }}
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
                        @if($post['avaliacao'][$d]->id_postagem !== $posts ?? ''->id_postagem)
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
                    <div style="margin-bottom: 50px">
                    <form action="">
                        <textarea required class="comentario" maxlength="255" cols="60" rows="2" placeholder="Digite aqui seu comentário"></textarea>
                        <input type="submit" name="" class="btn btn-primary button_coment" value="Enviar">
                    </form>
                    </div>
                    @if(!empty($post['comentarios'][0]))  
                    @for($f=0; $f<sizeof($post['comentarios']); $f++)
                        @if($post['comentarios'][$f]->id_postagem === $posts ?? ''->id_postagem)
                        <div class="popup_coment_aval">
                            <div class="header-coment">
                            @if($post['comentarios'][$f]->img_usuarios === null)
                                <img class="img-dados-coment" src="{{asset('img/semuser.png')}}">
                            @else
                                <img  alt="{{ Auth::user()->img_usuarios }}" name="img_usuarios" class="img-dados-coment" src="{{url('storage/users/'.Auth::user()->img_usuarios)}}">
                            @endif
                            <span class="bold "><a href="" class="user">{{ $post['comentarios'][$f]->usuario}}</a></span> 
                            <span class="underline data-coment">{{ date('d/m/Y', strtotime($post['comentarios'][$f]->data_comentarios))}}</span>
                            </div>
                            <p class="conteudo-coment">{{ $post['comentarios'][$f]->conteudo_comentarios }}</p>
                            <div class="footer-coment">
                            <span class="mostrar">Responder</span> 
                            <a href="#" class="curtir">Curtir</a>                                 
                            <div class="likes_coment">  
                                <img width="30px" src="{{ asset('img/like.png') }}">
                                <p class="num-like">{{ $post['comentarios'][$f]->likes_comentarios }}</p>
                            </div>
                            <div id="comentarios">
                                <form action="" method="POST">
                                <input maxlength="255" style="width: 100%" type="text" class="btn-popup mr-sm-2" placeholder="Digite aqui sua resposta">
                                </form>
                            </div>
                            </div>
                            
                        </div>                                    
                        @endif
                        @for($g=0; $g<sizeof($post['reply_coment']); $g++)
                        @if($post['reply_coment'][$g]->id_comentarios === $post['comentarios'][$f]->id_comentarios && $post['comentarios'][$f]->id_postagem === $posts ?? ''->id_postagem)
                            <div class="popup_coment_enc" id="respostas">
                            <div class="header-coment">
                                @if($post['reply_coment'][$g]->img_usuarios === null)
                                <img class="img-dados-coment" src="{{asset('img/semuser.png')}}">
                                @else
                                <img  alt="{{ Auth::user()->img_usuarios }}" name="img_usuarios" class="img-dados-coment" src="{{url('storage/users/'.Auth::user()->img_usuarios)}}">
                                @endif
                                <span class="bold "><a href="" class="user">{{ $post['reply_coment'][$g]->usuario}}</a></span> 
                                <span class="underline data-coment">{{ date('d/m/Y', strtotime($post['reply_coment'][$g]->data_comentarios))}}</span>
                            </div>
                            <p class="conteudo-coment">{{ $post['reply_coment'][$g]->conteudo_comentarios }}</p>
                            <div class="footer-coment">
                                <a href="#" class="curtir">Curtir</a>    
                                <div class="likes_coment"> 
                                <img width="30px" src="{{ asset('img/like.png') }}">
                                <p class="num-like">{{ $post['reply_coment'][$g]->likes_comentarios }}</p>
                                </div>
                            </div>
                            </div>
                        @endif
                        @endfor
                    @endfor
                    @endif
                </div>           
                <div class="modal-footer seila">
                    <p class="data-post seila">
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
<!-- Modal visualizar ideias modificado-->