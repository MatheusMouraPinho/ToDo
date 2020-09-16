@extends('layouts.app')



<?php  session_start();
$db_config = Config::get('database.connections.'.Config::get('database.default'));
$conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
mysqli_set_charset($conn, 'utf8');

$user = Auth::user()->id;
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
if(!isset($tipo)){$tipo = "1 OR 2 OR 3 OR 4 OR 5";}
if(!isset($periodo)){ $periodo = "data_postagem";}
if(!isset($avalia)){ $avalia = "1 OR 2";}
if($filtro == "media"){$avalia = "1";}

$sql = "SELECT * FROM postagens LEFT JOIN usuarios ON (postagens.id_usuarios = usuarios.id) WHERE data_postagem >= $periodo AND (id_categoria = $tipo) AND (id_situacao_postagem = $avalia) AND (postagens.titulo_postagem LIKE '%$pesquisa%' OR usuarios.usuario LIKE '%$pesquisa%') ORDER BY $filtro DESC";
$result = mysqli_query($conn, $sql); //pesquisa pra ser usado na conta das rows
$total_pesquisa = mysqli_num_rows($result); //conta o total de rows

$quantidade = 6; //quantidade de rows

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

$s = 1;
$smartphone = true;
?>

@section('content')

<div class="container my-4">
    <div class="filtro-pc row justify-content-center">
        <form method="POST" action="{{url('filtro')}}">
            @csrf
            <div class="row contorno"> 
                <button name="filtro" value="novo" <?php if($filtro == "data_postagem"){?> class="btn selecionado" <?php }else{?> class="btn btn-outline-primary-custom" <?php }?>><img width="21px" src="{{asset('img/new.png')}}"> Novos</button> 
                <button name="filtro" value="popu" <?php if($filtro == "likes_postagem"){?> class="btn selecionado" <?php }else{?> class="btn btn-outline-primary-custom" <?php }?>><img width="23px" src="{{asset('img/like.png')}}">Populares</button> 
                <button name="filtro" value="melh" <?php if($filtro == "media"){?> class="btn selecionado" <?php }else{?> class="btn btn-outline-primary-custom" <?php }?>><img width="22px" src="{{asset('img/avaliacao.png')}}">Melhores Avaliados</button> 
                <div class="dropdown">
                    <button class="btn selecionado dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if($avalia == "1"){ echo "Avaliados"; }elseif($avalia == "2"){ echo "Pendentes"; }else{echo "Situação";}?> 
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php if($avalia != "1"){?><button class="dropdown-item" name="avalia" value="1">Avaliados</button><?php }?>
                        <?php if($avalia != "2"){?><button class="dropdown-item" name="avalia" value="2">Pendentes</button><?php }?>
                        <?php if($avalia != "1 OR 2"){?><button class="dropdown-item" name="avalia" value="3">Todos</button><?php }?>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn selecionado dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if($tipo == "1"){ echo "Web, Mobile & Software"; }elseif($tipo == "2"){ echo "Design & Criação"; }elseif($tipo == "3"){echo "Engenharia & Arquitetura";
                        }elseif($tipo == "4"){echo "Marketing";}elseif($tipo == "5"){echo "Outros";}else{echo "Categoria";}?> 
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php if($tipo != "1"){?><button class="dropdown-item" name="tipo" value="1">Web, Mobile & Software</button><?php }?>
                        <?php if($tipo != "2"){?><button class="dropdown-item" name="tipo" value="2">Design & Criação</button><?php }?>
                        <?php if($tipo != "3"){?><button class="dropdown-item" name="tipo" value="3">Engenharia & Arquitetura</button><?php }?>
                        <?php if($tipo != "4"){?><button class="dropdown-item" name="tipo" value="4">Marketing</button><?php }?>
                        <?php if($tipo != "5"){?><button class="dropdown-item" name="tipo" value="5">Outros</button><?php }?>
                        <?php if($tipo != "1 OR 2 OR 3 OR 4 OR 5"){?><button class="dropdown-item" name="tipo" value="todas">Todas as categorias</button><?php }?>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn selecionado dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if($setup == "Todas as Postagens"){echo "Periodo";}else{ echo $setup; } ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php if($setup != "Ultima Semana"){?><button class="dropdown-item" name="periodo" value="1">Última Semana</button><?php }?>
                        <?php if($setup != "Ultimo Mês"){?><button class="dropdown-item" name="periodo" value="2">Último Mês</button><?php }?>
                        <?php if($setup != "Ultimo Ano"){?><button class="dropdown-item" name="periodo" value="3">Último Ano</button><?php }?>
                        <?php if($setup != "Todas as Postagens"){?><button class="dropdown-item" name="periodo" value="4">Todas as postagens</button><?php }?>
                    </div>
                </div>
                <div class="dropdown">
                    <a id="navbarDropdown" role="button" style="cursor: pointer" data-toggle="dropdown"><img style="padding-top:5px" width="38px" src="{{asset('img/option.png')}}"></a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{url('reset')}}">Limpar Filtro</a>
                    </div>
                </div>
            </div>  
        </form>
    </div>
    <!-- Filtro tablet  -->
    <div class="filtro-tablet row justify-content-center">
        <form method="POST" action="{{url('filtro')}}">
            @csrf
            <div class="row contorno">
                <div class="dropdown">
                    <button class="btn btn btn-outline-primary-custom dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if($filtro == "media"){?> <img width="22px" src="{{asset('img/avaliacao.png')}}"> <?php echo "Mais avaliados"; }elseif($filtro == "likes_postagem"){?><img width="23px" src="{{asset('img/like.png')}}"><?php  echo "Populares"; } elseif($filtro == "data_postagem"){?> <img width="21px" src="{{asset('img/new.png')}}"> <?php echo "Novos";}else{echo $filtro;}?> 
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php if($filtro != "data_postagem"){?><button class="dropdown-item" name="filtro" value="novos"><img width="21px" src="{{asset('img/new.png')}}"> Novos</button><?php }?>
                        <?php if($filtro != "likes_postagem"){?><button class="dropdown-item" name="filtro" value="popu"><img width="23px" src="{{asset('img/like.png')}}"> Populares</button><?php }?>
                        <?php if($filtro != "media"){?><button class="dropdown-item" name="filtro" value="melh"><img width="22px" src="{{asset('img/avaliacao.png')}}"> Mais avaliados</button><?php }?>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if($avalia == "1"){ echo "Avaliados"; }elseif($avalia == "2"){ echo "Pendentes"; }else{echo "Situação";}?> 
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php if($avalia != "1"){?><button class="dropdown-item" name="avalia" value="1">Avaliados</button><?php }?>
                        <?php if($avalia != "2"){?><button class="dropdown-item" name="avalia" value="2">Pendentes</button><?php }?>
                        <?php if($avalia != "1 OR 2"){?><button class="dropdown-item" name="avalia" value="3">Todos</button><?php }?>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if($tipo == "1"){ echo "Web, Mobile & Software"; }elseif($tipo == "2"){ echo "Design & Criação"; }elseif($tipo == "3"){echo "Engenharia & Arquitetura";
                        }elseif($tipo == "4"){echo "Marketing";}elseif($tipo == "5"){echo "Outros";}else{echo "Categoria";}?> 
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php if($tipo != "1"){?><button class="dropdown-item" name="tipo" value="1">Web, Mobile & Software</button><?php }?>
                        <?php if($tipo != "2"){?><button class="dropdown-item" name="tipo" value="2">Design & Criação</button><?php }?>
                        <?php if($tipo != "3"){?><button class="dropdown-item" name="tipo" value="3">Engenharia & Arquitetura</button><?php }?>
                        <?php if($tipo != "4"){?><button class="dropdown-item" name="tipo" value="4">Marketing</button><?php }?>
                        <?php if($tipo != "5"){?><button class="dropdown-item" name="tipo" value="5">Outros</button><?php }?>
                        <?php if($tipo != "1 OR 2 OR 3 OR 4 OR 5"){?><button class="dropdown-item" name="tipo" value="todas">Todas as categorias</button><?php }?>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if($setup == "Todas as Postagens"){echo "Periodo";}else{ echo $setup; } ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php if($setup != "Ultima Semana"){?><button class="dropdown-item" name="periodo" value="1">Última Semana</button><?php }?>
                        <?php if($setup != "Ultimo Mês"){?><button class="dropdown-item" name="periodo" value="2">Último Mês</button><?php }?>
                        <?php if($setup != "Ultimo Ano"){?><button class="dropdown-item" name="periodo" value="3">Último Ano</button><?php }?>
                        <?php if($setup != "Todas as Postagens"){?><button class="dropdown-item" name="periodo" value="4">Todas as postagens</button><?php }?>
                    </div>
                </div>
                <div class="dropdown">
                    <a id="navbarDropdown" role="button" style="cursor: pointer" data-toggle="dropdown"><img style="padding-top:5px" width="38px" src="{{asset('img/option.png')}}"></a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{url('reset')}}">Limpar Filtro</a>
                    </div>
                </div>
            </div>  
        </form>
    </div>
    <!-- FIM filtro tablet  -->
    <div class="espaço-filtro"></div>
    <div class="row justify-content-center"> 
        <form class="form-inline d-flex justify-content-center md-form form-sm mt-0" method="POST" action="{{url('pesquisa')}}">
            @csrf
            <i class="fas fa-search" aria-hidden="true"></i>
            <input class="form-control-sm ml-1 pesquisa-home" type="text" name="pesquisa" placeholder="Procurar ideias..." aria-label="Search">
        </form>
    </div>
    <div style="padding:12px"></div>
    <div class="row justify-content-center"> 
        <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 80%;">
    </div>
    <?php if(NULL !== $pesquisa){?><div class="contorno-pequeno"><a href="{{url('reset_search')}}"><img width="20px" src="{{asset('img/close.png')}}"></a> Resultados da Pesquisa "<?php echo $pesquisa ?>"</div><?php }?>

    <?php if ($total_pesquisa < 1){?>
        <div class="aviso-home">    
            <img class="aviso-center" width="150px" src="{{asset('img/danger.png')}}">
            <h2 class="aviso-text"><b>Nenhuma Postagem encontrada</b></h2>
        </div>
    <?php }?>
    <?php while($rows = mysqli_fetch_assoc($result2)){ $situation = $rows['id_situacao_postagem']; $id_post = $rows['id_postagem']; $user_post = $rows['id_usuarios']; $name = $rows['usuario']; $parts = explode(" ", $name); $scroll = $s +1;?>
        <nav id="scroll<?php echo $scroll?>"></nav>
        <div class="card-home">
            <div class="divisao">
                <div class="text-home"><h6>Postado por</h6></div>
                <?php if($rows['img_usuarios'] == NULL){?>
                    <img class="img-autor" width="30px" src="{{asset('img/semuser.png')}}">
                <?php }else{?>
                    <img class="img-autor" src="{{asset('/ToDo/storage/app/public/users/'.$rows['img_usuarios'])}}">
                <?php }?>
                <form action="{{url('perfil')}}" method="GET">
                    @csrf
                    <input type="hidden" name="id_usuario" value="<?php echo $rows['id']?>">
                    <div class="autor-home"><button style="text-decoration:underline" class="no-border-button" type="submit"><?php echo "$parts[0]"; ?></button></div>
                </form>
            </div>
            <div class="divisao2">
                <div class="title-home"><h3><b><?php echo mb_strimwidth(mb_strtoupper($rows['titulo_postagem']), 0, 30, "..."); ?></b></h3></div>
                <div class="desc-home"><?php echo mb_strimwidth($rows['descricao_postagem'], 0, 60, "..."); ?></div>
                
                <?php $sql = "SELECT * FROM like_postagens WHERE id_postagens = $id_post AND id_usuarios = $user";
                $result3 = mysqli_query($conn, $sql); 
                $like_check = mysqli_num_rows($result3);

                if($like_check == 0){?>
                    <form method="POST" action="{{url('like_post')}}">
                        @csrf
                        <input type="hidden" name="id_post" value="<?php echo $rows['id_postagem'];?>">
                        <input type="hidden" name="id_usuario" value="<?php echo Auth::user()->id;?>">
                        <input type="hidden" name="scroll" value="<?php echo $s?>">
                        <div class="like-home like-border"><b><button type="submit" class="row no-border-button"><img width="30px" src="{{asset('img/like.png')}}"><div class="num-like-home"><?php echo $rows['likes_postagem']; ?></div></button></b></div>
                    </form>
                <?php }else{?>
                    <form method="POST" action="{{url('remov_like_post')}}">
                        @csrf
                        <input type="hidden" name="id_post" value="<?php echo $rows['id_postagem'];?>">
                        <input type="hidden" name="id_usuario" value="<?php echo $user?>">
                        <input type="hidden" name="scroll" value="<?php echo $s?>">
                        <div class="like-home like-border"><b><button type="submit" class="row no-border-button"><img class="ajuste-unlike" width="30px" src="{{asset('img/liked.png')}}"><div class="num-like-home"><?php echo $rows['likes_postagem']; ?></div></button></b></div>
                    </form>
                <?php }?>
                <div class="link-home"> <a style="text-decoration:underline" type="button"  data-toggle="modal" data-target="#post<?php echo $id_post ?>">Visualizar</a> </div>
                <div class="situation-home"><b>
                    <?php if ($situation == 1) { echo "<f3> Média: ". number_format((float)$rows['media'], 2, '.', ''). "</f3>";}else{ echo "<f4>" . "Pendente" . "</f4>";} ?>
                </b></div>
                <div class="data-home"><f2><?php echo date('d/m/Y', strtotime($rows['data_postagem'])); ?></f2></div>
                <div class="denuncia-home">
                    <div class="dropdown">
                        <a id="navbarDropdown" role="button" style="cursor: pointer" data-toggle="dropdown"><img class="danger-icon" width="30px" src="{{asset('img/danger.png')}}"></a>
                        <div class="dropdown-menu">
                            <?php if($rows['id_usuarios'] == Auth::user()->id){?>
                                <a class="dropdown-item" style="cursor: pointer"  data-toggle="modal" data-target="#del-post<?php echo $rows['id_postagem'];?>">
                                    <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                      </svg>&nbsp;
                                    Apagar
                                </a>
                            <?php }else{ ?>
                                <a class="dropdown-item" style="cursor: pointer" data-toggle="modal" data-target="#den-post<?php echo $rows['id_postagem'];?>">
                                    <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-exclamation-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                      </svg>&nbsp;
                                    Denunciar
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.post')
        <!-- Modal ordenação -->
        <div class="modal fade" id="ordenacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle"><b>Ordernar Por</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('filtro') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <label class="radio-custom"><h6><b>Novos</b></h6>
                                <input type="radio" id="radio1" type="radio" name="filtro" value="novo" <?php if($filtro == "data_postagem"){ echo "checked"; }else{ echo "required";} ?>>
                                <span class="checkmark"></span>
                            </label>
                            <br>
                            <label class="radio-custom"><h6><b>Populares</b></h6>
                                <input type="radio" id="radio2" type="radio" name="filtro" value="popu" <?php if($filtro == "likes_postagem"){ echo "checked"; }else{ echo "required";} ?>>
                                <span class="checkmark"></span>
                            </label>
                            <br>
                            <label class="radio-custom"><h6><b>Mais avaliados</b></h6>
                                <input type="radio" id="radio3" type="radio" name="filtro" value="melh" <?php if($filtro == "media"){ echo "checked"; }else{ echo "required";} ?>>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar alteração</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- FIM Modal ordenação -->
        <!-- Modal Filtros -->
        <div class="modal fade" id="filtros" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle"><b>Filtrar Por</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('filtro') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="justify-content-center alinhamento-filtro">
                                <select name="avalia" class="selecionar-op">
                                    <option class="op" selected disabled hidden><?php if($avalia == "1 OR 2"){ echo "&nbsp Situação"; }else{ echo $avalia; } ?></option>
                                    <option class="op" value="1">Avaliados</option>
                                    <option class="op" value="2">Pendentes</option>
                                    <option class="op" value="3">Todos</option>
                                </select>
                                <select name="tipo" class="selecionar-op">
                                    <option class="op" selected disabled hidden><?php if($tipo == "1 OR 2 OR 3 OR 4 OR 5"){ echo "&nbsp categorias"; }else{ echo $tipo; } ?></option>
                                    <option class="op" value="1">Web, Mobile & Software</option>
                                    <option class="op" value="2">Design & Criação</option>
                                    <option class="op" value="3">Engenharia & Arquitetura</option>
                                    <option class="op" value="4">Marketing</option>
                                    <option class="op" value="5">Outros</option>
                                    <option class="op" value="todas">Todas as categorias</option>
                                </select>
                            </div>
                            <div class="justify-content-center alinhamento-filtro">
                                <select name="periodo" class="selecionar-op">
                                    <option class="op" selected disabled hidden><?php if($setup == "Todas as Postagens"){ echo "&nbsp Periodo"; }else{ echo $setup; } ?></option>
                                    <option class="op" value="1">Última Semana</option>
                                    <option class="op" value="2">Último Mês</option>
                                    <option class="op" value="3">Último Ano</option>
                                    <option class="op" value="4">Todas as postagens</option>
                                </select>
                                <a class="ajuste-link selecionar-op" href="{{url('reset')}}">Limpar</a>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar alteração</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- FIM Modal Filtros -->
        <!-- Modal deletar postagem -->
        <div class="modal fade id" id="del-post<?php echo $rows['id_postagem'];?>" role="dialog">
            <div class="modal-dialog modal-content">
                <div class="modal-header"></div>
                <div class="modal-body">
                <h4><b><p>Deseja realmente apagar essa Postagem?</p></b><h4>
                    <div class="modal-footer">
                        <form action="{{url('apagar_post')}}" method="POST">
                            @csrf
                            <input name="id_postagem" type="hidden" value="<?php echo $rows['id_postagem'];?>">
                            <input type="hidden" name="identificador" value="0">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Confirmar</button>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
        <!-- FIM Modal deletar postagem -->
        <!-- Modal denunciar postagem -->
        <div class="modal fade id" id="den-post<?php echo $rows['id_postagem'];?>" role="dialog">
            <div class="modal-dialog modal-content">
                <div class="modal-header"></div>
                <form action="{{url('denunciar_post')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <h3><p>Denunciar postagem por:</p></h3><br>
                        <h6>
                            <label class="radio-custom">Conteúdo Inadequado
                                <input type="radio" id="radio1" type="radio" name="option" value="3" required>
                                <span class="checkmark"></span>
                            </label>
                            <label class="radio-custom">Spam
                                <input type="radio" id="radio3" type="radio" name="option" value="1" required>
                                <span class="checkmark"></span>
                            </label>
                            <label class="radio-custom">Cópia
                                <input type="radio" id="radio3" type="radio" name="option" value="2" required>
                                <span class="checkmark"></span>
                            </label>
                        </h6>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            <input name="id_postagem" type="hidden" value="<?php echo $rows['id_postagem'];?>">
                            <input name="id_usuario" type="hidden" value="<?php echo $user;?>">
                            <input data-toggle="modal" type="submit" class="btn btn-primary" value="Confirmar">
                        </div> 
                    </div>
                </form>
            </div>
        </div>
        <!-- FIM Modal denunciar postagem -->
    <?php $s++; } ?>
    <?php if ($total_pesquisa > 1){?>
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
    <?php }?>
</div>
@endsection