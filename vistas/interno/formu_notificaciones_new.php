<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>
            <h3>PUBLICAR UNA NUEVA NOTIFICACIÓN</h3>
            <strong>Formulario de Registro</strong>
            <hr>
        </div>
        <div class="clearfix"></div>

        <div class="custom-container">
            <form id="registration-form" class="custom-form" action="./php/formu_notificacion_guardar.php" method="POST" autocomplete="off" data-redirect-url="./index.php?mostrar=formu_notificaciones">
                <!-- mensaje de alerta -->
                <div id="alert" class="alert-overlay">
                    <div class="alert-container">
                        <span class="close" onclick="closeAlert()">&times;</span>
                        <strong>¡Error!</strong> Los datos ingresados no son válidos, intente nuevamente.
                    </div>
                </div>

                <input type="hidden" name="idusu" value="<?php echo $_SESSION['id']?>">

                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-titulo">Titulo (*)</label>
                        <input type="text" name="titulo" class="custom-form-control">
                    </div>
                    <div class="custom-form-group">
                    </div>
                    <div class="custom-form-group">
                    </div>
                </div>
                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-mensaje">Mensaje</label>
                        <textarea name="mensaje" class="custom-form-control"></textarea>
                    </div>
                    <div class="custom-form-group">
                    </div>
                </div>
                <div class="custom-form-row">
                    <button type="submit" class="custom-btn custom-btn-primary">Publicar</button>
                    <a href="./index.php?mostrar=formu_notificaciones" type="button" class="custom-btn custom-btn-secondary">Salir</a>
                </div>
            </form>
        </div>
              
    </div>
</div>
<!-- /page content -->