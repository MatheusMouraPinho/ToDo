@extends('layouts.app')
<?php

use Symfony\Component\Console\Input\Input;
session_start();
$nivel = Auth::user()->nivel;
$user = Auth::user()->id;

if(NULL !== Session::get('filtro_coment')){$_SESSION['filtro_coment'] = Session::get('filtro_coment');}
if(isset($_SESSION['filtro_coment'])){$filtro_coment = $_SESSION['filtro_coment'];}
if(!isset($filtro_coment)){$filtro_coment = "data_comentarios";}


if(NULL !== Session::get('selected')){$_SESSION['selected'] = Session::get('selected');}
if(isset($_SESSION['selected'])){$selected = $_SESSION['selected'];}
if(!isset($selected)){$selected = "1";}

if(Session::get('nav_selected_perfil') !== NULL){$nav_selected = Session::get('nav_selected_perfil');}
if(!isset($nav_selected)){$nav_selected = 1;}


$comments = [
            'comentarios' => DB::table('comentarios')
                                ->join('postagens', 'postagens.id_postagem', '=', 'comentarios.id_postagem')
                                ->where('comentarios.id_mencionado', '=', null, 'and')
                                ->where('comentarios.id_avaliacao', '=', null)
                                ->join('usuarios', 'comentarios.id_usuarios', '=', 'usuarios.id')
                                ->select('comentarios.*', 'postagens.id_usuarios', 'postagens.id_postagem', 'usuarios.*')
                                ->orderBy($filtro_coment, 'desc')
                                ->get(),


            'reply_coment' => DB::table('comentarios')
                                ->join('postagens', 'postagens.id_postagem', '=', 'comentarios.id_postagem')
                                ->where('comentarios.id_mencionado', '!=', null)
                                ->leftJoin('usuarios as users', 'comentarios.id_usuarios', '=', 'users.id')
                                ->select('comentarios.*', 'postagens.id_usuarios', 'postagens.id_postagem', 'users.*')                               
                                ->orderBy($filtro_coment, 'desc')
                                ->get(),
];

$posts = Helper::ordenar_post_perfil($dados['id']);
$solicit = Helper::ordenar_solicit_perfil($dados['id']);

?>

@section('content')

        @if(session('success'))
          <div class="alert alert-success text-center">
            {{ session('success') }}
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger text-center">
            {{ session('error') }}
          </div>
        @endif

