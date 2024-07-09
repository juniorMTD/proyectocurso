
<div class="container body">
    <div class="main_container">

        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="./index.php?mostrar=home" class="site_title"><i class="fa fa-building"></i> <span>TERRACIVIL</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="./biblioteca/images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Bienvenido</span>
                <h2><?php echo $_SESSION['nombres']." ".$_SESSION['apellidos']?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li>
                    <a href="./index.php?mostrar=frmnotificaciones"><i class="fa fa-edit"></i> Notificaciones </a>
                  </li>
                  <li><a><i class="fa fa-home"></i> Inicio <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="index.html">Perfil</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-edit"></i> Listas <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="./index.php?mostrar=frmprincipal">Categoria</a></li>
                    </ul>
                  </li>
                  <li>
                    <a href="./index.php?mostrar=frmsugerencia"><i class="fa fa-edit"></i> Sugerencias </a>
                  </li>
                  <li><a><i class="fa fa-desktop"></i> Gestion <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="./index.php?mostrar=formu_categoria">Categorias</a></li>
                      <li><a href="./index.php?mostrar=formu_curso">Cursos</a></li>
                      <li><a href="./index.php?mostrar=formu_tema">Temas</a></li>
                      <li><a href="./index.php?mostrar=formu_matricula">Matricula</a></li>
                      <li><a href="./index.php?mostrar=formu_usuario">Usuarios</a></li>
                      <li><a href="./index.php?mostrar=formu_sugerencias">Sugerencias</a></li>
                      <li><a href="./index.php?mostrar=formu_notificaciones">Notificaciones</a></li>
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
                    <img src="./biblioteca/images/img.jpg" alt=""><?php ob_start(); echo $_SESSION['nombres']." ".$_SESSION['apellidos']?>
                    <span class="fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> Salir</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->