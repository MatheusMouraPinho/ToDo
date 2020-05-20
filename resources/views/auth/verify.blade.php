@extends('layouts.LR')

<?php $user = \Auth::user()->usuario; ?> 

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-login">
                <div class="card-cabeca">Verificação de Email</div>

                <div class="card-corpo">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Um link de verificação foi enviado para o seu endereço de e-mail.
                        </div>
                    @endif

                    Ola! <?php  echo $user?>, antes de prosseguir, verifique seu e-mail para um link de verificação.
                    Se você não recebeu o email,
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-linkk p-0 m-0 align-baseline"><b>clique aqui</b></button>
                    </form>
                    para solicitar outro.
                    <br><br>
                    <a id="nv" href="{{ url('/redirect') }}"> Não é você? </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
