<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";


$id = (isset($_GET['id_update'])) ? $_GET['id_update'] : 0;
$id=limpiar_cadena($id);



$start = new Conexion();
$check_categoria = $start->Conexiondb();
$check_categoria=$check_categoria->query("SELECT * FROM categoriax c where c.idcategoriax='$id'");


if($check_categoria->rowCount()>0){
    $datos=$check_categoria->fetch();
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>
            <h3>ACTUALIZAR CATEGORIA DE CURSOS</h3>
            <strong>Formulario para Actualizar</strong>
            <hr>
        </div>
        <div class="clearfix"></div>

        <div class="custom-container">
            <form id="update-form" class="custom-form" action="./php/formu_categoria_actualizar.php" method="POST" autocomplete="off" data-redirect-url="./index.php?mostrar=formu_categoria">
                <!-- mensaje de alerta -->
                <div id="alert" class="alert-overlay">
                    <div class="alert-container">
                        <span class="close" onclick="closeAlert()">&times;</span>
                        <strong>¡Error!</strong> Los datos ingresados no son válidos, intente nuevamente.
                    </div>
                </div>

                <input type="hidden" value="<?php echo $datos['idcategoriax']; ?>" name="idcate" required>

                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-categoria">Nombre de la categoria (*)</label>
                        <input type="text" name="categoria" class="custom-form-control" value="<?php echo $datos['nomx']; ?>">
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
                        <textarea name="descripcion" class="custom-form-control" value="<?php echo $datos['descx']; ?>"></textarea>
                    </div>
                    <div class="custom-form-group">
                    </div>
                </div>
                <div class="custom-form-row">
                    <button type="submit" class="custom-btn custom-btn-primary ">Actualizar</button>
                    <a href="./index.php?mostrar=formu_categoria" type="button" class="custom-btn custom-btn-secondary">Salir</a>
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
    $check_categoria=null;
?>