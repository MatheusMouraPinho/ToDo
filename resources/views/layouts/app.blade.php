<?php // $user = \Auth::user()->name; ?> 

<!-- idicar a pagina:   {{ url('/pagina123') }}    -->
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
</head>
<body>

  <!-- ||Nav Bar||  -->
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="menu">
      <img width="150px" src="{{asset('img/logo.png')}}">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="{{ url('/home') }}">Home <span class="sr-only">(current)</span></a>
          </li>
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Digite o nome da ideia" aria-label="Search" style="width: 400px">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Procurar</button>
          </form>
          <div style="width: 500px" class="form-inline my-2 my-lg-0">
            <form class="form-inline my-2 my-lg-0">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Crie uma ideia</button>
            </form>
          </div>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Configurações
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ url('/conta') }}">Minha conta</a>
              <a class="dropdown-item" href="{{ url('/logout') }}"> Sair </a>
            </div>
          </li>
        </ul>
      </div>
    </nav> 
  </header>
  <!--||Fim Nav bar||-->

    <div id="area_principal">
      <!-- Puxa o arquivo home dentro da div-->
      <div class="container my-4">
      @yield('content')
      </div>

      <!--||Footer||-->
      <div class="card">
          <div class="card-body text-center">
          isso é o rodapé
          </div>
      </div>
      <!--||Fim Footer||-->
    </div>
</body>
</html>