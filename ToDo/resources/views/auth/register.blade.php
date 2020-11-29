@extends('layouts.LR')

@section('content')
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
				<form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="logo">
                    <a href="{{ route('login') }}">  <img height="90px" src="{{asset('img/ToDo.png')}}"> </a>
                </div>
                <br>

					<div class="wrap-input100 validate-input">
                    <input id="usuario" type="text" class="input100 @error('usuario') is-invalid @enderror" name="usuario" value="{{ old('usuario') }}" required autocomplete="usuario" autofocus placeholder="Nome">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
                        @error('usuario')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
					</div>

                    <div class="wrap-input100 rs1 validate-input">
                    <input id="registro" type="text" class="input100 @error('registro') is-invalid @enderror" name="registro" value="{{ old('registro') }}" autocomplete="registro" autofocus placeholder="RGM/CPF (opcional)">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
                        @error('registro')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
					</div>

                    <div>
                        <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                            <input id="email" class="input100 @error('email') is-invalid @enderror" type="text" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                            @error('email')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                             @enderror
                         </div>
                    </div>

					<div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
                    <input id="senha" type="password" class="input100 @error('senha') is-invalid @enderror" name="senha" required autocomplete="new-senha" placeholder="Senha">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
                        @error('senha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
					</div>

                    <div class="wrap-input100 rs1 validate-input" >
                    <input id="senha-confirm" type="password" class="input100" name="senha_confirmation" required autocomplete="new-senha" placeholder="Confirmar Senha">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
                    </div>
                    <br>
                    
                    <div >
                    <input id="check" type="checkbox" name="check" required> Eu aceito os <a href="" class="txt2 hov1" data-toggle="modal" data-target="#modal_termo">Termos e condições</a> do site
						
						
                        @error('check')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
					</div>

					<div class="container-login100-form-btn m-t-20">
						<button type="submit" class="login100-form-btn btn btn-lg btn-primaria btn-block">
                        {{ __('Cadastrar') }}
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>
    @endsection