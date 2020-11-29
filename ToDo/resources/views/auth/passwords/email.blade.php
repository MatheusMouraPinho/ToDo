@extends('layouts.LR')

@section('content')
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
            @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
				<form class="login100-form validate-form" method="POST" action="{{ route('password.email') }}">
                <div class="login100-form-title p-b-33">Recuperar senha</div>

				    <div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
                        <input id="email" type="email" class="input100 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Digite seu e-mail">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
					</div>
                    <div class="container-login100-form-btn m-t-20">
						<button type="submit" class="login100-form-btn btn btn-lg btn-primaria btn-block">
                            Recuperar
						</button>
					</div>	  
				</form>
			</div>
		</div>
	</div>
@endsection
