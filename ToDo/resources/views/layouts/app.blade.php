<?php
Artisan::call('route:clear');
Artisan::call('view:clear');
Artisan::call('cache:clear');

$nivel = Auth::user()->nivel; 
$id_user = Auth::user()->id;
$denuncia = Session::get('denuncia');
?>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>ToDo Ideias</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  <script src="https://kit.fontawesome.com/1618aca3df.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
  <script type="text/javascript" src="{{ asset('js/funcoes.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  <link rel="shortcut icon" href="img/img_ToDo.png" type="img/x-icon" />

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/estilo.css') }}" rel="stylesheet">
  <link href="{{ asset('css/estilo2.css') }}" rel="stylesheet">
</head>
<body>
  <!-- ||Nav Bar||  -->
<<<<<<< Updated upstream
  <nav class="navbar navbar-light cor">
    <ul class="navbar-nav" style="cursor: pointer">
      <li>
        <a href="{{ url('home') }}"> <img width="110px" src="{{asset('img/ToDo.png')}}"> </a>
      </li>
    </ul>
    <ul class="nav ml-auto" style="cursor: pointer">
      <li style="margin-right:22px" class="nav-item dropdown">
        <a id="navbarDropdown" role="button" data-toggle="dropdown"> <img src="{{asset('img/op-icon.png')}}" width="110px"> </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php if(3 == $nivel){?>
          <a class="dropdown-item" href="{{ url('adm') }}">
            <svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-clipboard-data" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
              <path fill-rule="evenodd" d="M9.5 1h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
              <path d="M4 11a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0v-1zm6-4a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0V7zM7 9a1 1 0 0 1 2 0v3a1 1 0 1 1-2 0V9z"/>
            </svg>&nbsp Painel Admin
          </a>
          <?php }?>
          <a class="dropdown-item" data-toggle="modal" data-target="#modalideia">
            <svg width="1.4em" height="1.4em" viewBox="0 0 16 16" class="bi bi-plus-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
            </svg>&nbsp Criar ideia
          </a>
          <a class="dropdown-item" href="{{ url('home') }}">
            <svg width="1.4em" height="1.4em" viewBox="0 0 16 16" class="bi bi-house-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M8 3.293l6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
              <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
            </svg>&nbsp Inicio
          </a>
          <a class="dropdown-item" href="{{ url('conta') }}">
            <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-person-lines-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7 1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm2 9a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
            </svg>&nbsp Perfil
          </a>
          <a class="dropdown-item" href="{{ url('logout') }}">
            <svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-box-arrow-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
              <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
            </svg>&nbsp Sair
          </a>
      </li>
    </ul>
=======
  <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <img width="6.6%" src="{{asset('img/ToDo.png')}}">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="nav navbar-nav ml-auto">
        <li style="padding-right:22px" class="nav-item active">
          <div class="form-inline my-2 my-lg-0">
            <a class="btn btn-primary my-2 my-sm-0"  href="{{ url('home') }}">Início</a>
          </div>
        </li>
        <li style="padding-right:25px" class="nav-item">
          <form class="form-inline my-2 my-lg-0" method="POST" action="{{url('pesquisa')}}">
            @csrf
            <input class="form-control mr-sm-2" type="text" name="pesquisa" placeholder="Procure pelo nome da postagem ou autor" aria-label="Search" style="width: 440px">
            <button class="btn btn-primary my-2 my-sm-0" type="submit">Procurar</button>
          </form>
        </li>
        <li class="nav-item">
          <button class="btn btn-primary my-2 my-sm-0" data-toggle="modal" data-target="#modalideia">Criar uma Ideia</button>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto" style="cursor: pointer">
        <li style="margin-right:20px" class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Configurações </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php if(3 == $nivel){?>
            <a class="dropdown-item" href="{{ url('adm') }}">Admin Painel</a>
            <?php }?>
            <a class="dropdown-item" href="{{ url('conta') }}">Minha conta</a>
            <a class="dropdown-item" href="{{ url('logout') }}"> Sair </a>
          </div>
        </li>
      </ul>
