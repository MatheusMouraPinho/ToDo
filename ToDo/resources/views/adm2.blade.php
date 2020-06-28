@extends('layouts.app')

<?php  session_start();
$db_config = Config::get('database.connections.'.Config::get('database.default'));
$conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
mysqli_set_charset($conn, 'utf8');

$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

$notific = Session::get('notific');
$usu = Session::get('usu');

if(NULL !== Session::get('pesquisa2')){   $_SESSION['pesquisa2'] = Session::get('pesquisa2');}
if(isset($_SESSION['pesquisa2'])){$pesquisa2 = $_SESSION['pesquisa2'];}
if(!isset($pesquisa2)){ $pesquisa2 = NULL;}

$sql = "SELECT * FROM usuarios WHERE id_situacao = '1' AND (usuario LIKE '%$pesquisa2%' OR registro LIKE '%$pesquisa2%')";
$result = mysqli_query($conn, $sql); //pesquisa pra ser usado na conta das rows
$total_pesquisa = mysqli_num_rows($result); //conta o total de rows

$quantidade = 8; //quantidade de rows

$num_pagina = ceil($total_pesquisa/$quantidade);

$inicio = ($quantidade*$pagina)-$quantidade;

$sql = "SELECT * FROM usuarios WHERE id_situacao = '1' AND (usuario LIKE '%$pesquisa2%' OR registro LIKE '%$pesquisa2%') ORDER BY nivel DESC LIMIT $inicio, $quantidade ";
$result2 = mysqli_query($conn, $sql); //pesquisa limitada com paginação

$pagina_anterior = $pagina - 1; //paginação
$pagina_posterior = $pagina + 1;

$i = 1; //id base tabelas

if ($total_pesquisa > 0 ){ //se tiver rows
    $check = TRUE;
}
?>


@section('content')
<div class="container my-4">
    <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link fix"  href="{{ url('adm') }}">Cadastros</a>
        <a class="nav-item nav-link ativo"  href="{{ url('adm2') }}">Usuários</a>
        <a class="nav-item nav-link fix"  href="{{ url('adm3') }}">Postagens</a>
        <a class="nav-item nav-link fix"  href="{{ url('adm4') }}">Comentários</a>
    </div>
    </nav>
    <br>
    <div class="row">
    <div class="text-centro contorno-titulo"><h3>Nível de acesso Usuários</h3></div>
    </div>
    <div class="row justify-content-md-center">
        <form class="form-inline my-2 my-lg-0" method="POST" action="{{url('pesquisa_user')}}">
            @csrf
            <label><b style="margin-right:10px;">Procurar Usuários:</b></label>
            <input class="form-control mr-sm-2" type="text" name="pesquisa_user" placeholder="Procure o usuário pelo Nome ou RGM/CPF" aria-label="Search" style="width: 400px">
            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Procurar</button>
        </form>
    </div>
    <br>
    <hr class="justify-content-md-center accent-2 mb-3 mt-0" style="width: 800px;">
    <?php if(NULL !== $pesquisa2){?><div class="contorno-pequeno"><a href="{{url('reset_search2')}}"><img width="20px" src="{{asset('img/close.png')}}"></a> Resultados da Pesquisa "<?php echo $pesquisa2 ?>"</div><?php }?>
    <br>
    <div class="row">
        <table class="col-12" id="table_conta">
            <caption><br></caption>
            <?php if(isset($check)){ ?>
                <thead>
                    <tr class="tr-custom">
                        <th scope="col">Nome</th>
                        <th scope="col">RGM/CPF</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Alterar</th>
                    </tr>
                </thead>
                <?php while($rows = mysqli_fetch_assoc($result2)){ $setup = $rows['nivel'];$id_usuario = $rows['id'];$nome = $rows['usuario']; $mail = $rows['email'];?>
                <!-- Modal alterar -->
                <div class="modal fade" id="modal<?php echo $id_usuario ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{url('alterar')}}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <p class="text-center"><h5>Alterar o acesso de <b><?php echo $nome ?></b></h5></p>
                                    <br>
                                    <input name="nome" type="hidden" value="<?php echo $nome; ?>"/>
                                    <input type='hidden' name="alterar" value="<?php echo $id_usuario ?>"/>
                                    <label for="tipo" class="bold subdados">Tipo</label>
                                    <select name="tipo" class="select" class="btn btn-primary">
                                        <option>Usuario</option><option>Avaliador</option><option>Admin</option>
                                    </select>
                                    <br><br>
                                    <a data-dismiss="modal" data-toggle="modal" data-target="#del_usu<?php echo $id_usuario;?>" style="text-decoration:underline;color:red;cursor:pointer;">Deletar usuário</a>
                                </div>
                                <div class="modal-footer-custom grey">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Salvar mudanças</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Fim Modal alterar -->
                <!-- Modal deletar usuario -->
                <div class="modal fade id" id="del_usu<?php echo $id_usuario; ?>" role="dialog">
                    <div class="modal-dialog modal-content">
                        <div class="modal-header"></div>
                        <div class="modal-body">
                            <h4><p>Deseja realmente deletar <b><?php echo $nome ?></b>?</p><h4><br>
                            <form action="{{url('del_usu')}}" method="POST">
                                @csrf
                                <div class="modal-footer">
                                    <input name="nome" type="hidden" value="<?php echo $nome; ?>"/>
                                    <input name="email" type="hidden" value="<?php echo $mail; ?>"/>
                                    <input name="del_usu" type="hidden" value="<?php echo $id_usuario; ?>"/>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Confirmar</button>
                                </div> 
                            </form>
                        </div>
                    </div>
                </div>
                <!-- FIM Modal deletar usuario -->
                <tbody class="texture pisca">
                    <tr>
                        <td><?php echo mb_strimwidth($rows['usuario'], 0, 30, "..."); ?></td>
                        <td><?php echo $rows['registro']; ?></td>
                        <td><?php   if ($setup == 1) { echo "Usuário";    
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
                <tbody class="texture">  
                    <tr>
                        <td rowspan="10">
                            <div>
                                <img width="20%" height="20%" style="margin-top:8px;" src="{{asset('img/clock.png')}}"><br>
                                <p><h4><b>Nenhum usuário disponível para alteração de nível</h4></b></p>
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
</div>
<!-- Modal notificação -->
<div class="modal fade id" id="notific" role="dialog">
    <div class="modal-dialog modal-content">
        <div class="modal-header" style="color:white;"> <b>Aviso</b> </div>
        <div class="modal-body">
                <h4><?php if($notific == 1){ echo "Acesso de <b>". $usu ."</b> Alterado."; }else{echo "Usuario <b>". $usu ."</b> Deletado";}?></h4><br>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div> 
        </div>
    </div>
</div>
<!-- FIM Modal notificação -->
<?php
if(isset($notific)){ ?>
    <script>
        $(function(){
            $("#notific").modal('show');
        });
    </script>
<?php } ?>
@endsection