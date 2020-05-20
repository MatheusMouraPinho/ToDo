@extends('layouts.LR')

<?php $user = \Auth::user()->usuario; ?> 

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-login">
                <div class="card-cabeca">Aviso</div>

                <div class="card-corpo">
                    Olá! <?php  echo $user?>, estamos analisando os seus dados, aguarde a confirmação
                    do seu cadastro para acessar o nosso Site!
                    <br><br>
                    <a id="nv" href="{{ url('/logout') }}"> Sair </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
