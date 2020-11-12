<?php
Artisan::call('route:clear');
Artisan::call('view:clear');
Artisan::call('cache:clear');

$nivel = Auth::user()->nivel; 
$id_user = Auth::user()->id;
$denuncia = Session::get('denuncia');

$db_config = Config::get('database.connections.'.Config::get('database.default'));
$conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
mysqli_set_charset($conn, 'utf8');

$user = Auth::user()->id;

$sql = "SELECT * FROM usuarios WHERE id = $user ";
$resultado = mysqli_query($conn, $sql);

$sql22 = "SELECT COUNT(id_notificacao) FROM notificacoes WHERE usuario_notificacao = $user AND visu_notificacao = 0 ";
$res22 = mysqli_query($conn, $sql22);
$notificacao = mysqli_fetch_array($res22);

$sql23 = "SELECT * FROM notificacoes WHERE usuario_notificacao = $user AND visu_notificacao = 0 LIMIT 10";
$res23 = mysqli_query($conn, $sql23);
?>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">

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
	<script src="https://unpkg.com/dropzone"></script>
	<script src="https://unpkg.com/cropperjs"></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  <link rel="shortcut icon" href="img/img_ToDo.png" type="img/x-icon" />
  <link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
  <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
  

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/estilo.css') }}" rel="stylesheet">
  <link href="{{ asset('css/estilo2.css') }}" rel="stylesheet">
