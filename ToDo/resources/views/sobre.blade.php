@extends('layouts.app')


@section('content')

<!-- Container (About Section) -->
<div class="container justify-center">
    <hr class="rgba-white-light" style="margin-bottom:50px;margin-top:50px;">
    <div class="row">
        <div class="col-sm-6">
        <h2 class="titulo_sobre_1">Como surgiu ToDo Ideias?</h2><br>
            <h5>   
                <p class="text_sobre_p1">
                    Os coordenadores e os professores dos cursos, a cada semestre precisam pensar
                    em problemas e propostas de projetos para que os alunos possam desenvolver os Projetos
                    Interdisciplinares. No entanto, torna-se cada vez mais necessária a utilização de temas
                    que tenham ligação com o mundo real e não apenas situações fictícias.
                </p>
                <p class="text_sobre_p2">
                    O levantamento destas propostas ou temas torna-se cada vez mais complicado e escasso.
                    Diante disso surgi o ToDo ideias, uma ferramenta para reunir e escolher as melhores ideias para
                    esses projetos.
                </p>
                <p class="text_sobre_p3">
                    Um sistema que é algo muito necessário para quem cria/procura por inovações, em
                    algum momento se perdem as ideias e em um momento de crise de desenvolvimento poder
                    acessar um site que expõe diversas ideias em diversas áreas faz com que o desenvolvedor
                    não pare de produzir assim contribuindo por manter o fluxo de criação.
                </p>
            </h5>
        </div>
        <div class="col-sm-5 offset-1">
            <img class="img-sobre" src="{{asset('img/art3.png')}}">
        </div>
    </div>
    <hr class="rgba-white-light" style="margin-bottom:50px;margin-top:50px;">
</div>

@endsection