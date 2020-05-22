@extends('layouts.app')

<?php  session_start();
$conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");

$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

if(NULL !== Session::get('pesquisa2')){   $_SESSION['pesquisa2'] = Session::get('pesquisa2');}
if(isset($_SESSION['pesquisa2'])){$pesquisa2 = $_SESSION['pesquisa2'];}
if(!isset($pesquisa2)){ $pesquisa2 = NULL;}

$sql = "SELECT * FROM usuarios WHERE id_situacao = '1' AND (usuario LIKE '%$pesquisa2%' OR registro LIKE '%$pesquisa2%') ";
$result = mysqli_query($conn, $sql); //pesquisa pra ser usado na conta das rows
$total_pesquisa = mysqli_num_rows($result); //conta o total de rows

$quantidade = 5; //quantidade de rows

$num_pagina = ceil($total_pesquisa/$quantidade);

$inicio = ($quantidade*$pagina)-$quantidade;

$sql = "SELECT * FROM usuarios WHERE id_situacao = '1' AND (usuario LIKE '%$pesquisa2%' OR registro LIKE '%$pesquisa2%') LIMIT $inicio, $quantidade ";
$result2 = mysqli_query($conn, $sql); //pesquisa limitada com paginação

$modal = "adm2"; 
if ($total_pesquisa == 0){ $modal = false;} //se não ouver rows de usuarios o modal é desabilitado

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
    <a class="nav-item nav-link"  href="{{ url('/adm') }}">Cadastros</a>
    <a class="nav-item nav-link active"  href="{{ url('/adm2') }}">Nivel de acesso</a>
    <a class="nav-item nav-link"  href="{{ url('/adm3') }}">Denuncias</a>
  </div>
</nav>
<br>
<div class="row justify-content-md-center">
<form class="form-inline my-2 my-lg-0" method="POST" action="/pesquisa_user">
    @csrf
    <input class="form-control mr-sm-2" type="text" name="pesquisa_user" placeholder="Procure o usuario pelo Nome, RGM/CPF ou Tipo" aria-label="Search" style="width: 400px">
    <button class="btn btn-secondary my-2 my-sm-0" type="submit">Procurar</button>
</form>
</div>
<br>
<?php if(NULL !== $pesquisa2){?><div class="contorno-pequeno"><a href="/reset_search2"><img width="20px" src="{{asset('img/close.png')}}"></a> Resultados da Pesquisa "<?php echo $pesquisa2 ?>"</div><?php }?>
<br>
<div class="row">
    <table class="col-12" id="table_conta">
        <caption>Alterar nivel de acesso</caption>
        <?php if(isset($check)){ $style = TRUE ?>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">RGM/CPF</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Alterar</th>
                </tr>
            </thead>
            <?php while($rows = mysqli_fetch_assoc($result2)){ $setup = $rows['nivel'];$id_usuario = $rows['id'];$nome = $rows['usuario'];?>
            <!-- Modal -->
            <div class="modal fade" id="modal<?php echo $id_usuario ?>" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('/alterar') }}" method="POST">
                        @csrf
                        <div class="modal-body-white">
                            <p class="text-center"><h5>Alterar o acesso de: <?php echo $nome ?></h5></p>
                            <br>
                            <input type='hidden' name="alterar" value="<?php echo $id_usuario ?>"/>
                            <label for="tipo" class="bold subdados">Tipo</label>
                            <select name="tipo" class="select" class="btn btn-primary">
                                <option>Usuario</option><option>Avaliador</option><option>Admin</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar mudanças</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <!-- Fim Modal -->
            <tbody>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $rows['usuario']; ?></td>
                    <td><?php echo $rows['registro']; ?></td>
                    <td><?php   if ($setup == 1) { echo "Usuario";    
                                }else if ($setup == 2) { echo "Avaliador";
                                }else if ($setup == 3) { echo "Admin";}
                        ?>
                    </td>
                    <td><a type="button"  data-toggle="modal" data-target="#modal<?php echo $id_usuario ?>">
                    <img width="40px" src="{{asset('img/edit.png')}}">
                    </a></td>
                </tr>
            </tbody>
            <?php $i++; } ?>
        <?php }else{?>
            <tbody>  
                <tr>
                    <td rowspan="10">
                        <div><br>
                            <img width="500px" height="200" src="{{asset('img/clock.png')}}"><br><br>
                            <p><h4><b>Nenhum usuario disponivel para alteração de nivel</h4></b></p>
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
<?php }?>


@endsection