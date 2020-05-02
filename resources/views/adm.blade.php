@extends('layouts.app')

<?php  

$conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");

$sql = "SELECT * FROM usuarios WHERE id_situacao = '2' AND email_verified_at IS NOT NULL  ";
$result = mysqli_query($conn, $sql);

?>

@section('content')
<div class="row-md-6" aling="left">
    <div class="card">
        <div class="card-header">Header</div>
            <div class="card-body">
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
                    </tbody>
                    <?php } ?>
                </table>    
            </div>
        </div>
    </div>
</div>
@endsection
