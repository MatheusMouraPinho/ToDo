@extends('layouts.LR')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-login">
                <div class="row card-corpo">
                    <div class="col-8">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right"></label>
    
                                <div class="col-md-6">
                                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right"></label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Senha">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            
                                
                                @if (Route::has('password.request'))
                                    <a class="btn btn-linkk" href="{{ route('password.request') }}">
                                        {{ __('Esqueceu Sua Senha?') }}
                                    </a><br><br>
                                @endif
                                <button type="submit" class="btn btn-lg btn-primaria btn-block">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                        </form>
                        
                        <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <a>
                                Não tem uma conta? <a href="{{ route('register') }}">Registre-se </a>
                            </a>
                        </div>
                    </div>
                    </div>
                    <div class="col-4">
                        <img class="imglogin" src="{{asset('img/Pencil.svg')}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript">
if(navigator.appName.indexOf("Internet Explorer")!=-1 || navigator.userAgent.match(/Trident.*rv[ :]*11\./))
{
  window.location = "{{url('IE')}}";
}
</script>
