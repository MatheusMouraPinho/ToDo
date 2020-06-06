@extends('layouts.app')

<?php  
$conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");

$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

$sql = "SELECT * FROM usuarios WHERE id_situacao = '2' AND email_verified_at IS NOT NULL";
$result = mysqli_query($conn, $sql); //pesquisa pra ser usado na conta das rows
$total_pesquisa = mysqli_num_rows($result); //conta o total de rows

$quantidade = 5; //quantidade de rows

$num_pagina = ceil($total_pesquisa/$quantidade);

$inicio = ($quantidade*$pagina)-$quantidade;

$sql = "SELECT * FROM usuarios WHERE id_situacao = '2' AND email_verified_at IS NOT NULL LIMIT $inicio, $quantidade ";
$result2 = mysqli_query($conn, $sql); //pesquisa limitada com paginação

$pagina_anterior = $pagina - 1; //paginação
$pagina_posterior = $pagina + 1;

$i = 1; //id base tabelas

if ($total_pesquisa > 0 ){ //se tiver rows
    $check = TRUE;
}
?>


@section('content')
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active"  href="{{ url('/adm') }}">Cadastros</a>
    <a class="nav-item nav-link"  href="{{ url('/adm2') }}">Usuarios</a>
    <a class="nav-item nav-link"  href="{{ url('/adm3') }}">Postagens</a>
    <a class="nav-item nav-link"  href="{{ url('/adm4') }}">Comentarios</a>
  </div>
</nav>
<br>

<div class="row">
    <div class="text-centro contorno-titulo"><h3>Cadastros Pendentes</h3></div>
    <table class="col-12" id="table_conta">
        <caption><br></caption>
        <?php if(isset($check)){ ?>
            <thead>
                <tr class="tr-custom">
                    <th scope="col">ID</th>
                    <th scope="col">Data</th>
                    <th scope="col">Nome</th>
                    <th scope="col">RGM/CPF</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Autorizar</th>
                    <th scope="col">Deletar</th>
                </tr>
            </thead>
            <?php while($rows = mysqli_fetch_assoc($result2)){ $setup = $rows['nivel']; ?>
                <tbody class="pisca">
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $rows['email_verified_at']; ?></td>
                        <td><?php echo mb_strimwidth($rows['usuario'], 0, 25, "..."); ?></td>
                        <td><?php echo $rows['registro']; ?></td>
                        <td><?php   if ($setup == 1) { echo "Usuario";    
                                    }else if ($setup == 2) { echo "Avaliador";
                                    }else if ($setup == 3) { echo "Admin";}
                            ?>
                        </td>
                        <form action="{{ url('/alt') }}" method="POST">
                            @csrf
                            <td><button class="no-border-button" name="alt" value="<?php echo $rows['id']; ?>"><img width="40px" src="{{asset('img/correct.png')}}"></button></td>
                        </form>
                        <form action="{{ url('/del') }}" method="POST">
                            @csrf
                            <td><button class="no-border-button" name="del" value="<?php echo $rows['id']; ?>"><img width="40px" src="{{asset('img/denie.png')}}"></button></td>
                        </form>
                    </tr>
                </tbody>
            <?php $i++; }?>
        <?php }else{?>
            <tbody class="texture">  
                <tr>
                    <td rowspan="10">
                        <div>
                            <img width="20%" height="20%" style="margin-top:8px;" src="{{asset('img/clock.png')}}"><br>
                            <p><h4><b>Nenhum cadastro disponivel para gerenciamento</h4></b></p>
                        </div>
                    </td>
                </tr>
            </tbody>
        <?php } ?>
    </table>    
</div>
<br>

<?php if(isset($check)){ ?>
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
<?php } ?>

@endsection