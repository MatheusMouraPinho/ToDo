<?php $nivel = Auth::user()->nivel; 

if (isset($style)){?> 
  <style>
  tbody tr:hover {
    background-color: rgb(221, 221, 221);
  }
  </style>
<?php }?>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Repositório de Ideias - ToDo</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/estilo.css') }}" rel="stylesheet">
    <link href="{{ asset('css/estilo2.css') }}" rel="stylesheet">
</head>
<body>
  <!-- ||Nav Bar||  -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <img class="navbar-brand" width="150px" src="{{asset('img/logo.png')}}">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-md-center" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li style="padding-left:2em" class="nav-item active">
          <div class="form-inline my-2 my-lg-0">
            <a class="btn btn-primary my-2 my-sm-0"  href="{{ url('/home') }}">Home</a>
          </div>
        </li>
        <li style="padding-left:2em" class="nav-item">
          <form class="form-inline my-2 my-lg-0" method="POST" action="/pesquisa">
            @csrf
            <input class="form-control mr-sm-2" type="text" name="pesquisa" placeholder="Procure pelo nome da postagem ou autor" aria-label="Search" style="width: 400px">
            <button class="btn btn-primary my-2 my-sm-0" type="submit">Procurar</button>
          </form>
        </li>
        <li style="padding-left:2em" class="nav-item">
          <button class="btn btn-primary my-2 my-sm-0" data-toggle="modal" data-target=".bd-example-modal-lg">Crie uma ideia</button>
        </li>
        <?php if($nivel > 1){?>
          <li class="nav-item">
            <button class="btn btn btn-primary my-2 my-sm-0" data-toggle="modal" data-target=".bd-example-modal-lg">Criar uma Sugestão</button>
          </li>
        <?php }?>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Configurações </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php if(3 == $nivel){?>
            <a class="dropdown-item" href="{{ url('/adm') }}">Admin Painel</a>
            <?php }?>
            <a class="dropdown-item" href="{{ url('/conta') }}">Minha conta</a>
            <a class="dropdown-item" href="{{ url('/logout') }}"> Sair </a>
          </div>
        </li>
      </ul>
    <div>
  </nav> 
  <!--||Fim Nav bar||-->

  <div>
    <!-- Puxa o arquivo home dentro da div-->
    <div class="container my-4">
    <br>
    @yield('content')
    </div>
  </div>

<!-- Footer -->
<footer class="custom-footer">
  <div class="space"></div>
  <div class="container text-center text-md-left mt-5">
    <div class="row mt-3">
      <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
        <h6 class="text-uppercase font-weight-bold"><ff>Desenvolvimento</ff></h6>
        <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 130px;">
        <p><fw>Site desenvolvido por alunos da Universidade Módulo - Campus MÓDULO Caraguatatuba, Ministrado pelo Professor Fabio Lippi.
        </fw></p>
      </div>
      <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
        <h6 class="text-uppercase font-weight-bold"><ff>RGM</ff></h6>
        <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 30px;">
        <fw>
          <p>20867000</p>
          <hr class="accent-3 mb-3 mt-0 d-inline-block mx-auto" style="width: 80px;">
          <p>20541929</p>
          <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto" style="width: 80px;">
          <p>22132066</p>
          <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto" style="width: 80px;">
          <p>20530625</p>
        </fw>
      </div>
      <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
        <h6 class="text-uppercase font-weight-bold"><ff>Integrantes</ff></h6>
        <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 90px;">
        <fw>
          <p>Matheus Moura Pinho</p>
          <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto" style="width: 150px;">
          <p>Vinicius Vieira Pereira</p>
          <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto" style="width: 150px;">
          <p>Jonathan Gonçalves Dias</p>
          <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto" style="width: 150px;">
          <p>Mauricio Freire da Silva</p>
        </fw>
      </div>
      <div class="col-md-4 col-lg-3 col-xl-4 mx-auto mb-md-0 mb-4">
        <h6 class="text-uppercase font-weight-bold"><ff>Contato</ff></h6>
        <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
        <fw>
          <p>Matheusmpinho@outlook.com</p>
          <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto" style="width: 200px;">
          <p>vinicius_vieira_pereira@hotmail.com</p>
          <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto" style="width: 200px;">
          <p>jonathangoncalves.dias2001@gmail.com</p>
          <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto" style="width: 200px;">
          <p>mauriciofreire520@gmail.com</p>
        </fw>
      </div>
    </div>
  </div>
  <div class="space2">
    <div class="footer-copyright text-center py-3">© 2020 Copyright:
      <a href=""> RepositorioToDo.com</a>
    </div>
  </div>
</footer>





  <!--Modal Criação post-->
  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
      <div class="modal-content">
        ...
      </div>
    </div>
  </div>
  <!--Modal Criação post-->
  
</body>
</html>