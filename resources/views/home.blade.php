@extends('layouts.app')


<?php  
$conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");

$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

$filtro = Session::get('filtro');
$tipo = Session::get('tipo');
$periodo = Session::get('periodo');

if(!isset($filtro)){$filtro = "data_postagem";}
if(!isset($tipo)){$tipo = "1";}
if(!isset($periodo)){ $periodo = "data_postagem";}

$sql = "SELECT * FROM postagens WHERE data_postagem >= $periodo AND id_categoria = $tipo ORDER BY $filtro DESC";
$result = mysqli_query($conn, $sql); //pesquisa pra ser usado na conta das rows
$total_pesquisa = mysqli_num_rows($result); //conta o total de rows

$quantidade = 3; //quantidade de rows

$num_pagina = ceil($total_pesquisa/$quantidade);

$inicio = ($quantidade*$pagina)-$quantidade;

$sql = "SELECT * FROM postagens WHERE data_postagem >= $periodo AND id_categoria = $tipo ORDER BY $filtro DESC LIMIT $inicio, $quantidade ";
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
            <button name="filtro" value="popu" <?php if($filtro == "likes_postagem"){?> class="btn btn-outline-primary-custom" <?php }else{?> class="btn btn-primary" <?php }?>>populares</button> 
            <button name="filtro" value="melh" class="btn btn-primary">Melhores Avaliados(To Do)</button> 
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php if($tipo == "1"){ echo "ideias"; }else{ echo "Sugestões"; }?> 
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <button class="dropdown-item" name="tipo" value="1">Ideias</button>
                    <button class="dropdown-item" name="tipo" value="2">Sugestões</button>
                </div>
            </div>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $setup ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <button class="dropdown-item" name="periodo" value="1">Ultima Semana</button>
                    <button class="dropdown-item" name="periodo" value="2">Ultima Mês</button>
                    <button class="dropdown-item" name="periodo" value="3">Ultimo Ano</button>
                    <button class="dropdown-item" name="periodo" value="4">Todas as postagens</button>
                </div>
            </div>
        </div>  
    </form>
</div>
<?php if ($total_pesquisa < 1){?>
    <div class="aviso-home">    
        <img class="aviso-center" width="150px" src="{{asset('img/danger.png')}}">
        <h2 class="aviso-text"><b>Nenhuma Postagem encontrada</b></h2>
    </div>
<?php }?>


<?php while($rows = mysqli_fetch_assoc($result2)){ $situation = $rows['id_situacao_postagem']; ?>
    <div class="card-home">
        <div class="title-home"><h2><b><?php echo $rows['titulo_postagem']; ?></b></h2></div>
        <div class="desc-home"><?php echo mb_strimwidth($rows['descricao_postagem'], 0, 70, "..."); ?></div>
        <div class="like-home"><?php echo "<f><b>" . $rows['likes_postagem'] . " Likes" . "</b></f>"; ?></div>
        <div class="link-home"> <a style = "text-decoration:underline" href="#">Visualizar Ideia</a> </div>
        <div class="situation-home"><b><?php if ($situation == 1) { echo "<f3>". "Avaliado" . "</f3>";}else echo "<f4>" . "Pendente" . "</f4>"; ?></b></f2></div>
        <div class="data-home"><f2><?php echo date('d/m/Y', strtotime($rows['data_postagem'])); ?></f2></div>
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
