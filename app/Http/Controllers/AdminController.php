<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function admin()
    {
        return view('adm');
    }

    public function admin2()
    {
        return view('adm2');
    }

    public function admin3()
    {
        return view('adm3');
    }

    public function ava()
    {
        return view('ava');
    }

    

    public function alt()
    {  
        $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
        $id_sql = $_POST ['alt'];
        $sql = "UPDATE usuarios SET id_situacao = 1 WHERE id ='$id_sql'";
        mysqli_query($conn, $sql);

        return redirect('adm');
    }

    public function del()
    {  
        $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
        $id_sql = $_POST ['del'];
        $sql = "DELETE FROM usuarios WHERE id ='$id_sql'";
        mysqli_query($conn, $sql);

        return redirect('adm');
    }
    
    public function alterar()
    {  
        $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
        $id_sql = $_POST ['alterar'];
        $tipo = $_POST ['tipo'];

        if($tipo =='Admin'){$result = '3';}
        else if($tipo == 'Avaliador'){ $result = '2';}
        else{ $result = '1';}

        $sql = "UPDATE usuarios SET nivel = '$result' WHERE id ='$id_sql'";
        mysqli_query($conn, $sql);

        return redirect('adm2');
    }

    public function rem_den()
    {  
        $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
        $id_sql = $_POST ['id'];

        $sql = "DELETE FROM denuncias WHERE id ='$id_sql'";
        mysqli_query($conn, $sql);

        return redirect('adm3');
    }

    public function del_post()
    {  
        $conn = mysqli_connect("localhost", "root", "", "repositorio_de_ideias");
        $id1 = $_POST ['id_denuncia'];
        $id2 = $_POST ['id_postagem'];

        $sql = "DELETE FROM denuncias WHERE id ='$id1'";
        mysqli_query($conn, $sql);

        $sql = "DELETE FROM postagens WHERE id_postagem ='$id2'";
        mysqli_query($conn, $sql);

        return redirect('adm3');
    }
    
}