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

<style type="text/css">
    .espaco{
        display:none;
    }
    .espaco-footer{
        display:none;
    }
</style>

@section('content')
<div class="d-flex admin" id="wrapper">
    @include('admin/layout/slide')
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <button class="btn btn-primary" id="menu-toggle">
            <svg width="1.4em" height="1.4em" viewBox="0 0 16 16" class="bi bi-justify-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
            </svg>
            </button>
        </nav>
        <div class="titulo-admin">
            <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-exclamation-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
            </svg>&nbsp
            <b>Tipos de Denuncias</b>
        </div>
        <div class="espaco2"></div>
        <div class="row justify-content-center">
            <a href="{{ url('admin/denuncias/postagem') }}" class="col-1 option">
                <br><svg width="3.5em" height="3.5em" viewBox="0 0 16 16" class="bi bi-file-text-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"/>
                </svg><br><br>
                <b>Postagens</b>
            </a>
            <a href="{{ url('admin/denuncias/comentario') }}" class="offset-1 col-1 option">
                <br><svg width="3.5em" height="3.5em" viewBox="0 0 16 16" class="bi bi-chat-dots-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                </svg><br><br>
                <b>Comentarios</b>
            </a>
        </div>
    </div>
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

<script>
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});
</script>
@endsection