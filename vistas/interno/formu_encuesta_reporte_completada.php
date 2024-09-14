<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";

$id = (isset($_GET['id_reporte'])) ? $_GET['id_reporte'] : 0;
$id = limpiar_cadena($id);

$start = new Conexion();
$check_pregunta = $start->Conexiondb();
$check_pregunta = $check_pregunta->query("SELECT p.idpreguntax FROM encuestax e JOIN preguntax p ON p.idencuestax=e.idencuestax WHERE e.idencuestax='$id'");

if ($check_pregunta->rowCount() > 0) {
    $preguntas_ids = $check_pregunta->fetchAll(PDO::FETCH_ASSOC);
    $resultados = [];

    foreach ($preguntas_ids as $pregunta) {
        $pregunta_id = $pregunta['idpreguntax'];
        
        // Cambiar nombre del parámetro en la consulta y en bindParam
        $query = "SELECT o.texto_opcionx AS opcion, COUNT(r.idopcionx) AS total
                  FROM respuestax r
                  JOIN opcionx o ON r.idopcionx = o.idopcionx
                  WHERE o.idpreguntax = :id_pregunta
                  GROUP BY r.idopcionx";
        
        $opciones = $start->Conexiondb();
        $opciones = $opciones->prepare($query);
        $opciones->bindParam(':id_pregunta', $pregunta_id, PDO::PARAM_INT);
        $opciones->execute();

        // Guardar los resultados de esta pregunta
        $opciones_respuestas = $opciones->fetchAll(PDO::FETCH_ASSOC);
        
        // Calcular el total de respuestas para esa pregunta
        $total_respuestas = array_sum(array_column($opciones_respuestas, 'total'));
        
        // Calcular porcentaje para cada opción
        foreach ($opciones_respuestas as &$fila) {
            $fila['porcentaje'] = ($total_respuestas > 0) ? ($fila['total'] / $total_respuestas) * 100 : 0;
        }
        
        // Almacenar los resultados de esta pregunta en el array resultados
        $resultados[$pregunta_id] = $opciones_respuestas;
    }

    $labels = [];
    $datasets = [];

    foreach ($resultados as $pregunta_id => $opciones_respuestas) {
        $opciones = [];
        $totales = [];
        
        foreach ($opciones_respuestas as $respuesta) {
            $opciones[] = $respuesta['opcion'];
            $totales[] = $respuesta['total'];
        }
        
        $labels[$pregunta_id] = $opciones;
        $datasets[$pregunta_id] = $totales;
    }
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>
            <h3>REPORTES</h3>
            <hr>
            <a href="./indexado.php?mostrar=formu_curso_new" type="button" class="btn btn-warning"><i class="fa fa-user"></i> IMPRIMIR</a>
            <hr>

        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="row">
                            <div style="width: 50%; margin: auto;">
                                <?php foreach ($preguntas_ids as $pregunta) {
                                    echo '<canvas id="chart_' . $pregunta['idpreguntax'] . '"></canvas>';
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
} else {
    include "./inc/error_alert.php";
}
$check_pregunta = null;
?>