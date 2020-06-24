<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ToDo Ideias</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="shortcut icon" href="img/img_ToDo.png" type="img/x-icon" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/estiloAuth.css') }}" rel="stylesheet">
</head>
    <div id="fundo">
         <div>
            <img id="modulo" src="{{asset('css/img/centro.jpg')}}" >
        </div>   

        <div id="logo" style="padding-top:28px">
            <img height="90px" src="{{asset('img/ToDo.png')}}" >
        </div>  
    </div>
<body>
    <div id="app" style="padding-top:20px">
      <!--  layout da tela de login, register, comfirmação de email... -->
      

        <main class="py-4">
            @yield('content') <!-- conteudo que ira ficar aqui-->
        </main>
    </div>

    <footer>© 2020 ToDoIdeias.gq All Rights Reserved</footer>

</body>
</html>
