<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";


$id = (isset($_GET['id_update'])) ? $_GET['id_update'] : 0;
$id=limpiar_cadena($id);

$start = new Conexion();

$check_curso = $start->Conexiondb();
$check_curso=$check_curso->query("select * from sugerenciax r where r.idsugerenciax='$id';");

if($check_curso->rowCount()>0){
    $datos1=$check_curso->fetch();

?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>
            <h3>VISUALIZAR SUGERENCIA</h3>
            <strong>Vista de Sugerencias</strong>
            <hr>
        </div>
        <div class="clearfix"></div>

        <div class="custom-container">
            <form  class="custom-form"  autocomplete="off">
                
                <!-- mensaje de alerta -->
                <div id="alert" class="alert-overlay">
                    <div class="alert-container">
                        <span class="close" onclick="closeAlert()">&times;</span>
                        <strong>¡Error!</strong> Los datos ingresados no son válidos, intente nuevamente.
                    </div>
                </div>
                <input type="hidden" name="idusu" value="<?php echo $_SESSION['id'] ?>" >

                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-descripcion">Describa su Sugerencia (*)</label>
                        <textarea name="descripcion" class="custom-form-control" disabled><?php echo htmlspecialchars($datos1['descx'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>
                </div>
                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-tema">Usuario: <?php echo $_SESSION['nombres']  ?> <?php echo $_SESSION['apellidos']  ?></label>
                    </div>
                </div>
                <div class="custom-form-row">
                    <a href="./index.php?mostrar=formu_sugerencias" type="button" class="custom-btn custom-btn-secondary">Salir</a>
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