@extends('layouts.app')

<?php  
$db_config = Config::get('database.connections.'.Config::get('database.default'));
$conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
mysqli_set_charset($conn, 'utf8');

$user = Auth::user()->id;
$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;
$notific = Session::get('notific');
$nom = Session::get('nom');

$notific = Session::get('notific');
$usu = Session::get('usu');

$sql = "SELECT * FROM solicitacoes WHERE status_solicitacao = 3";
$result = mysqli_query($conn, $sql); //pesquisa pra ser usado na conta das rows
$total_pesquisa = mysqli_num_rows($result); //conta o total de rows

$quantidade = 8; //quantidade de rows

$num_pagina = ceil($total_pesquisa/$quantidade);

$inicio = ($quantidade*$pagina)-$quantidade;

$sql = "SELECT * FROM solicitacoes LEFT JOIN usuarios ON (usuario_solicitacao = usuarios.id) LEFT JOIN tipo_solicitacoes ON (tipo_solicitacao = tipo_solicitacoes.id_tipo_solicitacao) WHERE status_solicitacao = 3 ORDER BY data_solicitacao DESC LIMIT $inicio, $quantidade ";
$result2 = mysqli_query($conn, $sql); //pesquisa limitada com paginação

$pagina_anterior = $pagina - 1; //paginação
$pagina_posterior = $pagina + 1;

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
            <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-question-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z"/>
            </svg>&nbsp
            <b>Solicitações de usuários</b>
        </div>
        <div class="espaco2"></div>
        <div class="container col-11 limit-table">
            <div class="table-responsive">
                <table class="table" id="table_admin" width="100%" cellspacing="0">
                    <caption class="aredonda"></caption>
                    <?php if(isset($check)){ ?>
                        <thead>
                            <tr class="custom">
                                <th>Data da solicitação</th>
                                <th>Nome do usuario</th>
                                <th>RGM/CPF</th>
                                <th>Tipo</th>
                                <th>Detalhes</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <?php while($rows = mysqli_fetch_assoc($result2)){?>
                            <tbody>
                                <tr class="linha">
                                    <td class="ajuste1"><?php echo date('d/m/Y', strtotime($rows['data_solicitacao'])). " às ". date('H:i', strtotime($rows['data_solicitacao'])); ?></td>
                                    <td class="ajuste3"><?php echo $rows['usuario']; ?></td>
                                    <td class="ajuste1"><?php echo $rows['registro']; ?></td>
                                    <td class="ajuste1"><?php echo $rows['nome_tipo_solicitacao']; ?></td>
                                    <!-- Modal visualizar -->
                                    <div class="modal fade" id="post<?php echo $rows['id_solicitacao'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                    <p class="text-center"><h5>Detalhes da solicitação <b></b></h5></p>
                                                    <br>
                                                    <textarea style="resize: none" cols="60" rows="6" readonly><?php echo $rows['conteudo_solicitacao'] ?></textarea>
                                                </div>
                                                <div class="modal-footer-custom">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fim Modal visualizar -->
                                    <td><a type="button" data-toggle="modal" data-target="#post<?php echo $rows['id_solicitacao'] ?>">
                                        <img width="30px" src="{{asset('img/lupe.png')}}">
                                    </a></td>
                                    <!-- Modal Opções --> 
                                    <div class="modal fade" id="modal<?php echo $rows['id_solicitacao'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header-custom">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{url('option3')}}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <p><h4>Opções de Notificação:</h4></p>
                                                    <br>
                                                    <h6>
                                                        <label class="radio-custom">Aceitar solicitação.
                                                            <input type="radio" id="radio1" type="radio" name="option" value="aceita" required>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <label class="radio-custom">Recusar solicitação.
                                                            <input type="radio" id="radio2" type="radio" name="option" value="recusada" required>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </h6>
                                                </div>
                                                <div class="modal-footer-custom">
                                                    <input type='hidden' name="id_soli" value="<?php echo $rows['id_solicitacao']; ?>"/>
                                                    <input type='hidden' name="usu" value="<?php echo $rows['usuario']; ?>"/>
                                                    <input type='hidden' name="mail" value="<?php echo $rows['email']; ?>"/>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                                    <button type="submit" class="btn btn-primary">Confirmar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Fim Modal Opções -->
                                    <td><a type="button" data-toggle="modal" data-target="#modal<?php echo $rows['id_solicitacao'] ?>">
                                            <img width="33px" src="{{asset('img/options.png')}}">
                                    </a></td>
                                </tr>
                            </tbody>
                        <?php }?>
                    <?php }else{?>
                        <tbody>  
                            <tr>
                                <td rowspan="10">
                                    <div style="padding-top:20px">
                                        <svg width="60%" height="60%" viewBox="0 0 16 16" class="bi bi-clock-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                        </svg>
                                        <p style="margin-top:35px" ><h4><b>Nenhuma solicitação no momento.</h4></b></p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
            <br>
            <?php if($total_pesquisa > 8){ ?>
                @include('admin/layout/page')
            <?php }else{ ?> <div class="espaco2"></div> <?php } ?>
        </div>
    </div>
</div>

<!-- Modal notificação -->
<div class="modal fade id" id="notific" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="color:white;"> <b>Aviso</b> </div>
            <div class="modal-body">
                    <h5><?php if($notific == 1){ echo "Solicitação de <b>". $nom . "</b> foi aceita e notificada ao usuário."; }else{echo "Solicitação de <b>". $nom ."</b> foi recusada e notificada ao usuário.";}?></h5><br>
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