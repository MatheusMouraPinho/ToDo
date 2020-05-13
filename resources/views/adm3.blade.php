@extends('layouts.app')

<?php  
$conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");

$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

$sql = "SELECT * FROM denuncias WHERE spam > '0' or copia > '0' ";
$resultado = mysqli_query($conn, $sql);//pesquisa pra ser usado na conta das rows
$total_pesquisa = mysqli_num_rows($resultado); //conta o total de rows

$quantidade = 5; //quantidade de rows

$num_pagina = ceil($total_pesquisa/$quantidade);

$inicio = ($quantidade*$pagina)-$quantidade;

$sql = "SELECT * FROM denuncias WHERE spam > '0' or copia > '0' LIMIT $inicio, $quantidade";
$result = mysqli_query($conn, $sql);//pesquisa limitada com paginação


$sql2 = "SELECT * FROM postagens LEFT JOIN denuncias ON (postagens.id_postagem = denuncias.id_postagem) WHERE denuncias.spam > '0' or denuncias.copia > '0' ";
$result2 = mysqli_query($conn, $sql2);//pega os dados das postagens

if ($total_pesquisa > 0){ $modal = "adm3";} //se aver rows de denuncias o modal é ativado

$pagina_anterior = $pagina - 1; //paginação
$pagina_posterior = $pagina + 1;
?>


@section('content')
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link"  href="{{ url('/adm') }}">Cadastros</a>
    <a class="nav-item nav-link"  href="{{ url('/adm2') }}">Nivel de acesso</a>
    <a class="nav-item nav-link active"  href="{{ url('/adm3') }}">Denuncias</a>
  </div>
</nav>
<br>

<div class="row">
    <table class="col-12" id="table_conta">
        <caption>Denuncias</caption>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome da ideia</th>
                <th scope="col">Motivo</th>
                <th scope="col">Visualizar ideia</th>
                <th scope="col">Opções</th>
            </tr>
        </thead>

        <?php while($rows = mysqli_fetch_assoc($result)){ 
          $motivo1 = $rows['spam'];
          $motivo2 = $rows['copia'];
          $id_denuncia = $rows['id'];
          ?>
        <tbody>
            <tr>
              <td><?php echo $rows['id']; ?></td>
              <?php if($rows = mysqli_fetch_assoc($result2)){
               $nome_post = $rows['titulo_postagem'];
               $id_post = $rows['id_postagem'];
              ?>
              <!--modal -->
                <div class="modal fade" id="modal<?php echo $id_post ?>" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                      <h5 class="modal-title"><?php echo $nome_post ?><?php echo $id_denuncia ?><?php echo $id_post ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <br>
                      <form action="{{ url('/option') }}" method="POST">
                        @csrf
                        <div class="container">
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="Radio" name="option" value="barrar" required>
                            <label class="form-check-label">Barrar Post</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="Radio" name="option" value="rem_den" required>
                            <label class="form-check-label">Remover Denuncias</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="Radio" name="option" value="del_post" required>
                            <label class="form-check-label">Deletar Post</label>
                          </div>
                        </div>
                        <br>
                        <div class="modal-footer">
                            <input type='hidden' name="id_denuncia" value="<?php echo $id_denuncia ?>"/>
                            <input type='hidden' name="id_postagem" value="<?php echo $id_post ?>"/>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Confirmar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              <!--modal -->
              <td><?php echo $rows['titulo_postagem']; ?></td>
              <?php } ?>
              <td>
                <?php 
                  if ($motivo1 > $motivo2) { echo "Spam";    
                  }else echo "Copia";
                ?>
              </td>
              <td><button class="no-border-button" type="button"><img width="40px" src="{{asset('img/lupe.png')}}"></button>
              </td>
              <td><a type="button"  data-toggle="modal" data-target="#modal<?php echo $id_post ?>">
                    <img width="40px" src="{{asset('img/options.png')}}">
              </a></td>
            </tr>
        </tbody>
        <?php } ?>
    </table>    
</div>

<br>
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
@endsection