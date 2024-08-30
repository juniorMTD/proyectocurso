<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>
            <h3>AGREGAR NUEVA CATEGORIA DE CURSOS</h3>
            <strong>Formulario de Registro</strong>
            <hr>
        </div>
        <div class="clearfix"></div>

        <div class="custom-container">
            <form id="registration-form" class="custom-form" action="./php/formu_categoria_guardar.php" method="POST" autocomplete="off" data-redirect-url="./indexado.php?mostrar=formu_categoria">
                <!-- mensaje de alerta -->
                <div id="alert" class="alert-overlay">
                    <div class="alert-container">
                        <span class="close" onclick="closeAlert()">&times;</span>
                        <strong>¡Error!</strong> Los datos ingresados no son válidos, intente nuevamente.
                    </div>
                </div>

                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-categoria">Nombre de la categoria (*)</label>
                        <input type="text" name="categoria" class="custom-form-control">
                    </div>
                    <div class="custom-form-group">
                        <!-- <label for="custom-departamento">Departamento</label>
                        <select id="custom-departamento" name="departamento" class="custom-form-control">
                        </select> -->
                    </div>
                    <div class="custom-form-group">
                        <!-- <label for="custom-provincia">Provincia</label>
                        <select id="custom-provincia" name="provincia" class="custom-form-control">
                        </select> -->
                    </div>
                </div>
                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-descripcion">Descripcion</label>
                        <textarea name="descripcion" class="custom-form-control"></textarea>
                    </div>
                    <div class="custom-form-group">
                    </div>
                </div>
                <div class="custom-form-row">
                    <button type="submit" class="custom-btn custom-btn-primary">Guardar</button>
                    <a href="./indexado.php?mostrar=formu_categoria" type="button" class="custom-btn custom-btn-secondary">Salir</a>
                </div>
            </form>
        </div>
              
    </div>
</div>
<!-- /page content -->