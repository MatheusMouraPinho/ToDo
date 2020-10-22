@extends('layouts.app')

<?php  
$db_config = Config::get('database.connections.'.Config::get('database.default'));
$conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
mysqli_set_charset($conn, 'utf8');

$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;
$notific = Session::get('notific');
$nom = Session::get('nom');

$sql = "SELECT * FROM denuncias_comentarios";
$resultado = mysqli_query($conn, $sql);//pesquisa pra ser usado na conta das rows
$total_pesquisa = mysqli_num_rows($resultado); //conta o total de rows

$quantidade = 8; //quantidade de rows

$num_pagina = ceil($total_pesquisa/$quantidade);

$inicio = ($quantidade*$pagina)-$quantidade;

$sql = "SELECT * FROM denuncias_comentarios LEFT JOIN comentarios ON (id_comentario = comentarios.id_comentarios) LEFT JOIN usuarios ON (id_usuarios = usuarios.id) ORDER BY quantidade DESC LIMIT $inicio, $quantidade";
$result = mysqli_query($conn, $sql);//pesquisa limitada com paginação

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
        <a class="nav-item nav-link fix"  href="{{ url('adm2') }}">Usuários</a>
        <a class="nav-item nav-link fix"  href="{{ url('adm3') }}">Postagens</a>
        <a class="nav-item nav-link ativo"  href="{{ url('adm4') }}">Comentários</a>
    </div>
    </nav>
    <br>
    <div class="card-body">
        <div class="row justify-content-center"><h3> Denuncias comentarios </h3></div>
        <div class="table-responsive">
            <table class="table" id="table_admin" width="100%" cellspacing="0">
                <caption class="aredonda"></caption>
                <?php if(isset($check)){ ?>
                    <thead>
                        <tr class="tr-custom">
                            <th scope="col">Autor do comentário</th>
                            <th scope="col">Motivo</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Visualizar comentário</th>
                            <th scope="col">Opções</th>
                        </tr>
                    </thead>
                    <?php while($rows = mysqli_fetch_assoc($result)){ $nome_autor = $rows['usuario'];?>
                        <tbody class="texture pisca">
                            <tr class="linha">
                                <td><?php echo mb_strimwidth($rows['usuario'], 0, 30, "..."); ?></td>
                                <td>
                                    <?php 
                                    if ($rows['id_motivo'] == 1 ) { echo "Spam";    
                                    }elseif($rows['id_motivo'] == 2 ){ echo "Cópia";
                                    }else{ echo "Conteúdo Inadequado";}
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                    echo $rows['quantidade'];
                                    ?>
                                </td>
                                <!-- Modal visualizar -->
                                <div class="modal fade" id="post<?php echo $rows['id_comentarios'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                <p class="text-center"><h5>Conteúdo do Comentário de <b><?php echo $rows['usuario'] ?></b></h5></p>
                                                <br>
                                                <textarea style="resize: none" cols="60" rows="6" readonly><?php echo $rows['conteudo_comentarios'] ?></textarea>
                                            </div>
                                            <div class="modal-footer-custom grey">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fim Modal visualizar -->
                                <td><a type="button" data-toggle="modal" data-target="#post<?php echo $rows['id_comentarios'] ?>">
                                    <img width="33px" src="{{asset('img/lupe.png')}}">
                                </a></td>
                                <!-- Modal Opções --> 
                                <div class="modal fade" id="modal<?php echo $rows['id_comentarios'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{url('option2')}}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <p><h4>Opções:</h4></p>
                                                <br>
                                                <h6>
                                                    <label class="radio-custom">Remover denúncias
                                                        <input type="radio" id="radio1" type="radio" name="option" value="rem_den" required>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="radio-custom">Deletar Comentário
                                                        <input type="radio" id="radio2" type="radio" name="option" value="del_comen" required>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </h6>
                                            </div>
                                            <div class="modal-footer-custom grey">
                                                <input type='hidden' name="id_comentario" value="<?php echo $rows['id_comentario']; ?>"/>
                                                <input type='hidden' name="id_denuncia" value="<?php echo $rows['id_denunciacomentario']; ?>"/>
                                                <input type='hidden' name="autor_coment" value="<?php echo $nome_autor; ?>"/>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                                <button type="submit" class="btn btn-primary">Confirmar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- Fim Modal Opções -->
                                <td><a type="button" data-toggle="modal" data-target="#modal<?php echo $rows['id_comentarios'] ?>">
                                        <img width="33px" src="{{asset('img/options.png')}}">
                                </a></td>
                            </tr>
                        </tbody>
                    <?php $i++; }?>
                <?php }else{?>
                    <tbody class="texture">  
                        <tr>
                            <td rowspan="10">
                                <div>
                                <img width="20%" height="20%" style="margin-top:8px;" src="{{asset('img/clock.png')}}"><br>
                                    <p><h4><b>Nenhuma denúncia disponível para apuração</h4></b></p>
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
                <h4><?php if($notific == 1){ echo "Todas a denúncias foram removidas do comentario de <b>". $nom .".</b>"; }else{echo "O Comentario de <b>". $nom ."</b> foi deletado.";}?></h4><br>
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