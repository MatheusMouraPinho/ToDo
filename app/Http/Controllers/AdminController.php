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
}