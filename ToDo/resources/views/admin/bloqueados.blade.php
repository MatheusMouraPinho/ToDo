@extends('layouts.app')

<?php  
$db_config = Config::get('database.connections.'.Config::get('database.default'));
$conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
mysqli_set_charset($conn, 'utf8');

$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

$notific = Session::get('notific');
$mail = Session::get('mail');

$sql = "SELECT * FROM bloqueados";
$result = mysqli_query($conn, $sql); //pesquisa pra ser usado na conta das rows
$total_pesquisa = mysqli_num_rows($result); //conta o total de rows

$quantidade = 8; //quantidade de rows

$num_pagina = ceil($total_pesquisa/$quantidade);

$inicio = ($quantidade*$pagina)-$quantidade;

$sql = "SELECT * FROM bloqueados ORDER BY data_bloqueio DESC LIMIT $inicio, $quantidade ";
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
        <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-shield-fill-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M8 .5c-.662 0-1.77.249-2.813.525a61.11 61.11 0 0 0-2.772.815 1.454 1.454 0 0 0-1.003 1.184c-.573 4.197.756 7.307 2.368 9.365a11.192 11.192 0 0 0 2.417 2.3c.371.256.715.451 1.007.586.27.124.558.225.796.225s.527-.101.796-.225c.292-.135.636-.33 1.007-.586a11.191 11.191 0 0 0 2.418-2.3c1.611-2.058 2.94-5.168 2.367-9.365a1.454 1.454 0 0 0-1.003-1.184 61.09 61.09 0 0 0-2.772-.815C9.77.749 8.663.5 8 .5zM6.854 6.146a.5.5 0 1 0-.708.708L7.293 8 6.146 9.146a.5.5 0 1 0 .708.708L8 8.707l1.146 1.147a.5.5 0 0 0 .708-.708L8.707 8l1.147-1.146a.5.5 0 0 0-.708-.708L8 7.293 6.854 6.146z"/>
        </svg>&nbsp
            <b>Emails bloqueados</b>
        </div>
        <div class="espaco2"></div>
        <div class="container col-11 limit-table">
            <div class="table-responsive">
                <table class="table" id="table_admin" width="100%" cellspacing="0">
                    <caption class="aredonda"></caption>
                    <?php if(isset($check)){ ?>
                        <thead>
                            <tr class="custom">
                                <th>Data de Bloqueio</th>
                                <th>Email</th>
                                <th style="min-width:80px">Motivo</th>
                                <th style="min-width:80px">Opções</th>
                            </tr>
                        </thead>
                        <?php while($rows = mysqli_fetch_assoc($result2)){?>
                            <tbody>
                                <tr class="linha">
                                    <td class="ajuste1"><?php echo date('d/m/Y', strtotime($rows['data_bloqueio'])). " às ". date('H:i', strtotime($rows['data_bloqueio'])); ?></td>
                                    <td class="ajuste3"><?php echo $rows['email']; ?></td>
                                    <!-- Modal visualizar -->
                                    <div class="modal fade" id="post<?php echo $rows['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                    <p class="text-center"><h5>Motivo do bloqueio: <b></b></h5></p>
                                                    <br>
                                                    <div class="container">
                                                        <textarea class="form-control textarea-modal" style="background-color:white;box-shadow: 1px 1px 5px #999;" rows="6" readonly><?php echo $rows['motivo_bloqueio'] ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer-custom">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fim Modal visualizar -->
                                    <td><a type="button" data-toggle="modal" data-target="#post<?php echo $rows['id'] ?>">
                                        <img width="30px" src="{{asset('img/lupe.png')}}">
                                    </a></td>
                                    <!-- Modal Opções --> 
                                    <div class="modal fade" id="modal<?php echo $rows['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header-custom">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{url('option4')}}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <p><h4>Remover Banimento:</h4></p>
                                                    <br>
                                                    <h6>
                                                        <label class="radio-custom">Remover e notificar.
                                                            <input type="radio" id="radio1" type="radio" name="option" value="notif" required>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <label class="radio-custom">Remover somente.
                                                            <input type="radio" id="radio2" type="radio" name="option" value="no" required>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </h6>
                                                </div>
                                                <div class="modal-footer-custom">
                                                    <input type='hidden' name="id" value="<?php echo $rows['id']; ?>"/>
                                                    <input type='hidden' name="mail" value="<?php echo $rows['email']; ?>"/>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                                    <button type="submit" class="btn btn-primary">Confirmar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Fim Modal Opções -->
                                    <td><a type="button" data-toggle="modal" data-target="#modal<?php echo $rows['id'] ?>">
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
                                        <p style="margin-top:35px" ><h4><b>Nenhum email bloqueado.</h4></b></p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
            <br>
            <?php if($total_pesquisa > 1){ ?>
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
                    <h5><?php if($notific == 1){ echo "O email <b><span class='encaixar'>". $mail . "</span></b> foi desbloqueado e notificado."; }else{echo "O email <b><span class='encaixar'>". $mail ."</span></b> foi desbloqueado.";}?></h5><br>
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