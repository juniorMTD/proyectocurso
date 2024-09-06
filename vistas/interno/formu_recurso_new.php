<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";


$id = (isset($_GET['idtex'])) ? $_GET['idtex'] : 0;
$id=limpiar_cadena($id);




$start = new Conexion();
$conn = $start->Conexiondb();
$consulta_datos="select * from tipo_recursox;";

$consulta_tema="select * from temax t where t.idtemax='$id';";

$datos=$conn->query($consulta_datos);
$tema=$conn->query($consulta_tema);
$datos=$datos->fetchAll();
$tema=$tema->fetchAll();
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>
            <?php 
                foreach($tema as $rows1){
            ?>
            <h3>AGREGAR NUEVO RECURSO PARA <?php echo $rows1['temx'] ?></h3>
            <strong>Formulario de Registro</strong>
            <hr>
            <?php
                } 
            ?>
        </div>
        <div class="clearfix"></div>

        <div class="custom-container">
        <?php echo ' <form id="registration-form" class="custom-form" action="./php/formu_recurso_guardar.php" method="POST" autocomplete="off" enctype="multipart/form-data" data-redirect-url="./indexado.php?mostrar=formu_recurso&idtemax='.$id.'">' ?>
                
                <!-- mensaje de alerta -->
                <div id="alert" class="alert-overlay">
                    <div class="alert-container">
                        <span class="close" onclick="closeAlert()">&times;</span>
                        <strong>¡Error!</strong> Los datos ingresados no son válidos, intente nuevamente.
                    </div>
                </div>

                <div>
                    <input type="hidden" name="idtex" value="<?php echo $id ?>" >
                </div>
                
                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-nomrecur">Nombre del Recurso (*)</label>
                        <input type="text"  name="nomrecur" class="custom-form-control">
                    </div>
                    <div class="custom-form-group"></div>
                </div>
                <div class="custom-form-row">
                    
                    <div class="custom-form-group">
                        <label for="custom-tipo_recurso">Tipo de recurso (*)</label>
                            <select name="tipo_recurso" class="custom-form-control">
                                <option value="">SELECCIONA...</option>
                                <?php 
                                    foreach($datos as $rows){
                                 ?>
                                <option value="<?php echo $rows['idtipo_recursox'] ?>"><?php echo $rows['tipox'] ?></option>
                                <?php
                                    } 
                                 ?>
                            </select>
                    </div>
                    <div class="custom-form-group">
                        <label for="custom-icono">Seleccione un icono <small>(*)</small> </label>
                        <select id="icon-select" style="width: 200px;" name="icono">
                            <option value="icon-pdf-2-50.png" class="icon-option" data-icon="icon-pdf-2-50.png">PDF</option>
                            <option value="icon-zip-50.png" class="icon-option" data-icon="icon-zip-50.png">ZIP</option>
                            <option value="icon-libro-50.png" class="icon-option" data-icon="icon-libro-50.png">WORD</option>
                            <option value="icon-fotos-48.png" class="icon-option" data-icon="icon-fotos-48.png">IMAGEN</option>
                            <option value="icon-vídeo-50.png" class="icon-option" data-icon="icon-vídeo-50.png">VIDEO</option>
                            <option value="icon-dominio-50.png" class="icon-option" data-icon="icon-dominio-50.png">WEB</option>
                        </select>
                    </div>
                </div>
                <hr>
                <small>Dependiendo al recurso que tiene, elija 1</small>
                <hr>
                <div class="custom-form-row">
                    <div class="custom-form-group">
                        <label for="custom-recurso">Suba el recurso </label>
                        <input type="file"  name="recurso" class="custom-form-control">
                    </div>
                    <div class="custom-form-group">
                        <label for="custom-recurso">Suba el enlace</label>
                        <input type="text"  name="enlace" class="custom-form-control">
                    </div>
                </div>
                <div class="custom-form-row">
                    <button type="submit" class="custom-btn custom-btn-primary">Guardar</button>
                    <?php echo '<a href="./indexado.php?mostrar=formu_recurso&idtemax='.$id.'" type="button" class="custom-btn custom-btn-secondary">Salir</a>' ?>
                </div>
            </form>
        </div>
              
    </div>
</div>
<!-- /page content -->