<?php
require_once("assets/php/class/class.seg.php");
require_once("assets/php/class/class.utils.php");
session_start();
proteger();

$host="10.0.0.2";
$service="//10.0.0.2:1521/orcl";
$id=$_SESSION['usuarioId'];
$conn= new \PDO("oci:host=$host;dbname=$service","INTRANET","ifnefy6b9");

$query1 = "SELECT USR.EMAIL, USR.TIPO_USUARIO, USR.SETOR, USR.IMG_PERFIL, IMG.IMAGEM,
    CASE
      WHEN USR.SETOR IN (SELECT SIGLA FROM IN_SETORES SETO, IN_MURAL MUR WHERE MUR.SETOR = SETO.SIGLA)
      THEN 'S'
      ELSE 'N'
      END AS MURAL,
    CASE
      WHEN USR.ID IN (SELECT GESTOR FROM IN_SETORES WHERE GESTOR = :id)
      THEN 'S'
      ELSE 'N'
      END AS GESTOR
FROM 
    IN_USUARIOS USR, 
    IN_IMAGENS IMG 
WHERE 
    USR.IMG_PERFIL = IMG.ID AND USR.ID =:id";

//#1
$stmt1 = $conn->prepare($query1);
$stmt1->bindValue(':id',$id);
$stmt1->execute();
$result1=$stmt1->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Aniger - Cadastros</title>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN PLUGIN CSS -->
    <link href="assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="assets/plugins/bootstrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/bootstrapv3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/animate.min.css" rel="stylesheet" type="text/css" />
    <!-- <link href="assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" /> -->
    <!-- END PLUGIN CSS -->
    <!-- BEGIN CORE CSS FRAMEWORK -->
    <link href="assets/css/material.css" rel="stylesheet">
    <link href="webarch/css/webarch.css" rel="stylesheet" type="text/css" />
    <!-- END CORE CSS FRAMEWORK -->
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
  </head>
  <body class="">
    <!-- BEGIN HEADER -->
    <div class="header navbar navbar-inverse ">
      <!-- BEGIN TOP NAVIGATION BAR -->
      <div class="navbar-inner">
        <div class="header-seperation">
          <ul class="nav pull-left notifcation-center visible-xs visible-sm">
            <li class="dropdown">
              <a href="#main-menu" data-webarch="toggle-left-side">
                <i class="material-icons">menu</i>
              </a>
            </li>
          </ul>
          <!-- BEGIN LOGO -->
          <a href="index.php">
            <img src="assets/img/logo.png" class="logo" alt="" data-src="assets/img/logo.png" data-src-retina="assets/img/logo.png" width="106" height="21" />
          </a>
          <!-- END LOGO -->
          <ul class="nav pull-right notifcation-center">
            <li class="dropdown hidden-xs hidden-sm">
              <a href="index.php" class="dropdown-toggle active" data-toggle="">
                <i class="material-icons">home</i>
              </a>
            </li>
            <li class="dropdown hidden-xs hidden-sm">
              <a href="chamados.php" class="dropdown-toggle">
                <i class="material-icons">desktop_mac</i><!-- <span class="badge bubble-only"></span> -->
              </a>
            </li>
            <!--<li class="dropdown visible-xs visible-sm">
              <a href="#" data-webarch="toggle-right-side">
                <i class="material-icons">chat</i>
              </a>
            </li>-->
          </ul>
        </div>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <div class="header-quick-nav">
          <!-- BEGIN TOP NAVIGATION MENU -->
          <div class="pull-left">
            <ul class="nav quick-section">
              <li class="quicklinks">
                <a href="#" class="" id="layout-condensed-toggle">
                  <i class="material-icons">menu</i>
                </a>
              </li>
            </ul>
            <ul class="nav quick-section">
              <li class="quicklinks  m-r-10">
                <a href="javascript:history.go(0)" class="">
                  <i class="material-icons">refresh</i>
                </a>
              </li>
              <li class="quicklinks">
                <a href="#" class="" id="my-task-list" data-placement="bottom" data-content='' data-toggle="dropdown" data-original-title="Novidades">
                  <i class="material-icons">notifications_none</i>
                  <span class="badge badge-important bubble-on  ly"></span>
                </a>
              </li>
              <li class="quicklinks"> <span class="h-seperate"></span></li>
              <?php
                if ($result1['TIPO_USUARIO'] == 'ADM') {
                  echo '
                  <li class="quicklinks">
                    <a href="dados.php">
                      <i class="material-icons">apps</i>
                    </a>
                  </li>';
                } elseif ($result1['MURAL'] == 'S') {
                  echo '
                  <li class="quicklinks">
                    <a href="dados.php">
                      <i class="material-icons">apps</i>
                    </a>
                  </li>';
                } elseif ($result1['GESTOR'] == 'S') {
                  echo '
                  <li class="quicklinks">
                    <a href="dados.php">
                      <i class="material-icons">apps</i>
                    </a>
                  </li>';
                } elseif ($result1['SETOR'] == 'RH' || $result1['SETOR'] == 'REC') {
                  echo '
                  <li class="quicklinks">
                    <a href="dados.php">
                      <i class="material-icons">apps</i>
                    </a>
                  </li>';
                }                 
              ?>
              <!--<li class="m-r-10 input-prepend inside search-form no-boarder">
                <span class="add-on"> <i class="material-icons">search</i></span>
                <input name="" type="text" class="no-boarder " placeholder="Buscar" style="width:250px;">
              </li>-->
            </ul>
          </div>
          <div id="notification-list" style="display:none">
            <div style="width:220px">
            <a href="changelog.php">
              <div class="notification-messages info">
                <div class="user-profile">
                  <img src="assets/img/profiles/Aa.jpg" width="35" height="35">
                </div>
                <div class="message-wrapper">
                  <div class="heading" style="text-align:center;">
                    <?php
                      echo "Vers&atilde;o " . $_SESSION['versao']
                    ?>
                  </div>
                  <div class="description" style="text-align:center;">
                    Visualizar as novidades!
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
            </a>
            </div>
          </div>
          <!-- END TOP NAVIGATION MENU -->
          <!-- BEGIN CHAT TOGGLER -->
          <div class="pull-right">
            <!-- <div class="chat-toggler sm">
              <div class="profile-pic">
                <img src="assets/img/profiles/Aa.jpg" alt="" data-src="assets/img/profiles/Aa.jpg" data-src-retina="assets/img/profiles/Aa.jpg" width="35" height="35" />
                <div class="availability-bubble online"></div>
              </div>
            </div> -->
            <ul class="nav quick-section ">
              <li class="quicklinks">
                <a data-toggle="dropdown" class="dropdown-toggle  pull-right " href="#" id="user-options">
                  <i class="material-icons">tune</i>
                </a>
                <ul class="dropdown-menu  pull-right" role="menu" aria-labelledby="user-options">
                  <li class="">
                    <?php echo '<a href="perfil.php?id='.$id.'" title="Acesse seu perfil"><i class="fa fa-male fa-fw"></i>&nbsp;&nbsp;Meu perfil</a>';?>
                  </li>
                  <!-- <li class="disabled">
                    <a href="calender.php" title="Recurso ainda n&atilde;o implementado.">Calend&aacute;rio</a>
                  </li> -->
                  <!-- <li>
                    <a href="email.php"> My Inbox&nbsp;&nbsp;
                      <span class="badge badge-important animated bounceIn">2</span>
                    </a>
                  </li> -->
                  <li class="divider"></li>
                  <li>
                    <a href="logout.php"><i class="material-icons">power_settings_new</i>&nbsp;&nbsp;Sair</a>
                  </li>
                </ul>
              </li>
              <!--<li class="quicklinks"> <span class="h-seperate"></span></li>-->
              <!--<li class="quicklinks">-->
                <!-- <a href="#" class="chat-menu-toggle" data-webarch="toggle-right-side"><i class="material-icons">chat</i><span class="badge badge-important hide">1</span> -->
                <!--<a href="#" class="chat-menu-toggle"><i class="material-icons" title="Recurso ainda n&atilde;o implementado.">chat</i><span class="badge badge-important hide">1</span>-->
                <!--</a>-->
                <!--<div class="simple-chat-popup chat-menu-toggle hide">-->
                  <!--<div class="simple-chat-popup-arrow"></div>
                  <div class="simple-chat-popup-inner">
                     <div style="width:100px">
                      <div class="semi-bold">David Nester</div>
                      <div class="message">Hey you there </div>
                    </div> -->
                  <!--</div>
                </div>
              </li>-->
            </ul>
          </div>
          <!-- END CHAT TOGGLER -->
        </div>
        <!-- END TOP NAVIGATION MENU -->
      </div>
      <!-- END TOP NAVIGATION BAR -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN CONTENT -->
    <div class="page-container row-fluid">
      <!-- BEGIN SIDEBAR -->
      <div class="page-sidebar " id="main-menu">
        <!-- BEGIN MINI-PROFILE -->
        <div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">
          <div class="user-info-wrapper sm">
            <div class="profile-wrapper sm">
              <?php
                echo '<img width="69" height="69" src="data:image/jpeg;base64,'.base64_encode(stream_get_contents($result1['IMAGEM'])).'">';
              ?>
              <div class="availability-bubble online"></div>
            </div>
            <div class="user-info sm">
              <div class="username"><span class="semi-bold"> <?php echo $_SESSION['usuarioNome']; ?> </span></div>
              <div class="status">Seja bem-vindo(a)</div>
            </div>
          </div>
          <!-- END MINI-PROFILE -->
          <!-- BEGIN SIDEBAR MENU -->
            <?php
               //Exibe o menu lateral das páginas WEB
               exibe_menu_lateral("cadastros.php");
            ?>
          <!-- END SIDEBAR MENU -->
        </div>
      </div>
      <a href="#" class="scrollup">Scroll</a>
      <div class="footer-widget">
        <div class="pull-left">
          <i class="material-icons">alarm</i>
          <iframe src="http://free.timeanddate.com/clock/i5hp9yxv/n595/tlbr5/fn17/fc555/tc22262e/pa0/th1" frameborder="0" width="66" height="14"></iframe>
        </div>
        <div class="pull-right">          
          <a href="bloquear.php"><i class="material-icons">lock_outline</i></a>
        </div>
      </div>
      <!-- END SIDEBAR -->
      <!-- BEGIN PAGE CONTAINER-->
      <div class="page-content">
        <div class="content">
        <ul class="breadcrumb">
            <li>
              <p>VOC&Ecirc; EST&Aacute; EM </p>
            </li>
            <li>
            <a href="index.php">Home</a>
            </li>
            <li><a href="#" class="active">Cadastros</a> </li>
          </ul>
          <!-- BEGIN PAGE TITLE -->
          <div class="page-title"> <i class="material-icons">library_add</i>
            <h3>Cadastros </h3>
          </div>
          <!-- END PAGE TITLE -->
          <!-- BEGIN PlACE PAGE CONTENT HERE -->

          <!-- TILE #1 -->
          <div class="col-md-3 col-sm-4 m-b-10">
            <div class="tiles gray blend weather-widget ">
              <div class="tiles-body">
                <a href="#" style="color: #edeeef;">
                  <div class="heading">
                    <div class="pull-left">Clientes </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="big-icon">
                    <i class="fa fa-user fa-7x fa-fw"></i>
                  </div>
                  <div class="clearfix"></div>
              </div>
                </a>
              <div class="tile-footer">
                <div class="pull-left">
                  <canvas id="" width="1" height="30"></canvas>
                  <span class=" small-text-description">&nbsp;&nbsp;<span class="label">CTB</span>&nbsp;</span>
                </div>
                <div class="pull-right">
                  <canvas id="" width="1" height="28"></canvas>
                  <span style="cursor: pointer;" data-toggle="modal" data-target="#1Modal"><i class="fa fa-info fa-2x"></i> </span>
                </div>
                <div class="pull-right">
                  <canvas id="" width="32" height="32"></canvas>
                  <span class="text-white small-text-description"></span> 
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
          </div>

          <!-- MODAL #1 -->
          <div class="modal fade" id="1Modal" tabindex="-1" role="dialog" aria-labelledby="1ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                  <br>
                  <i class="fa fa-info fa-6x"></i>
                  <h4 id="1ModalLabel" class="semi-bold">Informa&ccedil;&atilde;o.</h4>
                </div>
                <div class="modal-body">
                  <div class="alert alert-info">
                    <i class="pull-left material-icons">feedback</i>
                    <div style="padding-left: 30px;">
                      <p>Utilize este cadastro para solicitar a inclus&atilde;o de novos <span class="bold">clientes</span> no sistema.
                      Ap&oacute;s informar os dados solicitados, solicite autoriza&ccedil;&atilde;o do seu gestor e aguarde o retorno do setor respons&aacute;vel pelo cadastramento, em seu email. <br>                      
                      <p>Os cadastros autorizados s&atilde;o encaminhados para: <span class="bold"> iraci.kraemer@aniger.com.br</span></p>
                      <p>Ramal: <span class="bold">105</span></p>
                    </div>    
                  </div>             
                </div>
              </div>
            </div>
          </div>

          <!-- TILE #2 -->
          <div class="col-md-3 col-sm-4 m-b-10">
            <div class="tiles gray blend weather-widget ">
              <div class="tiles-body">
                <a href="#" style="color: #edeeef;">
                  <div class="heading">
                    <div class="pull-left">Fornecedores </div>  
                    <div class="clearfix"></div>
                  </div>
                  <div class="big-icon">
                    <i class="fa fa-users fa-7x fa-fw"></i>
                  </div>
                  <div class="clearfix"></div>
              </div>
                </a>
              <div class="tile-footer">
                <div class="pull-left">
                  <canvas id="" width="1" height="30"></canvas>
                  <span class=" small-text-description">&nbsp;&nbsp;<span class="label">CTB</span>&nbsp;</span>
                </div>
                <div class="pull-right">
                  <canvas id="" width="1" height="28"></canvas>
                  <span style="cursor: pointer;" data-toggle="modal" data-target="#2Modal"><i class="fa fa-info fa-2x"></i> </span>
                </div>
                <div class="pull-right">
                  <canvas id="" width="32" height="32"></canvas>
                  <span class="text-white small-text-description"></span> 
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
          </div>
          <!-- MODAL #2 -->
          <div class="modal fade" id="2Modal" tabindex="-1" role="dialog" aria-labelledby="2ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                  <br>
                  <i class="fa fa-info fa-6x"></i>
                  <h4 id="2ModalLabel" class="semi-bold">Informa&ccedil;&atilde;o.</h4>
                </div>
                <div class="modal-body">
                  <div class="alert alert-info">
                    <i class="pull-left material-icons">feedback</i>
                    <div style="padding-left: 30px;">
                      <p>Utilize este cadastro para solicitar a inclus&atilde;o de novos <span class="bold">fornecedores</span> no sistema.
                      Ap&oacute;s informar os dados solicitados, solicite autoriza&ccedil;&atilde;o do seu gestor e aguarde o retorno do setor respons&aacute;vel pelo cadastramento, em seu email. <br>                      
                      <p>Os cadastros autorizados s&atilde;o encaminhados para: <span class="bold"> iraci.kraemer@aniger.com.br</span></p> 
                      <p>Ramal: <span class="bold">105</span></p>
                    </div>    
                  </div>             
                </div>
              </div>
            </div>
          </div>

          <!-- TILE #3 -->
          <div class="col-md-3 col-sm-4 m-b-10">
            <div class="tiles dark-blue weather-widget ">
              <div class="tiles-body">
                <a href="http://10.0.6.242/" style="color: #edeeef;">
                  <div class="heading">
                    <div class="pull-left">Materiais </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="big-icon">
                    <i class="fa fa-map-o fa-7x fa-fw"></i>
                  </div>
                  <div class="clearfix"></div>
              </div>
                </a>
              <div class="tile-footer">
                <div class="pull-left">
                  <canvas id="" width="1" height="30"></canvas>
                  <span class=" small-text-description">&nbsp;&nbsp;<span class="label">CMP</span>&nbsp;</span>
                </div>
                <div class="pull-right">
                  <canvas id="" width="1" height="28"></canvas>
                  <span style="cursor: pointer;" data-toggle="modal" data-target="#3Modal"><i class="fa fa-info fa-2x"></i> </span>
                </div>
                <div class="pull-right">
                  <canvas id="" width="32" height="32"></canvas>
                  <span class="text-white small-text-description"></span> 
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
          </div>
          <!-- MODAL #3 -->
          <div class="modal fade" id="3Modal" tabindex="-1" role="dialog" aria-labelledby="3ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                  <br>
                  <i class="fa fa-info fa-6x"></i>
                  <h4 id="3ModalLabel" class="semi-bold">Informa&ccedil;&atilde;o.</h4>
                </div>
                <div class="modal-body">
                  <div class="alert alert-info">
                    <i class="pull-left material-icons">feedback</i>
                    <div style="padding-left: 30px;">
                      Utilize este link para acessar a plataforma de solicita&ccedil;&atilde;o de cadastro de materiais.
                      <p>Os cadastros s&atilde;o encaminhados para: <span class="bold">lisangela.hermes@aniger.com.br</span> ou <span class="bold">joseane.oliveira@aniger.com.br</span></p> 
                      <p>Ramal: <span class="bold">333</span></p>  
                    </div>    
                  </div>             
                </div>
              </div>
            </div>
          </div>

          <!-- END PLACE PAGE CONTENT HERE -->
        </div>
      </div>
      <!-- END PAGE CONTAINER -->
     
    </div>
    <!-- END CONTENT -->
    <!-- BEGIN CORE JS FRAMEWORK-->
    <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>
    <!-- BEGIN JS DEPENDECENCIES-->
    <script src="assets/plugins/jquery/jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="assets/plugins/bootstrapv3/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-block-ui/jqueryblockui.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>
    <!-- END CORE JS DEPENDECENCIES-->
    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="webarch/js/webarch.js" type="text/javascript"></script>
    <script src="assets/js/chat.js" type="text/javascript"></script>
    <!-- END CORE TEMPLATE JS -->
  </body>
</html>