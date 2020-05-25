@extends('layouts.app')

<link href="{{ asset('css/estilo.css') }}" rel="stylesheet">
<script src="https://kit.fontawesome.com/1618aca3df.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script type="text/javascript" src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/funcoes.js') }}"></script>



<?php if($rows['id_categoria'] = "1" ){$categoria = "Ideia";}else{$categoria = "Sugestão";}?>


<?php  session_start();
$conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");

$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

if(NULL !== Session::get('pesquisa')){$_SESSION['pesquisa'] = Session::get('pesquisa');}
if(NULL !== Session::get('filtro')){$_SESSION['filtro'] = Session::get('filtro');}
if(NULL !== Session::get('tipo')){$_SESSION['tipo'] = Session::get('tipo');}
if(NULL !== Session::get('periodo')){$_SESSION['periodo'] = Session::get('periodo');}
if(NULL !== Session::get('avalia')){$_SESSION['avalia'] = Session::get('avalia');}

if(isset($_SESSION['pesquisa'])){$pesquisa = $_SESSION['pesquisa'];}
if(isset($_SESSION['filtro'])){$filtro = $_SESSION['filtro'];}
if(isset($_SESSION['tipo'])){$tipo = $_SESSION['tipo'];}
if(isset($_SESSION['periodo'])){$periodo = $_SESSION['periodo'];}
if(isset($_SESSION['avalia'])){$avalia = $_SESSION['avalia'];}

if(!isset($pesquisa)){ $pesquisa = NULL;}
if(!isset($filtro)){$filtro = "data_postagem";}
if(!isset($tipo)){$tipo = "1 OR 2";}
if(!isset($periodo)){ $periodo = "data_postagem";}
if(!isset($avalia)){ $avalia = "1 OR 2";}

$sql = "SELECT * FROM postagens LEFT JOIN usuarios ON (postagens.id_usuarios = usuarios.id) WHERE data_postagem >= $periodo AND (id_categoria = $tipo) AND (id_situacao_postagem = $avalia) AND (postagens.titulo_postagem LIKE '%$pesquisa%' OR usuarios.usuario LIKE '%$pesquisa%') ORDER BY $filtro DESC";
$result = mysqli_query($conn, $sql); //pesquisa pra ser usado na conta das rows
$total_pesquisa = mysqli_num_rows($result); //conta o total de rows

$quantidade = 4; //quantidade de rows

$num_pagina = ceil($total_pesquisa/$quantidade);

$inicio = ($quantidade*$pagina)-$quantidade;

$sql = "SELECT * FROM postagens LEFT JOIN usuarios ON (postagens.id_usuarios = usuarios.id) WHERE data_postagem >= $periodo AND (id_categoria = $tipo) AND (id_situacao_postagem = $avalia) AND (postagens.titulo_postagem LIKE '%$pesquisa%' OR usuarios.usuario LIKE '%$pesquisa%') ORDER BY $filtro DESC LIMIT $inicio, $quantidade ";
$result2 = mysqli_query($conn, $sql); //pesquisa limitada com paginação

$pagina_anterior = $pagina - 1; //paginação
$pagina_posterior = $pagina + 1;

if ($periodo == "DATE(NOW()) - INTERVAL 7 DAY"){$setup = "Ultima Semana";
}elseif($periodo == "DATE(NOW()) - INTERVAL 30 DAY"){$setup = "Ultimo Mês";
}elseif($periodo == "DATE(NOW()) - INTERVAL 365 DAY"){$setup = "Ultimo Ano";
}else{$setup = "Todas as Postagens";}
?>


@section('content')

<div class="row justify-content-md-center">
    <form method="POST" action="/filtro">
        @csrf
        <div class="row contorno"> 
            <button name="filtro" value="novo" <?php if($filtro == "data_postagem"){?> class="btn btn-outline-primary-custom" <?php }else{?> class="btn btn-primary" <?php }?>>Novos</button> 
            <button name="filtro" value="popu" <?php if($filtro == "likes_postagem"){?> class="btn btn-outline-primary-custom" <?php }else{?> class="btn btn-primary" <?php }?>>Populares</button> 
            <button name="filtro" value="melh" <?php if($filtro == "media"){?> class="btn btn-outline-primary-custom" <?php }else{?> class="btn btn-primary" <?php }?>>Melhores Avaliados</button> 
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php if($avalia == "1"){ echo "Avaliados"; }elseif($avalia == "2"){ echo "Pendentes"; }else{echo "Avaliados/Pendentes";}?> 
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <?php if($avalia != "1"){?><button class="dropdown-item" name="avalia" value="1">Avaliados</button><?php }?>
                    <?php if($avalia != "2"){?><button class="dropdown-item" name="avalia" value="2">Pendentes</button><?php }?>
                    <?php if($avalia != "1 OR 2"){?><button class="dropdown-item" name="avalia" value="3">Avaliados/Pendentes</button><?php }?>
                </div>
            </div>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php if($tipo == "1"){ echo "Ideias"; }elseif($tipo == "2"){ echo "Sugestões"; }else{echo "Ideias/Sugestões";}?> 
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <?php if($tipo != "1"){?><button class="dropdown-item" name="tipo" value="1">Ideias</button><?php }?>
                    <?php if($tipo != "2"){?><button class="dropdown-item" name="tipo" value="2">Sugestões</button><?php }?>
                    <?php if($tipo != "1 OR 2"){?><button class="dropdown-item" name="tipo" value="3">Ideias/Sugestões</button><?php }?>
                </div>
            </div>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $setup ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <?php if($setup != "Ultima Semana"){?><button class="dropdown-item" name="periodo" value="1">Ultima Semana</button><?php }?>
                    <?php if($setup != "Ultimo Mês"){?><button class="dropdown-item" name="periodo" value="2">Ultimo Mês</button><?php }?>
                    <?php if($setup != "Ultimo Ano"){?><button class="dropdown-item" name="periodo" value="3">Ultimo Ano</button><?php }?>
                    <?php if($setup != "Todas as Postagens"){?><button class="dropdown-item" name="periodo" value="4">Todas as postagens</button><?php }?>
                </div>
            </div>
            <a href="/reset"><img width="45px" src="{{asset('img/reset.png')}}"></a>
        </div>  
    </form>
