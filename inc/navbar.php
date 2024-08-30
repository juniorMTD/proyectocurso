<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";

$start = new Conexion();
$usu = $_SESSION['usuario'];

$conn = $start->Conexiondb();
$check_usuario = $conn->query("SELECT * FROM usux ux inner join usuariox usx on ux.idusux=usx.idusux and usux='$usu' and estadox=1;");
$check_empleado = $conn->query("SELECT * FROM usux ux inner join empleado e on e.idusux=ux.idusux and ux.usux='$usu' and ux.estadox=1;");


$id_usuario = limpiar_cadena($_SESSION['id']);
$id_usu = limpiar_cadena($_SESSION['idusu']);

if ($check_empleado->rowCount() == 1) {


  $consulta_datos = $start->Conexiondb();
  $consulta_datos = $consulta_datos->query("select nu.idnotificacionx_usuariox,n.titulo,n.mensaje, n.fec,nu.leido from notificacionx n inner join notificacionx_usuariox nu on 
nu.idnotificacionx=n.idnotificacionx where nu.leido='0' and nu.idusuariox='admin' ORDER BY n.fec DESC limit 0,5 ");
  $datos = $consulta_datos->fetchAll();

  $consulta_total = $start->Conexiondb();
  $consulta_total = $consulta_total->query("select count(nu.idnotificacionx_usuariox) from notificacionx n inner join notificacionx_usuariox nu on 
nu.idnotificacionx=n.idnotificacionx where nu.leido='0' and nu.idusuariox='admin' ORDER BY n.fec DESC");
  $total = (int) $consulta_total->fetchColumn();

?>

  <div class="container body">
    <div class="main_container">

      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="./indexado.php?mostrar=home" class="site_title"><i class="fa fa-building"></i> <span>TERRACIVIL</span></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <img src="./biblioteca/images/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Bienvenido</span>
              <h2><?php echo $_SESSION['nombres'] . " " . $_SESSION['apellidos']  ?></h2>
            </div>
          </div>
          <!-- /menu profile quick info -->
          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>General</h3>
              <ul class="nav side-menu">
                <li><a><i class="fa fa-home"></i> Inicio <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="indexado.html">Perfil</a></li>
                  </ul>
                </li>
                <li><a href="./indexado.php?mostrar=frmprincipal"><i class="fa fa-pie-chart"></i> Recursos</a>
                </li>
                <li>
                  <a href="./indexado.php?mostrar=frmsugerencia"><i class="fa fa-thumbs-up"></i> Sugerencias </a>
                </li>
                <li><a><i class="fa fa-desktop"></i> Gestion Recursos<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="./indexado.php?mostrar=formu_categoria">Categorias</a></li>
                    <li><a href="./indexado.php?mostrar=formu_curso">Cursos</a></li>
                    <li><a href="./indexado.php?mostrar=formu_tema">Temas</a></li>
                    
                  </ul>
                </li>
                <li><a><i class="fa fa-envelope-o"></i> Gestion Notificación<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="./indexado.php?mostrar=formu_sugerencias">Sugerencias</a></li>
                    <li><a href="./indexado.php?mostrar=formu_notificaciones">Notificaciones</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-users"></i> Gestion Usuarios<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="./indexado.php?mostrar=formu_matricula">Matricula</a></li>
                    <li><a href="./indexado.php?mostrar=formu_usuario">Usuarios</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-bar-chart"></i> Gestion Encuestas<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="./indexado.php?mostrar=formu_encuesta">Encuesta</a></li>
                    <li><a href="./indexado.php?mostrar=formu_usuario">Reportes</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
          <!-- /sidebar menu -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <nav>
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="#" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <img src="./biblioteca/images/img.jpg" alt=""><?php ob_start();
                                                                echo $_SESSION['nombres'] . " " . $_SESSION['apellidos'] ?>
                  <span class="fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="./indexado.php?mostrar=logout"><i class="fa fa-sign-out pull-right"></i> Salir</a></li>
                </ul>
              </li>
              <li role="presentation" class="dropdown">
                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-bell"></i>
                  <?php if ($total > 0) { ?>
                    <span class="badge bg-green"><?php echo $total ?></span>
                  <?php } ?>
                </a>
                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                  <?php if ($total > 0) {
                    foreach ($datos as $rows) { ?>
                      <li>
                        <a href="./php/marcar_noti.php?id_n=<?php echo $rows['idnotificacionx_usuariox']; ?>">
                          <span class="image"><img src="./biblioteca/images/noti.png" alt="Noti" /></span>
                          <span>
                            <span class="time"><?php echo tiempo_transcurrido($rows['fec']) ?></span><br>
                            <span><?php echo $rows['titulo'] ?></span>
                          </span>
                          <span class="message"><br><br>
                            <?php echo $rows['mensaje'] ?>
                          </span>
                        </a>
                      </li>
                    <?php }
                  } else { ?>
                    <li>
                      <a>
                        <span class="image"><img src="./biblioteca/images/noti.png" alt="Noti" /></span>
                        <span class="message"><br>
                          No hay ninguna notificación
                        </span>
                      </a>
                    </li>
                  <?php } ?>
                  <li>
                    <div class="text-center">
                      <a href="./indexado.php?mostrar=frmnotificaciones">
                        <strong>Ver mas</strong>
                        <i class="fa fa-angle-right"></i>
                      </a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->

    <?php

  } else if ($check_usuario->rowCount() == 1) {
    //capturar los datos del usuario
    $consultaid_usuario = $start->Conexiondb();
    $consultaid_usuario = $consultaid_usuario->query("select usu.idusuariox from usux u inner join usuariox usu on usu.idusux=u.idusux
  where u.idusux='$id_usu'");
    $idusu = (int)$consultaid_usuario->fetchColumn();

    $consulta_datos = $start->Conexiondb();
    $consulta_datos = $consulta_datos->query("select nu.idnotificacionx_usuariox,n.titulo,n.mensaje, n.fec,nu.leido,nu.idusuariox from 
notificacionx n inner join notificacionx_usuariox nu on nu.idnotificacionx=n.idnotificacionx 
inner join usuariox usu on nu.idusuariox=usu.idusuariox
where nu.leido='0' and nu.idusuariox='$idusu' ORDER BY n.fec DESC limit 0,5;");
    $datos = $consulta_datos->fetchAll();

    $consulta_total = $start->Conexiondb();
    $consulta_total = $consulta_total->query("select count(nu.idnotificacionx_usuariox) from notificacionx n inner join notificacionx_usuariox nu on 
  nu.idnotificacionx=n.idnotificacionx where nu.leido='0' and nu.idusuariox='$idusu' ORDER BY n.fec DESC");
    $total = (int) $consulta_total->fetchColumn();
    ?>
    <div class="container body">
    <div class="main_container">

      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="./indexado.php?mostrar=home" class="site_title"><i class="fa fa-building"></i> <span>TERRACIVIL</span></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <img src="./biblioteca/images/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Bienvenido</span>
              <h2><?php echo $_SESSION['nombres'] . " " . $_SESSION['apellidos']  ?></h2>
            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>General</h3>
              <ul class="nav side-menu">
                <li><a><i class="fa fa-home"></i> Inicio <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="indexado.html">Perfil</a></li>
                  </ul>
                </li>
                <li><a href="./indexado.php?mostrar=frmprincipal"><i class="fa fa-pie-chart"></i> Recursos</a>
                </li>
                <li>
                  <a href="./indexado.php?mostrar=frmsugerencia"><i class="fa fa-thumbs-up"></i> Sugerencias </a>
                </li>
              </ul>
            </div>
          </div>
          <!-- /sidebar menu -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <nav>
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="#" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <img src="./biblioteca/images/img.jpg" alt=""><?php ob_start();
                                                                echo $_SESSION['nombres'] . " " . $_SESSION['apellidos'] ?>
                  <span class="fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="./indexado.php?mostrar=logout"><i class="fa fa-sign-out pull-right"></i> Salir</a></li>
                </ul>
              </li>
              <li role="presentation" class="dropdown">
                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-bell"></i>
                  <?php if ($total > 0) { ?>
                    <span class="badge bg-green"><?php echo $total ?></span>
                  <?php } ?>
                </a>
                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                  <?php if ($total > 0) {
                    foreach ($datos as $rows) { ?>
                      <li>
                        <a href="./php/marcar_noti.php?id_n=<?php echo $rows['idnotificacionx_usuariox']; ?>&id_u=<?php echo $rows['idusuariox']; ?>">
                          <span class="image"><img src="./biblioteca/images/noti.png" alt="Noti" /></span>
                          <span>
                            <span class="time"><?php echo tiempo_transcurrido($rows['fec']) ?></span><br>
                            <span><?php echo $rows['titulo'] ?></span>
                          </span>
                          <span class="message"><br><br>
                            <?php echo $rows['mensaje'] ?>
                          </span>
                        </a>
                      </li>
                    <?php }
                  } else { ?>
                    <li>
                      <a>
                        <span class="image"><img src="./biblioteca/images/noti.png" alt="Noti" /></span>
                        <span class="message"><br>
                          No hay ninguna notificación
                        </span>
                      </a>
                    </li>
                  <?php } ?>
                  <li>
                    <div class="text-center">
                      <a href="./indexado.php?mostrar=frmnotificaciones">
                        <strong>Ver mas</strong>
                        <i class="fa fa-angle-right"></i>
                      </a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->
    <?php
  } else {
  }
