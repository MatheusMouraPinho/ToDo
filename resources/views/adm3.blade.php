@extends('layouts.app')



@section('content')
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link"  href="{{ url('/adm') }}">Cadastros</a>
    <a class="nav-item nav-link"  href="{{ url('/adm2') }}">Nivel de acesso</a>
    <a class="nav-item nav-link active"  href="{{ url('/adm3') }}">Reports</a>
  </div>
</nav>
<br>

<H1>To Do</H1>

@endsection