>>>>>>> Stashed changes
  </nav>
  <!--||Fim Nav bar||-->

  <div class="fundo" style="background-color: #E5E5E5">
    <!-- Puxa o arquivo home dentro da div-->
    <div class="justify-content-md-center">
    <br>
    @yield('content')
    </div>
    <!-- Footer -->
    <footer class="layout-footer space">
      <div class="container text-center text-md-left mt-5">
        <div class="row mt-3">
          <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-5">
            <h6 class="text-uppercase font-weight-bold"><ff>Desenvolvimento</ff></h6>
            <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto white" style="width: 160px;">
            <p>Site desenvolvido por <br> alunos da Universidade <br> Módulo - Campus <br> Módulo Caraguatatuba, <br> Ministrado pelo Professor<br> Fabio Lippi.
            </p>
          </div>
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4" style="padding-right:20px">
            <h6 class="text-uppercase font-weight-bold"><ff>RGM</ff></h6>
            <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto white" style="width: 40px;">
              <p>20867000</p>
              <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto white" style="width: 80px;">
              <p>20541929</p>
              <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto white" style="width: 80px;">
              <p>22132066</p>
              <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto white" style="width: 80px;">
              <p>20530625</p>
          </div>
          <div class="col-md-3 col-lg-2 col-xl-3 mx-auto mb-4" style="padding-right:10px">
            <h6 class="text-uppercase font-weight-bold"><ff>Integrantes</ff></h6>
            <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto white" style="width: 120px;">
              <p>Matheus Moura Pinho</p>
              <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto white" style="width: 150px;">
              <p>Vinicius Vieira Pereira</p>
              <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto white" style="width: 150px;">
              <p>Jonathan Gonçalves Dias</p>
              <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto white" style="width: 150px;">
              <p>Mauricio Freire da Silva</p>
          </div>
          <div class="col-md-4 col-lg-3 col-xl-4 mx-auto mb-md-0 mb-4">
            <h6 class="text-uppercase font-weight-bold"><ff>Contatos</ff></h6>
            <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto white" style="width: 90px;">
              <p>Matheusmpinho@outlook.com</p>
              <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto white" style="width: 200px;">
              <p>vinicius_vieira_pereira@hotmail.com</p>
              <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto white" style="width: 200px;">
              <p>jonathangoncalves.dias2001@gmail.com</p>
              <hr class="accent-2 mb-3 mt-0 d-inline-block mx-auto white" style="width: 200px;">
              <p>mauriciofreire520@gmail.com</p>
          </div>
        </div>
      </div>
    </footer>
    <div class="space2">
        <div class="footer-copyright text-center py-3">© 2020 ToDoIdeias.gq All Rights Reserved</div>
    </div>
    <!-- FIM Footer -->
    <!--Modal Criação post-->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modalideia" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{url('cria')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body texture">
              <div class="row">
              </div><br><br>
              <div class="row">
                <div class="alinhamento">
                  <label><h5><b>Titulo:</b></h5></label>
                  <input type="text" name="titulo" placeholder="Digite aqui..." required>
                  &nbsp;
                  <label><h5><b>Categoria:</b></h5></label>
                  <select class="Bselect" type="text" name="categoria" required> 
                    <option value="" disabled selected> Selecionar categoria </option>
                    <option value="1"> Web, Mobile & Software </option>
                    <option value="2"> Design & Criação </option>
                    <option value="3"> Engenharia & Arquitetura </option>
                    <option value="4"> Marketing </option>
                    <option value="5"> Outros </option>
                  </select>
                </div>
              </div><br><br>
              <div class="row">
                <div class="alinhamento">
                  <h5><b>Descrição:</b></h5>
                  <textarea class="descricao" type="text" placeholder="Digite aqui..."  name="descricao" cols="60" rows="7" required></textarea>
                </div>
              </div><br>
              <div class="row">
                <div class="alinhamento-img">
                  <label class="form-control-range">
                    <input type="file" name="img_post" id="file" accept="image/jpeg, image/png" multiple onchange="javascript:update_file1()"/>
                    <a name="img_post" class="get-file">Adicionar Imagem</a>
                    <div class="file-name" id="file-name">File: Empty</div>
                  </label>
                </div>
                <div class="alinhamento-img2">
                  <label class="form-control-range">
                    <input type="file" name="img_post2" id="file2" accept="image/jpeg, image/png" multiple onchange="javascript:update_file2()"/>
                    <a name="img_post" class="get-file">Adicionar Imagem</a>
                    <div class="file-name" id="file-name2">File: Empty</div>
                  </label>
                </div>
                <div class="alinhamento-img3">
                  <label class="form-control-range">
                    <input type="file" name="img_post3" id="file3" accept="image/jpeg, image/png" multiple onchange="javascript:update_file3()"/>
                    <a name="img_post" class="get-file">Adicionar Imagem</a>
                    <div class="file-name" id="file-name3">File: Empty</div>
                  </label>
                </div>
              </div>
              <div class="modal-footer">
                <input type='hidden' name="id_usuario" value="<?php echo $id_user ?>"/>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Enviar Ideia</button><br>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- FIM Modal Criação post-->
  </div>
  <script>
    function update_file1() {
      var input = document.getElementById('file'); //define o id do input
      var infoArea = document.getElementById( 'file-name' );//define o id do resutado do script
      var fileName = input.files[0].name; //nome do arquivo que foi selecionado no input
      infoArea.textContent = 'File: ' + fileName; //define infoArea como texto que recebe fileName
    }
    function update_file2() {
      var input = document.getElementById('file2');
      var infoArea = document.getElementById( 'file-name2' );
      var fileName = input.files[0].name;
      infoArea.textContent = 'File: ' + fileName;
    }
    function update_file3() {
      var input = document.getElementById('file3');
      var infoArea = document.getElementById( 'file-name3' ); 
      var fileName = input.files[0].name;
      infoArea.textContent = 'File: ' + fileName;
    }
  </script>
<!-- Modal notificação denuncia -->
<div class="modal fade id" id="denuncia" role="dialog">
    <div class="modal-dialog modal-content">
        <div class="modal-header" style="color:white;"> <b>Aviso</b> </div>
        <div class="modal-body">
                <h4><?php if($denuncia == 1){ echo "<b> Denuncia efetuada </b>"; }else{echo "<b> Esta postagem ja foi denúnciada </b>";}?></h4><br>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div> 
        </div>
    </div>
</div>
<!-- FIM Modal notificação denuncia -->
<?php
if(isset($denuncia)){ ?>
    <script>
        $(function(){
            $("#denuncia").modal('show');
        });
    </script>
<?php } ?>
</body>
</html>
