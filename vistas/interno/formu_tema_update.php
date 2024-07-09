<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";

$id = (isset($_GET['id_update'])) ? $_GET['id_update'] : 0;
$id=limpiar_cadena($id);

$start = new Conexion();
$conn = $start->Conexiondb();
$consulta_datos="select * from cursox;";

$datos=$conn->query($consulta_datos);
$datos=$datos->fetchAll();

$check_tema = $start->Conexiondb();
$check_tema=$check_tema->query("SELECT * FROM temax t where t.idtemax='$id'");

if($check_tema->rowCount()>0){
    $datos1=$check_tema->fetch();

?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>
            <h3>ACTUALIZAR TEMA</h3>
            <strong>Formulario de Actualización</strong>
            <hr>
        </div>
        <div class="clearfix"></div>

        <div class="custom-container">
            <form id="update-form" class="custom-form" action="./php/formu_tema_actualizar.php" method="POST" autocomplete="off" data-redirect-url="./index.php?mostrar=formu_tema">
                
                <!-- mensaje de alerta -->
                <div id="alert" class="alert-overlay">
                    <div class="alert-container">
                        <span class="close" onclick="closeAlert()">&times;</span>
                        <strong>¡Error!</strong> Los datos ingresados no son válidos, intente nuevamente.
                    </div>
                </div>
                <input type="hidden" value="<?php echo $datos1['idtemax']; ?>" name="idtema" required>

                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-tema">Nombre del tema (*)</label>
                        <input type="text"  name="tema" class="custom-form-control" value="<?php echo $datos1['temx']; ?>">
                    </div>
                    <div class="custom-form-group">
                        <label for="custom-curso">Curso (*)</label>
                            <select name="curso" class="custom-form-control">
                                <option value="">SELECCIONA...</option>
                                <?php 
                                    foreach ($datos as $rows) {
                                        $selected = ($rows['idcursox'] == $datos1['idcursox']) ? 'selected' : '';
                                        echo "<option value='{$rows['idcursox']}' $selected>{$rows['nombre']}</option>";
                                    }
                                ?>
                            </select>
                    </div>
                    <div class="custom-form-group">
                        <label for="custom-estado">Estado del estado (*)</label>
                        <input type="checkbox" name="estado" value="1" <?php echo $datos1['estadox'] ? 'checked' : '';?> class="custom-form-control">
                    </div>
                </div>
                <div class="custom-form-row">
                    <button type="submit" class="custom-btn custom-btn-primary">Actualizar</button>
                    <a href="./index.php?mostrar=formu_tema" type="button" class="custom-btn custom-btn-secondary">Salir</a>
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
    $check_tema=null;
?>