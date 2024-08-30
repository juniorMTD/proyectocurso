<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";



$id = (isset($_GET['id_update'])) ? $_GET['id_update'] : 0;
$id=limpiar_cadena($id);

$start = new Conexion();


$check_encuesta = $start->Conexiondb();
$check_encuesta=$check_encuesta->query("SELECT * FROM encuestax  where idencuestax='$id'");

if($check_encuesta->rowCount()>0){
    $datos1=$check_encuesta->fetch();

?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>
            <h3>ACTUALIZAR ENCUESTA</h3>
            <strong>Formulario de Actualización</strong>
            <hr>
        </div>
        <div class="clearfix"></div>

        <div class="custom-container">
            <form id="update-form" class="custom-form" action="./php/formu_encuesta_actualizar.php" method="POST" autocomplete="off" data-redirect-url="./indexado.php?mostrar=formu_encuesta">
                
                <!-- mensaje de alerta -->
                <div id="alert" class="alert-overlay">
                    <div class="alert-container">
                        <span class="close" onclick="closeAlert()">&times;</span>
                        <strong>¡Error!</strong> Los datos ingresados no son válidos, intente nuevamente.
                    </div>
                </div>

                <input type="hidden" value="<?php echo $datos1['idencuestax']; ?>" name="idencu" required>

                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-encuesta">Nombre de la encuesta (*)</label>
                        <input type="text"  name="encuesta" class="custom-form-control" value="<?php echo $datos1['titulox']; ?>">
                    </div>
                    <div class="custom-form-group">
                    </div>
                    
                    <div class="custom-form-group">
                        <label for="custom-estado">Publicar encuesta <small>(Marque para publicar)</small> </label>
                        <input type="checkbox" name="estado" class="custom-form-control" value="1" <?php echo $datos1['estado_encuesta'] ? 'checked' : '';?>>
                    </div>
                </div>
                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-encuesta">Descripcion (*)</label>
                        <textarea name="descripcion"><?php echo $datos1['descripx']; ?></textarea>
                    </div>
                </div>
                <div class="custom-form-row">
                    <button type="submit" class="custom-btn custom-btn-primary">Actualizar</button>
                    <a href="./indexado.php?mostrar=formu_encuesta" type="button" class="custom-btn custom-btn-secondary">Salir</a>
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
    $check_encuesta=null;
?>

