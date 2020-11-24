@extends('layouts.app')
<?php
session_start();
use Symfony\Component\Console\Input\Input;

$nivel = Auth::user()->nivel;
$user = Auth::user()->id;

if($dados['show_registro'] === 1) {
  $checked = "checked";
} else {
  $checked = null;
}

if($dados['show_email'] === 1) {
  $checked_email = "checked";
} else {
  $checked_email = null;
}

if(NULL !== Session::get('filtro_coment')){$_SESSION['filtro_coment'] = Session::get('filtro_coment');}
if(isset($_SESSION['filtro_coment'])){$filtro_coment = $_SESSION['filtro_coment'];}
if(!isset($filtro_coment)){$filtro_coment = "data_comentarios";}


if(NULL !== Session::get('selected')){$_SESSION['selected'] = Session::get('selected');}
if(isset($_SESSION['selected'])){$selected = $_SESSION['selected'];}
if(!isset($selected)){$selected = "1";}

if(Session::get('nav_selected') !== NULL){$nav_selected = Session::get('nav_selected');}
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

$posts = Helper::ordenar_post();
$solicit = Helper::ordenar_solicit();

?>
@section('content')

        @if(session('success'))
          <div class="alert alert-success alert-dismissible">
            <button class="close mt-0" type="button" data-dismiss="alert">&times;</button>
            {{ session('success') }}
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible">
            <button class="close mt-0" type="button" data-dismiss="alert">&times;</button>
            {{ session('error') }}
          </div>
        @endif