<div class="flex justify-content-md-center">
      <div id="area_principal">
        <div id="area_capa">
          @if($dados['img_capa'] === null)
            <img id="img_capa" src="{{asset('img/fundo_azul.jpg')}}">
          @else
            <img id="img_capa" src="{{url('/ToDo/storage/app/public/users_capa/'.$dados['img_capa'])}}">
          @endif
        </div>

        <!--||Área de dados do usuário||-->
        <div id="area-dados">
          <div class="card-body text-center">
              
              @if($dados['img_perfil'] === null)
                <img width="150px" class="img-dados" src="{{asset('img/semuser.png')}}">
              @else
                <img  alt="{{ Auth::user()->img_usuarios }}" name="img_usuarios" class="img-dados" src="{{url('/ToDo/storage/app/public/users/'.$dados['img_perfil'])}}">
              @endif

            <h3 style="font-weight: bold;">{{ $dados['nome'] }}</h3>
            
            <p>{{ $dados['email'] }}</p>
            
              <div id="conteudo-dados">
                <div class="dados-pessoais">
                  <p style="padding: 5px; margin: 0px;">
                    <span class="type_data">
                    <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-person" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                    </svg>&nbsp;
                    @if($dados['show_registro'] === 1 || $user == $dados['id'] || $nivel >= 2)
                      RGM/CPF: </span> {{ $dados['rgm'] }}
                    @elseif($dados['rgm'] === null)
                      RGM/CPF: </span> <i>Não definido</i>
                    @else
                      RGM/CPF: </span> <i>Indisponível</i>
                    @endif
                  </p>
                </div>

                <div class="dados-pessoais">
                  <p style="padding: 5px; margin: 0px;">
                    <span class="type_data">
                    <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-envelope" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/>
                    </svg>&nbsp;
                    @if($dados['show_email'] === 1 || $user == $dados['id'] || $nivel >= 2)
                      E-mail: </span> {{ $dados['email'] }}
                    @else
                      E-mail: </span> <i>Indisponível</i>
                    @endif
                  </p>
                </div>

                @if(is_null($dados['telefone']))
                  <div class="dados-pessoais">
                    <p style="padding: 5px; margin: 0px;">
                      <span class="type_data">
                      <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-telephone" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                      </svg>&nbsp;
                      Telefone/Celular:</span><span class="font-italic"> Não definido</span>
                    </p>
                  </div>
                @else 
                  <div class="dados-pessoais">
                    <p style="padding: 5px; margin: 0px;">
                      <span class="type_data">
                      <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-telephone" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                      </svg>&nbsp;
                      Telefone/Celular:</span> {{ $dados['telefone'] }}
                    </p>
                  </div>
                @endif

                @if(empty($dados['instituicao'][0]))
                  <div class="dados-pessoais">
                    <p style="padding: 5px; margin: 0px;">
                      <span class="type_data">
                      <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-building" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694L1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                        <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                      </svg>&nbsp;
                      Instituição de Ensino:</span> <span class="font-italic"> Não definido</span>
                    </p>
                  </div>
                @else 
                  <div class="dados-pessoais">
                    <p style="padding: 5px; margin: 0px;">
                      <span class="type_data">
                      <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-building" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694L1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                        <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                      </svg>&nbsp;
                      Instituição:</span> {{ $dados['instituicao'] }}
                    </p>
                  </div>
                @endif

                @if(empty($dados['area'][0]))
                  <div class="dados-pessoais">
                    <p style="padding: 5px; margin: 0px;">
                      <span class="type_data">
                      <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-book" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M1 2.828v9.923c.918-.35 2.107-.692 3.287-.81 1.094-.111 2.278-.039 3.213.492V2.687c-.654-.689-1.782-.886-3.112-.752-1.234.124-2.503.523-3.388.893zm7.5-.141v9.746c.935-.53 2.12-.603 3.213-.493 1.18.12 2.37.461 3.287.811V2.828c-.885-.37-2.154-.769-3.388-.893-1.33-.134-2.458.063-3.112.752zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                      </svg>&nbsp;
                      Curso:</span> <span class="font-italic"> Não definido</span>
                    </p>
                  </div>
                @else 
                  <div class="dados-pessoais">
                    <p style="padding: 5px; margin: 0px;">
                      <span class="type_data">
                      <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-book" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M1 2.828v9.923c.918-.35 2.107-.692 3.287-.81 1.094-.111 2.278-.039 3.213.492V2.687c-.654-.689-1.782-.886-3.112-.752-1.234.124-2.503.523-3.388.893zm7.5-.141v9.746c.935-.53 2.12-.603 3.213-.493 1.18.12 2.37.461 3.287.811V2.828c-.885-.37-2.154-.769-3.388-.893-1.33-.134-2.458.063-3.112.752zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                      </svg>&nbsp;
                      Curso:</span> {{ $dados['area'] }}
                    </p>
                  </div>
                @endif

                @if(empty($dados['cidade'][0]))
                  <div class="dados-pessoais">
                    <p style="padding: 5px; margin: 0px;">
                      <span class="type_data">
                      <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-geo-alt" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M12.166 8.94C12.696 7.867 13 6.862 13 6A5 5 0 0 0 3 6c0 .862.305 1.867.834 2.94.524 1.062 1.234 2.12 1.96 3.07A31.481 31.481 0 0 0 8 14.58l.208-.22a31.493 31.493 0 0 0 1.998-2.35c.726-.95 1.436-2.008 1.96-3.07zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                        <path fill-rule="evenodd" d="M8 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                      </svg>&nbsp;
                      Região:</span> <span class="font-italic"> Não definido</span>
                    </p>
                  </div>
                @else 
                  <div class="dados-pessoais">
                    <p style="padding: 5px; margin: 0px;">
                      <span class="type_data">
                      <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-geo-alt" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M12.166 8.94C12.696 7.867 13 6.862 13 6A5 5 0 0 0 3 6c0 .862.305 1.867.834 2.94.524 1.062 1.234 2.12 1.96 3.07A31.481 31.481 0 0 0 8 14.58l.208-.22a31.493 31.493 0 0 0 1.998-2.35c.726-.95 1.436-2.008 1.96-3.07zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                        <path fill-rule="evenodd" d="M8 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                      </svg>&nbsp;
                      Região:</span> {{ $dados['cidade'] }} - {{ $dados['uf'][0]->uf_regiao_estado }}
                    </p> 
                  </div> 
                @endif             
                
              </div>
            </div>
          </div>
      <!--||Fim área de dados||-->

          <div class="divisao-conta"></div>

          <div id="content_user">
            @if($nivel === 3)
              <ul class="nav nav-tabs mt-4 font-weight-bolder justify-content-start ml-auto mr-auto mb-3" style="font-size: 1.4em; width: 95%" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <a class="nav-link <?php if($nav_selected == 1){ echo 'active' ;} ?>" id="ideias-tab" data-toggle="tab" href="#ideias" role="tab" aria-controls="ideias" aria-selected="<?php ($nav_selected == 1) ? 'True' : 'False' ;?>">Ideias</a>
                </li>
                <li class="nav-item" role="presentation">
                  <a class="nav-link <?php if($nav_selected == '2'){ echo 'active' ;} ?>" id="solicitacoes-tab" data-toggle="tab" href="#solicitacoes" role="tab" aria-controls="solicitacoes" aria-selected="<?php ($nav_selected == '2') ? 'True' : 'False' ;?>">Solicitações</a>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade <?php if($nav_selected == 1){ echo 'active show' ;} ?>" id="ideias" role="tabpanel" aria-labelledby="ideias-tab">
            @endif

      <!-- Área de ideias do usuario -->

      <!-- Início da tabela de ideias -->
        @if(empty($posts[0]))

          <div id="area_ideias">
            @if($nivel < 3)
              <div class="container mt-4 mb-0">
                <h3 id="h1conta" class="mb-1">Ideias Postadas</h3>
                <hr class="mb-3 mt-0" style="margin-left: 1px">
              </div>
            @endif
            
            <table id="table_conta">
              <thead>
                <tr>
                  <th>Situação</th>
                </tr>
              </thead>
              <tbody>  
                <tr>
                  <td rowspan="10">
                    <div class="centralizar">
                      <p class="font-italic">Não foi criada nenhuma ideia</p>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

        @else
          <div id="area_ideias">
            @if($nivel < 3)
              <div class="container ml-1 mt-4 mb-0">
                <h3 id="h1conta" class="mb-1">Ideias Postadas</h3>
                <hr class="mb-3 mt-0">
              </div>
            @endif

            <div class="container pl-3 w-100 mb-3 mt-0">
              <div class="div_order">
                <form action="{{ route('order_post_perfil') }}" method="POST">
                  @csrf
                  <p class="font-weight-bold m-0 p-1">
                    <svg width="1.6em" height="1.6em" viewBox="0 0 16 16" class="bi bi-filter-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M2 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                    </svg>&nbsp;
                    Ordenar por:
                  </p>
                  <select name="ordenar_post" onchange="this.form.submit()" class="custom-select select-order bg-transparent" title="Selecione uma opção">
                    @if($_SESSION['selected_post_perfil'] == '1')
                      <option value="Recentes">Recentes</option>
                      <option value="Populares">Populares</option>
                      <option value="Avaliados">Avaliados</option>
                      <option value="Pendentes">Pendentes</option>
                    @elseif($_SESSION['selected_post_perfil'] == '2')
                      <option value="Populares">Populares</option>
                      <option value="Recentes">Recentes</option>
                      <option value="Avaliados">Avaliados</option>
                      <option value="Pendentes">Pendentes</option>
                    @elseif($_SESSION['selected_post_perfil'] == '3')
                      <option value="Avaliados">Avaliados</option>
                      <option value="Recentes">Recentes</option>
                      <option value="Populares">Populares</option>
                      <option value="Pendentes">Pendentes</option>
                    @elseif($_SESSION['selected_post_perfil'] == '4')
                      <option value="Pendentes">Pendentes</option>
                      <option value="Recentes">Recentes</option>
                      <option value="Populares">Populares</option>
                      <option value="Avaliados">Avaliados</option>
                    @endif
                  </select>
                  <input type="hidden" name="id_user" value="{{ $dados['id'] }}">
                </form>
              </div>
            </div>

            <div class="scroll_table">
              <table id="table_conta" style="font-size: 1.1em">
                <thead class="">
                  <tr>
                    <th style="min-width: 100px">Título</th>
                    <th>Data</th>
                    <th>Situação</th>
                    <th>Detalhes</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 0?>            
                  @foreach($posts as $posts)
                    <?php $user_post = $posts->id_usuarios; ?>
                    <tr>
                      <td class="abreviar">{{ $posts->titulo_postagem }}</td>
                      <td>{{ date('d/m/Y', strtotime($posts->data_postagem)) }}</td>
                      <td>{{ $posts->situacao_postagem }}</td>
                      <td>
                        <div class="btn-group dropdown">
                          <button class="btn btn-primary dropdown-toggle" type="button" style="background-color: #3490dc" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-list" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                            </svg>
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="" data-toggle="modal" onclick="modal({{$posts->id_postagem }})" data-target="#popup{{$posts->id_postagem }}">
                              <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                                <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                              </svg>&nbsp;
                              Visualizar postagem
                            </a>
                            <a class="dropdown-item" href="" data-toggle="modal" data-target="#den-post{{$posts->id_postagem }}">
                              <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-exclamation-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                            </svg>&nbsp;
                              Denunciar postagem
                            </a>
                          </div>
                        </div>
                        
                      </td>
                      </tr> 
                    
                      @include('layouts.post_conta')

                      <!-- Modal denunciar postagem -->
                      <div class="modal fade id" id="den-post{{$posts->id_postagem }}" role="dialog">
                        <div class="modal-dialog modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{url('denunciar_post')}}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <h4><p><b>Denunciar postagem por:</b></p></h4><br>
                                    <h6>
                                        <label class="radio-custom">Conteúdo Inadequado
                                            <input type="radio" id="radio1" name="option" value="3" required>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-custom">Spam
                                            <input type="radio" id="radio3" name="option" value="1" required>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-custom">Cópia
                                            <input type="radio" id="radio3" name="option" value="2" required>
                                            <span class="checkmark"></span>
                                        </label>
                                    </h6>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                        <input name="id_postagem" type="hidden" value="{{$posts->id_postagem }}">
                                        <input name="id_usuario" type="hidden" value="<?php echo $user;?>">
                                        <button type="submit" class="btn btn-primary">Confirmar</button>
                                    </div> 
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- FIM Modal denunciar postagem -->

                    @for($v=0; $v < sizeof($comments['comentarios']); $v++)
                        @if($comments['comentarios'][$v]->id == $user)
                        <!--  Modal para apagar comentários -->
                        <div class="painel-dados">
                          <div class="modal fade id" id="popup{{$comments['comentarios'][$v]->id_comentarios}}_apagar2" role="dialog">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body"> 
                                  <p>Deseja realmente apagar este comentário?</p>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    <form action="{{route('apagar-coment')}}" method="POST">
                                      @csrf
                                      <input name="id_comentario" type="hidden" value="{{ $comments['comentarios'][$v]->id_comentarios }}">
                                      <input type="hidden" value="{{$comments['comentarios'][$v]->id_postagem}}" name="id_postagem">
                                      <button type="submit" class="btn btn-primary">Confirmar</button>
                                    </form>
                                  </div> 
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>      
                        
                        <!--  Modal de edição de comentários -->
                        <div class="painel-dados">
                          <div class="modal fade id" id="popup{{$comments['comentarios'][$v]->id_comentarios}}_edit1" role="dialog">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body"> 
                                  <form action="{{ route('edit.coment') }}" method="POST"> 
                                    @csrf                   
                                    <div class="div-edit">
                                      <label style="vertical-align: top" for="editcomentario" class="bold subedit">Descrição:</label>
                                      <textarea name="editcomentario" id="edit_desc" cols="60" rows="1" required maxlength="255">{{$comments['comentarios'][$v]->conteudo_comentarios }}</textarea>
                                      <input type="hidden" name="id_coment" value="{{ $comments['comentarios'][$v]->id_comentarios }}">
                                      <input type="hidden" value="{{$comments['comentarios'][$v]->id_postagem}}" name="id_postagem">
                                    </div>
                                  

                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    <button data-toggle="modal" type="submit" class="btn btn-primary">Salvar Alterações</button>
                                  </div> 
                                </form> 

                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Fim modal de edição de comentarios -->
                        
                        @elseif($comments['comentarios'][$v]->id != $user)
                        <!-- Modal denunciar comentario -->
                        <div class="modal fade id" id="den_comen{{$comments['comentarios'][$v]->id_comentarios}}" role="dialog">
                          <div class="modal-dialog modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                              <form action="{{url('/denunciar_comentario')}}" method="POST">
                                  @csrf
                                  <div class="modal-body">
                                      <h3><p>Denunciar Comentario por:</p></h3><br>
                                      <h6>
                                          <label class="radio-custom">Conteúdo Inadequado
                                              <input type="radio" id="radio1" type="radio" name="option" value="3" required>
                                              <span class="checkmark"></span>
                                          </label>
                                          <label class="radio-custom">Spam
                                              <input type="radio" id="radio2" type="radio" name="option" value="1" required>
                                              <span class="checkmark"></span>
                                          </label>
                                          <label class="radio-custom">Copia
                                              <input type="radio" id="radio3" type="radio" name="option" value="2" required>
                                              <span class="checkmark"></span>
                                          </label>
                                      </h6>
                                      <input type="hidden" value="{{$comments['comentarios'][$v]->id_postagem}}" name="id_postagem">
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                          <input name="id_comentario" type="hidden" value="{{$comments['comentarios'][$v]->id_comentarios}}">
                                          <input name="id_usuario" type="hidden" value="<?php echo $user;?>">
                                          <button type="submit" class="btn btn-primary">Confirmar</button>
                                      </div> 
                                  </div>
                              </form>
                          </div>
                        </div>
                        <!-- FIM Modal denunciar comentario -->
                        @endif

                        @endfor  
                        
                        @for($r=0; $r<sizeof($comments['reply_coment']); $r++)

                          @if($comments['reply_coment'][$r]->id == $user)
                            <!--  Modal de edição de respostas de comentários -->
                            <div class="painel-dados">
                              <div class="modal fade id" id="popup{{$comments['reply_coment'][$r]->id_comentarios}}_edit" role="dialog">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body"> 
                                      <form action="{{ route('edit.coment') }}" method="POST"> 
                                        @csrf                   
                                        <div class="div-edit">
                                          <label style="vertical-align: top" for="editcomentario" class="bold subedit">Descrição:</label>
                                          <textarea name="editcomentario" id="edit_desc" cols="60" rows="1" required maxlength="255">{{$comments['reply_coment'][$r]->conteudo_comentarios }}</textarea>
                                          <input type="hidden" name="id_coment" value="{{ $comments['reply_coment'][$r]->id_comentarios }}">
                                          <input type="hidden" value="{{$comments['reply_coment'][$r]->id_postagem}}" name="id_postagem">
                                        </div>
                                      

                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                            <button data-toggle="modal" data-target="#hiddenDiv" type="submit" class="btn btn-primary">Salvar Alterações</button>
                                        
                                      </div> 
                                    </form> 

                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!--  Fim modal de edição de respostas de comentários -->

                            <!--  Modal para apagar subcomentários -->
                            <div class="painel-dados">
                              <div class="modal fade id" id="popup{{$comments['reply_coment'][$r]->id_comentarios}}_apagar1" role="dialog">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                    </div>
                                    <div class="modal-body"> 
                                      <p>Deseja realmente apagar este comentário?</p>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                        <form action="{{route('apagar-coment')}}" method="POST">
                                          @csrf
                                          <input name="id_comentario" type="hidden" value="{{ $comments['reply_coment'][$r]->id_comentarios }}">
                                          <input data-toggle="modal" type="submit" class="btn btn-primary dropright" value="Apagar comentário">
                                          <input type="hidden" value="{{$comments['reply_coment'][$r]->id_postagem}}" name="id_postagem">
                                        </form>
                                      </div> 
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!--  Modal para apagar subcomentários -->
                          
                            @elseif($comments['reply_coment'][$r]->id != $user)
                            <!-- Modal denunciar comentario Reply -->
                            <div class="modal fade id" id="den_comen_reply{{$comments['reply_coment'][$r]->id_comentarios }}" role="dialog">
                              <div class="modal-dialog modal-content">
                                  <div class="modal-header"></div>
                                  <form action="/denunciar_comentario" method="POST">
                                      @csrf
                                      <div class="modal-body">
                                          <h3><p>Denunciar Comentario por:</p></h3><br>
                                          <h6>
                                              <label class="radio-custom">Conteúdo Inadequado
                                                  <input type="radio" id="radio1" type="radio" name="option" value="3" required>
                                                  <span class="checkmark"></span>
                                              </label>
                                              <label class="radio-custom">Spam
                                                  <input type="radio" id="radio3" type="radio" name="option" value="1" required>
                                                  <span class="checkmark"></span>
                                              </label>
                                              <label class="radio-custom">Copia
                                                  <input type="radio" id="radio3" type="radio" name="option" value="2" required>
                                                  <span class="checkmark"></span>
                                              </label>
                                          </h6>
                                          <input type="hidden" value="{{$comments['reply_coment'][$r]->id_postagem}}" name="id_postagem">
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                              <input name="id_comentario" type="hidden" value="{{$comments['reply_coment'][$r]->id_comentarios }}">
                                              <input name="id_usuario" type="hidden" value="<?php echo $user;?>">
                                              <input data-toggle="modal" type="submit" class="btn btn-primary" value="Confirmar">
                                          </div> 
                                      </div>
                                  </form>
                              </div>
                          </div>
                          <!-- FIM Modal denunciar comentario reply -->
                          @endif
                        @endfor

                  @endforeach
                </tbody>
              </table>
            <!-- Fim da tabela de ideias -->

          </div>
          </div>
        @endif

      <!-- Fim área de ideias do usuario -->
    @if($nivel === 3)  
      </div>
    @endif
    <div class="tab-pane fade <?php if($nav_selected == '2'){ echo 'active show' ;} ?>" id="solicitacoes" role="tabpanel" aria-labelledby="solicitacoes-tab">

      <!-- Área de solicitações do usuário -->

      @if(empty($solicit[0]))
        <div id="area_ideias">

          <div class="scroll_table">
          <!-- Início da tabela de solicitações -->
          <table id="table_conta">
            <thead>
              <tr>
                <th>Situação</th>
              </tr>
            </thead>
            <tbody>  
              <tr>
                <td rowspan="10">
                  <div class="centralizar">
                    <p class="font-italic">Não foi enviada nenhuma solicitação</p>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <!-- Fim da tabela de solicitações -->
        </div>

      @else
        <div id="area_ideias">

          <div class="container mb-3">
            <div class="div_order">
              <form action="{{ route('order_solicit_perfil') }}" method="POST">
                @csrf
                  <p class="font-weight-bold m-0 p-1">
                    <svg width="1.6em" height="1.6em" viewBox="0 0 16 16" class="bi bi-filter-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M2 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                    </svg>&nbsp;
                    Ordenar por:
                  </p>
                  <select name="ordenar_solicit" onchange="this.form.submit()" class="custom-select select-order bg-transparent" title="Selecione uma opção">
                    @if($_SESSION['selected_solicit_perfil'] === '1')
                      <option value="Recentes">Recentes</option>
                      <option value="Aprovadas">Aprovadas</option>
                      <option value="Recusadas">Recusadas</option>
                      <option value="Pendentes">Pendentes</option>
                    @elseif($_SESSION['selected_solicit_perfil'] == '2')
                      <option value="Aprovadas">Aprovadas</option>
                      <option value="Recentes">Recentes</option>
                      <option value="Recusadas">Recusadas</option>
                      <option value="Pendentes">Pendentes</option>
                    @elseif($_SESSION['selected_solicit_perfil'] == '3')
                      <option value="Recusadas">Recusadas</option>
                      <option value="Recentes">Recentes</option>
                      <option value="Aprovadas">Aprovadas</option>
                      <option value="Pendentes">Pendentes</option>
                    @elseif($_SESSION['selected_solicit_perfil'] == '4')
                      <option value="Pendentes">Pendentes</option>
                      <option value="Recentes">Recentes</option>
                      <option value="Aprovadas">Aprovadas</option>
                      <option value="Recusadas">Recusadas</option>
                    @endif
                  </select>
                  <input type="hidden" name="nav_selected" value="2">
                  <input type="hidden" name="id_user" value="{{ $dados['id'] }}">
              </form>
            </div>
          </div>

          <div class="scroll_table">
            <table id="table_conta">
              <thead class="sticky-top">
                <tr>
                  <th>Tipo de pedido</th>
                  <th>Data</th>
                  <th>Situação</th>
                  <th>Detalhes</th>
                </tr>
              </thead>
              <tbody>
                @foreach($solicit as $solicitacoes)
                  <tr>
                    <td class="abreviar">{{ $solicitacoes->nome_tipo_solicitacao }}</td>
                    <td>{{ date('d/m/Y', strtotime($solicitacoes->data_solicitacao)) }}</td>
                    <td>{{ $solicitacoes->nome_status }}</td>
                    <td><a href="" data-toggle="modal" data-target="#solicitacao{{ $solicitacoes->id_solicitacao }}">Visualizar</a></td>
                  </tr> 

                  <!-- Modal para visualizar solicitação -->
                  <div class="modal fade id" id="solicitacao{{$solicitacoes->id_solicitacao}}" role="dialog">
                    <div class="modal-dialog modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Pedido</h5>
                      </div>
                      <div class="modal-body">
                        <p id="edit_desc">{{ $solicitacoes->conteudo_solicitacao }}</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                      </div> 
                    </div>
                  </div>
                  <!-- FIM Modal para visualizar solicitação -->
                @endforeach
              </tbody>
            </table>
            

          </div>
          <!-- Fim da tabela de ideias -->
        </div>
        @endif

      <!-- Fim área de solicitações do usuário -->

    </div>
  </div>
</div>
</div>

<!-- Área de edição de dados do usuário -->
@endsection