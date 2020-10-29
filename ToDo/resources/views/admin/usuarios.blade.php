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

$sql = "SELECT * FROM usuarios WHERE email_verified_at IS NOT NULL AND (usuario LIKE '%$pesquisa2%' OR registro LIKE '%$pesquisa2%')";
$result = mysqli_query($conn, $sql); //pesquisa pra ser usado na conta das rows
$total_pesquisa = mysqli_num_rows($result); //conta o total de rows

$quantidade = 8; //quantidade de rows

$num_pagina = ceil($total_pesquisa/$quantidade);

$inicio = ($quantidade*$pagina)-$quantidade;

$sql = "SELECT * FROM usuarios WHERE email_verified_at IS NOT NULL AND (usuario LIKE '%$pesquisa2%' OR registro LIKE '%$pesquisa2%') ORDER BY nivel DESC LIMIT $inicio, $quantidade ";
$result2 = mysqli_query($conn, $sql); //pesquisa limitada com paginação

$pagina_anterior = $pagina - 1; //paginação
$pagina_posterior = $pagina + 1;

$i = 1; //id base tabelas

if ($total_pesquisa > 0 ){ //se tiver rows
    $check = TRUE;
}
?>

<style type="text/css">
    .espaco{
        display:none;
    }
    .espaco-footer{
        display:none;
    }
</style>

@section('content')
<div class="d-flex" id="wrapper">
    @include('admin/layout/slide')
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <button class="btn btn-primary" id="menu-toggle">
            <svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-justify-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
            </svg>
            </button>
        </nav>
        <div class="titulo-admin">
            <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-people-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
            </svg>&nbsp
            <b>Gerenciar usuários</b>
        </div>
        <div style="margin-top:38px" class="row justify-content-center"> 
            <form class="form-inline d-flex justify-content-center md-form form-sm mt-0" method="POST" action="{{url('pesquisa_user')}}">
                @csrf
                <button type="submit" class="fas fa-search no-border-button" aria-hidden="true"></button>
                <input class="form-control-sm ml-1 pesquisa" type="text" name="pesquisa_user" placeholder="Procurar usuarios..." aria-label="Search">
            </form>
        </div>
        <div style="padding:6px"></div>
        <div class="row justify-content-center"> 
            <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 80%;">
        </div>
        <?php if(NULL !== $pesquisa2){?><div class="result-pesquisa"><a href="{{url('reset_search2')}}"><img width="16px" style="padding-bottom:3px" src="{{asset('img/close.png')}}"></a> Resultados da Pesquisa "<?php echo $pesquisa2 ?>"</div><?php }?>
        <div style="padding:15px"></div>
        <div class="container col-11 limit-table">
            <div class="table-responsive">
                <table class="table" id="table_admin" width="100%" cellspacing="0">
                    <caption class="aredonda"></caption>
                    <?php if(isset($check)){ ?>
                        <thead>
                            <tr class="custom">
                                <th>Nome</th>
                                <th>RGM/CPF</th>
                                <th>Tipo</th>
                                <th>Alterar</th>
                            </tr>
                        </thead>
                        <?php while($rows = mysqli_fetch_assoc($result2)){ $setup = $rows['nivel'];$id_usuario = $rows['id'];$nome = $rows['usuario']; $mail = $rows['email'];?>
                        <!-- Modal alterar -->
                        <div class="modal fade" id="modal<?php echo $id_usuario ?>" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header-custom">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{url('alterar')}}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <p class="text-center"><h5>Alterar o dados de <b><?php echo $nome ?></b></h5></p>
                                            <br>
                                            <input name="nome" type="hidden" value="<?php echo $nome; ?>"/>
                                            <input type='hidden' name="alterar" value="<?php echo $id_usuario ?>"/>
                                            <label for="tipo" class="bold subdados">RGM/CPF: </label>
                                            <input type="text" class="Bselect" name="registro" value="{{ $rows['registro'] }}">
                                            <br><br>
                                            <label for="tipo" class="bold subdados">Tipo: </label>
                                            <select name="tipo" class="Bselect" class="btn btn-primary">
                                                <option value="" disabled selected> Selecionar tipo </option>
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
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header-custom">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h5><p>Deseja realmente deletar <b><?php echo $nome ?></b>?</p><h5><br>
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
                        </div>
                        <!-- FIM Modal deletar usuario -->
                        <tbody class="pisca">
                            <tr class="linha">
                                <td class="ajuste3"><?php echo $rows['usuario']; ?></td>
                                <td class="ajuste1"><?php echo $rows['registro']; ?></td>
                                <td class="ajuste1"><?php   if ($setup == 1) { echo "Usuário";    
                                            }else if ($setup == 2) { echo "Avaliador";
                                            }else if ($setup == 3) { echo "Admin";}
                                    ?>
                                </td>
                                <td class="ajuste1"><a type="button"  data-toggle="modal" data-target="#modal<?php echo $id_usuario ?>">
                                <img width="33px" src="{{asset('img/edit.png')}}">
                                </a></td>
                            </tr>
                        </tbody>
                        <?php $i++; } ?>
                    <?php }else{?>
                        <tbody>  
                            <tr>
                                <td rowspan="10">
                                    <div style="padding-top:20px">
                                        <svg width="60%" height="60%" viewBox="0 0 16 16" class="bi bi-clock-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                        </svg>
                                        <p style="margin-top:35px" ><h4><b>Nenhum usuario Encontrado</h4></b></p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>
        <br>
        <?php if(isset($check)){ ?>
            @include('admin/layout/page')
        <?php }?>
    </div>
</div>
<!-- Modal notificação -->
<div class="modal fade id" id="notific" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="color:white;"> <b>Aviso</b> </div>
            <div class="modal-body">
                    <h5><?php if($notific == 1){ echo "Os dados de <b>". $usu ."</b> foram alterados."; }else{echo "Usuario <b>". $usu ."</b> Deletado";}?></h5><br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div> 
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

<script>
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});
</script>
@endsection