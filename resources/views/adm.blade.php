@extends('layouts.app')

<?php  

$conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");

$sql = "SELECT * FROM usuarios WHERE id_situacao = '2' AND email_verified_at IS NOT NULL  ";
$result = mysqli_query($conn, $sql);

$sql = "SELECT * FROM usuarios WHERE id_situacao = '1' AND email_verified_at IS NOT NULL  ";
$result2 = mysqli_query($conn, $sql);

?>

@section('content')

<div class="row justify-content-between">
<div class="col-8">
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Data</th>
                <th scope="col">Nome</th>
                <th scope="col">RGM/CPF</th>
                <th scope="col">Tipo</th>
                <th scope="col">Altorizar</th>
                <th scope="col">Deletar</th>
                </tr>
            </thead>

            <?php while($rows = mysqli_fetch_assoc($result)){ 
                $setup = $rows['nivel']; ?>
            <tbody>
                <tr>
                <td><?php echo $rows['id']; ?></td>
                <td><?php echo $rows['email_verified_at']; ?></td>
                <td><?php echo $rows['usuario']; ?></td>
                <td><?php echo $rows['registro']; ?></td>
                <td><?php   if ($setup == 1) { echo "Usuario";    
                            }else if ($setup == 2) { echo "Avaliador";
                            }else if ($setup == 3) { echo "Admin";}
                    ?>
                </td>
                <form action="{{ url('/alt') }}" method="POST">
                    @csrf
                    <td><button name="alt" value="<?php echo $rows['id']; ?>">Icon</button></td>
                </form>
                <form action="{{ url('/del') }}" method="POST">
                    @csrf
                    <td><button name="del" value="<?php echo $rows['id']; ?>">Icon</button></td>
                </form>
                </tr>
                <tr>
                <?php } ?>
            </tbody>
        </table>    
</div>

<div class="col-3">
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">RGM/CPF</th>
                <th scope="col">Tipo</th>
                <th scope="col">Alterar</th>
                </tr>
            </thead>

            <?php while($rows = mysqli_fetch_assoc($result2)){ 
                $setup = $rows['nivel'];
                $id = $rows['id']; ?>
            <tbody>
                <tr>
                <td><?php echo $rows['id']; ?></td>
                <td><?php echo $rows['usuario']; ?></td>
                <td><?php echo $rows['registro']; ?></td>
                <td><?php   if ($setup == 1) { echo "Usuario";    
                            }else if ($setup == 2) { echo "Avaliador";
                            }else if ($setup == 3) { echo "Admin";}
                    ?>
                </td>
                <td><button type="button"  data-toggle="modal" data-target="#ModalCentralizado">
                icon
                </button></td>
                </tr>
                <tr>
            </tbody>
            <?php } ?>
        </table>    
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="ModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TituloModalCentralizado">Título do modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ url('/alterar') }}" method="POST">
        @csrf
        <div class="modal-body">
            <input type='hidden' name="alterar" value="<?php echo $id ?>"/>

            <label for="tipo" class="bold subdados">Tipo</label>
            <select name="tipo" class="select" class="btn btn-primary">
                <option>Usuario</option><option>Avaliador</option><option>Admin</option>
            </select>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Salvar mudanças</button>
        </div>
      </form>
    </div>
  </div>
</div>


@endsection