</div>  
<?php if(NULL !== $pesquisa){?><div class="contorno-pequeno"><a href="/reset_search"><img width="20px" src="{{asset('img/close.png')}}"></a> Resultados da Pesquisa "<?php echo $pesquisa ?>"</div><?php }?>

<?php if ($total_pesquisa < 1){?>
    <div class="aviso-home">    
        <img class="aviso-center" width="150px" src="{{asset('img/danger.png')}}">
        <h2 class="aviso-text"><b>Nenhuma Postagem encontrada</b></h2>
    </div>
<?php }?>
<?php while($rows = mysqli_fetch_assoc($result2)){ $situation = $rows['id_situacao_postagem']; $id_post = $rows['id_postagem'];?>
    <div class="card-home">
        <form action="/perfil" method="POST">
            @csrf
            <input type="hidden" name="id_usuario" value="$rows['id']">
            <div class="text-home"><h6>Postado por</h6></div>
            <?php if($rows['img_usuarios'] == NULL){?>
                <img class="img-autor" src="{{asset('img/semuser.png')}}">
            <?php }else{?>
                <img class="img-autor" src="{{asset('/storage/users/'.$rows['img_usuarios'])}}">
            <?php }?>
            <div class="autor-home justify-content-md-center"><button class="no-border-button" type="submit"><?php echo mb_strimwidth($rows['usuario'], 0, 16, "..."); ?></button></div>
        </form>
        <div class="divisao"></div>
        <div class="title-home"><h3><b><?php echo mb_strtoupper($rows['titulo_postagem']); ?></b></h3></div>
        <div class="desc-home"><?php echo mb_strimwidth($rows['descricao_postagem'], 0, 60, "..."); ?></div>
        <div class="like-home"><?php echo "<f><b>" . $rows['likes_postagem'] . " Likes" . "</b></f>"; ?></div>
        <div class="link-home"> <a style = "text-decoration:underline" type="button"  data-toggle="modal" data-target="#post<?php echo $id_post ?>">Visualizar Ideia</a> </div>
        <div class="situation-home"><b><?php if ($situation == 1) { echo "<f3> Media: ". number_format((float)$rows['media'], 2, '.', ''). "</f3>";}else{ echo "<f4>" . "Pendente" . "</f4>";} ?></b></f2></div>
        <div class="data-home"><f2><?php echo date('d/m/Y', strtotime($rows['data_postagem'])); ?></f2></div>
    </div>

    <!-- Área de detalhes de ideias postadas -->

    <div class="painel-dados">
        <div class="modal fade id" id="post<? echo $id_post ?>" role="dialog">
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
                    @if($post['avaliacao'][$c]->id_postagem == $id_post)
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
                        <span class="bold">Avaliador: {{ $post['avaliador'][$c]->usuario }}</span> 
                        <span class="underline">{{ date('d/m/Y', strtotime($post['avaliacao'][0]->data_avaliacao))}}</span><br>{{ $post['avaliacao'][$c]->comentario_avaliacao }}
                        </p>
                    @endif

                    <!-- Verifica se a avaliação está pendente ou não -->
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
                    <p class="popup_coment">Pendente</p>
                    @endif
                @else
                    <p class="popup_coment">Pendente</p>
                @endif
                
                </div>
                <div class="popup-aval">
                <span class="popup_sub bold">Comentários:</span>   
                <div style="margin-bottom: 13%">
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
    
<?php } ?>
                                   
<nav class="text-center">
    <ul class="pagination">
        <li class="page-item">
            <?php
            if($pagina_anterior != 0){ ?>
                <a class="page-link" href="?pagina=<?php echo $pagina_anterior; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            <?php }else{ ?>
                <a class="page-link" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            <?php }  ?>
        </li>
        <?php 
        for($i = 1; $i < $num_pagina + 1; $i++){ ?>
            <li class="page-item"><a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php } ?>
        <li>
            <?php
            if($pagina_posterior <= $num_pagina){ ?>
                <a class="page-link" href="?pagina=<?php echo $pagina_posterior; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            <?php }else{ ?>
                <a class="page-link" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            <?php }  ?>
        </li>
    </ul>
</nav>


@endsection
