<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";

?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>
            <h3>AGREGAR NUEVO PERSONAL</h3>
            <strong>Formulario de Registro</strong>
            <hr>
        </div>
        <div class="clearfix"></div>

        <div class="custom-container">
            <form id="registration-form" class="custom-form" action="./php/formu_personal_guardar.php" method="POST" autocomplete="off" data-redirect-url="./indexado.php?mostrar=formu_personal">
                
                <!-- mensaje de alerta -->
                <div id="alert" class="alert-overlay">
                    <div class="alert-container">
                        <span class="close" onclick="closeAlert()">&times;</span>
                        <strong>¡Error!</strong> Los datos ingresados no son válidos, intente nuevamente.
                    </div>
                </div>

                <div class="custom-form-row">
                    <div class="custom-form-group col-12 col-md-12 col-sm-12">
                        <label for="nom">Nombres (*)</label>
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Ingresa tus nombres" required>
                    </div>
                    <div class="custom-form-group col-12 col-md-12 col-sm-12">
                        <label for="apel">Apellidos (*)</label>
                        <input type="text" class="form-control" id="apel" name="apel" placeholder="Ingresa tus apellidos" required>
                    </div>
                </div>

                <div class="custom-form-row">
                    <div class="custom-form-group col-12 col-md-6">
                        <label for="cargo">Cargo (*)</label>
                        <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Ingresa tu cargo" required>
                    </div>
                    <div class="custom-form-group col-12 col-md-6">
                    </div>
                </div>

                <div class="custom-form-row">
                    <div class="custom-form-group col-12 col-md-4">
                        <label for="user">Usuario (*)</label>
                        <input type="text" class="form-control" id="user" name="user" placeholder="Ingresa tu usuario" required>
                    </div>
                    <div class="custom-form-group col-12 col-md-4">
                        <label for="clv">Clave (*)</label>
                        <input type="password" class="form-control" id="clv" name="clv" placeholder="Ingresa una clave" required>
                    </div>
                    <div class="custom-form-group col-12 col-md-4">
                        <label for="clv2">Confirmar Clave (*)</label>
                        <input type="password" class="form-control" id="clv2" name="clv2" placeholder="Confirma tu clave" required>
                    </div>
                </div>
                
                <div class="custom-form-row">
                    <button type="submit" class="custom-btn custom-btn-primary">Guardar</button>
                    <a href="./indexado.php?mostrar=formu_personal" type="button" class="custom-btn custom-btn-secondary">Salir</a>
                </div>
            </form>
        </div>
              
    </div>
</div>
<!-- /page content -->