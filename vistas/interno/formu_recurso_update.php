<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";


$id = (isset($_GET['id_update'])) ? $_GET['id_update'] : 0;
$id=limpiar_cadena($id);



$start = new Conexion();
$conn = $start->Conexiondb();
$consulta_datos="select * from tipo_recursox;";


$datos=$conn->query($consulta_datos);

$datos=$datos->fetchAll();

$check_curso = $start->Conexiondb();
$check_curso=$check_curso->query("select * from recursox r inner join temax t on r.idtemax=t.idtemax
where r.idrecursox='$id';");

if($check_curso->rowCount()>0){
    $datos1=$check_curso->fetch();


$ruta_archivo = './biblioteca/images/archivos_recursos/'.$datos1['recurso'];

?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>

            <h3>ACTUALIZAR RECURSO PARA <?php echo $datos1['temx'] ?></h3>
            <strong>Formulario de Actualización</strong>
            <hr>
        </div>
        <div class="clearfix"></div>

        <div class="custom-container">
        <?php echo ' <form id="update-form" class="custom-form" action="./php/formu_recurso_actualizar.php" method="POST" autocomplete="off" enctype="multipart/form-data" data-redirect-url="./index.php?mostrar=formu_recurso&idtemax='. $datos1['idtemax'].'">' ?>
                
                <!-- mensaje de alerta -->
                <div id="alert" class="alert-overlay">
                    <div class="alert-container">
                        <span class="close" onclick="closeAlert()">&times;</span>
                        <strong>¡Error!</strong> Los datos ingresados no son válidos, intente nuevamente.
                    </div>
                </div>


                <input type="hidden" value="<?php echo $datos1['idrecursox']; ?>" name="idrecurso" required>
                
                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-nomrecur">Nombre del Recurso (*)</label>
                        <input type="text"  name="nomrecur" class="custom-form-control" value="<?php echo htmlspecialchars($datos1['nom_recu'], ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                    <div class="custom-form-group"></div>
                </div>

                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-recurso">Suba el recurso (*)</label>
                        <label for="custom-recurso">Recurso Actual:</label>
                        <?php if ($datos1['recurso']): ?>
                            <p>Archivo actual: <a href="<?php echo htmlspecialchars($ruta_archivo, ENT_QUOTES, 'UTF-8'); ?>" download><?php echo htmlspecialchars($datos1['recurso'], ENT_QUOTES, 'UTF-8'); ?></a></p>
                        <?php else: ?>
                            <p>No hay ningún archivo cargado.</p>
                        <?php endif; ?>
                        <label for="custom-recurso">Subir un nuevo recurso:</label>
                        <input type="file" name="recurso" class="custom-form-control">
                    </div>
                    <div class="custom-form-group">
                        <label for="custom-tipo_recurso">Tipo de recurso (*)</label>
                            <select name="tipo_recurso" class="custom-form-control">
                                <option value="">SELECCIONA...</option>
                                <?php 
                                    foreach ($datos as $rows) {
                                        $selected = ($rows['idtipo_recursox'] == $datos1['idtipo_recursox']) ? 'selected' : '';
                                        echo "<option value='{$rows['idtipo_recursox']}' $selected>{$rows['tipox']}</option>";
                                    }
                                ?>
                            </select>
                    </div>
                    <div class="custom-form-group">
                        <label for="custom-icono">Seleccione un icono <small>(*)</small> </label>
                        <select id="icon-select" style="width: 200px;" name="icono">
                            <option value="icon-pdf-2-50.png" class="icon-option" data-icon="icon-pdf-2-50.png" <?php echo $datos1['icono']=='icon-pdf-2-50.png' ? 'selected' : ''; ?>>PDF</option>
                            <option value="icon-zip-50.png" class="icon-option" data-icon="icon-zip-50.png" <?php echo $datos1['icono']=='icon-zip-50.png' ? 'selected' : ''; ?>>ZIP</option>
                            <option value="icon-libro-50.png" class="icon-option" data-icon="icon-libro-50.png" <?php echo $datos1['icono']=='icon-libro-50.png' ? 'selected' : ''; ?>>WORD</option>
                            <option value="icon-fotos-48.png" class="icon-option" data-icon="icon-fotos-48.png" <?php echo $datos1['icono']=='icon-fotos-48.png' ? 'selected' : ''; ?>>IMAGEN</option>
                            <option value="icon-vídeo-50.png" class="icon-option" data-icon="icon-vídeo-50.png" <?php echo $datos1['icono']=='icon-video-50.png' ? 'selected' : ''; ?>>VIDEO</option>
                            <option value="icon-dominio-50.png" class="icon-option" data-icon="icon-dominio-50.png" <?php echo $datos1['icono']=='icon-dominio-50.png' ? 'selected' : ''; ?>>WEB</option>
                        </select>
                    </div>
                </div>
                <div class="custom-form-row">
                    <button type="submit" class="custom-btn custom-btn-primary">Actualizar</button>
                    <?php echo '<a href="./index.php?mostrar=formu_recurso&idtemax='.$datos1['idtemax'].'" type="button" class="custom-btn custom-btn-secondary">Salir</a>' ?>
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
    $check_curso=null;
?>