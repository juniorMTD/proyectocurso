<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";

$id = (isset($_GET['id_update'])) ? $_GET['id_update'] : 0;
$id=limpiar_cadena($id);

$start = new Conexion();
$check_personal = $start->Conexiondb();
$check_personal=$check_personal->query("SELECT * FROM empleado e inner join usux u on e.idusux=u.idusux where e.idempleado='$id'");

if($check_personal->rowCount()>0){
    $datos1=$check_personal->fetch();

?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>
            <h3>ACTUALIZAR PERSONAL</h3>
            <strong>Formulario de Actualización</strong>
            <hr>
        </div>
        <div class="clearfix"></div>

        <div class="custom-container">
            <form id="update-form" class="custom-form" action="./php/formu_personal_actualizar.php" method="POST" autocomplete="off" data-redirect-url="./indexado.php?mostrar=formu_personal">
                
                <!-- mensaje de alerta -->
                <div id="alert" class="alert-overlay">
                    <div class="alert-container">
                        <span class="close" onclick="closeAlert()">&times;</span>
                        <strong>¡Error!</strong> Los datos ingresados no son válidos, intente nuevamente.
                    </div>
                </div>

                <input type="hidden" value="<?php echo $datos1['idempleado']; ?>" name="idempleado" required>

                <div class="custom-form-row">
                    <div class="custom-form-group col-12 col-md-12 col-sm-12">
                        <label for="nom">Nombres (*)</label>
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Ingresa tus nombres" value="<?php echo $datos1['nomx']; ?>" required>
                    </div>
                    <div class="custom-form-group col-12 col-md-12 col-sm-12">
                        <label for="apel">Apellidos (*)</label>
                        <input type="text" class="form-control" id="apel" name="apel" placeholder="Ingresa tus apellidos" value="<?php echo $datos1['apelx']; ?>" required>
                    </div>
                </div>

                <div class="custom-form-row">
                    <div class="custom-form-group col-12 col-md-6">
                        <label for="cargo">Cargo (*)</label>
                        <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Ingresa tu cargo" value="<?php echo $datos1['cargo']; ?>" required>
                    </div>
                    <div class="custom-form-group col-12 col-md-6">
                        <label for="custom-estado">Estado del personal<small></small> </label>
                        <input type="checkbox" name="estado" class="custom-form-control" value="1" <?php echo $datos1['estadox'] ? 'checked' : '';?>>
                    </div>
                </div>

                <div class="custom-form-row">
                    <div class="custom-form-group col-12 col-md-4">
                        <label for="user">Usuario (*)</label>
                        <input type="text" class="form-control" id="user" name="user" placeholder="Ingresa tu usuario" value="<?php echo $datos1['usux']; ?>" required>
                    </div>
                    <div class="custom-form-group col-12 col-md-4">
                        <label for="clv">Clave (*)</label>
                        <input type="password" class="form-control" id="clv" name="clv" placeholder="Ingresa una clave">
                    </div>
                    <div class="custom-form-group col-12 col-md-4">
                        <label for="clv2">Confirmar Clave (*)</label>
                        <input type="password" class="form-control" id="clv2" name="clv2" placeholder="Confirma tu clave" >
                    </div>
                </div>
                
                <div class="custom-form-row">
                    <button type="submit" class="custom-btn custom-btn-primary">Actualizar</button>
                    <a href="./indexado.php?mostrar=formu_personal" type="button" class="custom-btn custom-btn-secondary">Salir</a>
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
    $check_personal=null;
?>