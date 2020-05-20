

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
</head>

<!-- ||Nav Bar||  -->
<nav class="navbar navbar-expand-lg navbar-light bg-light" id="menu">
  <img width="150px" src="{{asset('css/img/logo.png')}}">
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
      <div style="width: 500px">
        <form>
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Crie uma ideia</button>
        </form>
      </div>
      <!--<li class="nav-item">
        <a class="nav-link" href="{{ url('/pagina') }}">Outra Pagina</a>
      </li>-->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
<!--||Fim Nav bar||-->

    <!-- Puxa o arquivo home dentro da div-->
    <div id="area_principal">
      <div class="container my-4">
        @yield('content')
        <h2 id="h1conta">Minha Conta</h2>
      </div>

      <!--||Área de dados do usuário||-->
      <div id="area-dados">
          <div class="card-body text-center">
            <img width="150px" src="{{asset('css/img/semuser.png')}}">
          <h3>{{ Auth::user()->usuario }}</h3>
          <p>{{ Auth::user()->email }}</p>
            <div id="conteudo-dados">

              <?php $rgm = Auth::user()->registro ?>
              <p>RGM: {{ $rgm }}</p>

              <?php $email = Auth::user()->email;?>
              <p>E-mail para contato: {{ $email }}</p>

              <?php $instituicao = Auth::user()->id_instituicao;?>
              @if($instituicao === null)
                <p>Instituição de Ensino: Não definido</p>
              @else 
                <p>Instituição de Ensino: {{ $instituicao }}</p>
              @endif

              <?php $area = Auth::user()->id_area;?>
              @if($area === null)
                <p>Área: Não definido</p>
              @else 
                <p>Área: {{ $area }}</p>
              @endif

              <?php $telefone = Auth::user()->telefone;?>
              @if($telefone === null)
                <p>Telefone: Não definido</p>
              @else 
                <p>Telefone: {{ $telefone }}</p>
              @endif

              <?php  $cidade = Auth::user()->id_regiao_cidade;?>
              @if($cidade === null)
                <p>Região: Não definido</p>
              @else 
                <p>Região: {{ $cidade }}</p>
              @endif 
                                        
            </p>
              <a href="#">Editar perfil</a>
            </div>
          </div>
      </div>
    <!--||Fim área de dados||-->

    <!-- Área de ideias do usuario -->
      <div id="area_ideias">
        <table id="tableconta">
          <caption>Minhas Ideias</caption>
          <thead>
            <tr>
              <th>Num</th>
              <th>Data</th>
              <th>Nome da ideia</th>
              <th>Situação</th>
              <th>Detalhes</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th>1</th>
              <th>12/12/2019</th>
              <th>Seila</th>
              <th>Pendente</th>
              <th><a href="#">Visualizar</a></th>
            </tr>
            <tr>
              <th>2</th>
              <th>43/34/2099</th>
              <th>Palhaço de chuteira</th>
              <th>Pendente</th>
              <th><a href="#">Visualizar</a></th>
            </tr>
            <tr>
              <th>3</th>
              <th>55/65/2340</th>
              <th>Avestruz Desdentado</th>
              <th>Avaliado</th>
              <th><a href="#">Visualizar</a></th>
            </tr>
            <tr>
              <th>4</th>
              <th>32/43/3232</th>
              <th>Mouse democrático</th>
              <th>Avaliado</th>
              <th><a href="#">Visualizar</a></th>
            </tr>
            <tr>
              <th>5</th>
              <th>32/32/2032</th>
              <th>Copo ajoelhado</th>
              <th>Pendente</th>
              <th><a href="#">Visualizar</a></th>
            </tr>
            <tr>
              <th>6</th>
              <th>65/76/4333</th>
              <th>Headset soltando pipa</th>
              <th>Pendente</th>
              <th><a href="#">Visualizar</a></th>
            </tr> 
          </tbody><!--
          <tfoot>
            <tr>
              <th class=""></th>
            </tr>
          </tfoot>-->
        </table>
      </div>

    <!-- Fim área de ideias do usuario -->

    </div>
</body>
</html>