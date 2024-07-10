<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";

$id = (isset($_GET['id_update'])) ? $_GET['id_update'] : 0;
$id=limpiar_cadena($id);

$check_notificacion = $start->Conexiondb();
$check_notificacion=$check_notificacion->query("select * from notificacionx n inner join usux u on n.idusux=u.idusux
where n.idnotificacionx='$id';");

if($check_notificacion->rowCount()>0){
    $datos1=$check_notificacion->fetch();


?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>
            <h3>ACTUALIZAR LA NOTIFICACIÓN</h3>
            <strong>Formulario de Actualización</strong>
            <hr>
        </div>
        <div class="clearfix"></div>

        <div class="custom-container">
            <form id="update-form" class="custom-form" action="./php/formu_notificacion_actualizar.php" method="POST" autocomplete="off" data-redirect-url="./index.php?mostrar=formu_notificaciones">
                <!-- mensaje de alerta -->
                <div id="alert" class="alert-overlay">
                    <div class="alert-container">
                        <span class="close" onclick="closeAlert()">&times;</span>
                        <strong>¡Error!</strong> Los datos ingresados no son válidos, intente nuevamente.
                    </div>
                </div>

                <input type="hidden" name="idusu" value="<?php echo $_SESSION['id']?>">
                <input type="hidden" name="idnoti" value="<?php echo htmlspecialchars($datos1['idnotificacionx'], ENT_QUOTES, 'UTF-8');?>">

                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-titulo">Titulo (*)</label>
                        <input type="text" name="titulo" class="custom-form-control" value="<?php echo htmlspecialchars($datos1['titulo'], ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                    <div class="custom-form-group">
                    </div>
                    <div class="custom-form-group">
                    </div>
                </div>
                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-mensaje">Mensaje</label>
                        <textarea name="mensaje" class="custom-form-control"><?php echo htmlspecialchars($datos1['mensaje'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>
                    <div class="custom-form-group">
                    </div>
                </div>
                <div class="custom-form-row">
                    <button type="submit" class="custom-btn custom-btn-primary">Actualizar Publicación</button>
                    <a href="./index.php?mostrar=formu_notificaciones" type="button" class="custom-btn custom-btn-secondary">Salir</a>
                </div>
            </form>
        </div>
              
    </div>
</div>
<!-- /page content -->

<?php
    }else{
        include "./inc/error_alert.php";
    }
    $check_curso=null;
?>