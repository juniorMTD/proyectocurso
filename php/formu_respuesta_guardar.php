<?php
require_once "../conexion/conexion_db.php";
require_once "./main.php";


$start = new Conexion();
$conexion = $start->Conexiondb();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idusuario = limpiar_cadena($_POST['idusuario']);

    $idencuesta = isset($_POST['idencuesta']) ? limpiar_cadena($_POST['idencuesta']) : null;

    $preguntas = isset($_POST['preguntas']) ? $_POST['preguntas'] : [];


    // Verificar si $preguntas es un array
    if (!is_array($preguntas)) {
        $preguntas = [];
    }

    // Verifica si hay preguntas para procesar
    if (empty($preguntas)) {
        $response = array("status" => "error", "message" => "No se enviaron preguntas.");
        echo json_encode($response);
        exit();
    }


    try {
        $conexion->beginTransaction();
        foreach ($preguntas as $idpregunta => $opcion_seleccionada) {
            // Obtener el tipo de pregunta
            $tipo_pregunta_query = $conexion->prepare("SELECT idtipo_preguntax FROM preguntax WHERE idpreguntax = :idpre");
            $tipo_pregunta_query->execute([':idpre' => $idpregunta]);
            $tipo_pregunta = $tipo_pregunta_query->fetchColumn();

            $opciones = [];
            if ($tipo_pregunta == '1') { // Opción simple
                $opciones = !empty($opcion_seleccionada) ? [$opcion_seleccionada] : [];
            } elseif ($tipo_pregunta == '2') { // Opción múltiple
                $opciones = is_array($opcion_seleccionada) ? $opcion_seleccionada : [];
            }

            if (empty($opciones)) {
                // Mostrar un mensaje de error si no se agregaron opciones
                $response = array("status" => "error", "message" => "¡Debe seleccionar al menos una opción en cada pregunta!");
                echo json_encode($response);
                exit();
            }

             // Insertar las respuestas en la base de datos
             foreach ($opciones as $idopcion) {
                $guardar_respuesta = $conexion->prepare('INSERT INTO respuestax VALUES (DEFAULT, DEFAULT,:estado,:idpregunta,:idusuario,:idopcion)');
                $guardar_respuesta->execute([
                    ":estado"=>'1',
                    ":idpregunta" => $idpregunta,
                    ":idusuario" => $idusuario,
                    ":idopcion" => $idopcion
                ]);
            }

        }

        $guardar_encuesta_usu = $conexion->prepare('INSERT INTO encuesta_usux (completada, idencuestax, idusux) VALUES (:completada, :idencuesta, :idusuario)');
        $guardar_encuesta_usu->execute([
            ":completada"=>'1',
            ":idencuesta" => $idencuesta,
            ":idusuario" => $idusuario
        ]);

        $conexion->commit();

        $response = array("status" => "success", "message" => "¡Se registro correctamente!");
        echo json_encode($response);

    } catch (Exception $e) {
        $conexion->rollBack();
        $response = array("status" => "error", "message" => "Error al guardar las respuestas. Inténtelo de nuevo.");
        echo json_encode($response);
    }
}