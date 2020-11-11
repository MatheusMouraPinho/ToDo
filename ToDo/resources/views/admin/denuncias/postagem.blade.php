@extends('layouts.app')

<?php  
$db_config = Config::get('database.connections.'.Config::get('database.default'));
$conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
mysqli_set_charset($conn, 'utf8');

$user = Auth::user()->id;
$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;
$notific = Session::get('notific');
$nom = Session::get('nom');

$sql = "SELECT * FROM denuncias";
$resultado = mysqli_query($conn, $sql);//pesquisa pra ser usado na conta das rows
$total_pesquisa = mysqli_num_rows($resultado); //conta o total de rows

$quantidade = 8; //quantidade de rows

$num_pagina = ceil($total_pesquisa/$quantidade);

$inicio = ($quantidade*$pagina)-$quantidade;

$sql = "SELECT * FROM denuncias LEFT JOIN postagens ON (denuncias.id_postagem = postagens.id_postagem) LEFT JOIN motivo_denuncia ON (id_motivo = motivo_denuncia.id_motivo_denuncia) ORDER BY quantidade DESC LIMIT $inicio, $quantidade";
$result = mysqli_query($conn, $sql);//pesquisa limitada com paginação

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
<div class="d-flex admin" id="wrapper">
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
            <svg width="1.1em" height="1.1em" viewBox="0 0 16 16" class="bi bi-exclamation-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
            </svg>&nbsp
            <b>Denúncias de postagens</b>
        </div>
        <div class="espaco2"></div>
        <div class="container col-11 limit-table">
            <div class="table-responsive">
                <table class="table" id="table_admin" width="100%" cellspacing="0">
                    <caption class="aredonda"></caption>
                    <?php if(isset($check)){ ?>
                        <thead>
                            <tr class="custom">
                                <th>Nome da ideia</th>
                                <th>Motivo</th>
                                <th style="min-width:120px">Quantidade</th>
                                <th style="min-width:100px">Visualizar ideia</th>
                                <th style="min-width:80px">Opções</th>
                            </tr>
                        </thead>
                        <?php while($rows = mysqli_fetch_assoc($result)){ $id_denuncia = $rows['id_denuncia'];
                            $nome_post = $rows['titulo_postagem']; $id_post = $rows['id_postagem'];

                        ?>
                            <tbody class="texture pisca">
                                <tr class="linha">
                                    <td class="ajuste3"><?php echo $rows['titulo_postagem']; ?></td>
                                    <td class="ajuste1"><?php echo $rows['nome_motivo']; ?></td>
                                    <td class="ajuste1">
                                        <?php 
                                        echo $rows['quantidade'];
                                        ?>
                                    </td>
                                    <!-- Modal --> 
                                    <div class="modal fade" id="modal<?php echo $id_post ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header-custom">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ url('option') }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <p><b><h4>Opções:</b></h4></p>
                                                    <br>
                                                    <h6>
                                                        <label class="radio-custom">Remover denúncias.
                                                            <input type="radio" id="radio1" type="radio" name="option" value="rem_den" required>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <label class="radio-custom">Deletar a Postagem.
                                                            <input type="radio" id="radio2" type="radio" name="option" value="del_post" required>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </h6>
                                                </div>
                                                <div class="modal-footer-custom">
                                                    <input type='hidden' name="id_postagem" value="<?php echo $id_post ?>"/>
                                                    <input type='hidden' name="id_denuncia" value="<?php echo $rows['id_denuncia']; ?>"/>
                                                    <input type='hidden' name="nome_post" value="<?php echo $nome_post ?>"/>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                                    <button type="submit" class="btn btn-primary">Confirmar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Fim Modal -->
                                    <td><a type="button" data-toggle="modal" onclick="modal(<?php echo $id_post ;?>)" data-target="#post<?php echo $id_post ?>">
                                        <img width="30px" src="{{asset('img/lupe.png')}}">
                                    </a></td>
                                    @include('layouts.post')
                                    <td><a type="button" data-toggle="modal" data-target="#modal<?php echo $id_post ?>">
                                            <img width="33px" src="{{asset('img/options.png')}}">
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
                                        <p style="margin-top:35px" ><h4><b>Nenhuma denúncia disponível para apuração.</h4></b></p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>  
        <br>
        <?php if($total_pesquisa > 1){ ?>
            @include('admin/layout/page')
        <?php }else{ ?> <div class="espaco2"></div> <?php } ?>
    </div>
</div>
<!-- Modal notificação -->
<div class="modal fade id" id="notific" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="color:white;"> <b>Aviso</b> </div>
            <div class="modal-body">
                    <h5><?php if($notific == 1){ echo "Todas a denúncias foram removidas da postagem <b>". $nom .".</b>"; }else{echo "Postagem <b>". $nom ."</b> foi deletada.";}?></h5><br>
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