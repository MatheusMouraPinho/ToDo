@extends('layouts.app')


<?php  
$conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");

$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

$sql = "SELECT id_postagem FROM postagens";
$result = mysqli_query($conn, $sql); //pesquisa pra ser usado na conta das rows
$total_pesquisa = mysqli_num_rows($result); //conta o total de rows

$quantidade = 3; //quantidade de rows

$num_pagina = ceil($total_pesquisa/$quantidade);

$inicio = ($quantidade*$pagina)-$quantidade;



if(isset($_GET['filtro'])){
    $var = $_GET['filtro'];

    if($var == "popu"){
        $filtro = "likes_postagem"; 
    }else{
        $filtro = "data_postagem";
    }

}else{
    $filtro = "data_postagem";
}

if(isset($_GET['tipo'])){
    $var2 = $_GET['tipo'];

    if($var2 == "1"){
        $tipo = "1"; 
    }else{
        $tipo = "2";
    }

}else{
    $tipo = "1";
}

if(isset($_GET['periodo'])){
    $var3 = $_GET['periodo'];

    if($var3 == "1"){
        $periodo = "";
    }else{
        $periodo = ""; 
    }
}else{
    $periodo = "data_postagem"; 
}

$sql = "SELECT * FROM postagens WHERE data_postagem >= $periodo AND id_categoria = $tipo ORDER BY $filtro DESC LIMIT $inicio, $quantidade ";
$result2 = mysqli_query($conn, $sql); //pesquisa limitada com paginação

$pagina_anterior = $pagina - 1; //paginação
$pagina_posterior = $pagina + 1;

?>


@section('content')

<div class="row justify-content-md-center">
    <form method="GET">
        <div class="row contorno"> 
            <button name="filtro" value="novo" <?php if($filtro == "data_postagem"){?> class="btn btn-outline-primary-custom" <?php }else{?> class="btn btn-primary" <?php }?>>Novos</button> 
            <button name="filtro" value="popu" <?php if($filtro == "likes_postagem"){?> class="btn btn-outline-primary-custom" <?php }else{?> class="btn btn-primary" <?php }?>  >populares</button> 
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
                    Periodo (To Do)
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <button class="dropdown-item" name="periodo" value="1">Ultima Semana</button>
                    <button class="dropdown-item" name="periodo" value="2">Ultima Mes</button>
                </div>
            </div>
        </div>  
    </form>
</div>
<?php while($rows = mysqli_fetch_assoc($result2)){ $situation = $rows['id_situacao_postagem']; ?>
    <div class="card-home">
        <div class="title-home"><h2><b><?php echo $rows['titulo_postagem']; ?></b></h2></div>
        <div class="desc-home"><?php echo mb_strimwidth($rows['descricao_postagem'], 0, 70, "..."); ?></div>
        <div class="like-home"><?php echo $rows['likes_postagem'] . " <b>Likes</b>"; ?></div>
        <div class="link-home"> <a href="#">Visualizar Ideia</a> </div>
        <div class="situation-home"><?php if ($situation == 1) { echo "Avaliado";}else echo "Pendente"; ?></div>
        <div class="data-home"><?php echo $rows['data_postagem']; ?></div>
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
