@extends('layouts.app')

<?php  
$db_config = Config::get('database.connections.'.Config::get('database.default'));
$conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
mysqli_set_charset($conn, 'utf8');

$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

$notific = Session::get('notific');
$usu = Session::get('usu');

$sql = "SELECT * FROM usuarios";
$result = mysqli_query($conn, $sql); //pesquisa pra ser usado na conta das rows
$total_pesquisa = mysqli_num_rows($result); //conta o total de rows

$quantidade = 8; //quantidade de rows

$num_pagina = ceil($total_pesquisa/$quantidade);

$inicio = ($quantidade*$pagina)-$quantidade;

$sql = "SELECT * FROM usuarios ORDER BY data_cadastro DESC LIMIT $inicio, $quantidade ";
$result2 = mysqli_query($conn, $sql); //pesquisa limitada com paginação

$pagina_anterior = $pagina - 1; //paginação
$pagina_posterior = $pagina + 1;

if ($total_pesquisa > 0 ){ //se tiver rows
    $check = TRUE;
}
?>


@section('content')
<div class="container my-4">
    <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link ativo"  href="{{ url('adm') }}">Cadastros</a>
        <a class="nav-item nav-link fix"  href="{{ url('adm2') }}">Usuários</a>
        <a class="nav-item nav-link fix"  href="{{ url('adm3') }}">Postagens</a>
        <a class="nav-item nav-link fix"  href="{{ url('adm4') }}">Comentários</a>
    </div>
    </nav>
    <br>

    <div class="row">
        <div class="text-centro contorno-titulo"><h3>Historico de cadastros</h3></div>
        <table class="col-12">
            <caption><br></caption>
            <?php if(isset($check)){ ?>
                <thead>
                    <tr class="tr-custom">
                        <th scope="col">Data de cadastro</th>
                        <th scope="col">Nome</th>
                        <th scope="col">RGM/CPF</th>
                        <th scope="col">Email</th>
                        <th scope="col">Situação Email</th>
                    </tr>
                </thead>
                <?php while($rows = mysqli_fetch_assoc($result2)){ $setup = $rows['nivel']; $mail = $rows['email']; $name = $rows['usuario']; $id_usuario = $rows['id'];?>
                    <tbody class="texture pisca">
                        <tr class="">
                            <td><?php echo date('d/m/Y', strtotime($rows['data_cadastro'])). " às ". date('H:i', strtotime($rows['email_verified_at'])); ?></td>
                            <td><?php echo mb_strimwidth($rows['usuario'], 0, 25, "..."); ?></td>
                            <td><?php echo $rows['registro']; ?></td>
                            <td><?php echo mb_strimwidth($rows['email'], 0, 20, "..."); ?></td>
                            <td><?php 
                                if($rows['email_verified_at'] == NULL){
                                    $situ = "Pendente";
                                }else{
                                    $situ = "Confirmado";
                                }
                                echo $situ; 
                            ?></td>
                        </tr>
                    </tbody>
                <?php }?>
            <?php }else{?>
                <tbody class="texture">  
                    <tr>
                        <td rowspan="10">
                            <div>
                                <img width="20%" height="20%" style="margin-top:8px;" src="{{asset('img/clock.png')}}"><br>
                                <p><h4><b>Nenhum cadastro disponível para gerenciamento</h4></b></p>
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
                    <li class="page-item"><a class="page-link" href="?pagina=<?php echo $i?>"><?php echo $i; ?></a></li>
                <?php } ?>
                <li>
                    <?php
                    if($pagina_posterior <= $num_pagina){ ?>
                        <a class="page-link" href="?pagina=<?php echo $i?>" aria-label="Next">
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
</div>
<!-- Modal notificação -->
<div class="modal fade id" id="notific" role="dialog">
    <div class="modal-dialog modal-content">
        <div class="modal-header" style="color:white;"> <b>Aviso</b> </div>
        <div class="modal-body">
                <h4><?php if($notific == 1){ echo "Cadastro do Usuario <b>". $usu ."</b> Aceito."; }else{echo "Cadastro do Usuario <b>". $usu ."</b> Recusado";}?></h4><br>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div> 
        </div>
    </div>
</div>
<!-- FIM Modal notificação -->
<?php
if(isset($notific)){?>
    <script>
        $(function(){
            $("#notific").modal('show');
        });
    </script>
<?php }?>
@endsection