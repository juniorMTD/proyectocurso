<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";



$id = (isset($_GET['id_update'])) ? $_GET['id_update'] : 0;
$id=limpiar_cadena($id);



$start = new Conexion();
$conn = $start->Conexiondb();
$consulta_datos="select * from categoriax;";

$datos=$conn->query($consulta_datos);
$datos=$datos->fetchAll();


$check_curso = $start->Conexiondb();
$check_curso=$check_curso->query("SELECT * FROM cursox c where c.idcursox='$id'");

if($check_curso->rowCount()>0){
    $datos1=$check_curso->fetch();

?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>
            <h3>ACTUALIZAR CURSO</h3>
            <strong>Formulario de Actualización</strong>
            <hr>
        </div>
        <div class="clearfix"></div>

        <div class="custom-container">
            <form id="update-form" class="custom-form" action="./php/formu_curso_actualizar.php" method="POST" autocomplete="off" data-redirect-url="./indexado.php?mostrar=formu_curso">
                
                <!-- mensaje de alerta -->
                <div id="alert" class="alert-overlay">
                    <div class="alert-container">
                        <span class="close" onclick="closeAlert()">&times;</span>
                        <strong>¡Error!</strong> Los datos ingresados no son válidos, intente nuevamente.
                    </div>
                </div>

                <input type="hidden" value="<?php echo $datos1['idcursox']; ?>" name="idcu" required>

                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-curso">Nombre del curso (*)</label>
                        <input type="text"  name="curso" class="custom-form-control" value="<?php echo $datos1['nombre']; ?>">
                    </div>
                    <div class="custom-form-group">
                        <label for="custom-categoria">Categoria (*)</label>
                            <select name="categoria" class="custom-form-control">
                                <option value="">SELECCIONA...</option>
                                <?php 
                                    foreach ($datos as $rows) {
                                        $selected = ($rows['idcategoriax'] == $datos1['idcategoriax']) ? 'selected' : '';
                                        echo "<option value='{$rows['idcategoriax']}' $selected>{$rows['nomx']}</option>";
                                    }
                                ?>
                            </select>
                    </div>
                    <div class="custom-form-group">
                        <label for="custom-estado">Estado del Curso <small>(Marcar para publicar)</small> </label>
                        <input type="checkbox" name="estado" class="custom-form-control" value="1" <?php echo $datos1['estadox'] ? 'checked' : '';?>>
                    </div>
                </div>
                <hr>
                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-docente">Nombres y Apellidos del docente (*)</label>
                        <input type="text" name="docente" class="custom-form-control" value="<?php echo $datos1['docentex']; ?>">
                    </div>
                    <div class="custom-form-group">
                        <label for="custom-celular">N° de Celular del Docente(*)</label>
                        <input type="text" name="celular" class="custom-form-control" value="<?php echo $datos1['celularx']; ?>">
                    </div>
                </div>
                <div class="custom-form-row">
                    <button type="submit" class="custom-btn custom-btn-primary">Actualizar</button>
                    <a href="./indexado.php?mostrar=formu_curso" type="button" class="custom-btn custom-btn-secondary">Salir</a>
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