@extends('layouts.app')

<?php  
$conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");


$sql = "SELECT * FROM denuncias WHERE spam > '0' or copia > '0' ";
$result = mysqli_query($conn, $sql);

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
                <th scope="col">Motivo</th>
                <th scope="col">Visualizar ideia</th>
                <th scope="col">Remover Denuncia</th>
                <th scope="col">Barrar Post</th>
                <th scope="col">Deletar Post</th>
            </tr>
        </thead>

        <?php while($rows = mysqli_fetch_assoc($result)){ 
          $motivo1 = $rows['spam'];
          $motivo2 = $rows['copia'];
          ?>
        <tbody>
            <tr>
                <td><?php echo $rows['id']; ?></td>
                <td>
                  <?php 
                    if ($motivo1 > $motivo2) { echo "Spam";    
                    }else echo "Copia";
                  ?>
                </td>
                <td><button type="button">
                    To Do
                </button></td>
                <form action="{{ url('/rem_den') }}" method="POST">
                    @csrf
                    <td><button name="id" value="<?php echo $rows['id']; ?>">Icon</button></td>
                </form>
                <form action="{{ url('/barrar') }}" method="POST">
                    @csrf
                    <td><button name="id" value="<?php echo $rows['id_postagem']; ?>">To Do</button></td>
                </form>
                <form action="{{ url('/del_post') }}" method="POST">
                    @csrf
                    <td><button name="id_postagem" value="<?php echo $rows['id_postagem']; ?>">icon</button>
                      <input type='hidden' name="id_denuncia" value="<?php echo $rows['id']; ?>"/>
                    </td>
                </form>
            </tr>
        </tbody>
        <?php } ?>
    </table>    
</div>

@endsection
