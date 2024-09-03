<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";


$start = new Conexion();
$conexion = $start->Conexiondb();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idusuario = limpiar_cadena($_SESSION['idusu']);

    $preguntas = isset($_POST['preguntas']) ? $_POST['preguntas'] : [];

    $conexion->beginTransaction();
    foreach ($preguntas as $idpregunta => $idopcion) {
        // Obtener el tipo de pregunta
        $tipo_pregunta_query = $conexion->prepare("SELECT idtipo_preguntax FROM preguntax WHERE idpreguntax = :idpregunta");
        $tipo_pregunta_query->execute(['idpregunta' => $idpregunta]);
        $tipo_pregunta = $tipo_pregunta_query->fetchColumn();

        $opciones = [];
        if ($tipo_pregunta == '1') { // Opción simple
            $opciones = isset($_POST['preguntas'][$idpregunta]) ? $_POST['preguntas'][$idpregunta] : [];
        } elseif ($tipo_pregunta == '2') { // Opción múltiple
            $opciones = isset($_POST['preguntas'][$idpregunta]) ? $_POST['preguntas'][$idpregunta] : [];
        }


        if (empty($opciones)) {
            // Mostrar un mensaje de error si no se agregaron opciones
            $response = array("status" => "error", "message" => "¡Debe seleccionar al menos una opción para la pregunta!");
            echo json_encode($response);
            exit();
        }

        // Insertar las respuestas en la base de datos
            $guardar_respuesta = $conn->prepare("INSERT INTO respuestax VALUES (DEFAULT,DEFAULT,:idpregunta, :idusuario, :idopcion)");
            $guardar_respuesta->execute([
                'idpregunta' => $idpregunta,
                'idusuario' => $idusuario,
                'idopcion' => $idopcion
            ]);

    }

    $conexion->commit();
    $response = array("status" => "success", "message" => "¡Se registro correctamente!");
    echo json_encode($response);

}