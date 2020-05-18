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

    <title>{{ config('app.name', 'Laravel') }}</title>

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
            <a class="btn btn-secondary my-2 my-sm-0"  href="{{ url('/home') }}">Home</a>
          </div>
        </li>
        <li style="padding-left:2em" class="nav-item">
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Digite o nome da ideia" aria-label="Search" style="width: 400px">
            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Procurar</button>
          </form>
        </li>
        <li style="padding-left:2em" class="nav-item">
          <form class="form-inline my-2 my-lg-0">
            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Crie uma ideia</button>
          </form>
        </li>
        <?php if($nivel > 1){?>
          <li class="nav-item">
            <form class="form-inline my-2 my-lg-0">
              <button class="btn btn btn-secondary my-2 my-sm-0" type="submit">Criar uma Sugestão</button>
            </form>
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

      <!--||Footer||-->
      <div class="card">
          <div class="card-body text-center">
          Rodapé
          </div>
      </div>
      <!--||Fim Footer||-->
    </div>
</body>
</html>