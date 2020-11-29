@extends('layouts.LR')

<?php $user = \Auth::user()->usuario; ?> 

@section('content')
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
				<form class="login100-form validate-form">
                <div class="login100-form-title p-b-33">Verificação de E-mail</div>

					    <div>
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    Um link de verificação foi enviado para o seu endereço de e-mail.
                                </div>
                            @endif

                            Olá! <?php  echo $user?>, enviamos um Email de verificação para o email cadastrado.
                            Se você não recebeu o email,
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-linkk p-0 m-0 align-baseline"><b>clique aqui</b></button>
                            </form>
                            para solicitar outro. Lembre-se de verificar a caixa de Spam caso não encontre.
                            <br><br>
                            <a class="txt2 hov1" href="{{ url('/logout') }}">Sair</a>
                        </div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
