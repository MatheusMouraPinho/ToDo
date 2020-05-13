<?php

use Symfony\Component\Console\Input\Input;
$nivel = Auth::user()->nivel; ?> 
?>

<!-- indicar a pagina:   {{ url('/pagina123') }}    -->
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/funcao.js') }}"></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/estilo.css') }}" rel="stylesheet">

</head>
<body>
  <!-- ||Cabeçalho||  -->
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded" id="menu">
      <img class="navbar-brand" width="150px" src="{{asset('img/logo.png')}}">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-md-center" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <form class="form-inline my-2 my-lg-0" action="{{ url('/home') }}">
              <button class="btn btn-outline-success my-2 my-sm-0">Home</button>
            </form>
          </li>
          <li class="nav-item">
            <form class="form-inline my-2 my-lg-0">
              <input class="form-control mr-sm-2" type="search" placeholder="Digite o nome da ideia" aria-label="Search" style="width: 400px">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Procurar</button>
            </form>
          </li>
          <li class="nav-item">
            <form class="form-inline my-2 my-lg-0">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Crie uma ideia</button>
            </form>
          </li>
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
  </header>
  <!--||Fim Cabeçalho||-->

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

                <p>RGM: {{ $dados['rgm'] }}</p>

                <p>E-mail para contato: {{ $dados['email'] }}</p>

                @if(is_null($dados['telefone']))
                  <p>Telefone: Não definido</p>
                @else 
                  <p  id="telefone">
                    Telefone: {{ $dados['telefone'] }}
                  </p>
                @endif

                @if(empty($dados['instituicao'][0]))
                  <p>Instituição de Ensino: Não definido</p>
                @else 
                  <p>Instituição de Ensino: {{ $dados['instituicao'] }}</p>
                  
                @endif

                @if(empty($dados['area'][0]))
                  <p>Área: Não definido</p>
                @else 
                  <p>Área: {{ $dados['area'] }}</p>
                @endif

                @if(empty($dados['cidade'][0]))
                  <p>Região: Não definido</p>
                @else 
                  <p>Região: {{ $dados['cidade'] }} - {{ $dados['uf'][0]->uf_regiao_estado }}</p>  
                @endif 

                
                                          
              </p>
                <a href="" data-toggle="modal" data-target="#popup{{$dados['id'] }}">Editar perfil</a>
                
              </div>
            </div>
        </div>
      <!--||Fim área de dados||-->

      <!-- Área de ideias do usuario -->
        @if(empty($dados['posts'][0]))

          <div class="area_ideias">
            <table id="table_conta">
              <caption>Minhas Ideias</caption>
              <tbody>  
                <tr>
                  <td rowspan="10">
                    <div class="centralizar">
                      <img width="350px" src="{{asset('img/carinhatriste.jpg')}}">
                      <p>Ainda não foi criada nenhuma ideia</p>
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
                  <th>#</th>
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
                  
              
                  
                  <!-- Área de detalhes de ideias postadas -->

                  <div class="painel-dados">
                    <div class="modal fade id" id="popup{{$posts->id_postagem}}" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          <div class="modal-body">
                            <div class="popup-title">
                              <span class="popup_sub bold">Título:</span>
                              <p class="popup_cont">{{$posts->titulo_postagem}}</p>
                            </div>
                            <div class="popup_desc">
                              <span class="popup_sub bold">Descrição:</span>
                              <p id="popup_cont_desc">{{ $posts->descricao_postagem }}</p>
                            </div>
                            <div>
                              <span class="popup_sub bold">Categoria:</span>
                              <p class="popup_coment">{{$dados['posts'][$i]->categoria_postagem}}</p>
                            </div>
                            <div class="popup_img">
                              <span class="popup_sub bold">Imagens:</span>
                              <img class="popup_imgs" src="{{asset('img/semimagem.jpg')}}">
                              <img class="popup_imgs" src="{{asset('img/semimagem.jpg')}}">
                              <img class="popup_imgs" src="{{asset('img/semimagem.jpg')}}">
                            </div>
                            <div class="popup_aval">
                              <span class="popup_sub bold">Avaliação:</span>
                              @if(!empty($post['avaliacao'][0]))
                                @for($c=0; $c<sizeof($post['avaliacao']); $c++)
                                  @if($post['avaliacao'][$c]->id_postagem === $posts->id_postagem)
                                    <p class="popup_avali">
                                      <span class="bold">Inovação: </span>{{ $post['avaliacao'][$c]->inovacao_avaliacao }}
                                    </p>
                                    <p class="popup_avali">
                                      <span class="bold">Potencial de Mercado: </span>{{ $post['avaliacao'][$c]->potencial_avaliacao }}
                                    </p>
                                    <p class="popup_avali">
                                      <span class="bold">Complexidade: </span>{{ $post['avaliacao'][$c]->complexidade_avaliacao }}
                                    </p>
                                    <p class="popup_avaliador">
                                      <span class="bold">Avaliador: {{ $dados['avaliador'][$c]->usuario }}</span> 
                                      <span class="underline">{{ date('d/m/Y', strtotime($post['avaliacao'][0]->data_avaliacao))}}</span><br>{{ $post['avaliacao'][$c]->comentario_avaliacao }}
                                    </p>
                                  @endif

                                  <!-- Verifica se a avaliação está pendente ou não -->
                                  <?php $cont = 0;?>
                                  @for($d=0;$d<sizeof($post['avaliacao']);$d++)
                                    @if($post['avaliacao'][$d]->id_postagem !== $posts->id_postagem)
                                      <?php 
                                        $cont+= 1 ;
                                      ?>
                                    @endif
                                  @endfor
                                @endfor
                                @if($cont === sizeof($post['avaliacao']))
                                  <p class="popup_coment">Pendente</p>
                                @endif
                              @else
                                <p class="popup_coment">Pendente</p>
                              @endif
                              
                            </div>
                            <div class="popup-aval">
                              <span class="popup_sub bold">Comentários:</span>   
                              <div style="margin-bottom: 50px">
                                <form action="">
                                  <textarea required class="comentario" maxlength="255" cols="60" rows="2" placeholder="Digite aqui seu comentário"></textarea>
                                  <input type="submit" name="" class="btn btn-primary button_coment" value="Enviar">
                                </form>
                              </div>
                              @if(!empty($post['comentarios'][0]))  
                                @for($f=0; $f<sizeof($post['comentarios']); $f++)
                                  @if($post['comentarios'][$f]->id_postagem === $posts->id_postagem)
                                    <div class="popup_coment_aval">
                                      <div class="header-coment">
                                        @if($post['comentarios'][$f]->img_usuarios === null)
                                          <img class="img-dados-coment" src="{{asset('img/semuser.png')}}">
                                        @else
                                          <img  alt="{{ Auth::user()->img_usuarios }}" name="img_usuarios" class="img-dados-coment" src="{{url('storage/users/'.Auth::user()->img_usuarios)}}">
                                        @endif
                                        <span class="bold "><a href="" class="user">{{ $post['comentarios'][$f]->usuario}}</a></span> 
                                        <span class="underline data-coment">{{ date('d/m/Y', strtotime($post['comentarios'][$f]->data_comentarios))}}</span>
                                      </div>
                                      <p class="conteudo-coment">{{ $post['comentarios'][$f]->conteudo_comentarios }}</p>
                                      <div class="footer-coment">
                                        <span class="mostrar">Responder</span> 
                                        <a href="#" class="curtir">Curtir</a>                                 
                                        <div class="likes_coment">  
                                          <img width="30px" src="{{ asset('img/like.png') }}">
                                          <p class="num-like">{{ $post['comentarios'][$f]->likes_comentarios }}</p>
                                        </div>
                                        <div id="comentarios">
                                          <form action="" method="POST">
                                            <input maxlength="255" style="width: 100%" type="text" class="btn-popup mr-sm-2" placeholder="Digite aqui sua resposta">
                                          </form>
                                        </div>
                                      </div>
                                      
                                    </div>                                    
                                  @endif
                                  @for($g=0; $g<sizeof($post['reply_coment']); $g++)
                                    @if($post['reply_coment'][$g]->id_comentarios === $post['comentarios'][$f]->id_comentarios && $post['comentarios'][$f]->id_postagem === $posts->id_postagem)
                                      <div class="popup_coment_enc" id="respostas">
                                        <div class="header-coment">
                                          @if($post['reply_coment'][$g]->img_usuarios === null)
                                            <img class="img-dados-coment" src="{{asset('img/semuser.png')}}">
                                          @else
                                            <img  alt="{{ Auth::user()->img_usuarios }}" name="img_usuarios" class="img-dados-coment" src="{{url('storage/users/'.Auth::user()->img_usuarios)}}">
                                          @endif
                                          <span class="bold "><a href="" class="user">{{ $post['reply_coment'][$g]->usuario}}</a></span> 
                                          <span class="underline data-coment">{{ date('d/m/Y', strtotime($post['reply_coment'][$g]->data_comentarios))}}</span>
                                        </div>
                                        <p class="conteudo-coment">{{ $post['reply_coment'][$g]->conteudo_comentarios }}</p>
                                        <div class="footer-coment">
                                          <a href="#" class="curtir">Curtir</a>    
                                          <div class="likes_coment"> 
                                            <img width="30px" src="{{ asset('img/like.png') }}">
                                            <p class="num-like">{{ $post['reply_coment'][$g]->likes_comentarios }}</p>
                                          </div>
                                        </div>
                                      </div>
                                    @endif
                                  @endfor
                                @endfor
                              @endif
                            </div>           
                            <div class="modal-footer seila">
                              <p class="data-post seila">
                                Postado em {{date('d/m/Y', strtotime($posts->data_postagem))}} às  {{date('H:i:s', strtotime($posts->data_postagem))}} horas
                              </p>
                              <div class="popup-like">
                                <img width="30px" src="{{ asset('img/like.png') }}">
                                <p class="num-like">{{ $posts->likes_postagem }}</p>
                              </div>          
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php $i = $i + 1?>
                  <!-- Fim área de detalhes de ideias postadas-->
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

      <!-- Área de detalhes de ideias postadas -->

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
                        <input type="file" name="img_usuarios"/>
                        <a name="img_usuarios" class="get-file">Alterar imagem de perfil</a>
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
                      <label for="telefone_usuario" class="bold subdados ">Telefone</label>
                      <input minlength="10" data-mask="00/00/0000" maxlength="11" id="telefone_usuario" type="text" class="btn-popup mr-sm-2 phones" value="{{ $dados['telefone'] }}" name="telefone_usuario" placeholder="Ex: (11) 11111-1111"/>
                    </div>

                    <hr>

                    <div class="popup-title">
                      <label for="id_instituicao" class="bold subdados">Instituição de Ensino</label>
                      <select name="id_instituicao" class="select">
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
                      <select name="id_regiao_cidade" class="select">
                        <option value="">{{$dados['cidade']}}</option>
                        @for($a = 0; $a<sizeof($dados['cidades']);$a++)
                          <option value="{{ $dados['cidades'][$a]->id_regiao_cidade }}">
                            {{ $dados['cidades'][$a]->nome_cidade }}
                          </option>
                        @endfor
                      </select>
                    </div>
                    <div class="modal-footer">
                      <input onload="mostrarConteudo()" data-toggle="modal" data-target="#hiddenDiv" type="submit" class="btn btn-primary dropright" value="Salvar Alterações">
                    </div>  
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Fim área de detalhes de ideias postadas-->
      </div>
</body>
</html>