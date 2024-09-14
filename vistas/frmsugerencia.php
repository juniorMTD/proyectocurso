<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";

?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>
            <h3>TUS SUGERENCIAS SON MUY IMPORTANTES PARA MEJORAR</h3>
            <strong>Formulario de Sugerencias</strong>
            <hr>
        </div>
        <div class="clearfix"></div>

        <div class="custom-container">
            <form id="registration-form" class="custom-form" action="./php/formu_sugerencia_guardar.php" method="POST" autocomplete="off" data-redirect-url="./indexado.php?mostrar=home">
                
                <!-- mensaje de alerta -->
                <div id="alert" class="alert-overlay">
                    <div class="alert-container">
                        <span class="close" onclick="closeAlert()">&times;</span>
                        <strong>¡Error!</strong> Los datos ingresados no son válidos, intente nuevamente.
                    </div>
                </div>
                <input type="hidden" name="idusu" value="<?php echo $_SESSION['idusu'] ?>" >

                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-descripcion">Describa su Sugerencia (*)</label>
                        <textarea name="descripcion" class="custom-form-control"></textarea>
                    </div>
                </div>
                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-tema">Usuario: <?php echo $_SESSION['nombres']  ?> <?php echo $_SESSION['apellidos']  ?></label>
                    </div>
                </div>
                <div class="custom-form-row">
                    <button type="submit" class="custom-btn custom-btn-primary">Enviar</button>
                    <a href="./indexado.php?mostrar=home" type="button" class="custom-btn custom-btn-secondary">Salir</a>
                </div>
            </form>
        </div>
              
    </div>
</div>
<!-- /page content -->