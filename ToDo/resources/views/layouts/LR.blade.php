<?php 
Artisan::call('route:clear');
Artisan::call('view:clear');
Artisan::call('cache:clear');
?>
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
    <link href="{{ asset('css/estilo2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/estiloAuth.css') }}" rel="stylesheet">
</head>
    <div id="fundo">
         <div>
            <img id="modulo" src="{{asset('img/fundo.jpg')}}" >
        </div>   

        <div id="logo" style="padding-top:28px" >
         <a href="{{ route('login') }}">  <img height="90px" src="{{asset('img/ToDo.png')}}"> </a>
        </div>  
    </div>
<body>
    <div id="app" style="padding-top:20px">
      <!--  layout da tela de login, register, confirmação de email... -->
      

        <main class="py-4">
            @yield('content') <!-- conteudo que ira ficar aqui-->
        </main>
    </div>

    <footer>© 2020 ToDoIdeias.gq All Rights Reserved</footer>

</body>
</html>

<!--Modal termos-->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_termo" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body fundo">
                @include('layouts/termos')
            </div>
            <div class="modal-footer-custom" style="border-top: 1px solid #ccc">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal termos de uso-->