@extends('layouts.LR')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">\O_O/ </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="registro" class="col-md-4 col-form-label text-md-right">RGM/CPF</label>

                            <div class="col-md-6">
                                <input id="registro" type="text" class="form-control @error('registro') is-invalid @enderror" name="registro" value="{{ old('registro') }}" required autocomplete="registro" autofocus>

                                @error('registro')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Senha</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                                <br><br>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Esqueceu Sua Senha?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                    
                    <div class="col-md-8 offset-md-4">
                        <a class="btn btn-link" href="{{ route('register') }}">
                            Não Possui Conta?
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
