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
?>

@section('content')

<div class="container my-4">
    <div class="row justify-content-md-center">
        <form method="POST" action="{{url('filtro')}}">
            @csrf
            <div class="row contorno"> 
                <button name="filtro" value="novo" <?php if($filtro == "data_postagem"){?> class="btn btn-outline-primary-custom" <?php }else{?> class="btn btn-primary" <?php }?>>Novos</button> 
                <button name="filtro" value="popu" <?php if($filtro == "likes_postagem"){?> class="btn btn-outline-primary-custom" <?php }else{?> class="btn btn-primary" <?php }?>>Populares</button> 
                <button name="filtro" value="melh" <?php if($filtro == "media"){?> class="btn btn-outline-primary-custom" <?php }else{?> class="btn btn-primary" <?php }?>>Melhores Avaliados</button> 
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if($avalia == "1"){ echo "Avaliados"; }elseif($avalia == "2"){ echo "Pendentes"; }else{echo "Todos";}?> 
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
                        }elseif($tipo == "4"){echo "Marketing";}elseif($tipo == "5"){echo "Outros";}else{echo "Todas as categorias";}?> 
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
                        <?php echo $setup ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php if($setup != "Ultima Semana"){?><button class="dropdown-item" name="periodo" value="1">Última Semana</button><?php }?>
                        <?php if($setup != "Ultimo Mês"){?><button class="dropdown-item" name="periodo" value="2">Último Mês</button><?php }?>
                        <?php if($setup != "Ultimo Ano"){?><button class="dropdown-item" name="periodo" value="3">Último Ano</button><?php }?>
                        <?php if($setup != "Todas as Postagens"){?><button class="dropdown-item" name="periodo" value="4">Todas as postagens</button><?php }?>
                    </div>
                </div>
                <a href="{{url('reset')}}"><img width="45px" src="{{asset('img/reset.png')}}"></a>
            </div>  
        </form>
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
                        <div class="like-home like-border"><b><button type="submit" class="row no-border-button"><img class="ajuste-unlike" width="25px" src="{{asset('img/like2.png')}}"><div class="num-like-home"><?php echo $rows['likes_postagem']; ?></div></button></b></div>
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
                                <a class="dropdown-item" style="cursor: pointer"  data-toggle="modal" data-target="#del-post<?php echo $rows['id_postagem'];?>">Apagar</a>
                            <?php }else{ ?>
                                <a class="dropdown-item" style="cursor: pointer" data-toggle="modal" data-target="#den-post<?php echo $rows['id_postagem'];?>">Denunciar</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.post')
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
</div>
@endsection