@extends('layouts.app')

<?php  
$conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
$user = Auth::user()->id;
$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

$sql = "SELECT * FROM denuncias";
$resultado = mysqli_query($conn, $sql);//pesquisa pra ser usado na conta das rows
$total_pesquisa = mysqli_num_rows($resultado); //conta o total de rows

$quantidade = 8; //quantidade de rows

$num_pagina = ceil($total_pesquisa/$quantidade);

$inicio = ($quantidade*$pagina)-$quantidade;

$sql = "SELECT * FROM denuncias LEFT JOIN postagens ON (denuncias.id_postagem = postagens.id_postagem) ORDER BY quantidade DESC LIMIT $inicio, $quantidade";
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
        <a class="nav-item nav-link"  href="{{ url('/adm') }}">Cadastros</a>
        <a class="nav-item nav-link"  href="{{ url('/adm2') }}">Usuarios</a>
        <a class="nav-item nav-link active"  href="{{ url('/adm3') }}">Postagens</a>
        <a class="nav-item nav-link"  href="{{ url('/adm4') }}">Comentarios</a>
    </div>
    </nav>
    <br>
    <div class="row">
        <div class="text-centro contorno-titulo"><h3>Denuncias de Postagens</h3></div>
        <table class="col-12" id="table_conta">
            <caption><br></caption>
            <?php if(isset($check)){ ?>
                <thead>
                    <tr class="tr-custom">
                        <th scope="col">Nome da ideia</th>
                        <th scope="col">Motivo</th>
                        <th scope="col">quantidade</th>
                        <th scope="col">Visualizar ideia</th>
                        <th scope="col">Opções</th>
                    </tr>
                </thead>
                <?php while($rows = mysqli_fetch_assoc($result)){ $id_denuncia = $rows['id_denuncia'];
                    $nome_post = $rows['titulo_postagem']; $id_post = $rows['id_postagem'];

                ?>
                    <tbody class="texture pisca">
                        <tr>
                            <td><?php echo mb_strimwidth($rows['titulo_postagem'], 0, 35, "..."); ?></td>
                            <td>
                                <?php 
                                if ($rows['id_motivo'] == 1 ) { echo "Spam";    
                                }elseif($rows['id_motivo'] == 2 ){ echo "Copia";
                                }else{ echo "Conteudo Inadequado";}
                                ?>
                            </td>
                            <td>
                                <?php 
                                  echo $rows['quantidade'];
                                ?>
                            </td>
                            <!-- Modal --> 
                            <div class="modal fade" id="modal<?php echo $id_post ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ url('/option') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <p><h4>Opções:</h4></p>
                                            <br>
                                            <h6>
                                                <label class="radio-custom">Remover denuncias
                                                    <input type="radio" id="radio1" type="radio" name="option" value="rem_den" required>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="radio-custom">Deletar o Postagem
                                                    <input type="radio" id="radio2" type="radio" name="option" value="del_post" required>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </h6>
                                        </div>
                                        <div class="modal-footer-custom grey">
                                            <input type='hidden' name="id_postagem" value="<?php echo $id_post ?>"/>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                            <button type="submit" class="btn btn-primary">Confirmar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Fim Modal -->
                            <td><a type="button" data-toggle="modal" data-target="#post<?php echo $id_post ?>">
                                <img width="40px" src="{{asset('img/lupe.png')}}">
                            </a></td>
                            @include('layouts.post')
                            <td><a type="button" data-toggle="modal" data-target="#modal<?php echo $id_post ?>">
                                    <img width="40px" src="{{asset('img/options.png')}}">
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
                                <p><h4><b>Nenhuma denuncia disponivel para apuração</h4></b></p>
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
@endsection