</head>
<body>
  <!-- ||Nav Bar||  -->
  <nav class="navbar navbar-light cor">
    <ul class="navbar-nav" style="cursor: pointer">
      <li>
        <a href="{{ url('home') }}"> <img class="nav_icon" src="{{asset('img/ToDo.png')}}"> </a>
      </li>
    </ul>
    <ul class="nav ml-auto" style="cursor: pointer">
      <li class="nav-item dropdown notificacao">
        <button class="navbar_drop no-border-button" onclick="wipe_notif()" role="button" data-toggle="dropdown">
          <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-bell-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"/>
          </svg>
          <?php if($notificacao[0] > 0 ){ ?>
            <span id="notificacoes" class="notifi bell">
              <?php echo $notificacao[0]; ?>
            </span>
          <?php } ?>
          <span class="nav_nome" style="margin-left:5px;"><?php echo "Notificações"; ?></span>
          <svg width="0.9em" height="1em" viewBox="0 0 16 16" class="bi bi-caret-down-fill" fill="current color" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
          </svg>
        </button>
        <div class="dropdown-menu ajuste_notifi" aria-labelledby="notificações">
          <?php if($notificacao[0] < 1 ){ ?>
            <div class="dropdown-item" style="cursor:default;margin-bottom:6px;background-color:white;">
              <span style="font-size:14px;"><b>Não visualizadas:</b></span><br>
              <span class="texto_notificacao">Nenhuma notificação</span>
            </div>
          <?php }else{ ?>
            <div class="dropdown-item" style="cursor:default;margin-bottom:6px;background-color:white;">
              <span style="font-size:14px;"><b>Não visualizadas:</b></span><br>
            </div>
          <?php } ?>
          <?php while($row = mysqli_fetch_assoc($res23)){ ?>
            <hr class="rgba-white-light" style="margin: 0 10%;">
            <div class="dropdown-item" style="cursor:default;margin-bottom:6px;background-color:white;">
              <span style="font-size:15px;"><?php echo mb_strimwidth($row['titulo_notificacao'], 0, 23, "...") ; ?></span><br>
              <span class="texto_notificacao"><?php echo $row['conteudo_notificacao']; ?></span>
            </div>
          <?php } ?>
          <div class="dropdown-divider"></div>
          <a href="{{ url('notificacoes') }}" class="dropdown-item text-center" style="color:black;"><b>Ver todas as notificações</b></a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <?php if($row = mysqli_fetch_assoc($resultado)){
          $nome_completo = $row['usuario'];
          $words = explode(" ", $nome_completo);
          if(isset($words[1])){
            $nome_resum = substr($words[0], 0)  ." ". substr($words[1], 0);
          }else{
            $nome_resum = $row['usuario'];
          }
        ?>
          <button class="navbar_drop no-border-button" id="navbarDropdown" role="button" data-toggle="dropdown">
            <?php if($row['img_usuarios'] == NULL){?>
              <img class="nav_img" style="border-color:black" src="{{asset('img/semuser.png')}}">
            <?php }else{?>
              <img class="nav_img" src="{{asset('/ToDo/storage/app/public/users/'.$row['img_usuarios'])}}">
            <?php }?>
            <span class="nav_nome"><?php echo mb_strimwidth($nome_resum, 0, 22, "...") ; ?></span>
            <svg width="0.9em" height="0.9em" viewBox="0 0 16 16" class="bi bi-caret-down-fill" fill="current color" xmlns="http://www.w3.org/2000/svg">
              <path d="M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
            </svg>
          </button>
        <?php } ?>
        <div class="dropdown-menu ajuste_drop" aria-labelledby="navbarDropdown">
          <?php if(3 == $nivel){?>
            <a class="dropdown-item" style="margin-bottom:6px" href="{{ url('admin/historico') }}">
              <svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-clipboard-data" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                <path fill-rule="evenodd" d="M9.5 1h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
                <path d="M4 11a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0v-1zm6-4a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0V7zM7 9a1 1 0 0 1 2 0v3a1 1 0 1 1-2 0V9z"/>
              </svg>&nbsp Painel Admin
            </a>
          <?php }?>
          <a class="dropdown-item" style="margin-bottom:6px" data-toggle="modal" data-target="#modalideia">
            <svg width="1.4em" height="1.4em" viewBox="0 0 16 16" class="bi bi-plus-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
            </svg>&nbsp Criar ideia
          </a>
          <a class="dropdown-item" style="margin-bottom:6px" href="{{ url('home') }}">
            <svg width="1.4em" height="1.4em" viewBox="0 0 16 16" class="bi bi-house-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M8 3.293l6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
              <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
            </svg>&nbsp Início
          </a>
          <a class="dropdown-item" href="{{ url('conta') }}">
            <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-person-lines-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7 1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm2 9a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
            </svg>&nbsp Perfil
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ url('logout') }}">
            <svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-box-arrow-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
              <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
            </svg>&nbsp Sair
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!--||Fim Nav bar||-->

  <div class="fundo" style="background-color: #E5E5E5">
    <!-- Filtro SmartPhone  -->
    <?php if (isset($smartphone)){?>
      <div class="filtro-smartphone">
        <a class="fix filtro-esquerda" data-toggle="modal" data-target="#ordenacao">Ordenação</a>
        <a class="fix filtro-direita" data-toggle="modal" data-target="#filtros">Filtros</a>
      </div>
    <?php }?>
    <!-- FIM filtro SmartPhone  -->

    <div class="espaco"></div>
    <div class="min">
      @yield('content') <!-- Puxa a pagina aqui -->
    </div>
    <!-- Footer -->
    <div class="espaco-footer"></div>
    <footer class="page-footer font-small indigo layout-footer">
      <div class="container">
      <div class="row text-center d-flex justify-content-center pt-5 mb-3">
        <div class="col-md-2 mb-3">
          <h6 class="text-uppercase font-weight-bold">
            <a href="{{ url('sobre') }}">Sobre nós</a>
          </h6>
        </div>
        <div class="col-md-3 mb-3">
          <h6 class="text-uppercase font-weight-bold">
            <a href="" data-toggle="modal" data-target="#modal_termo" >Termos de uso</a>
          </h6>
        </div>
        <div class="col-md-3 mb-3">
          <h6 class="text-uppercase font-weight-bold">
            <a href="" data-toggle="modal" data-target="#modal_politi" >Política de privacidade</a>
          </h6>
        </div>
        <div class="col-md-2 mb-3">
          <h6 class="text-uppercase font-weight-bold">
            <a href="" data-toggle="modal" data-target="#modal_contato" >contatos</a>
          </h6>
        </div>
        </div>
        <hr class="rgba-white-light" style="margin: 0 15%;">
        <div class="text-center d-flex justify-content-center pt-5">
          <div class="col-md-3">
            <h6 class="text-uppercase font-weight-bold">
              O que é ToDo ideias?
            </h6>
          </div>
        </div>
      </div>
      <div class="d-flex text-center justify-content-center mb-md-3 mb-1">
        <div class="col-md-8 col-12 mt-4">
          <p style="line-height: 1.7rem">
            ToDo Ideias é um site voltado para a coleta, armazenamento e gestão de ideias de forma a se tornar em um repositório, onde qualquer pessoa poderá registrar
            uma ideia. Considera-se “ideia" qualquer proposta que venha a surgir de uma inovação, oportunidade, necessidade ou problema.
            Tem como objetivo coletar, armazenar e gerenciar propostas de projetos para desenvolvimento, permitir que todos os usuários exponham suas ideias,
            permitir votações e comentários das ideias de modo que o sistema fará o ranqueamento das ideias com melhores avaliações
            permitindo aos docentes a visão das melhores ideias de forma a contribuir para o conhecimento e a definição dos projetos a serem desenvolvidos pelos alunos.
          </p>
        </div>
      </div>
      <div class="copyright">
          <div class="footer-copyright text-center py-3">© 2020 ToDoIdeias.gq All Rights Reserved</div>
      </div>
    </footer>
    <!-- FIM Footer -->
  </div>
    
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
          <div class="modal-body fundo">
            <div class="espaço_cria">
              <div class="titulo_cria">
                <b style="font-size:18px;">Titulo:</b>
                <input class="custom_input espaço-input" type="text" name="titulo" placeholder="Titulo da ideia" maxlength="45" required>
              </div>
              <div class="categoria_cria">
                <b style="font-size:18px;"> Categoria:</b>
                <select class="custom_input espaço-input" type="text" name="categoria" required> 
                  <option value="" disabled selected> Selecionar categoria </option>
                  <option value="1"> Web, Mobile & Software </option>
                  <option value="2"> Design & Criação </option>
                  <option value="3"> Engenharia & Arquitetura </option>
                  <option value="4"> Marketing </option>
                  <option value="5"> Outros </option>
                </select>
              </div>
            </div>
            <div class="desc_cria"><b>Descrição:</b></div>
            <textarea class="descricao_cria" type="text" placeholder="Descreva sua ideia"  name="descricao" onkeyup="limite_textarea(this.value)" id="texto" required></textarea>
            <br>
            <div class="cont_desc"><span id="cont">20.000</span> Caracteres restantes </div><br>
            <br>
            <div class="espaço_cria2">
              <div class="alinhamento-img">
                <label class="form-control-range">
                  <input type="file" name="img_post" id="file" accept="image/*" multiple onchange="javascript:update_file1()"/>
                  <a name="img_post" class="img_cria">Adicionar Imagem</a>
                  <div class="file-name" id="file-name">Arquivo: Vazio</div>
                </label>
              </div>
              <div class="alinhamento-img2">
                <label class="form-control-range">
                  <input type="file" name="img_post2" id="file2" accept="image/*" multiple onchange="javascript:update_file2()"/>
                  <a name="img_post" class="img_cria">Adicionar Imagem Capa</a>
                  <div class="file-name" id="file-name2">Arquivo: Sem capa</div>
                </label>
              </div>
              <div class="alinhamento-img3">
                <label class="form-control-range">
                  <input type="file" name="img_post3" id="file3" accept="image/*" multiple onchange="javascript:update_file3()"/>
                  <a name="img_post" class="img_cria">Adicionar Imagem</a>
                  <div class="file-name" id="file-name3">Arquivo: Vazio</div>
                </label>
              </div>
            </div>
          </div>
          <div class="modal-footer-custom" style="border-top: 1px solid #ccc">
            <input type='hidden' name="id_usuario" value="<?php echo $id_user ?>"/>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Enviar ideia</button><br>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- FIM Modal Criação post-->
  <!--Modal termos de uso-->
  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_termo" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body fundo">
          <div class="text-center" style="padding:50px;"><H5><b>WORK IN PROGESS</b></h5></div>
        </div>
        <div class="modal-footer-custom" style="border-top: 1px solid #ccc">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- FIM Modal termos de uso-->
  <!--Modal politica de privacidade-->
  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_politi" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body fundo">
          <div class="text-center" style="padding:50px;"><H5><b>WORK IN PROGESS</b></h5></div>
        </div>
        <div class="modal-footer-custom" style="border-top: 1px solid #ccc">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- FIM Modal politica de privacidade-->
  <!--Modal contatos-->
  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_contato" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body fundo">
          <div class="text-center justify-content-center pt-3">
            <b style="font-size:20px;"> Desenvolvedores </b>
          </div>
          <div class="text-center justify-content-center pt-4">
            <b> Matheus Moura Pinho </b> - <a href="mailto:Matheusmpinho@outlook.com"> Matheusmpinho@outlook.com</a> <br><br>
            <b> Jonathan Gonçalves Dias </b> - <a href="mailto:jonathangoncalves.dias2001@gmail.com"> jonathangoncalves.dias2001@gmail.com</a> <br><br>
            <b> Vinicius Vieira Pereira </b> - <a href="mailto:vinicius_vieira_pereira@hotmail.com"> vinicius_vieira_pereira@hotmail.com</a> <br><br>
            <b> Mauricio Freire da Silva </b> - <a href="mailto:mauriciofreire520@gmail.com"> mauriciofreire520@gmail.com</a> <br><br>
          </div>
        </div>
        <div class="modal-footer-custom" style="border-top: 1px solid #ccc">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- FIM Modal contatos-->

  <script>
    function update_file1() {
      var input = document.getElementById('file'); //define o id do input
      var infoArea = document.getElementById( 'file-name' );//define o id do resutado do script
      var fileName = input.files[0].name; //nome do arquivo que foi selecionado no input
      infoArea.textContent = 'Arquivo: ' + fileName; //define infoArea como texto que recebe fileName
    }
    function update_file2() {
      var input = document.getElementById('file2');
      var infoArea = document.getElementById( 'file-name2' );
      var fileName = input.files[0].name;
      infoArea.textContent = 'Arquivo: ' + fileName;
    }
    function update_file3() {
      var input = document.getElementById('file3');
      var infoArea = document.getElementById( 'file-name3' ); 
      var fileName = input.files[0].name;
      infoArea.textContent = 'Arquivo: ' + fileName;
    }
  </script>
<!-- Modal notificação denuncia -->
<div class="modal fade id" id="denuncia" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="color:white;"> <b>Aviso</b> </div>
        <div class="modal-body">
                <h4><?php if($denuncia == 1){ echo "<b> Denuncia efetuada. </b>"; }else{echo "<b> Esta postagem ja foi denúnciada. </b>";}?></h4><br>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div> 
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

<script>
function wipe_notif() {
  $.ajax({
    method: "GET",
    url: "wipe_recentes",
  });
  document.getElementById("notificacoes").innerHTML = "";
}
</script>

<script type="text/javascript">
if(navigator.appName.indexOf("Internet Explorer")!=-1 || navigator.userAgent.match(/Trident.*rv[ :]*11\./))
{
  window.location = "/ToDo/IE";
}
</script>

</body>
</html>