<div class="flex justify-content-md-center">
      <div id="area_principal">
        <div id="area_capa">
          @if($dados['img_capa'] === null)
            <img id="img_capa" src="{{asset('img/fundo_azul.jpg')}}">
          @else
            <img id="img_capa" src="{{url('ToDo/storage/app/public/users_capa/'.Auth::user()->img_capa)}}">
          @endif
        </div>

        <!--||Área de dados do usuário||-->
        <div id="area-dados">
          <div class="card-body text-center">
              
              @if($dados['img_perfil'] === null)
                <img width="150px" class="img-dados" id="img_user" src="{{asset('img/semuser.png')}}">
              @else
                <img  alt="{{ Auth::user()->img_usuarios }}" id="img_user" name="img_usuarios" class="img-dados" src="{{url('ToDo/storage/app/public/users/'.Auth::user()->img_usuarios)}}">
              @endif

            <h3 style="font-weight: bold;">{{ $dados['nome'] }}</h3>
            
            <p>{{ $dados['email'] }}</p>
            <a class="edit_perfil" href="" data-toggle="modal" onclick="modal()" data-target="#popup{{$dados['id'] }}">
              <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
              </svg>&nbsp;
               Editar perfil
              </a>
            
              <div id="conteudo-dados">
                {{-- <div id="info_rgm" style="display: none">
                  <p class="bg-dark text-center text-light p-1 m-0 rounded">
                    Seu RGM/CPF está oculto para outros usuários
                  </p>
                </div> --}}
                <div class="dados-pessoais">
                  <p style="padding: 5px; margin: 0px;">
                    <span class="type_data">
                    <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-person" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                    </svg>&nbsp;
                    @if($dados['rgm'] != null)
                      RGM/CPF:</span> {{ $dados['rgm'] }}
                    @else
                      RGM/CPF: </span> <i>Não definido</i>
                    @endif
                    {{-- <span class="float-right mt-1">
                    <svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-info-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                    </svg>
                    </span> --}}
                  </p>
                </div>

                <div class="dados-pessoais">
                  <p style="padding: 5px; margin: 0px;">
                    <span class="type_data">
                    <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-envelope" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/>
                    </svg>&nbsp;
                    E-mail:</span> {{ $dados['email'] }}
                  </p>
                </div>

                @if(is_null($dados['telefone']))
                  <div class="dados-pessoais">
                    <p style="padding: 5px; margin: 0px;">
                      <span class="type_data">
                      <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-telephone" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                      </svg>&nbsp;
                      Telefone/Celular:</span> <span class="font-italic">Não definido</span>
                    </p>
                  </div>
                @else 
                  <div class="dados-pessoais">
                    <p id="telefone" style="padding: 5px; margin: 0px;">
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
                      Instituição de Ensino:</span> <span class="font-italic">Não definido</span>
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
                      Curso:</span> <span class="font-italic">Não definido</span>
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
                      Região:</span> <span class="font-italic">Não definido</span>
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
            <ul class="nav nav-tabs mt-4 font-weight-bolder justify-content-start ml-auto mr-auto" style="font-size: 1.4em; width: 95%" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link <?php if($nav_selected == 1){ echo 'active' ;} ?>" id="ideias-tab" data-toggle="tab" href="#ideias" role="tab" aria-controls="ideias" aria-selected="<?php ($nav_selected == 1) ? 'True' : 'False' ;?>">Ideias</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link <?php if($nav_selected == '2'){ echo 'active' ;} ?>" id="solicitacoes-tab" data-toggle="tab" href="#solicitacoes" role="tab" aria-controls="solicitacoes" aria-selected="<?php ($nav_selected == '2') ? 'True' : 'False' ;?>">Solicitações</a>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade <?php if($nav_selected == 1){ echo 'active show' ;} ?>" id="ideias" role="tabpanel" aria-labelledby="ideias-tab">

                
                  <div class="container mt-2 pl-3 w-100">
                      <div class="div_order">
                        <form action="{{ route('order_post') }}" method="POST">
                          @csrf
                            <p class="font-weight-bold m-0 p-1">
                              <svg width="1.6em" height="1.6em" viewBox="0 0 16 16" class="bi bi-filter-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M2 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                              </svg>&nbsp;
                              Ordenar por:
                            </p>
                            <select name="ordenar_post" onchange="this.form.submit()" class="custom-select select-order bg-transparent" title="Selecione uma opção">
                              @if($_SESSION['selected_post'] == '1')
                                <option value="Recentes">Recentes</option>
                                <option value="Populares">Populares</option>
                                <option value="Avaliados">Avaliados</option>
                                <option value="Pendentes">Pendentes</option>
                              @elseif($_SESSION['selected_post'] == '2')
                                <option value="Populares">Populares</option>
                                <option value="Recentes">Recentes</option>
                                <option value="Avaliados">Avaliados</option>
                                <option value="Pendentes">Pendentes</option>
                              @elseif($_SESSION['selected_post'] == '3')
                                <option value="Avaliados">Avaliados</option>
                                <option value="Recentes">Recentes</option>
                                <option value="Populares">Populares</option>
                                <option value="Pendentes">Pendentes</option>
                              @elseif($_SESSION['selected_post'] == '4')
                                <option value="Pendentes">Pendentes</option>
                                <option value="Recentes">Recentes</option>
                                <option value="Populares">Populares</option>
                                <option value="Avaliados">Avaliados</option>
                              @endif
                            </select>
                        </form>
                      </div>
                    <button class="btn btn-light ml-0 btn_create" data-toggle="modal" data-target="#modalideia"><span style="font-size: 1.4em">+</span> Criar Ideia</button>
                  </div>
                
                <!-- Área de ideias do usuario -->
                @if(empty($posts[0]))
                  <div id="area_ideias">

                    <!-- Início da tabela de ideias -->
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
        
                    <div class="scroll_table">
                      <table id="table_conta">
                        <thead class="">
                          <tr>
                            <th>Título</th>
                            <th>Data</th>
                            <th>Situação</th>
                            <th>Opções</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $i = 0?>            
                          @foreach($posts as $posts)
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
                                    <a class="dropdown-item" href="" data-toggle="modal" onclick="modal({{ $posts->id_postagem }})" data-target="#popup{{$posts->id_postagem }}">
                                      <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                                        <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                                      </svg>&nbsp;
                                      Visualizar postagem
                                    </a>
                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#del-post{{$posts->id_postagem}}">
                                      <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                      </svg>&nbsp;
                                      Apagar postagem
                                    </a>
                                  </div>
                                </div>
                                
                              </td>
                              </tr> 
                            
                              @include('layouts.post_conta')
        
                              <!-- Modal deletar postagem -->
                              <div class="modal fade id" id="del-post{{$posts->id_postagem}}" role="dialog">
                                <div class="modal-dialog modal-content">
                                    <div class="modal-header"></div>
                                    <div class="modal-body">
                                    <h5><b><p>Deseja realmente apagar essa Postagem?</p></b><h5>
                                        <div class="modal-footer">
                                            <form action="{{url('apagar_post')}}" method="POST">
                                                @csrf
                                                <input name="id_postagem" type="hidden" value="{{$posts->id_postagem}}">
                                                <input type="hidden" name="identificador" value="1">
                                                <input type="hidden" name="filename" value="<?php echo $posts->id_postagem. $posts->titulo_postagem; ?>">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Confirmar</button>
                                            </form>
                                        </div> 
                                    </div>
                                </div>
                              </div>
                              <!-- FIM Modal deletar postagem -->
        
                          @endforeach
                        </tbody>
                      </table>
        
                      
        
                    </div>
                    <!-- Fim da tabela de ideias -->
        
                    {{-- <div class="" style="padding: 8px">
                      <p id="contagem-ideias">
                        {{ $dados['posts']->links() }}
                      </p>
                    </div> --}}
                  </div>
                @endif
        
              <!-- Fim área de ideias do usuario -->

              </div>
              <div class="tab-pane fade <?php if($nav_selected == '2'){ echo 'active show' ;} ?>" id="solicitacoes" role="tabpanel" aria-labelledby="solicitacoes-tab">

                <div class="container mt-2">
                  <div class="div_order">
                    <form action="{{ route('order_solicit') }}" method="POST">
                      @csrf
                        <p class="font-weight-bold m-0 p-1">
                          <svg width="1.6em" height="1.6em" viewBox="0 0 16 16" class="bi bi-filter-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M2 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                          </svg>&nbsp;
                          Ordenar por:
                        </p>
                        <select name="ordenar_solicit" onchange="this.form.submit()" class="custom-select select-order bg-transparent" title="Selecione uma opção">
                          @if($_SESSION['selected_solicit'] === '1')
                            <option value="Recentes">Recentes</option>
                            <option value="Aprovadas">Aprovadas</option>
                            <option value="Recusadas">Recusadas</option>
                            <option value="Pendentes">Pendentes</option>
                          @elseif($_SESSION['selected_solicit'] == '2')
                            <option value="Aprovadas">Aprovadas</option>
                            <option value="Recentes">Recentes</option>
                            <option value="Recusadas">Recusadas</option>
                            <option value="Pendentes">Pendentes</option>
                          @elseif($_SESSION['selected_solicit'] == '3')
                            <option value="Recusadas">Recusadas</option>
                            <option value="Recentes">Recentes</option>
                            <option value="Aprovadas">Aprovadas</option>
                            <option value="Pendentes">Pendentes</option>
                          @elseif($_SESSION['selected_solicit'] == '4')
                            <option value="Pendentes">Pendentes</option>
                            <option value="Recentes">Recentes</option>
                            <option value="Aprovadas">Aprovadas</option>
                            <option value="Recusadas">Recusadas</option>
                          @endif
                        </select>
                        <input type="hidden" name="nav_selected" value="2">
                    </form>
                  </div>
                  <button class="btn btn-light btn_create" data-toggle="modal" data-target="#new_solicitacao"><span style="font-size: 1.4em">+</span> Nova Solicitação</button>
                </div>

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

      <!-- Área de edição de dados do usuário -->

      <!-- Modal de solicitação -->
      <div class="modal fade" id="new_solicitacao" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Solicitação</h5>
            </div>
            <form action="{{ url('solicitacao') }}" method="POST">
              @csrf
              <div class="modal-body">
                <div class="container w-100 mb-3 p-0">
                  <p class="font-weight-bold m-0 p-1">
                    <svg width="1.4em" height="1.4em" viewBox="0 0 16 16" class="bi bi-sliders" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3h9.05zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8h2.05zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1h9.05z"/>
                    </svg>&nbsp;
                    Tipo de Solicitação:
                  </p>
                  <select name="motivo" class="custom-select bg-transparent" title="Selecione uma opção" required>
                    <option value="">Selecione uma opção</option>
                    <option value="1">Alterar Acesso</option>
                    <option value="2">Deletar Conta</option>
                    <option value="3">Outros</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="conteudo_solicitacao">Descrição:</label>
                  <textarea class="form-control" name="conteudo_solicitacao" id="conteudo_solicitacao" rows="3" required></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <input type="hidden" name="id_usuario" value="{{ $user }}">
                <input type="button" class="btn btn-secondary" value="Cancelar" data-dismiss="modal">
                <input type="hidden" name="nav_selected" value="2">
                <input type="submit" class="btn btn-primary" value="Enviar">
              </div>
            </form>

          </div>                
        </div>
      </div>
      <!-- FIM Modal de solicitação -->
          
      <div class="painel-dados">
        <div class="modal fade id" id="popup{{$dados['id']}}" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header m-0" style=" border-bottom: none">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body m-0 p-0">
                <form action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                      <div id="area_capa_edit">
                        @if($dados['img_capa'] === null)
                          <img id="img_capa" src="{{asset('img/fundo_azul.jpg')}}">
                        @else
                          <img id="img_capa" src="{{url('/ToDo/storage/app/public/users_capa/'.Auth::user()->img_capa)}}">
                        @endif
                      </div>

                      <div class="area_dados_edit">
                        <div class="img_perfil">
                          <div class="perfil">
                            @if($dados['img_perfil'] === null)
                              <img width="150px" name="img_usuarios" class="img" src="{{asset('img/semuser.png')}}">  
                            @else
                              <img width="200px" alt="{{ Auth::user()->img_usuarios }}" name="img_usuarios" class="img" src="{{url('/ToDo/storage/app/public/users/'.Auth::user()->img_usuarios)}}">
                            @endif
                            <div class="dropdown div_icon">
                              <button class="btn btn-secondary dropdown-toggle icon_cam" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      
                                <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-camera-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                  <path fill-rule="evenodd" d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z"/>
                                </svg>
  
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <label class="d-block">
                                  <input name="img_usuarios" id="img_usuarios" type="file" style="display: none; cursor:pointer" accept="image/*">
                                  <a name="img_usuarios" id="img_usuarios" class="dropdown-item">
                                    <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-file-person" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd" d="M12 1H4a1 1 0 0 0-1 1v10.755S4 11 8 11s5 1.755 5 1.755V2a1 1 0 0 0-1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
                                      <path fill-rule="evenodd" d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    </svg>&nbsp;
                                    Alterar foto de perfil
                                  </a>
                                </label>
                                <label class="d-block">
                                  <input name="img_capa" type="file" id="imgs_capa" style="display: none; cursor: pointer;" accept="image/*">
                                  <a name="img_capa" class="dropdown-item">
                                    <svg width="1.2em" height="1.2em" viewBox="0 0 17 16" class="bi bi-image" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd" d="M14.002 2h-12a1 1 0 0 0-1 1v9l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094L15.002 9.5V3a1 1 0 0 0-1-1zm-12-1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm4 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                    </svg>&nbsp;
                                    Alterar foto da capa
                                  </a>
                                </label>
                                <div class="dropdown-divider"></div>
                                <label class="d-block">
                                  <a class="dropdown-item" href="{{route('remove_perfil')}}">
                                    <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                                    </svg>&nbsp;
                                    Remover foto de perfil
                                  </a>
                                </label>
                                <label class="d-block">
                                  <a class="dropdown-item" href="{{route('remove_capa')}}">
                                    <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                      <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                      <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>&nbsp;
                                    Remover foto da capa
                                  </a>
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>                
                        <div class="centralizar">
                          <div class="popup-title">
                            <label for="registro" class="bold subdados">
                              <svg width="1.4em" height="1.4em" viewBox="0 0 16 16" class="bi bi-hash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.39 12.648a1.32 1.32 0 0 0-.015.18c0 .305.21.508.5.508.266 0 .492-.172.555-.477l.554-2.703h1.204c.421 0 .617-.234.617-.547 0-.312-.188-.53-.617-.53h-.985l.516-2.524h1.265c.43 0 .618-.227.618-.547 0-.313-.188-.524-.618-.524h-1.046l.476-2.304a1.06 1.06 0 0 0 .016-.164.51.51 0 0 0-.516-.516.54.54 0 0 0-.539.43l-.523 2.554H7.617l.477-2.304c.008-.04.015-.118.015-.164a.512.512 0 0 0-.523-.516.539.539 0 0 0-.531.43L6.53 5.484H5.414c-.43 0-.617.22-.617.532 0 .312.187.539.617.539h.906l-.515 2.523H4.609c-.421 0-.609.219-.609.531 0 .313.188.547.61.547h.976l-.516 2.492c-.008.04-.015.125-.015.18 0 .305.21.508.5.508.265 0 .492-.172.554-.477l.555-2.703h2.242l-.515 2.492zm-1-6.109h2.266l-.515 2.563H6.859l.532-2.563z"/>
                              </svg>&nbsp;
                              RGM/CPF:
                            </label>
                            <input type="text" class="btn-popup" value="{{ Auth::user()->registro }}" name="registro" placeholder="Ex: 1234567-8">
                            <div class="show_infos text-left">
                              <input class="form-check-input" name="show_registro" type="checkbox" value="1" id="show_registro" <?php echo $checked ?>>
                              <label class="form-check-label" for="show_registro">
                                Mostrar para todos usuários
                              </label>
                              <button type="button" id="tooltip" class="bg-transparent border-0 p-0 m-0">
                                <svg width="1.1em" height="1.1em" viewBox="0 0 16 16" class="bi bi-question-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z"/>
                                </svg>
                              </button>
                            </div>
                          </div>

                          <div class="popup-title">
                            <label for="registro" class="bold subdados">
                              <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-envelope" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/>
                              </svg>&nbsp;
                              E-mail:
                            </label>
                            <input type="text" class="btn-popup" name="email" value="{{ Auth::user()->email }}" placeholder="" readonly>
                            <div class="show_infos p-0 text-left">
                              <input class="form-check-input" name="show_email" type="checkbox" value="1" id="show_email" <?php echo $checked_email ?>>
                              <label class="form-check-label" for="show_email">
                                Mostrar para todos usuários
                              </label>
                            </div>
                          </div>

                          <div class="popup-title">
                            <label for="usuario" class="bold subdados">
                              <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-person" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                              </svg>&nbsp;
                              Usuário: 
                            </label>
                            <input type="text" class="btn-popup wd-sm-100" maxlength="50" value="{{ Auth::user()->usuario }}" placeholder="Usuário" name="usuario">
                          </div>

                          <div class="popup-title">
                            <label for="senha" class="bold subdados">
                              <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-key" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z"/>
                                <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                              </svg>&nbsp;
                              Senha:
                            </label>
                            <input type="password" class="btn-popup" value="{{ Auth::user()->senha }}" name="senha" placeholder="Senha" readonly>
                            <div class="div_pass">
                              <a href="{{ url('/password/reset') }}" class="password">Alterar senha</a>
                            </div>
                          </div>

                          <div class="popup-title">
                            <label for="telefone_usuario" class="bold subdados ">
                              <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-telephone" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                              </svg>&nbsp;
                              Celular:
                            </label>
                            <input onkeypress="return onlynumber();" minlength="10" maxlength="11" id="telefone_usuario" value="{{ Auth::user()->telefone_usuario }}" type="text" class="btn-popup phones" name="telefone_usuario" placeholder="Ex: (11) 11111-1111"/>
                          </div>

                          <div class="popup-title">
                            <label for="id_instituicao" class="bold subdados">
                              <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-building" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694L1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                                <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                              </svg>&nbsp;
                              Instituição:
                            </label>
                            <select name="id_instituicao" class="select" title="Selecione uma opção">
                            @if(isset($dados['instituicao']))
                              <option value="">{{ $dados['instituicao'] }}</option>
                            @else
                              <option value="">Selecione uma opção</option>
                            @endif
                              @for($a = 0; $a<sizeof($dados['instituicoes']);$a++)
                                <option value="{{ $dados['instituicoes'][$a]->id_instituicao }}">
                                  {{ $dados['instituicoes'][$a]->nome_instituicao }}
                                </option>
                              @endfor
                            </select>
                          </div>

                          <div class="popup-title">
                            <label for="id_area" class="bold subdados">
                              <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-book" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M1 2.828v9.923c.918-.35 2.107-.692 3.287-.81 1.094-.111 2.278-.039 3.213.492V2.687c-.654-.689-1.782-.886-3.112-.752-1.234.124-2.503.523-3.388.893zm7.5-.141v9.746c.935-.53 2.12-.603 3.213-.493 1.18.12 2.37.461 3.287.811V2.828c-.885-.37-2.154-.769-3.388-.893-1.33-.134-2.458.063-3.112.752zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                              </svg>&nbsp;
                              Curso:
                            </label>
                            <select name="id_area" class="select" title="Selecione uma opção" class="btn btn-primary">
                              
                              @if(isset($dados['area']))
                                <option value="">{{$dados['area']}}</option>
                              @else
                                <option value="">Selecione uma opção</option>
                              @endif
                              
                                @for($a = 0; $a<sizeof($dados['areas']);$a++)
                                  <option value="{{ $dados['areas'][$a]->id_area }}">
                                    {{ $dados['areas'][$a]->nome_area }}
                                  </option>
                                @endfor
                            </select>
                          </div>
                          <div class="popup-title">
                            <label for="id_regiao_cidade" class="bold subdados">
                              <img src="img/mapa.png" width="20px" alt="">&nbsp;
                              Estado:
                            </label>
                            <select id="id_regiao_estado" name="id_regiao_estado" class="select" title="Selecione uma opção" onchange="buscar_cidades()">
                              @if(isset($dados['cidade']))
                                <option value="">{{$dados['estado'][0]->nome_estado}}</option>
                              @else
                                <option value="">Selecione uma opção</option>
                              @endif
                              
                              @for($a = 0; $a<sizeof($dados['estados']);$a++)
                                <option value="{{ $dados['estados'][$a]->id_regiao_estado }}">
                                  {{ $dados['estados'][$a]->nome_estado }}
                                </option>
                              @endfor
                            </select>
                          </div>

                          <div class="popup-title">
                            <label for="id_regiao_cidade" class="bold subdados">
                              <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-geo-alt" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M12.166 8.94C12.696 7.867 13 6.862 13 6A5 5 0 0 0 3 6c0 .862.305 1.867.834 2.94.524 1.062 1.234 2.12 1.96 3.07A31.481 31.481 0 0 0 8 14.58l.208-.22a31.493 31.493 0 0 0 1.998-2.35c.726-.95 1.436-2.008 1.96-3.07zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                <path fill-rule="evenodd" d="M8 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                              </svg>&nbsp;
                              Cidade:
                            </label>
                            <select id="id_regiao_cidade" name="id_regiao_cidade" class="select" title="Selecione uma opção">
                              @if(isset($dados['cidade']))
                                <option value="">{{$dados['cidade']}}</option>

                                @for($a = 0; $a<sizeof($dados['cidades']);$a++)
                                  <option value="{{ $dados['cidades'][$a]->id_regiao_cidade }}">
                                    {{ $dados['cidades'][$a]->nome_cidade }}
                                  </option>
                                @endfor
                              @else
                                <option value="">Selecione uma opção</option>
                              @endif
                              
                               --}}
                            </select>
                          </div>
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


