@extends('layouts.LR')

@section('content')
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
				<form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="logo" style="padding-top:28px" >
                    <a href="{{ route('login') }}">  <img height="90px" src="{{asset('img/ToDo.png')}}"> </a>
                </div>

					<div>
                            <label for="email" class="col-md-4 col-form-label text-md-right"></label>
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
						<input id="password" class="input100 @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password" placeholder="Senha">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
					</div>

					<div class="container-login100-form-btn m-t-20">
						<button type="submit" class="login100-form-btn btn btn-lg btn-primaria btn-block">
                        {{ __('Login') }}
						</button>
					</div>

					<div class="text-center p-t-45 p-b-4">
                    @if (Route::has('password.request'))
                    <a class="txt2 hov1" href="{{ route('password.request') }}">
                            {{ __('Esqueceu Sua Senha?') }}
                    </a>
                    @endif
					</div>

					<div class="text-center">
                    <a>
                        Não tem uma conta? <a href="{{ route('register') }}" class="txt2 hov1">Registre-se </a>
                    </a>
					</div>
				</form>
			</div>
		</div>
	</div>
    @endsection


<script type="text/javascript">
if(navigator.appName.indexOf("Internet Explorer")!=-1 || navigator.userAgent.match(/Trident.*rv[ :]*11\./))
{
  window.location = "/ToDo/IE";
}
</script>
