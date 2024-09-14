<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";

$start = new Conexion();
$conn = $start->Conexiondb();

// Verificar que la sesión esté iniciada
if (!isset($_SESSION['idusu'])) {
    // Manejar el caso donde no haya sesión
    echo "Sesión no iniciada.";
    exit();
}

$check_encuesta=$start->Conexiondb();
$check_encuesta=$check_encuesta->query("select idencuestax,estado_encuesta from encuestax order by idencuestax desc limit 0,1");

$encuesta=$check_encuesta->fetch(PDO::FETCH_ASSOC);

if ($encuesta) {
if($encuesta && $encuesta['estado_encuesta']==1){
    $idusuario = $_SESSION['idusu'];
    $idencuesta = $encuesta['idencuestax'];
    
    $check_respuesta = $conn->prepare("SELECT COUNT(*) FROM encuesta_usux WHERE idusux = :idusuario AND idencuestax = :idencuesta");
    $check_respuesta->execute([':idusuario' => $idusuario, ':idencuesta' => $idencuesta]);
    $respuestas = $check_respuesta->fetchColumn();
    if ($respuestas > 0) {
        include "categoriahtml.php";
    }else{

    // Obtener las preguntas y opciones de la encuesta activa
    $preguntas = $conn->query("SELECT * FROM preguntax WHERE idencuestax = (SELECT idencuestax FROM encuestax ORDER BY idencuestax DESC LIMIT 1);");
    $preguntas = $preguntas->fetchAll();
?>


<!-- jdksdjssddjsdkskdsd -->
<div class="right_col" role="main">
    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="x_panel" style="background:#2A3F54">
                <div class="x_title">
                    <h3>ENCUESTA</h3>
                        <center><small>Por favor responda con sinceridad cada pregunta</small></center>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                    <form id="registration-form" class="custom-form"  action="./php/formu_respuesta_guardar.php" method="POST" autocomplete="off" enctype="multipart/form-data" data-redirect-url="./indexado.php?mostrar=frmprincipal">
                        <input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>">
                        <input type="hidden" name="idencuesta" value="<?php echo htmlspecialchars($encuesta['idencuestax'],ENT_QUOTES, 'UTF-8'); ?>">
                        <?php foreach ($preguntas as $pregunta) {
                            // Obtener las opciones para cada pregunta
                            $opciones = $conn->prepare("SELECT * FROM opcionx WHERE idpreguntax = :idpregunta");
                            $opciones->bindParam(':idpregunta', $pregunta['idpreguntax'], PDO::PARAM_INT);
                            $opciones->execute();
                            $opciones = $opciones->fetchAll();
                            ?>
                            
                            <div class="form-group">
                                <label ><?php echo htmlspecialchars($pregunta['texto_pregunta'], ENT_QUOTES, 'UTF-8'); ?></label>

                                <?php if ($pregunta['idtipo_preguntax'] == 1) { // Opción simple ?>
                                    <?php foreach ($opciones as $opcion) { ?>
                                        <div class="radio">
                                            <label><input type="radio" name="preguntas[<?php echo $pregunta['idpreguntax']; ?>]" value="<?php echo htmlspecialchars($opcion['idopcionx'], ENT_QUOTES, 'UTF-8'); ?>">
                                            <?php echo htmlspecialchars($opcion['texto_opcionx'], ENT_QUOTES, 'UTF-8'); ?></label>
                                        </div>
                                    <?php } ?>
                                <?php } elseif ($pregunta['idtipo_preguntax'] == 2) { // Opción múltiple ?>
                                    <?php foreach ($opciones as $opcion) { ?>
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="preguntas[<?php echo $pregunta['idpreguntax']; ?>][]" value="<?php echo htmlspecialchars($opcion['idopcionx'], ENT_QUOTES, 'UTF-8'); ?>">
                                            <?php echo htmlspecialchars($opcion['texto_opcionx'], ENT_QUOTES, 'UTF-8'); ?></label>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        <?php } ?>
                            <div class="form-group text-center" >
                                <div class="col-md-12 col-sm-12 col-xs-12 mx-auto">
                                    <button type="submit" class="btn btn-success btn-sm">Enviar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- dsdmsddsdsdsdsdsdsd -->

<?php   
    }
} 
else if($encuesta && $encuesta['estado_encuesta']==0) {

    include "categoriahtml.php";

}
} else {
    include "categoriahtml.php";
}
?>