<div class="modal fade" id="modal_cropp_perfil" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="background-color: rgb(0, 0, 0, .7);">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Cortar Imagem</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="img-container mr-auto ml-auto">
              <div class="row">
                  <div class="div_cropp mr-auto ml-auto" style="max-height: 300px; max-width: 500px">
                      <img src="" class="img_cropp" id="sample_image" />
                  </div>
                  <div class="col-lg-4 col-12 mt-1">
                      <div class="preview"></div>
                  </div>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" id="crop" class="btn btn-primary">Cortar e Enviar</button>
        </div>
    </div>
  </div>
</div>			

<div class="modal fade" id="modal_cropp_capa" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="modalLabel" aria-hidden="true" style="background-color: rgb(0, 0, 0, .7);">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Cortar Imagem</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="img-container ml-auto mr-auto">
              <div class="row align-items-center justify-content-center">
                <div class="div_cropp">
                    <img src="" style="border-radius: 10px" class="img_cropp" id="sample_image_capa" />
                </div>
              </div>
              <div class="row align-items-center justify-content-center">
                <div class="col-12">
                <div class="preview_capa" style=" @media(max-width: 400px) {max-width: 300px}"></div>
                </div>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" id="crop_capa" class="btn btn-primary">Cortar e Enviar</button>
        </div>
    </div>
  </div>
</div>
@endsection

<script>
  function autoResize()
    {
        objTextArea = document.getElementById('txtTextArea');
        while (objTextArea.scrollHeight > objTextArea.offsetHeight)
        {
            objTextArea.rows += 1;
        }
        while (objTextArea.scrollHeight < objTextArea.offsetHeight) {
            objTextArea.rows -= 1;
        }
    }
</script>