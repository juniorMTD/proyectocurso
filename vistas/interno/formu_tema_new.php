<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";

$start = new Conexion();
$conn = $start->Conexiondb();
$consulta_datos="select * from cursox;";

$datos=$conn->query($consulta_datos);
$datos=$datos->fetchAll();

?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>
            <h3>AGREGAR NUEVO TEMA</h3>
            <strong>Formulario de Registro</strong>
            <hr>
        </div>
        <div class="clearfix"></div>

        <div class="custom-container">
            <form id="registration-form" class="custom-form" action="./php/formu_tema_guardar.php" method="POST" autocomplete="off" data-redirect-url="./indexado.php?mostrar=formu_tema">
                
                <!-- mensaje de alerta -->
                <div id="alert" class="alert-overlay">
                    <div class="alert-container">
                        <span class="close" onclick="closeAlert()">&times;</span>
                        <strong>¡Error!</strong> Los datos ingresados no son válidos, intente nuevamente.
                    </div>
                </div>

                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-tema">Nombre del tema (*)</label>
                        <input type="text"  name="tema" class="custom-form-control">
                    </div>
                    <div class="custom-form-group">
                        <label for="custom-curso">Curso (*)</label>
                            <select name="curso" class="custom-form-control">
                                <option value="">SELECCIONA...</option>
                                <?php 
                                    foreach($datos as $rows){
                                 ?>
                                <option value="<?php echo $rows['idcursox'] ?>"><?php echo $rows['nombre'] ?></option>
                                <?php
                                    } 
                                 ?>
                            </select>
                    </div>
                    <div class="custom-form-group">
                        <label for="custom-estado">Marcar para publicar</label>
                        <input type="checkbox" name="estado" value="1" class="custom-form-control">
                    </div>
                </div>
                <div class="custom-form-row">
                    <button type="submit" class="custom-btn custom-btn-primary">Guardar</button>
                    <a href="./indexado.php?mostrar=formu_tema" type="button" class="custom-btn custom-btn-secondary">Salir</a>
                </div>
            </form>
        </div>
              
    </div>
</div>
<!-- /page content -->