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

    $respuestas_validas = [];
    $preguntas_sin_respuestas = [];

    // Obtener todas las preguntas de la encuesta
    $preguntas_encuesta_query = $conexion->prepare("SELECT idpreguntax FROM preguntax WHERE idencuestax = :idencuesta");
    $preguntas_encuesta_query->execute([':idencuesta' => $idencuesta]);
    $todas_preguntas = $preguntas_encuesta_query->fetchAll(PDO::FETCH_COLUMN);

    // Verificar si todas las preguntas de la encuesta han sido respondidas
    $preguntas_respondidas = array_keys($preguntas);

    foreach ($todas_preguntas as $idpregunta) {
        if (!in_array($idpregunta, $preguntas_respondidas)) {
            $preguntas_sin_respuestas[] = $idpregunta;
        }
    }

    // Validar preguntas y respuestas
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
            // Añadir a las preguntas sin respuestas
            $preguntas_sin_respuestas[] = $idpregunta;
        } else {
            // Agregar respuestas válidas al array
            foreach ($opciones as $idopcion) {
                $respuestas_validas[] = [
                    'idpregunta' => $idpregunta,
                    'idusuario' => $idusuario,
                    'idopcion' => $idopcion
                ];
            }
        }
    }

    // Verificar si hay preguntas sin respuestas
    if (!empty($preguntas_sin_respuestas)) {
        $response = array("status" => "error", "message" => "¡Debe responder todas las preguntas!");
        echo json_encode($response);
        exit();
    }

    try {
        $conexion->beginTransaction();
        // Insertar las respuestas válidas en la base de datos
        foreach ($respuestas_validas as $respuesta) {
            $guardar_respuesta = $conexion->prepare('INSERT INTO respuestax  VALUES (DEFAULT,DEFAULT, :estado, :idpregunta, :idusuario, :idopcion)');
            $guardar_respuesta->execute([
                ":estado" => '1',
                ":idpregunta" => $respuesta['idpregunta'],
                ":idusuario" => $respuesta['idusuario'],
                ":idopcion" => $respuesta['idopcion']
            ]);
        }

        // Insertar en la tabla encuesta_usux
        $guardar_encuesta_usu = $conexion->prepare('INSERT INTO encuesta_usux (completada, idencuestax, idusux) VALUES (:completada, :idencuesta, :idusuario)');
        $guardar_encuesta_usu->execute([
            ":completada" => '1',
            ":idencuesta" => $idencuesta,
            ":idusuario" => $idusuario
        ]);

        $conexion->commit();

        $response = array("status" => "success", "message" => "¡Se registró correctamente!");
        echo json_encode($response);

    } catch (PDOException $e) {
        $conexion->rollBack();
        // Mostrar el mensaje de error para depuración
        $response = array("status" => "error", "message" => "Error al guardar las respuestas. Detalle del error: " . $e->getMessage());
        echo json_encode($response);
        error_log("Error al guardar las respuestas: " . $e->getMessage()); // Guarda el error en el log del servidor
    }
}
?>