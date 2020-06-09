@extends('layouts.app')
<?php

use Symfony\Component\Console\Input\Input;
session_start();
$nivel = Auth::user()->nivel;
$_SESSION['id_usuario'] = $dados['id'];

// echo tempo_corrido("m/d/Y H:i:s");
?>

@section('content')
      <div id="area_principal">
        
        @if(session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger">
            {{ session('error') }}
          </div>
        @endif


        <div class="container my-4">
          <h2 id="h1conta">Perfil</h2>
        </div>

        <!--||Área de dados do usuário||-->
        <div id="area-dados">
            <div class="card-body text-center">
              
              @if($dados['img'] === null)
                <img width="150px" class="img-dados" src="{{asset('img/semuser.png')}}">
              @else
              <img  alt="{{ $dados['img'] }}" name="img_usuarios" class="img-dados" src="{{url('storage/users/'.$dados['img'])}}">
              @endif
            <h3>{{ $dados['nome'] }}</h3>
            
            <p>{{ $dados['email'] }}</p>
            <div id="conteudo-dados">
              <div class="dados-pessoais">
                <p style="padding: 5px; margin: 0px;">RGM/CPF: {{ $dados['rgm'] }}</p>
              </div>

              <div class="dados-pessoais">
                <p style="padding: 5px; margin: 0px;">E-mail: {{ $dados['email'] }}</p>
              </div>

              @if(is_null($dados['telefone']))
                  <div class="dados-pessoais">
                    <p style="padding: 5px; margin: 0px;">Telefone/Celular: <span class="font-italic">Não definido</span></p>
                  </div>
                @else 
                  <div class="dados-pessoais">
                    <p id="telefone" style="padding: 5px; margin: 0px;">
                      Celular: {{ $dados['telefone'] }}
                    </p>
                  </div>
                @endif

                @if(empty($dados['instituicao'][0]))
                  <div class="dados-pessoais">
                    <p style="padding: 5px; margin: 0px;">Instituição de Ensino: <span class="font-italic">Não definido</span></p>
                  </div>
                @else 
                  <div class="dados-pessoais">
                    <p style="padding: 5px; margin: 0px;">Instituição: {{ $dados['instituicao'] }}</p>
                  </div>
                @endif

                @if(empty($dados['area'][0]))
                  <div class="dados-pessoais">
                    <p style="padding: 5px; margin: 0px;">Área: <span class="font-italic">Não definido</span></p>
                  </div>
              @else 
                <div class="dados-pessoais">
                  <p style="padding: 5px; margin: 0px;">Área: {{ $dados['area'] }}</p>
                </div>
              @endif

              @if(empty($dados['cidade'][0]))
                <div class="dados-pessoais">
                  <p style="padding: 5px; margin: 0px;">Região: Não definido</p>
                </div>
              @else 
                <div class="dados-pessoais">
                  <p style="padding: 5px; margin: 0px;">Região: {{ $dados['cidade'] }} - {{ $dados['uf'][0]->uf_regiao_estado }}</p> 
                </div> 
              @endif 

                
                                          
              </p>
                
              </div>
            </div>
        </div>
      <!--||Fim área de dados||-->

      <!-- Área de ideias do usuario -->
        @if(empty($dados['posts'][0]))

          <div id="area_ideias">
            <table id="table_conta">
              <caption>Ideias Postadas</caption>
              <tbody>  
                <tr>
                  <td rowspan="10">
                    <div class="centralizar">
                      <img width="200px" src="{{asset('img/denie.png')}}">
                      <p class="font-italic">Não foi criada nenhuma ideia</p>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

        @else
          <div id="area_ideias">
            <table id="table_conta">
              <caption>Ideias Postadas</caption>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Data</th>
                  <th>Nome da ideia</th>
                  <th>Situação</th>
                  <th>Detalhes</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 0?>            
                @foreach($dados['posts'] as $posts)
                  <tr>
                    <td>{{ $posts->id_postagem }}</td>
                    <td>{{ date('d/m/Y', strtotime($posts->data_postagem)) }}</td>
                    <td>{{ $posts->titulo_postagem }}</td>
                    <td> {{ $posts->situacao_postagem}} </td>
                    <td>
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#popup{{$posts->id_postagem }}">
                        Visualizar
                      </button>
                    </td>
                    </tr> 
                  
                    @include('layouts.post_conta');

                @endforeach
              </tbody>
            </table>
              <div class="card-footer" style="padding: 8px">
                <p id="contagem-ideias">
                  {{ $dados['posts']->appends(['id_usuario' => $_SESSION['id_usuario']])->links() }}
                </p>
              </div>
          </div>
        @endif
      <!-- Fim área de ideias do usuario -->
@endsection