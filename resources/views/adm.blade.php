@extends('layouts.app')

<?php  
$conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");

$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

$sql = "SELECT * FROM usuarios WHERE id_situacao = '2' AND email_verified_at IS NOT NULL";
$result = mysqli_query($conn, $sql); //pesquisa pra ser usado na conta das rows
$total_pesquisa = mysqli_num_rows($result); //conta o total de rows

$quantidade = 2; //quantidade de rows

$num_pagina = ceil($total_pesquisa/$quantidade);

$inicio = ($quantidade*$pagina)-$quantidade;

$sql = "SELECT * FROM usuarios WHERE id_situacao = '2' AND email_verified_at IS NOT NULL LIMIT $inicio, $quantidade ";
$result2 = mysqli_query($conn, $sql); //pesquisa limitada com paginação

?>


@section('content')
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active"  href="{{ url('/adm') }}">Cadastros</a>
    <a class="nav-item nav-link"  href="{{ url('/adm2') }}">Nivel de acesso</a>
    <a class="nav-item nav-link"  href="{{ url('/adm3') }}">Reports</a>
  </div>
</nav>
<br>

<div class="row">
    <table class="col-12" id="table_conta">
        <caption>Cadastros Pendentes</caption>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Data</th>
                <th scope="col">Nome</th>
                <th scope="col">RGM/CPF</th>
                <th scope="col">Tipo</th>
                <th scope="col">Altorizar</th>
                <th scope="col">Deletar</th>
            </tr>
        </thead>

        <?php while($rows = mysqli_fetch_assoc($result2)){ 
            $setup = $rows['nivel']; ?>
        <tbody>
            <tr>
                <td><?php echo $rows['id']; ?></td>
                <td><?php echo $rows['email_verified_at']; ?></td>
                <td><?php echo $rows['usuario']; ?></td>
                <td><?php echo $rows['registro']; ?></td>
                <td><?php   if ($setup == 1) { echo "Usuario";    
                            }else if ($setup == 2) { echo "Avaliador";
                            }else if ($setup == 3) { echo "Admin";}
                    ?>
                </td>
                <form action="{{ url('/alt') }}" method="POST">
                    @csrf
                    <td><button name="alt" value="<?php echo $rows['id']; ?>">Icon</button></td>
                </form>
                <form action="{{ url('/del') }}" method="POST">
                    @csrf
                    <td><button name="del" value="<?php echo $rows['id']; ?>">Icon</button></td>
                </form>
            </tr>
        </tbody>
        <?php } ?>
    </table>    
</div>
<br>

<?php //paginação
    $pagina_anterior = $pagina - 1;
    $pagina_posterior = $pagina + 1;
?>

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