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
    <link href="{{ asset('css/estiloAuth.css') }}" rel="stylesheet">
</head>
    <div id="fundo">
         <div>
            <img id="modulo" src="{{asset('css/img/centro.jpg')}}" >
        </div>   

        <div id="logo">
            <img src="{{asset('css/img/logo.png')}}" >
        </div>  
    </div>
<body>
    <div id="app">
      <!--  layout da tela de login, register, comfirmação de email... -->
      

        <main class="py-4">
            @yield('content') <!-- conteudo que ira ficar aqui-->
        </main>
    </div>

    <footer>Repositorio de ideias</footer>

</body>
</html>
