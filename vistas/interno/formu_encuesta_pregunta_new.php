<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";

$start = new Conexion();
$conn = $start->Conexiondb();
$consulta_datos="select * from categoriax;";

$datos=$conn->query($consulta_datos);
$datos=$datos->fetchAll();
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>
            <h3>AGREGAR NUEVA PREGUNTA</h3>
            <strong>Formulario de Registro</strong>
            <hr>
        </div>
        <div class="clearfix"></div>

        <div class="custom-container">
            <form id="registration-form" class="custom-form" action="./php/formu_curso_guardar.php" method="POST" autocomplete="off" data-redirect-url="./index.php?mostrar=formu_curso">
                
                <!-- mensaje de alerta -->
                <div id="alert" class="alert-overlay">
                    <div class="alert-container">
                        <span class="close" onclick="closeAlert()">&times;</span>
                        <strong>¡Error!</strong> Los datos ingresados no son válidos, intente nuevamente.
                    </div>
                </div>

                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-curso">Nombre de la pregunta (*)</label>
                        <input type="text"  name="curso" class="custom-form-control">
                    </div>
                    <div class="custom-form-group">
                        <label for="custom-categoria">Tipo de pregunta (*)</label>
                            <select name="categoria" class="custom-form-control">
                                <option value="">SELECCIONA...</option>
                                <?php 
                                    foreach($datos as $rows){
                                 ?>
                                <option value="<?php echo $rows['idcategoriax'] ?>"><?php echo $rows['nomx'] ?></option>
                                <?php
                                    } 
                                 ?>
                            </select>
                    </div>
                    <div class="custom-form-group">
                        <label for="custom-estado">Estado de pregunta <small>(Marcar para activar)</small> </label>
                        <input type="checkbox" name="estado" class="custom-form-control" value="1">
                    </div>
                </div>
                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-curso">Nombre de la pregunta (*)</label>
                        <input type="text"  name="curso" class="custom-form-control">
                    </div>
                    <div class="custom-form-group">
                        <label for="custom-categoria">Tipo de pregunta (*)</label>
                            <select name="categoria" class="custom-form-control">
                                <option value="">SELECCIONA...</option>
                                <?php 
                                    foreach($datos as $rows){
                                 ?>
                                <option value="<?php echo $rows['idcategoriax'] ?>"><?php echo $rows['nomx'] ?></option>
                                <?php
                                    } 
                                 ?>
                            </select>
                    </div>
                    <div class="custom-form-group">
                        <label for="custom-estado">Estado de pregunta <small>(Marcar para activar)</small> </label>
                        <input type="checkbox" name="estado" class="custom-form-control" value="1">
                    </div>
                </div>
                <div class="custom-form-row">
                    <button type="submit" class="custom-btn custom-btn-primary">Guardar</button>
                    <a href="./index.php?mostrar=formu_curso" type="button" class="custom-btn custom-btn-secondary">Salir</a>
                </div>
            </form>
        </div>
              
    </div>
</div>
<!-- /page content -->