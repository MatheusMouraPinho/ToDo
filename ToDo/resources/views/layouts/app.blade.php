<?php 
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

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  <script src="https://kit.fontawesome.com/1618aca3df.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
  <script type="text/javascript" src="{{ asset('js/funcoes.js') }}"></script>

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
  <nav class="navbar navbar-expand-lg cor">
    <img width="6.6%" src="{{asset('img/ToDo.png')}}">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-md-center" id="navbarNavDropdown">
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
    <div>
  </nav> 
  <!--||Fim Nav bar||-->

  <div class="fundo">
    <!-- Puxa o arquivo home dentro da div-->
    <div class="flex justify-content-md-center">
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
                    <input type="file" name="img_post" id="file" accept="image/*" multiple onchange="javascript:update_file1()"/>
                    <a name="img_post" class="get-file">Adicionar Imagem</a>
                    <div class="file-name" id="file-name">File: Empty</div>
                  </label>
                </div>
                <div class="alinhamento-img2">
                  <label class="form-control-range">
                    <input type="file" name="img_post2" id="file2" accept="image/*" multiple onchange="javascript:update_file2()"/>
                    <a name="img_post" class="get-file">Adicionar Imagem</a>
                    <div class="file-name" id="file-name2">File: Empty</div>
                  </label>
                </div>
                <div class="alinhamento-img3">
                  <label class="form-control-range">
                    <input type="file" name="img_post3" id="file3" accept="image/*" multiple onchange="javascript:update_file3()"/>
                    <a name="img_post" class="get-file">Adicionar Imagem</a>
                    <div class="file-name" id="file-name3">File: Empty</div>
                  </label>
                </div>
              </div>
            </div>
            <div class="modal-footer-custom grey">
              <input type='hidden' name="id_usuario" value="<?php echo $id_user ?>"/>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Enviar Ideia</button><br>
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