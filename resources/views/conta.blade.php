<?php

use Symfony\Component\Console\Input\Input;
$nivel = Auth::user()->nivel;



?>

<!-- indicar a pagina:   {{ url('/pagina123') }}    -->
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Minha Conta - ToDo</title>

    <!-- Scripts -->
    
    <script type="text/javascript" src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/funcoes.js') }}"></script>
    
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/estilo.css') }}" rel="stylesheet">
    <link href="{{ asset('css/estilo2.css') }}" rel="stylesheet">

    <script src="https://kit.fontawesome.com/1618aca3df.js" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>

</head>
<body>
  <!-- ||Nav Bar||  -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <img class="navbar-brand" width="150px" src="{{asset('img/logo.png')}}">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-md-center" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li style="padding-left:2em" class="nav-item active">
          <div class="form-inline my-2 my-lg-0">
            <a class="btn btn-primary my-2 my-sm-0"  href="{{ url('/home') }}">Home</a>
          </div>
        </li>
        <li style="padding-left:2em" class="nav-item">
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Digite o nome da ideia" aria-label="Search" style="width: 400px">
            <button class="btn btn-primary my-2 my-sm-0" type="submit">Procurar</button>
          </form>
        </li>
        <li style="padding-left:2em" class="nav-item">
          <button class="btn btn-primary my-2 my-sm-0" data-toggle="modal" data-target=".bd-example-modal-lg">Crie uma ideia</button>
        </li>
        <?php if($nivel > 1){?>
          <li class="nav-item">
            <button class="btn btn btn-primary my-2 my-sm-0" data-toggle="modal" data-target=".bd-example-modal-lg">Criar uma Sugestão</button>
          </li>
        <?php }?>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Configurações </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php if(3 == $nivel){?>
            <a class="dropdown-item" href="{{ url('/adm') }}">Admin Painel</a>
            <?php }?>
            <a class="dropdown-item" href="{{ url('/conta') }}">Minha conta</a>
            <a class="dropdown-item" href="{{ url('/logout') }}"> Sair </a>
          </div>
        </li>
      </ul>
    <div>
  </nav> 
  <!--||Fim Nav bar||-->

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
          <h2 id="h1conta">Minha Conta</h2>
        </div>

        <!--||Área de dados do usuário||-->
        <div id="area-dados">
          <div class="card-body text-center">
              
              @if($dados['img'] === null)
                <img width="150px" class="img-dados" src="{{asset('img/semuser.png')}}">
              @else
              <img  alt="{{ Auth::user()->img_usuarios }}" name="img_usuarios" class="img-dados" src="{{url('storage/users/'.Auth::user()->img_usuarios)}}">
              @endif
            <h3>{{ $dados['nome'] }}</h3>
            
            <p>{{ $dados['email'] }}</p>
            
              <div id="conteudo-dados">
                <div class="dados-pessoais">
                  <p style="padding: 5px; margin: 0px;">RGM: {{ $dados['rgm'] }}</p>
                </div>

                <div class="dados-pessoais">
                  <p style="padding: 5px; margin: 0px;">E-mail: {{ $dados['email'] }}</p>
                </div>

                @if(is_null($dados['telefone']))
                  <div class="dados-pessoais">
                    <p style="padding: 5px; margin: 0px;">Celular: <span class="font-italic">Não definido</span></p>
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
                    <p style="padding: 5px; margin: 0px;">Região: <span class="font-italic">Não definido</span></p>
                  </div>
                @else 
                  <div class="dados-pessoais">
                    <p style="padding: 5px; margin: 0px;">Região: {{ $dados['cidade'] }} - {{ $dados['uf'][0]->uf_regiao_estado }}</p> 
                  </div> 
                @endif 

                
                                          
              </p>
                <a style="margin-left: 2%" href="" data-toggle="modal" data-target="#popup{{$dados['id'] }}">Editar perfil</a>
                
              </div>
            </div>
          </div>
      <!--||Fim área de dados||-->

      <!-- Área de ideias do usuario -->
        @if(empty($dados['posts'][0]))

          <div id="area_ideias">
            <table id="table_conta">
              <caption>Minhas Ideias</caption>
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
              <caption>Minhas Ideias</caption>
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
                    <td class="abreviar">{{ $posts->titulo_postagem }}</td>
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
                {{ $dados['posts']->links() }}
              </p>
            </div>
          </div>
        @endif

      <!-- Fim área de ideias do usuario -->

      <!-- Área de edição de dados do usuário -->

      <div class="painel-dados">
        <div class="modal fade id" id="popup{{$dados['id']}}" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <form action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <div class="popup-title">
                      @if($dados['img'] === null)
                        <img width="150px" name="img_usuarios" class="img" src="{{asset('img/semuser.png')}}">  
                      @else
                        <img width="200px" alt="{{ Auth::user()->img_usuarios }}" name="img_usuarios" class="img" src="{{url('storage/users/'.Auth::user()->img_usuarios)}}">
                      @endif
                      <label class="form-control-range">
                        <input type="file" name="img_usuarios" id="file" accept="image/*" multiple onchange="javascript:update()"/>
                        <a name="img_usuarios" class="get-file">Alterar imagem de perfil</a>
                        <div style="text-align: center" id="file-name"></div>
                      </label>
                    </div>

                    <div class="popup-title">
                      <label for="usuario" class="bold subdados">Usuário</label>
                      <input type="text" class="btn-popup mr-sm-2" value="{{ Auth::user()->usuario }}" placeholder="Usuário" name="usuario">
                    </div>

                    <div class="popup-title">
                      <label for="email" class="bold subdados">E-mail</label>
                      <input type="text" class="btn-popup mr-sm-2" value="{{ Auth::user()->email }}" name="email" placeholder="E-mail" readonly>
                    </div>

                    <div class="popup-title">
                      <label for="senha" class="bold subdados">Senha</label>
                      <input type="password" class="btn-popup mr-sm-2" value="{{ Auth::user()->senha }}" name="senha" placeholder="Senha" readonly>
                      <a href="{{ url('/password/reset') }}" class="password">Alterar senha</a>
                    </div>

                    <div class="popup-title">
                      <label for="telefone_usuario" class="bold subdados ">Celular</label>
                      <input onkeypress="return onlynumber();" minlength="10" maxlength="11" id="telefone_usuario" type="text" class="btn-popup mr-sm-2 phones" name="telefone_usuario" placeholder="Ex: (11) 11111-1111"/>
                    </div>

                    <hr>

                    <div class="popup-title">
                      <label for="id_instituicao" class="bold subdados">Instituição</label>
                      <select name="id_instituicao" class="select" title="Selecione uma opção">
                      <option value="">{{ $dados['instituicao'] }}</option>
                        @for($a = 0; $a<sizeof($dados['instituicoes']);$a++)
                          <option value="{{ $dados['instituicoes'][$a]->id_instituicao }}">
                            {{ $dados['instituicoes'][$a]->nome_instituicao }}
                          </option>
                        @endfor
                      </select>
                    </div>

                    <div class="popup-title">
                      <label for="id_area" class="bold subdados">Área</label>
                      <select name="id_area" class="select" title="Selecione uma opção" class="btn btn-primary">
                        <option value="">{{$dados['area']}}</option>
                          @for($a = 0; $a<sizeof($dados['areas']);$a++)
                            <option value="{{ $dados['areas'][$a]->id_area }}">
                              {{ $dados['areas'][$a]->nome_area }}
                            </option>
                          @endfor
                      </select>
                    </div>

                    <div class="popup-title">
                      <label for="id_regiao_cidade" class="bold subdados">Região</label>
                      <select name="id_regiao_cidade" class="select" title="Selecione uma opção">
                        <option value="">{{$dados['cidade']}}</option>
                        @for($a = 0; $a<sizeof($dados['cidades']);$a++)
                          <option value="{{ $dados['cidades'][$a]->id_regiao_cidade }}">
                            {{ $dados['cidades'][$a]->nome_cidade }}
                          </option>
                        @endfor
                      </select>
                    </div>
                    <div class="modal-footer">
                      <input data-toggle="modal" type="submit" class="btn btn-primary dropright" value="Salvar Alterações">
                    </div>  
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Fim área de edição de dados do usuário -->

        <!-- Footer -->
        <footer class="custom-footer">
          <div class="space"></div>
          <div class="container text-center text-md-left mt-5">
            <div class="row mt-3">
              <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                <h6 class="text-uppercase font-weight-bold"><ff>Desenvolvimento</ff></h6>
                <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 130px;">
                <p><fw>Site desenvolvido por alunos da Universidade Módulo - Campus MÓDULO Caraguatatuba, Ministrado pelo Professor Fabio Lippi.
                </fw></p>
              </div>
              <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                <h6 class="text-uppercase font-weight-bold"><ff>RGM</ff></h6>
                <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 30px;">
                <fw>
                  <p>20867000</p>
                  <hr class="accent-3 mb-3 mt-0 d-inline-block mx-auto" style="width: 80px;">
                  <p>20541929</p>
                  <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto" style="width: 80px;">
                  <p>22132066</p>
                  <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto" style="width: 80px;">
                  <p>20530625</p>
                </fw>
              </div>
              <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                <h6 class="text-uppercase font-weight-bold"><ff>Integrantes</ff></h6>
                <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 90px;">
                <fw>
                  <p>Matheus Moura Pinho</p>
                  <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto" style="width: 150px;">
                  <p>Vinicius Vieira Pereira</p>
                  <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto" style="width: 150px;">
                  <p>Jonathan Gonçalves Dias</p>
                  <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto" style="width: 150px;">
                  <p>Mauricio Freire da Silva</p>
                </fw>
              </div>
              <div class="col-md-4 col-lg-3 col-xl-4 mx-auto mb-md-0 mb-4">
                <h6 class="text-uppercase font-weight-bold"><ff>Contato</ff></h6>
                <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <fw>
                  <p>Matheusmpinho@outlook.com</p>
                  <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto" style="width: 200px;">
                  <p>vinicius_vieira_pereira@hotmail.com</p>
                  <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto" style="width: 200px;">
                  <p>jonathangoncalves.dias2001@gmail.com</p>
                  <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto" style="width: 200px;">
                  <p>mauriciofreire520@gmail.com</p>
                </fw>
              </div>
            </div>
          </div>
          <div class="space2">
            <div class="footer-copyright text-center py-3">© 2020 Copyright:
              <a href=""> RepositorioToDo.com</a>
            </div>
          </div>
        </footer>
      </div>
      <!-- Fim área de detalhes de ideias postadas-->

    </div>

</body>

</html>