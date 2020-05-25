@extends('layouts.app')

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
    @include('layouts.post')

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
