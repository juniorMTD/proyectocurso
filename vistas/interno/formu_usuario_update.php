<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";

$id_usuario = limpiar_cadena($_SESSION['id']);

$start = new Conexion();
$check_usuario = $start->Conexiondb();
$check_usuario=$check_usuario->query("SELECT * FROM usuariox usu inner join usux u on usu.idusux=u.idusux where usu.idusuariox='$id_usuario'");

if($check_usuario->rowCount()>0){
    $datos1=$check_usuario->fetch();

?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>
            <h3>EDICIÓN DE PERFIL</h3>
        </div>
        <div class="clearfix"></div>

        <div class="custom-container">
            <form id="update-form" class="custom-form" action="./php/formu_usuario_actualizar.php" method="POST" autocomplete="off" data-redirect-url="./indexado.php?mostrar=login">
                
                <!-- mensaje de alerta -->
                <div id="alert" class="alert-overlay">
                    <div class="alert-container">
                        <span class="close" onclick="closeAlert()">&times;</span>
                        <strong>¡Error!</strong> Los datos ingresados no son válidos, intente nuevamente.
                    </div>
                </div>

                <input type="hidden" value="<?php echo $datos1['idusuariox']; ?>" name="idusu" required>

                <div class="custom-form-row">
                    <div class="custom-form-group col-12 col-md-12 col-sm-12">
                        <label for="dni">DNI (*)</label>
                        <input type="text" class="form-control" id="dni" name="dni" placeholder="Ingresa tus nombres" value="<?php echo $datos1['dnix']; ?>" required>
                    </div>
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
                    <div class="custom-form-group col-12 col-md-12 col-sm-12">
                        <label for="cel">N° Celular (*)</label>
                        <input type="text" class="form-control" id="cel" name="cel" placeholder="Ingresa tu numero de celular" value="<?php echo $datos1['celx']; ?>" required>
                    </div>
                    <div class="custom-form-group col-12 col-md-12 col-sm-12">
                        <label for="email">Email (*)</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Ingresa tu correo electronico" value="<?php echo $datos1['emailx']; ?>" required>
                    </div>
                    <div class="custom-form-group col-12 col-md-12 col-sm-12">
                        <label for="dire">Dirección (*)</label>
                        <textarea type="text" class="form-control" id="dire" name="dire" placeholder="Ingresa tu dirección" required><?php echo $datos1['dirx']; ?></textarea>
                    </div>
                </div>

                <div class="custom-form-row">
                    <div class="custom-form-group col-12 col-md-12 col-sm-12">
                        <label for="uni">Universidad (*)</label>
                        <input type="text" class="form-control" id="uni" name="uni" placeholder="Ingresa tu universidad" value="<?php echo $datos1['unix']; ?>" required>
                    </div>
                    <div class="custom-form-group col-12 col-md-12 col-sm-12">
                        <label for="facu">Facultad (*)</label>
                        <input type="text" class="form-control" id="facu" name="facu" placeholder="Ingresa tu facultad" value="<?php echo $datos1['facux']; ?>" required>
                    </div>
                    <div class="custom-form-group col-12 col-md-12 col-sm-12">
                        <label for="escuela">Escuela (*)</label>
                        <input type="text" class="form-control" id="escuela" name="escuela" placeholder="Ingresa tus escuela" value="<?php echo $datos1['escux']; ?>" required>
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
    $check_usuario=null;
?>