@extends('layouts.LR')

@section('content')
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
				<form action="{{url('reset')}}" method="post">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="login100-form-title p-b-33">Alterar senha</div>

                    <div>
                        <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                        <input id="email" type="email" class="input100 @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus readonly>
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
                    <input id="password" type="password" class="input100 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Senha">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
                        @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
					</div>

                    <div class="wrap-input100 rs1 validate-input" >
                    <input id="password-confirm" type="password" class="input100" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmar Senha">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>
                    
					<div class="container-login100-form-btn m-t-20">
						<button type="submit" class="login100-form-btn btn btn-lg btn-primaria btn-block">
                        {{ __('Alterar') }}
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>
@endsection
