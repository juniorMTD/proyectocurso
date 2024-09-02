<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";

$id = (isset($_GET['id_view'])) ? $_GET['id_view'] : 0;
$id=limpiar_cadena($id);

$start = new Conexion();

$check_usuario = $start->Conexiondb();
$check_usuario=$check_usuario->query("SELECT * FROM usuariox usu inner join usux u on usu.idusux=u.idusux where usu.idusuariox='$id'");

if($check_usuario->rowCount()>0){
    $datos1=$check_usuario->fetch();

?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>
            <h3>VISUALIZAR USUARIO</h3>
            <hr>
        </div>
        <div class="clearfix"></div>

        <div class="custom-container">
            <form class="custom-form" autocomplete="off" >
                
                <!-- mensaje de alerta -->
                <div id="alert" class="alert-overlay">
                    <div class="alert-container">
                        <span class="close" onclick="closeAlert()">&times;</span>
                        <strong>¡Error!</strong> Los datos ingresados no son válidos, intente nuevamente.
                    </div>
                </div>

                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-tema">Nombre y Apellidos:</label>
                        <input type="text"  name="tema" class="custom-form-control" value="<?php echo $datos1['nomx']; ?> <?php echo $datos1['apelx']; ?>" disabled>
                    </div>
                    <div class="custom-form-group">
                        <label for="custom-tema">DNI: </label>
                        <input type="text"  name="tema" class="custom-form-control" value="<?php echo $datos1['dnix']; ?>" disabled>
                    </div>
                    <div class="custom-form-group">
                    </div>
                </div>
                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-tema">Celular:</label>
                        <input type="text"  name="tema" class="custom-form-control" value="<?php echo $datos1['celx']; ?>" disabled>
                    </div>
                    <div class="custom-form-group">
                        <label for="custom-tema">Email: </label>
                        <input type="text"  name="tema" class="custom-form-control" value="<?php echo $datos1['emailx']; ?>" disabled>
                    </div>
                    <div class="custom-form-group">
                        <label for="custom-tema">Dirección: </label>
                        <textarea disabled><?php echo $datos1['dirx']; ?></textarea>
                    </div>
                    
                </div>
                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-tema">UNIVERSIDAD: </label>
                        <input type="text"  name="tema" class="custom-form-control" value="<?php echo $datos1['unix']; ?>" disabled>
                    </div>
                    <div class="custom-form-group">
                        <label for="custom-tema">FACULTAD: </label>
                        <input type="text"  name="tema" class="custom-form-control" value="<?php echo $datos1['facux']; ?>" disabled>
                    </div>
                    <div class="custom-form-group">
                        <label for="custom-tema">ESCUELA: </label>
                        <input type="text"  name="tema" class="custom-form-control" value="<?php echo $datos1['escux']; ?>" disabled>
                    </div>
                </div>
                <hr>
                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-tema">USUARIO: </label>
                        <input type="text"  name="tema" class="custom-form-control" value="<?php echo $datos1['usux']; ?>" disabled> 
                    </div>
                    <div class="custom-form-group">
                        <label for="custom-tema">CLAVE: </label>
                        <input type="password"  name="tema" class="custom-form-control" value="<?php echo $datos1['clvx']; ?>" disabled>
                    </div>
                    <div class="custom-form-group">
                    </div>
                </div>
                
                <div class="custom-form-row">
                    <a href="./indexado.php?mostrar=formu_usuario" type="button" class="custom-btn custom-btn-secondary">Salir</a>
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