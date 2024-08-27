<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";


$id = (isset($_GET['id_pregunta'])) ? $_GET['id_pregunta'] : 0;
$id=limpiar_cadena($id);

$start = new Conexion();

$check_encuesta = $start->Conexiondb();
$check_encuesta=$check_encuesta->query("SELECT * FROM encuestax e where e.idencuestax='$id'");

if($check_encuesta->rowCount()>0){
    $datos=$check_encuesta->fetch();
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="" >
        <div>
            <h3>ASIGNACIÓN DE PREGUNTAS A LA ENCUESTA</h3>
            <hr>
        </div>
        <div class="clearfix"></div>

        <div class="row">
          <div class="col-md-12">
              <div class="x_panel">
                <div class="x_content">
                  <div class="row">
                    <div class="col-md-4 col-xs-12">
                      <div class="x_panel">
                        <div class="x_title">
                          <h2><?php echo $datos['titulox'] ?></h2>
                          
                          <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                          <br/>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <h2><?php echo $datos['descripx'] ?></h2>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <h2><?php echo $datos['estado_encuesta'] ?></h2>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <h2><?php echo $datos['f_creacion'] ?></h2>
                            </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-8 col-xs-12">
                      <div class="x_panel">
                        <div class="x_title">
                          <h2>Preguntas de la encuesta </h2>
                          <ul class="nav navbar-right panel_toolbox">
                            <li><a href="./index.php?mostrar=formu_encuesta_pregunta_new" type="button" class="btn btn-primary"><i class="fa fa-plus"></i>  <small>Agregar pregunta</small></a>
                            </li>
                          </ul>
                          <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="x_panel form-group">
                                <div class=" col-md-12">
                                  <h4 class="col-md-8 col-sm-8 col-xs-12">1. ¿Que te parece el sistema de recursos?</h4>
                                  <ul class="nav navbar-right panel_toolbox">
                                    <li class="dropdown">
                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-list"></i></a>
                                      <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Actualizar</a>
                                        </li>
                                        <li><a href="#">Eliminar</a>
                                        </li>
                                      </ul>
                                    </li>
                                  </ul>
                                </div>
                                <div class="col-md-12">
                                  <div>
                                      <input type="radio" value=""> Option one. select more than one options
                                  </div>
                                  <div>
                                      <input type="radio" value=""> Option two. select more than one options
                                  </div>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>
</div>
<!-- /page content -->
<?php
    }else{
        include "./inc/error_alert.php";
    }
    $check_encuesta=null;
?>