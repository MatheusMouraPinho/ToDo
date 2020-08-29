@extends('layouts.app')
<?php

use Symfony\Component\Console\Input\Input;

$nivel = Auth::user()->nivel;

?>
@section('content')

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

<div class="flex justify-content-md-center">
      <div id="area_principal">
        <div id="area_capa">
          @if($dados['img_capa'] === null)
            <img class="img_capa" src="{{asset('img/fundo_azul.jpg')}}">
          @else
            <img id="img_capa" src="{{url('/ToDo/storage/app/public/users_capa/'.Auth::user()->img_capa)}}">
          @endif
        </div>

        <!--||Área de dados do usuário||-->
        <div id="area-dados">
          <div class="card-body text-center">
              
              @if($dados['img_perfil'] === null)
                <img width="150px" class="img-dados" src="{{asset('img/semuser.png')}}">
              @else
                <img  alt="{{ Auth::user()->img_usuarios }}" name="img_usuarios" class="img-dados" src="{{url('/ToDo/storage/app/public/users/'.Auth::user()->img_usuarios)}}">
              @endif

            <h3 style="font-weight: bold;">{{ $dados['nome'] }}</h3>
            
            <p>{{ $dados['email'] }}</p>
            <a class="edit_perfil" href="" data-toggle="modal" data-target="#popup{{$dados['id'] }}">
              <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
              </svg>
               Editar perfil
              </a>
            
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
                    <p style="padding: 5px; margin: 0px;">Região: <span class="font-italic">Não definido</span></p>
                  </div>
                @else 
                  <div class="dados-pessoais">
                    <p style="padding: 5px; margin: 0px;">Região: {{ $dados['cidade'] }} - {{ $dados['uf'][0]->uf_regiao_estado }}</p> 
                  </div> 
                @endif             
                
              </div>
            </div>
          </div>
      <!--||Fim área de dados||-->

          <div class="divisao-conta"></div>

      <!-- Área de ideias do usuario -->
        @if(empty($dados['posts'][0]))

          <div id="area_ideias">
            <div class="">
              <p id="h1conta">Minha Conta</p>
            </div>
            
            <table id="table_conta">
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
            <div class="container my-4">
              <h2 id="h1conta">Minhas Ideias</h2>
            </div>

            <div class="scroll_table">
              <table id="table_conta">
                <thead>
                  <tr>
                    <th>Nome da Ideia</th>
                    <th>Data</th>
                    <th>Situação</th>
                    <th>Detalhes</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 0?>            
                  @foreach($dados['posts'] as $posts)
                    <tr>
                      <td class="abreviar">{{ $posts->titulo_postagem }}</td>
                      <td>{{ date('d/m/Y', strtotime($posts->data_postagem)) }}</td>
                      <td>{{ $posts->situacao_postagem }}</td>
                      <td>
                        {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#popup{{$posts->id_postagem }}">
                          Visualizar
                        </button> --}}
                        <a class="" href="" data-toggle="modal" data-target="#popup{{$posts->id_postagem }}"">
                          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                          </svg>
                          Visualizar
                        </a>
                      </td>
                      </tr> 
                    
                      @include('layouts.post_conta')

                  @endforeach
                </tbody>
              </table>
            </div>
            {{-- <div class="" style="padding: 8px">
              <p id="contagem-ideias">
                {{ $dados['posts']->links() }}
              </p>
            </div> --}}
          </div>
        @endif

      <!-- Fim área de ideias do usuario -->

      <!-- Área de edição de dados do usuário -->
          
      <div class="painel-dados">
        <div class="modal fade id" id="popup{{$dados['id']}}" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" style="color: white">&times;</button>
              </div>
              <div class="modal-body">
                <form action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                      <div id="area_capa_edit">
                        @if($dados['img_capa'] === null)
                          <img class="img_capa" src="{{asset('img/fundo_azul.jpg')}}">
                        @else
                          <img id="img_capa" src="{{url('/ToDo/storage/app/public/users_capa/'.Auth::user()->img_capa)}}">
                        @endif
                      </div>

                      <div class="area_dados_edit">
                        <div class="img_perfil">
                          @if($dados['img_perfil'] === null)
                            <img width="150px" name="img_usuarios" class="img" src="{{asset('img/semuser.png')}}">  
                          @else
                            <img width="200px" alt="{{ Auth::user()->img_usuarios }}" name="img_usuarios" class="img" src="{{url('/ToDo/storage/app/public/users/'.Auth::user()->img_usuarios)}}">
                            {{-- <button class="icon_cam" type=""><span class="fas fa-camera"></span></button> --}}
                          @endif
                          <div class="dropdown" style="position: absolute">
                            <button class="btn btn-secondary dropdown-toggle icon_cam" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    
                              <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-camera-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path fill-rule="evenodd" d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z"/>
                              </svg>

                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <label>
                                <input name="img_usuarios" type="file" style="display: none; cursor:pointer" accept="image/jpeg, image/png, image/svg">
                                <a name="img_usuarios" class="dropdown-item">Alterar foto de perfil</a>
                              </label>
                              <label>
                                <input name="img_capa" type="file" style="display: none; cursor: pointer;" accept="image/jpeg, image/png, image/svg">
                                <a name="img_capa" class="dropdown-item">Alterar foto da capa</a>
                              </label>
                              {{-- <input id="file" name="img_usuarios" type="file" style="display: none" accept="image/jpeg, image/png" multiple onchange="javascript:update()"/>
                              <a name="img_usuarios" class="dropdown-item">Alterar foto de perfil</a>
                              <input id="file2" name="img_capa" type="file" style="display: none" accept="image/jpeg, image/png" multiple onchange="javascript:update2()"/>
                              <a name="img_capa" class="dropdown-item">Alterar foto da capa</a> --}}
                            </div>
                          </div>
                        </div>
                        {{-- <label class="form-control-range">
                          <input type="file" name="img_usuarios" id="file" accept="image/jpeg, image/png" multiple onchange="javascript:update()"/>
                          <a name="img_usuarios" class="get-file">Alterar imagem de perfil</a>
                          <div style="text-align: center" id="file-name"></div>
                        </label>
                        <label class="form-control-range">
                          <input type="file" name="img_capa" id="file2" accept="image/jpeg, image/png" multiple onchange="javascript:update2()"/>
                          <a name="img_capa" class="get-file">Alterar imagem de capa</a>
                          <div style="text-align: center" id="file-name2"></div>
                        </label> --}}
                      

                        <div class="popup-title">
                          <label for="usuario" class="bold subdados">Usuário: </label>
                          <input type="text" class="btn-popup mr-sm-2" value="{{ Auth::user()->usuario }}" placeholder="Usuário" name="usuario">
                        </div>

                        <div class="popup-title">
                          <label for="email" class="bold subdados">E-mail: </label>
                          <input type="text" class="btn-popup mr-sm-2" value="{{ Auth::user()->email }}" name="email" placeholder="E-mail" readonly>
                        </div>

                        <div class="popup-title">
                          <label for="senha" class="bold subdados">Senha: </label>
                          <input type="password" class="btn-popup mr-sm-2" value="{{ Auth::user()->senha }}" name="senha" placeholder="Senha" readonly>
                          <a href="{{ url('/password/reset') }}" class="password">Alterar senha</a>
                        </div>

                        <div class="popup-title">
                          <label for="telefone_usuario" class="bold subdados ">Celular: </label>
                          <input onkeypress="return onlynumber();" minlength="10" maxlength="11" id="telefone_usuario" value="{{ Auth::user()->telefone_usuario }}" type="text" class="btn-popup mr-sm-2 phones" name="telefone_usuario" placeholder="Ex: (11) 11111-1111"/>
                        </div>

                        <hr>

                        <div class="popup-title">
                          <label for="id_instituicao" class="bold subdados">Instituição: </label>
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
                          <label for="id_area" class="bold subdados">Área: </label>
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
                          <label for="id_regiao_cidade" class="bold subdados">Região: </label>
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
                      </div>  
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Fim área de edição de dados do usuário -->
</div>
@endsection