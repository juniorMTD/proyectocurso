<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";


$start = new Conexion();

$consulta_datos = $start->Conexiondb();
$consulta_datos = $consulta_datos->query("select * from notificacionx ORDER BY fec DESC limit 0,20 ");
$datos = $consulta_datos->fetchAll();

$consulta_total = $start->Conexiondb();
$consulta_total = $consulta_total->query("select count(idnotificacionx) from notificacionx  ORDER BY fec DESC limit 0,20");
$total = (int) $consulta_total->fetchColumn();


?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>
            <h3>PANEL DE NOTIFICACIONES</h3>
            <hr>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Notificaciones <small>TerraCivil</small></h2>

                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <ul class="list-unstyled timeline">
                                       <?php
                                       if($total>0){
                                        $contador=$total+1;
                                        foreach($datos as $rows){ 
                                            $contador --;
                                            ?>
                                        
                                            <li>
                                                <div class="block">
                                                    <div class="tags">
                                                        <a href="" class="tag">
                                                            <span>Noti. N° <?php echo $contador ?></span>
                                                        </a>
                                                    </div>
                                                    <div class="block_content">
                                                        <h2 class="title">
                                                            <a><?php echo $rows['titulo'] ?></a>
                                                        </h2>
                                                        <div class="byline">
                                                            <span><?php echo tiempo_transcurrido($rows['fec']) ?></span> Publicado por: <a>TerraCivil</a>
                                                        </div>
                                                        <p class="excerpt"><?php echo $rows['mensaje'] ?></a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php } }else {?>
                                            <li>
                                                <div class="block">
                                                    <div class="tags">
                                                        <a href="" class="tag">
                                                            <span>Noti. N° 0</span>
                                                        </a>
                                                    </div>
                                                    <div class="block_content">
                                                        <h2 class="title">
                                                            <a>Por el momento no hay ninguna notificación</a>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php }?>
                                        </ul>
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