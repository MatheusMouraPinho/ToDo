@extends('layouts.app')
<?php
$db_config = Config::get('database.connections.'.Config::get('database.default'));
$conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
mysqli_set_charset($conn, 'utf8');

$user = Auth::user()->id;
$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

$sql = "SELECT * FROM notificacoes ORDER BY data_notificacao DESC";
$result = mysqli_query($conn, $sql); //pesquisa pra ser usado na conta das rows
$total_pesquisa = mysqli_num_rows($result); //conta o total de rows

$quantidade = 8; //quantidade de rows

$num_pagina = ceil($total_pesquisa/$quantidade);

$inicio = ($quantidade*$pagina)-$quantidade;

$sql = "SELECT * FROM notificacoes ORDER BY data_notificacao DESC LIMIT $inicio, $quantidade ";
$result2 = mysqli_query($conn, $sql); //pesquisa limitada com paginação

$pagina_anterior = $pagina - 1; //paginação
$pagina_posterior = $pagina + 1;
?>
@section('content')

<!-- Container (About Section) -->
<div class="container justify-center">
    <h2 class="text-center" style="margin-top:30px;"><b style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">Notificações</b></h2><br>
    <hr class="rgba-white-light" style="margin-bottom:50px;margin-top:20px;">
</div>
    <?php while($rows = mysqli_fetch_assoc($result2)){?>
        <div class="card-notificacao">
            <div class="titulo_notificacao">
                <b><?php echo $rows['titulo_notificacao']; ?></b>
            </div>
            <div class="conteudo_notificacao">
                <?php echo $rows['conteudo_notificacao']; ?>
            </div>
            <div class="data_notificacao text-center">
                <?php if(Helper::tempo_corrido($rows['data_notificacao']) == "Agora mesmo"){ 
                    echo "1min";
                }else{ 
                    echo Helper::tempo_corrido($rows['data_notificacao']);
                } ?>
            </div>
            <div class="option_notificacao dropdown">
                <a id="navbarDropdown" role="button" style="cursor: pointer" data-toggle="dropdown">
                    <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-three-dots" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                    </svg>
                </a>
                <div class="dropdown-menu ajuste-drop4">
                    <a class="dropdown-item" style="cursor: pointer"  data-toggle="modal" data-target="#del-notifi<?php echo $rows['id_notificacao'];?>">
                        <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>&nbsp;
                        Apagar
                    </a>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if ($total_pesquisa >= 10){?>
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
<div class="container justify-center">
    <hr class="rgba-white-light" style="margin-bottom:20px;margin-top:50px;">
</div>

@endsection