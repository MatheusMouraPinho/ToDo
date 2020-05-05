@extends('layouts.LR')

<?php $user = \Auth::user()->usuario; ?> 

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">aviso.blade.php</div>

                <div class="card-body">
                    Olá! <?php  echo $user?>, estamos analisando os seus dados, aguarde a confirmação
                    do seu cadastro para acessar o nosso Site!
                    <br><br>
                    <a href="{{ url('/logout') }}"> Utilizar outra conta </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
