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

$quantidade = 8; //quantidade de rows

$num_pagina = ceil($total_pesquisa/$quantidade);

$inicio = ($quantidade*$pagina)-$quantidade;

$sql = "SELECT * FROM postagens LEFT JOIN usuarios ON (postagens.id_usuarios = usuarios.id) WHERE data_postagem >= $periodo AND (id_categoria = $tipo) AND (id_situacao_postagem = $avalia) AND (postagens.titulo_postagem LIKE '%$pesquisa%' OR usuarios.usuario LIKE '%$pesquisa%') ORDER BY $filtro DESC LIMIT $inicio, $quantidade ";
$result2 = mysqli_query($conn, $sql); //pesquisa limitada com paginação

$pagina_anterior = $pagina - 1; //paginação
$pagina_posterior = $pagina + 1;

if ($periodo == "DATE(NOW()) - INTERVAL 7 DAY"){$setup = "Ultima Semana";
}elseif($periodo == "DATE(NOW()) - INTERVAL 30 DAY"){$setup = "Ultimo Mês";
}elseif($periodo == "DATE(NOW()) - INTERVAL 365 DAY"){$setup = "Ultimo Ano";
}else{$setup = "Periodo";}

if($tipo == "1"){ $setup2 = "Web, Mobile & Software"; 
}elseif($tipo == "2"){ $setup2 = "Design & Criação"; 
}elseif($tipo == "3"){$setup2 = "Engenharia & Arquitetura";
}elseif($tipo == "4"){$setup2 = "Marketing";
}elseif($tipo == "5"){$setup2 = "Outros";
}else{$setup2 = "Categoria";}

if($avalia == "1"){ $setup3 = "Avaliados"; 
}elseif($avalia == "2"){ $setup3 = "Pendentes"; 
}else{$setup3 = "Situação";}

$s = 1;
$smartphone = true;
?>

@section('content')

