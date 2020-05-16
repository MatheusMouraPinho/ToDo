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

$sql = "SELECT * FROM postagens WHERE id_categoria = $tipo ORDER BY $filtro DESC LIMIT $inicio, $quantidade ";
$result2 = mysqli_query($conn, $sql); //pesquisa limitada com paginação

$pagina_anterior = $pagina - 1; //paginação
$pagina_posterior = $pagina + 1;
?>


@section('content')

<div class="row justify-content-md-center">
    <form method="GET">
        <div> 
            <div class="row justify-content-md-center">
                
                    <button name="filtro" value="novo" <?php if($filtro == "data_postagem"){?> class="btn btn-outline-secondary" <?php }else{?> class="btn btn-primary" <?php }?>>Novos</button> 
                    <button name="filtro" value="popu" <?php if($filtro == "likes_postagem"){?> class="btn btn-outline-secondary" <?php }else{?> class="btn btn-primary" <?php }?>  >populares</button> 
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
                        Ultima semana (To Do)
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item">Ultimo Mês</a>
                    </div>
                </div>
            </div> 
        </div>  
    </form>
    <?php while($rows = mysqli_fetch_assoc($result2)){  ?>
        <table class="col-12" id="table_conta">
            <thead>
                <tr>
                    <th scope="col"><h2><b><?php echo $rows['titulo_postagem']; ?><b></h2></th>
                    <th scope="col">likes</th>
                    <th scope="col">Data</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $rows['descricao_postagem']; ?></td>
                    <td><?php echo $rows['likes_postagem']; ?></td>
                    <td><?php echo $rows['data_postagem']; ?></td>
                </tr>
            </tbody>
        </table> 
        <br> 
    <?php } ?>  
</div>
<br>



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
