<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";

?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>
            <h3>AGREGAR NUEVA ENCUESTA</h3>
            <strong>Formulario de Registro</strong>
            <hr>
        </div>
        <div class="clearfix"></div>

        <div class="custom-container">
            <form id="registration-form" class="custom-form" action="./php/formu_encuesta_guardar.php" method="POST" autocomplete="off" data-redirect-url="./index.php?mostrar=formu_encuesta">
                
                <!-- mensaje de alerta -->
                <div id="alert" class="alert-overlay">
                    <div class="alert-container">
                        <span class="close" onclick="closeAlert()">&times;</span>
                        <strong>¡Error!</strong> Los datos ingresados no son válidos, intente nuevamente.
                    </div>
                </div>

                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-encuesta">Nombre de la encuesta (*)</label>
                        <input type="text"  name="encuesta" class="custom-form-control">
                    </div>
                    <div class="custom-form-group">
                    </div>
                    
                    <div class="custom-form-group">
                        <label for="custom-estado">Publicar encuesta <small>(Marque para publicar)</small> </label>
                        <input type="checkbox" name="estado" class="custom-form-control" value="1">
                    </div>
                </div>
                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-encuesta">Descripcion (*)</label>
                        <textarea name="descripcion"></textarea>
                    </div>
                </div>
                <div class="custom-form-row">
                    <button type="submit" class="custom-btn custom-btn-primary">Guardar</button>
                    <a href="./index.php?mostrar=formu_encuesta" type="button" class="custom-btn custom-btn-secondary">Salir</a>
                </div>
            </form>
        </div>
              
    </div>
</div>
<!-- /page content -->