<div class="container my-4">
    <div class="filtro-pc row justify-content-center">
        <form method="POST" action="{{url('filtro')}}">
            @csrf
            <div class="row contorno"> 
                <button name="filtro" value="novo" <?php if($filtro == "data_postagem"){?> class="btn btn-edit selecionado" <?php }else{?> class="btn btn-edit btn-outline-primary-custom" <?php }?>><img width="21px" style="margin-top:-2px;" src="{{asset('img/new.png')}}"> Novos</button> 
                <button name="filtro" value="popu" <?php if($filtro == "likes_postagem"){?> class="btn btn-edit selecionado" <?php }else{?> class="btn btn-edit btn-outline-primary-custom" <?php }?>><img width="23px" style="margin-top:-2px;" src="{{asset('img/like.png')}}">Populares</button> 
                <button name="filtro" value="melh" <?php if($filtro == "media"){?> class="btn btn-edit selecionado" <?php }else{?> class="btn btn-edit btn-outline-primary-custom" <?php }?>><img width="22px" style="margin-top:-2px;" src="{{asset('img/avaliacao.png')}}">Melhores Avaliados</button> 
                <div class="dropdown">
                    <button class="btn btn-edit selecionado dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $setup3;?> 
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php if($avalia != "1"){?><button class="dropdown-item" style="margin-left: 0px" name="avalia" value="1">Avaliados</button><?php }?>
                        <?php if($avalia != "2"){?><button class="dropdown-item" style="margin-left: 0px" name="avalia" value="2">Pendentes</button><?php }?>
                        <?php if($avalia != "1 OR 2"){?><button class="dropdown-item" style="margin-left: 0px" name="avalia" value="3">Todos</button><?php }?>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-edit selecionado dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $setup2 ;?> 
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php if($tipo != "1"){?><button class="dropdown-item" style="margin-left: 0px" name="tipo" value="1">Web, Mobile & Software</button><?php }?>
                        <?php if($tipo != "2"){?><button class="dropdown-item" style="margin-left: 0px" name="tipo" value="2">Design & Criação</button><?php }?>
                        <?php if($tipo != "3"){?><button class="dropdown-item" style="margin-left: 0px" name="tipo" value="3">Engenharia & Arquitetura</button><?php }?>
                        <?php if($tipo != "4"){?><button class="dropdown-item" style="margin-left: 0px" name="tipo" value="4">Marketing</button><?php }?>
                        <?php if($tipo != "5"){?><button class="dropdown-item" style="margin-left: 0px" name="tipo" value="5">Outros</button><?php }?>
                        <?php if($tipo != "1 OR 2 OR 3 OR 4 OR 5"){?><button class="dropdown-item" style="margin-left: 0px" name="tipo" value="todas">Todas as categorias</button><?php }?>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-edit selecionado dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $setup; ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php if($setup != "Ultima Semana"){?><button class="dropdown-item" style="margin-left: 0px" name="periodo" value="1">Última Semana</button><?php }?>
                        <?php if($setup != "Ultimo Mês"){?><button class="dropdown-item" style="margin-left: 0px" name="periodo" value="2">Último Mês</button><?php }?>
                        <?php if($setup != "Ultimo Ano"){?><button class="dropdown-item" style="margin-left: 0px" name="periodo" value="3">Último Ano</button><?php }?>
                        <?php if($setup != "Periodo"){?><button class="dropdown-item" style="margin-left: 0px" name="periodo" value="4">Todas as postagens</button><?php }?>
                    </div>
                </div>
                <div class="dropdown">
                    <a id="navbarDropdown" role="button" style="cursor: pointer" data-toggle="dropdown">
                        <svg style="margin-left:4px;margin-top:13px" width="1.4em" height="1.4em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                        </svg>
                    </a>
                    <div class="dropdown-menu ajuste-drop3">
                        <a class="dropdown-item" href="{{url('reset')}}">
                            <svg width="1.1em" height="1.1em" viewBox="0 0 16 16" class="bi bi-arrow-counterclockwise" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                            </svg> &nbsp<b>Limpar</b>
                        </a>
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
                    <button class="btn btn-edit btn-outline-primary-custom dropdown-toggle t1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if($filtro == "media"){?> <img width="20px" style="margin-top:-3px;" src="{{asset('img/avaliacao.png')}}"> <?php echo "<t1>Mais avaliados</t1>"; }elseif($filtro == "likes_postagem"){?><img width="20px" style="margin-top:-2px;" src="{{asset('img/like.png')}}"><?php  echo "Populares"; } elseif($filtro == "data_postagem"){?> <img width="18px" style="margin-top:-2px;" src="{{asset('img/new.png')}}"> <?php echo "Novos";}else{echo $filtro;}?> 
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php if($filtro != "data_postagem"){?><button class="dropdown-item" style="margin-left: 0px" name="filtro" value="novos"><img width="21px" style="margin-top:-2px;" src="{{asset('img/new.png')}}"> Novos</button><?php }?>
                        <?php if($filtro != "likes_postagem"){?><button class="dropdown-item" style="margin-left: 0px" name="filtro" value="popu"><img width="23px" style="margin-top:-2px;" src="{{asset('img/like.png')}}"> Populares</button><?php }?>
                        <?php if($filtro != "media"){?><button class="dropdown-item" name="filtro" style="margin-left: 0px" value="melh"><img width="22px" style="margin-top:-3px;" src="{{asset('img/avaliacao.png')}}"> Mais avaliados</button><?php }?>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-edit selecionado btn-primary dropdown-toggle t1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $setup3;?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php if($avalia != "1"){?><button class="dropdown-item" style="margin-left: 0px" name="avalia" value="1">Avaliados</button><?php }?>
                        <?php if($avalia != "2"){?><button class="dropdown-item" style="margin-left: 0px" name="avalia" value="2">Pendentes</button><?php }?>
                        <?php if($avalia != "1 OR 2"){?><button class="dropdown-item" style="margin-left: 0px" name="avalia" value="3">Todos</button><?php }?>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-edit selecionado btn-primary dropdown-toggle t1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $setup2;?> 
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php if($tipo != "1"){?><button class="dropdown-item" style="margin-left: 0px" name="tipo" value="1">Web, Mobile & Software</button><?php }?>
                        <?php if($tipo != "2"){?><button class="dropdown-item" style="margin-left: 0px" name="tipo" value="2">Design & Criação</button><?php }?>
                        <?php if($tipo != "3"){?><button class="dropdown-item" style="margin-left: 0px" name="tipo" value="3">Engenharia & Arquitetura</button><?php }?>
                        <?php if($tipo != "4"){?><button class="dropdown-item" style="margin-left: 0px" name="tipo" value="4">Marketing</button><?php }?>
                        <?php if($tipo != "5"){?><button class="dropdown-item" style="margin-left: 0px" name="tipo" value="5">Outros</button><?php }?>
                        <?php if($tipo != "1 OR 2 OR 3 OR 4 OR 5"){?><button class="dropdown-item" style="margin-left: 0px" name="tipo" value="todas">Todas as categorias</button><?php }?>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-edit selecionado btn-primary dropdown-toggle t1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $setup; ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php if($setup != "Ultima Semana"){?><button class="dropdown-item" style="margin-left: 0px" name="periodo" value="1">Última Semana</button><?php }?>
                        <?php if($setup != "Ultimo Mês"){?><button class="dropdown-item" style="margin-left: 0px" name="periodo" value="2">Último Mês</button><?php }?>
                        <?php if($setup != "Ultimo Ano"){?><button class="dropdown-item" style="margin-left: 0px" name="periodo" value="3">Último Ano</button><?php }?>
                        <?php if($setup != "Periodo"){?><button class="dropdown-item" style="margin-left: 0px" name="periodo" value="4">Todas as postagens</button><?php }?>
                    </div>
                </div>
                <div class="dropdown">
                    <a id="navbarDropdown" role="button" style="cursor: pointer" data-toggle="dropdown">
                        <svg style="margin-left:4px;margin-top:13px" width="1.4em" height="1.4em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                        </svg>
                    </a>
                    <div class="dropdown-menu ajuste-drop3">
                        <a class="dropdown-item" href="{{url('reset')}}"><img width="33px"src="{{asset('img/reset.png')}}">Limpar</a>
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
            <button type="submit" class="fas fa-search no-border-button" aria-hidden="true"></button>
            <input class="form-control-sm ml-1 pesquisa" type="text" name="pesquisa" placeholder="Procurar ideias..." aria-label="Search">
        </form>
    </div>
    <div style="padding:10px"></div>
    <div class="row justify-content-center"> 
        <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 80%;">
    </div>
    <?php if(NULL !== $pesquisa){?><a href="{{url('reset_search')}}"><img width="16px" style="padding-bottom:3px" src="{{asset('img/close.png')}}"></a> Resultados da Pesquisa "<?php echo mb_strimwidth($pesquisa, 0, 30, "..."); ?>"<?php }?>
