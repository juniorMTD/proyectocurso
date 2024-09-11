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
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                              <h5><?php echo $datos['descripx'] ?></h5>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <?php echo ($datos['estado_encuesta']) ? 'PUBLICADO':'NO PUBLICADO'  ?>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                              <h5><?php echo $datos['f_creacion'] ?></h5>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                              <a href="./indexado.php?mostrar=formu_encuesta" type="button" class="btn btn-warning"><i class="fa fa-mail-reply"></i>  Salir</a>
                            </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-8 col-xs-12">
                      <div class="x_panel">
                        <div class="x_title">
                          <h2>Preguntas de la encuesta </h2>
                          <ul class="navbar-right">
                            <?php echo ' <li><a href="./indexado.php?mostrar=formu_encuesta_pregunta_new&idencuesta='.$datos['idencuestax'].'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i>  <small>Agregar pregunta</small></a>' ?>
                            </li>
                          </ul>
                          <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <?php
                              $encuesta_pregunta = $start->Conexiondb();
                              $encuesta_pregunta=$encuesta_pregunta->query("select * from preguntax p inner join opcionx o on o.idpreguntax=p.idpreguntax where p.idencuestax='".$datos['idencuestax']."' group by o.idpreguntax;");
                              $datos1=$encuesta_pregunta->fetchAll();
                              $contador = 1;
                              foreach($datos1 as $rows1){
                            ?>
                            <div class="x_panel form-group">
                                <div class=" col-md-12">
                                  <h4 class="col-md-8 col-sm-8 col-xs-12"><?php echo $contador ?>.  <?php  echo $rows1['texto_pregunta'] ?></h4>
                                  <ul class="nav navbar-right panel_toolbox">
                                    <li class="dropdown">
                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-list"></i></a>
                                      <ul class="dropdown-menu" role="menu">
                                        <li><a href="./indexado.php?mostrar=formu_encuesta_pregunta_update&idpregunta=<?php echo $rows1['idpreguntax'] ?>&idencuesta=<?php echo $rows1['idencuestax'] ?>"><i class="fa fa-edit"></i> Actualizar</a>
                                        </li>
                                        <li id="delete-form">
                                          <a href="#" type="button" class="delete-btn" data-url="php/formu_encuesta_pregunta_eliminar.php?id_delete=<?php echo $rows1['idpreguntax'] ?>">
                                            <i class="fa fa-trash"></i> Eliminar
                                          </a>
                                        </li>
                                      </ul>
                                    </li>
                                  </ul>
                                </div>
                                <div class="col-md-12">
                                  <?php $encuesta_pregunta2 = $start->Conexiondb();
                                  $encuesta_pregunta2=$encuesta_pregunta2->query("select * from preguntax p inner join opcionx o on o.idpreguntax=p.idpreguntax where p.idencuestax='".$datos['idencuestax']."' and o.idpreguntax='".$rows1['idpreguntax']."'");
                                  $datos2=$encuesta_pregunta2->fetchAll();
                                  foreach($datos2 as $rows2){ 
                                    if($rows2['idtipo_preguntax']==1){
                                ?>
                                  <div>
                                      <input type="radio" name="pregunta_<?php echo $rows1['idpreguntax']; ?>" value="<?php echo $rows2['texto_opcionx'] ?>"> <?php echo $rows2['texto_opcionx'] ?>
                                  </div>
                                <?php
                                    }else if($rows2['idtipo_preguntax']==2){
                                      ?>
                                  <div>
                                      <input type="checkbox" name="pregunta_<?php echo $rows1['idpreguntax']; ?>[]"  value="<?php echo $rows2['texto_opcionx'] ?>"> <?php echo $rows2['texto_opcionx'] ?>
                                  </div>
                                      <?php
                                    }
                                  }
                                ?>
                                </div>
                            </div>
                            <?php
                              $contador++;
                              }
                            ?>
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