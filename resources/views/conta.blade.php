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
                    <p style="padding: 5px; margin: 0px;">Telefone: Não definido</p>
                  </div>
                @else 
                  <div class="dados-pessoais">
                    <p id="telefone" style="padding: 5px; margin: 0px;">
                      Telefone: {{ $dados['telefone'] }}
                    </p>
                  </div>
                @endif

                @if(empty($dados['instituicao'][0]))
                  <div class="dados-pessoais">
                    <p style="padding: 5px; margin: 0px;">Instituição de Ensino: Não definido</p>
                  </div>
                @else 
                  <div class="dados-pessoais">
                    <p style="padding: 5px; margin: 0px;">Instituição: {{ $dados['instituicao'] }}</p>
                  </div>
                @endif

                @if(empty($dados['area'][0]))
                  <div class="dados-pessoais">
                    <p style="padding: 5px; margin: 0px;">Área: Não definido</p>
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
                              <span style="vertical-align: top" class="popup_sub bold">Descrição:</span>
                              <textarea id="popup_cont_desc" cols="70" rows="5" disabled>{{ $posts->descricao_postagem }}</textarea>
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
                              <div style="margin-bottom: 13%">
                                <form action="{{ route('comentario') }}" method="POST">
                                  @csrf
                                  <textarea required name="conteudo_comentarios" class="comentario" maxlength="255" cols="60" rows="2" placeholder="Digite aqui seu comentário"></textarea>
                                  <input type="hidden" name="id_postagem" value="{{ $posts->id_postagem }}">
                                  <input type="submit" name="comentario" class="btn btn-primary button_coment" value="Enviar">
                                </form>
                              </div>
                              @if(!empty($post['comentarios'][0]))  
                                @for($f=0; $f<sizeof($post['comentarios']); $f++)
                                  @if($post['comentarios'][$f]->id_postagem === $posts->id_postagem)
                                  <hr>
                                    <div class="popup_coment_aval" id="id_comentario{{ $post['comentarios'][$f]->id_comentarios }}">
                                      <div class="header-coment">
                                        @if($post['comentarios'][$f]->img_usuarios === null)
                                          <img class="img-dados-coment" src="{{asset('img/semuser.png')}}">
                                        @else
                                          <img  alt="{{ $post['comentarios'][$f]->img_usuarios }}" name="img_usuarios" class="img-dados-coment" src="{{asset('/storage/users/'.$post['comentarios'][$f]->img_usuarios)}}">
                                        @endif
                                        <form id="perfil" action="{{ route('perfil') }}" method="get">
                                          @csrf
                                          <input type="hidden" name="id_usuario" value="{{ $post['comentarios'][$f]->id }}">
                                          <input class="bold user" type="submit" value="{{ $post['comentarios'][$f]->usuario}}">
                                        </form>
                                        <div class="dropdown dropdown1">

                                          <!--Trigger-->
                                         
                                          <a class="btn-floating btn-lg "type="button" id="dropdownMenu2" data-toggle="dropdown"
                                          aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                        
                                        
                                          <!--Menu-->
                                          <div class="dropdown-menu dropdown-primary">
                                            @if($post['comentarios'][$f]->id === Auth::user()->id)
                                              <a id="edit" class="dropdown-item" onclick="ocultar_popup('popup{{$posts->id_postagem}}', 'popup{{$post['comentarios'][$f]->id_comentarios }}_edit1')" href="#" style="cursor: pointer" data-toggle="modal" data-target="#popup{{$post['comentarios'][$f]->id_comentarios }}_edit1">Editar</a>
                                              <a class="dropdown-item" href="#" style="cursor: pointer" data-toggle="modal" data-target="#popup{{$post['comentarios'][$f]->id_comentarios}}_apagar2">Apagar</a>
                                            @else
                                              <a class="dropdown-item" href="{{ url('/adm') }}">Denunciar</a>
                                            @endif
                                          </div>
                                        </div> 
                                        @if(empty($post['comentarios'][$f]->edit_comentarios))
                                          <span class="underline data-coment">{{ Helper::tempo_corrido($post['comentarios'][$f]->data_comentarios)}}</span>
                                        @else
                                          <span class="underline data-coment"><?='(editado) '. Helper::tempo_corrido($post['comentarios'][$f]->edit_comentarios)?></span>
                                        @endif
                                      </div>
                                      <p class="conteudo-coment text-justify">{{ $post['comentarios'][$f]->conteudo_comentarios }}</p>
                                      <div class="footer-coment">
                                        <span class="mostrar">Responder</span>
                                        <?php $resultados = Helper::verifica_like_coment($post['comentarios'][$f]->id_comentarios);$id_comentario = $post['comentarios'][$f]->id_comentarios;?>
                                          @if($resultados == 0)
                                            <span href="#" id="btn_like" class="curtir fa-thumbs-o-up fa" data-id="{{ $post['comentarios'][$f]->id_comentarios }}"></span> 
                                            <span class="likes" id="likes_{{ $post['comentarios'][$f]->id_comentarios }}">{{ $post['comentarios'][$f]->likes_comentarios }}</span>
                                          @else 
                                          <span href="#" id="btn_like" class="curtir fa-thumbs-up fa" data-id="{{ $post['comentarios'][$f]->id_comentarios }}"></span>
                                          <span class="likes" id="likes_{{ $post['comentarios'][$f]->id_comentarios }}">{{ $post['comentarios'][$f]->likes_comentarios }}</span>
                                          @endif

                                        <!--  Modal de edição de comentários -->
                                          <div class="painel-dados">
                                            <div class="modal fade id" id="popup{{$post['comentarios'][$f]->id_comentarios}}_edit1" role="dialog">
                                              <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                  </div>
                                                  <div class="modal-body"> 
                                                    <form action="{{ route('edit.coment') }}" method="POST"> 
                                                      @csrf                   
                                                      <div class="popup-title">
                                                        <label style="vertical-align: top" for="editcomentario" class="bold subdados">Descrição:</label>
                                                        <textarea name="editcomentario" id="edit_desc" cols="60" rows="1">{{$post['comentarios'][$f]->conteudo_comentarios }}</textarea>
                                                        <input type="hidden" name="id_coment" value="{{ $post['comentarios'][$f]->id_comentarios }}">
                                                      </div>
                                                    

                                                    <div class="modal-footer">
                                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                      <input data-toggle="modal" data-target="#hiddenDiv" type="submit" class="btn btn-primary dropright" value="Salvar Alterações">
                                                      
                                                    </div> 
                                                  </form> 

                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                  
                                        <div id="comentarios">
                                          <form action="{{ route('comentario') }}" method="POST">
                                            @csrf
                                            <input name="conteudo" maxlength="255" style="width: 100%" type="text" class="btn-popup mr-sm-2" placeholder="<?='Em resposta a '.'@'. $post['comentarios'][$f]->usuario?>">
                                            <input type="hidden" name="id_coment" value="{{ $post['comentarios'][$f]->id_comentarios }}">
                                            <input type="hidden" name="id_postagem" value="{{ $posts->id_postagem }}">
                                            <input type="submit" style="display: none" name="respostas">
                                          </form>
                                        </div>
                                      </div>
                                      
                                    </div> 
                                    
                                    <!--  Modal para apagar comentários -->
                                  <div class="painel-dados">
                                    <div class="modal fade id" id="popup{{$post['comentarios'][$f]->id_comentarios}}_apagar2" role="dialog">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                          </div>
                                          <div class="modal-body"> 
                                            <p>Deseja realmente apagar este comentário?</p>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                              <form action="{{route('apagar-coment')}}" method="POST">
                                                @csrf
                                                <input name="id_comentario" type="hidden" value="{{ $post['comentarios'][$f]->id_comentarios }}">
                                                <input data-toggle="modal" type="submit" class="btn btn-primary dropright" value="Apagar comentário">
                                              </form>
                                            </div> 
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>         
                                  @endif
                                  @for($g=0; $g<sizeof($post['reply_coment']); $g++)
                                    @if($post['reply_coment'][$g]->id_comentarios === $post['comentarios'][$f]->id_comentarios && $post['comentarios'][$f]->id_postagem === $posts->id_postagem)
                                      <div class="linha"></div>
                                      <div class="popup_coment_aval" id="respostas">
                                        
                                        
                                        <div class="header-coment">
                                          <form id="perfil" action="{{ route('perfil') }}" method="get">
                                            @csrf
                                            <input type="hidden" name="id_usuario" value="{{ $post['comentarios'][$f]->id }}">
                                            <span>Em resposta a</span><input class="link" type="submit" value="<?='@'. $post['comentarios'][$f]->usuario ?>">
                                            {{-- <p class="respondendo">Em resposta a <span class="link"></span></p> --}}
                                          </form>
                                          <div class="dropdown dropdown1">

                                            <!--Trigger-->
                                           
                                            <a class="btn-floating btn-lg black"type="button" id="dropdownMenu3" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                          
                                          
                                            <!--Menu-->
                                            <div class="dropdown-menu dropdown-primary">
                                              @if($post['reply_coment'][$g]->id === Auth::user()->id)
                                                <a class="dropdown-item" data-toggle="modal" style="cursor: pointer" data-target="#popup{{$post['reply_coment'][$g]->id_subcomentarios }}_edit">Editar</a>
                                                <a class="dropdown-item" style="cursor: pointer" data-toggle="modal" data-target="#popup{{$post['reply_coment'][$g]->id_subcomentarios }}_apagar1">Apagar</a>
                                              @else
                                                {{-- <form id="denunciar" action="{{ route('denunciar') }}" method="POST">
                                                  @csrf
                                                  <input type="hidden" name="id_subcomentario" value="{{$post['reply_coment'][$g]->id_subcomentarios}}"> --}}
                                                  <a class="dropdown-item" href="#">Denunciar</a>
                                                {{-- </form> --}}
                                              @endif
                                            </div>
                                          </div>
                                          @if(empty($post['reply_coment'][$g]->edit_subcomentarios))
                                            <span class="underline data-coment">{{ Helper::tempo_corrido($post['reply_coment'][$g]->data_comentarios)}}</span>
                                          @else
                                            <span class="underline data-coment"><?='(editado) '. Helper::tempo_corrido($post['reply_coment'][$g]->edit_subcomentarios)?></span>
                                          @endif
                                          <div>
                                            @if($post['reply_coment'][$g]->img_usuarios === null)
                                              <img class="img-dados-coment" src="{{asset('img/semuser.png')}}">
                                            @else
                                              <img  alt="{{ $post['reply_coment'][$g]->img_usuarios }}" name="img_usuarios" class="img-dados-coment" src="{{asset('/storage/users/'.$post['reply_coment'][$g]->img_usuarios)}}">
                                            @endif
                                            <form id="perfil" action="{{ route('perfil') }}" method="get">
                                              @csrf
                                              <input type="hidden" name="id_usuario" value="{{ $post['reply_coment'][$g]->id }}">
                                              <input alt="" class="bold user" type="submit" value="{{ $post['reply_coment'][$g]->usuario}}">
                                            </form>
                                          </div>
                                          
                                        </div>
                                        <p class="conteudo-coment te">{{ $post['reply_coment'][$g]->conteudo_comentarios }}</p>
                                        <div class="footer-coment">
                                          {{-- <span class="mostrar">Responder</span> --}}
                                          <?php $resultados = Helper::verifica_like_subcoment($post['reply_coment'][$g]->id_subcomentarios)?>
                                          @if($resultados == 0)
                                            <span href="#" id="{{ $post['reply_coment'][$g]->id_subcomentarios }}" class="subcurtir fa-thumbs-o-up fa" data-id="{{ $post['reply_coment'][$g]->id_subcomentarios }}"></span> 
                                            <span class="likes" id="likes_{{ $post['reply_coment'][$g]->id_subcomentarios }}">{{ $post['reply_coment'][$g]->likes_comentarios }}</span>
                                          @else 
                                            <span href="#" id="{{ $post['reply_coment'][$g]->id_subcomentarios }}" class="subcurtir fa-thumbs-up fa" data-id="{{ $post['reply_coment'][$g]->id_subcomentarios }}"></span>
                                            <span class="likes" id="likes_{{ $post['reply_coment'][$g]->id_subcomentarios }}">{{$post['reply_coment'][$g]->likes_comentarios }}</span>
                                          @endif
                                          

                                          <div id="comentarios">
                                            <form action="{{ route('comentario') }}" method="POST">
                                              @csrf
                                              <input name="conteudo_resposta" maxlength="255" style="width: 100%" type="text" class="btn-popup mr-sm-2" placeholder="<?='Em resposta a '.'@'. $post['reply_coment'][$g]->usuario?>">
                                              <input type="hidden" name="id_coment" value="{{ $post['reply_coment'][$g]->id_comentarios }}">
                                              <input type="hidden" name="id_resposta" value="{{ $post['reply_coment'][$g]->id_subcomentarios }}">
                                              <input type="hidden" name="id_postagem" value="{{ $posts->id_postagem }}">
                                              <input type="submit" style="display: none" name="respostas">
                                            </form>
                                          </div>
                                        </div>
                                      </div>

                                      <!--  Modal de edição de respostas de comentários -->
                                      <div class="painel-dados">
                                        <div class="modal fade id" id="popup{{$post['reply_coment'][$g]->id_subcomentarios}}_edit" role="dialog">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              </div>
                                              <div class="modal-body"> 
                                                <form action="{{ route('edit.coment') }}" method="POST"> 
                                                  @csrf                   
                                                  <div class="popup-title">
                                                    <label style="vertical-align: top" for="editsubcomentario" class="bold subdados">Descrição:</label>
                                                    <textarea name="editsubcomentario" id="edit_desc" cols="60" rows="1">{{$post['reply_coment'][$g]->conteudo_comentarios }}</textarea>
                                                    <input type="hidden" name="id_subcoment" value="{{ $post['reply_coment'][$g]->id_subcomentarios }}">
                                                  </div>
                                                

                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                  <input data-toggle="modal" data-target="#hiddenDiv" type="submit" class="btn btn-primary dropright" value="Salvar Alterações">
                                                  
                                                </div> 
                                              </form> 

                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <!--  Modal para apagar subcomentários -->
                                      <div class="painel-dados">
                                        <div class="modal fade id" id="popup{{$post['reply_coment'][$g]->id_subcomentarios}}_apagar1" role="dialog">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                              </div>
                                              <div class="modal-body"> 
                                                <p>Deseja realmente apagar este comentário?</p>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                  <form action="{{route('apagar-coment')}}" method="POST">
                                                    @csrf
                                                    <input name="id_subcomentario" type="hidden" value="{{ $post['reply_coment'][$g]->id_subcomentarios }}">
                                                    <input name="id_comentario" type="hidden" value="{{ $post['reply_coment'][$g]->id_comentarios }}">
                                                    <input data-toggle="modal" type="submit" class="btn btn-primary dropright" value="Apagar comentário">
                                                  </form>
                                                </div> 
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    @endif
                                  @endfor

                                                         
                                
                                @endfor
                              @endif
                            </div>           
                            <div class="modal-footer" style="margin-top: 10px">
                              <div class="popup-like">
                                <img width="30px" src="{{ asset('img/like.png') }}">
                                <p class="num-like">{{$posts->likes_postagem}}</p>
                              </div>   
                              <p class="data-post">
                                Postado em {{date('d/m/Y', strtotime($posts->data_postagem))}} às  {{date('H:i:s', strtotime($posts->data_postagem))}} horas
                              </p>
                                     
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