</div>
    
<?php if ($total_pesquisa < 1){?>
    <div class="aviso-home">    
        <img class="aviso-img" src="{{asset('img/danger.png')}}">
        <div class="aviso-text"><b>Nenhuma Postagem encontrada</b></div>
    </div>
<?php }?>

<?php while($rows = mysqli_fetch_assoc($result2)){ $situation = $rows['id_situacao_postagem']; $id_post = $rows['id_postagem']; $user_post = $rows['id_usuarios']; $name = $rows['usuario'];

    $cont = 0;
    for($q=0; $q<sizeof($post['img_post']); $q++){
        if($post['img_post'][$q]->id_postagem == $id_post) {
            if(Str::substr($post['img_post'][$q]->img_post, 30, 1) == 2) {
                $cont = $cont + 1;
            }
        }
    }
?>
    <div class="card-home">
        <div class="usu-home">
            <?php if($rows['img_usuarios'] == NULL){?>
                <form id="perfil_img<?php echo $rows['id']?>" action="{{url('perfil')}}" method="GET">
                    @csrf
                    <input type="hidden" name="id_usuario" value="<?php echo $rows['id']?>">
                    <a href="javascript:$('#perfil_img<?php echo $rows['id']?>').submit();">
                        <img class="img-home" src="{{asset('img/semuser.png')}}">
                    </a>
                </form>
            <?php }else{?>
                <form id="perfil_img<?php echo $rows['id']?>" action="{{url('perfil')}}" method="GET">
                    @csrf
                    <input type="hidden" name="id_usuario" value="<?php echo $rows['id']?>">
                    <a href="javascript:$('#perfil_img<?php echo $rows['id']?>').submit();">
                        <img class="img-home" src="{{asset('/ToDo/storage/app/public/users/'.$rows['img_usuarios'])}}">
                    </a>
                </form>
            <?php }?>
            <f1>&nbsp; Postado por</f1>
            <f2>
                <form action="{{url('perfil')}}" method="GET">
                    @csrf
                    <input type="hidden" name="id_usuario" value="<?php echo $rows['id']?>">
                    <button style="text-decoration:underline" class="no-border-button" type="submit"><b><?php echo mb_strimwidth($name, 0, 26, "...") ; ?></b></button>
                </form>
            </f2>
        </div>
        <div class="option-home dropdown">
            <a id="navbarDropdown" role="button" style="cursor: pointer" data-toggle="dropdown">
                <svg src="{{asset('img/option.png')}}" width="1.4em" height="1.4em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                </svg>
            </a>
            <div class="dropdown-menu ajuste-drop4">
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
        <div class="<?php if($cont > 0) {echo "title-home";}else{echo "title-home2";} ?>"><b><?php echo mb_strtoupper($rows['titulo_postagem']); ?></b></div>
        <div class="desc-home"><textarea readonly class="<?php if($cont>0){echo "text-desc";}else{echo "text-desc2";} ?>"><?php echo mb_strimwidth($rows['descricao_postagem'], 0, 500, "..."); ?></textarea></div>
        
        <?php $resultados = Helper::verifica_like_post($id_post)?>
        @if($resultados == 0)
        <div class="like_home">
            <span style="cursor:pointer;" id="btn_like" class="fa-thumbs-o-up fa" onclick="like_post(this)" data-id="<?php echo $id_post ;?>"></span>
            <?php if($rows['likes_postagem'] >= 999){?>
                <span class="like_conta"><?php echo "999+"; ?></span>
            <?php }else{ ?>
                <span class="like_count" id="<?php echo $id_post ;?>"><?php echo $rows['likes_postagem']; ?></span>
            <?php } ?>
        </div>
        @else 
        <div class="like_home">
            <span style="cursor:pointer;" id="btn_like" class="fa-thumbs-up fa" onclick="like_post(this)" data-id="<?php echo $id_post ;?>"></span>
            <?php if($rows['likes_postagem'] >= 999){?>
                <span class="like_conta"><?php echo "999+"; ?></span>
            <?php }else{ ?>
                <span class="like_count" id="<?php echo $id_post ;?>"><?php echo $rows['likes_postagem']; ?></span>
            <?php } ?>
        </div>
        @endif

        <div class="data-home"><f2><?php echo date('d/m/Y', strtotime($rows['data_postagem'])); ?></f2></div>
        <div class="situation-home">
            <img class="img-ava" src="{{asset('img/avaliacao.png')}}"></img>
            <div class="result-situation-home"><?php if ($situation == 1) { echo number_format((float)$rows['media'], 2, '.', '');}else{ echo "N/A";} ?></div>
        </div>
        <div class="visualizar-home"> <a style="text-decoration:underline" type="button"  data-toggle="modal" onclick="modal(<?php echo $id_post ;?>)" data-target="#post<?php echo $id_post ?>">Visualizar</a> </div>
        @for($a=0; $a<sizeof($post['img_post']); $a++)
            @if($post['img_post'][$a]->id_postagem == $id_post)
                    @for($m=0; $m<sizeof($post['img_post']); $m++)
                        @if($post['img_post'][$m]->id_postagem == $id_post)
                            @if(Str::substr($post['img_post'][$m]->img_post, 30, 1) == 2)
                                <img class="destaque-home" id="<?php echo 'img4'.$id_post ?>" onclick="show_modal('img4'+<?php echo $id_post ?>)" src="{{url($post['img_post'][$m]->img_post)}}">
                            @endif
                        @endif
                    @endfor
                <?php break; ?>
            @endif
        @endfor
    </div>
    @include('layouts.post')
    <!-- Modal deletar postagem -->
    <div class="modal fade id" id="del-post<?php echo $rows['id_postagem'];?>" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <br>
                    <h5><b><p>Deseja apagar essa Postagem?</p></b><h5>
                    <br>
                    <div class="modal-footer">
                        <form action="{{url('apagar_post')}}" method="POST">
                            @csrf
                            <input name="id_postagem" type="hidden" value="<?php echo $rows['id_postagem'];?>">
                            <input type="hidden" name="identificador" value="0">
                            <input type="hidden" name="filename" value="<?php echo $rows['id_postagem']. $rows['titulo_postagem']; ?>">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Confirmar</button>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    <!-- FIM Modal deletar postagem -->
    <!-- Modal denunciar postagem -->
    <div class="modal fade id" id="den-post<?php echo $rows['id_postagem'];?>" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{url('denunciar_post')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <h4><p><b>Denunciar postagem por:</b></p></h4><br>
                        <h6>
                            <label class="radio-custom">Conteúdo Inadequado
                                <input type="radio" id="radio1" name="option" value="3" required>
                                <span class="checkmark"></span>
                            </label>
                            <label class="radio-custom">Spam
                                <input type="radio" id="radio3" name="option" value="1" required>
                                <span class="checkmark"></span>
                            </label>
                            <label class="radio-custom">Cópia
                                <input type="radio" id="radio3" name="option" value="2" required>
                                <span class="checkmark"></span>
                            </label>
                        </h6>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            <input name="id_postagem" type="hidden" value="<?php echo $rows['id_postagem'];?>">
                            <input name="id_usuario" type="hidden" value="<?php echo $user;?>">
                            <button type="submit" class="btn btn-primary">Confirmar</button>
                        </div> 
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- FIM Modal denunciar postagem -->
<?php $s++; } ?>
<?php if ($total_pesquisa > 1){?>
    <nav class="text-center" style="margin-top:30px">
        <ul class="pagination">
            <li class="page-item">
                <?php
                if($pagina_anterior != 0){ ?>
                    <a class="page-link" href="?pagina=<?php echo $pagina_anterior ?>" aria-label="Primeiro">
                        <i class="fa fa-angle-left" style="font-size:15px"></i>
                    </a>
                <?php }else{ ?>
                    <a class="page-link" aria-label="Primeiro">
                        <i class="fa fa-angle-left" style="font-size:15px"></i>
                    </a>
                <?php }  ?>
            </li>
            <?php $pagina_ant = $pagina - 1; ?>
            <?php $pagina_atual = $pagina; ?>
            <?php $pagina_pos = $pagina + 1; ?>
            
            <?php if($pagina_anterior  - 2 > 0){ ?> 
                <li class="page-item"><a class="page-link" href="?pagina=<?php echo "1"; ?>"><?php echo "1"; ?></a></li>
                <li class="page-item"><a class="page-link" style="pointer-events: none;">...</a></li>
            <?php } ?>
            <?php if($pagina_anterior - 1 > 0){ ?>
                <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina_ant - 1; ?>"><?php echo $pagina_ant - 1; ?></a></li>
            <?php }?>
            <?php if($pagina_anterior != 0){ ?>
                <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina_ant; ?>"><?php echo $pagina_ant; ?></a></li>
            <?php }?>
            <li class="page-item"><a style="color:black"class="page-link"><?php echo "<b>" . $pagina_atual . "</b>"; ?></a></li>
            <?php if($pagina_posterior <= $num_pagina){ ?>
                <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina_pos; ?>"><?php echo $pagina_pos; ?></a></li>
            <?php } ?>
            <?php if($pagina_posterior + 1 <= $num_pagina){ ?>
                <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina_pos + 1; ?>"><?php echo $pagina_pos + 1; ?></a></li>
            <?php } ?>
            <?php if($pagina_posterior + 2 <= $num_pagina){ ?>
                <li class="page-item"><a class="page-link" style="pointer-events: none;">...</a></li> 
                <li class="page-item"><a class="page-link" href="?pagina=<?php echo $num_pagina; ?>"><?php echo $num_pagina; ?></a></li>
            <?php } ?>
            <li>
                <?php
                if($pagina_posterior <= $num_pagina){ ?>
                    <a class="page-link" href="?pagina=<?php echo $pagina_posterior; ?>" aria-label="Ultimo">
                        <i class="fa fa-angle-right" style="font-size:16px"></i>
                    </a>
                <?php }else{ ?>
                    <a class="page-link" aria-label="Ultimo">
                        <i class="fa fa-angle-right" style="font-size:16px"></i>
                    </a>
                <?php }  ?>
            </li>
        </ul>
    </nav>
<?php }?>
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
                    <br>
                    <label class="radio-custom"><b>Novos</b>
                        <input type="radio" id="radio1" name="filtro" value="novo" <?php if($filtro == "data_postagem"){ echo "checked"; }else{ echo "required";} ?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="radio-custom"><b>Populares</b>
                        <input type="radio" id="radio2" name="filtro" value="popu" <?php if($filtro == "likes_postagem"){ echo "checked"; }else{ echo "required";} ?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="radio-custom"><b>Mais avaliados</b>
                        <input type="radio" id="radio3" name="filtro" value="melh" <?php if($filtro == "media"){ echo "checked"; }else{ echo "required";} ?>>
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
            <form action="{{ url('filtro2') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="justify-content-center alinhamento-filtro">
                        <select name="avalia" class="selecionar-op">
                            <option class="op" selected disabled hidden><?php if($avalia == "1 OR 2"){ echo "Situação"; }else{ echo $setup3; } ?></option>
                            <option class="op" value="1">Avaliados</option>
                            <option class="op" value="2">Pendentes</option>
                            <option class="op" value="3">Todos</option>
                        </select>
                        <select name="tipo" class="selecionar-op">
                            <option class="op" selected disabled hidden><?php if($tipo == "1 OR 2 OR 3 OR 4 OR 5"){ echo "Categorias"; }else{ echo $setup2; } ?></option>
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
                            <option class="op" selected disabled hidden><?php if($setup == "Periodo"){ echo "Periodo"; }else{ echo $setup; } ?></option>
                            <option class="op" value="1">Última Semana</option>
                            <option class="op" value="2">Último Mês</option>
                            <option class="op" value="3">Último Ano</option>
                            <option class="op" value="4">Todas as postagens</option>
                        </select>
                        <a class="ajuste-link selecionar-op btn-danger" href="{{url('reset')}}"><s3>Limpar</s3></a>
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
@endsection