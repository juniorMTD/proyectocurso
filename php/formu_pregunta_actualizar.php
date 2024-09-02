<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$start = new Conexion();
$conexion = $start->Conexiondb();

$idencuesta = limpiar_cadena($_POST['idencuesta']);
$idpregunta = limpiar_cadena($_POST['idpregunta']);
$nombre_pregunta = limpiar_cadena($_POST['pregunta']);
$tipo_pregunta = limpiar_cadena($_POST['tipo_preguntas']);
$estado = isset($_POST['estado']) ? limpiar_cadena($_POST['estado']) : 0;

// Validar campos vacíos
if (empty($nombre_pregunta) || empty($tipo_pregunta)) {
    $response = array("status" => "error", "message" => "¡Los datos con (*) son obligatorios!");
    echo json_encode($response);
    exit();
}


try {
    $conexion->beginTransaction();

    // Actualizar pregunta
    $actualizar_pregunta = $conexion->prepare('UPDATE preguntax SET pregunta = :pregunta, estado = :estado, idtipopre = :idtipopre WHERE idpregunta = :idpregunta');
    $params = [
        ":pregunta" => $nombre_pregunta,
        ":estado" => $estado,
        ":idtipopre" => $tipo_pregunta,
        ":idpregunta" => $idpregunta
    ];
    $actualizar_pregunta->execute($params);

    if ($actualizar_pregunta->rowCount() >= 0) {
        // Actualizar opciones según el tipo de pregunta
        if ($tipo_pregunta == '1') { // Opción simple
            // Primero eliminar las opciones anteriores
            $eliminar_opciones = $conexion->prepare('DELETE FROM opcionx WHERE idpre = :idpregunta');
            $eliminar_opciones->execute([":idpregunta" => $idpregunta]);

            // Insertar las nuevas opciones
            $opciones = isset($_POST['opciones_simple']) ? $_POST['opciones_simple'] : [];
            foreach ($opciones as $opcion) {
                $guardar_opcionsimple = $conexion->prepare('INSERT INTO opcionx VALUES (DEFAULT, :texto_opcion, 1, :idpregunta)');
                $guardar_opcionsimple->execute([
                    ":texto_opcion" => $opcion,
                    ":idpregunta" => $idpregunta
                ]);
            }
        } elseif ($tipo_pregunta == '2') { // Opción múltiple
            // Primero eliminar las opciones anteriores
            $eliminar_opciones = $conexion->prepare('DELETE FROM opcionx WHERE idpre = :idpregunta');
            $eliminar_opciones->execute([":idpregunta" => $idpregunta]);

            // Insertar las nuevas opciones
            $opciones = isset($_POST['opciones_multiple_text']) ? $_POST['opciones_multiple_text'] : [];
            foreach ($opciones as $opcion) {
                $guardar_opcionmultiple = $conexion->prepare('INSERT INTO opcionx VALUES (DEFAULT, :texto_opcion, 1, :idpregunta)');
                $guardar_opcionmultiple->execute([
                    ":texto_opcion" => $opcion,
                    ":idpregunta" => $idpregunta
                ]);
            }
        }

        $conexion->commit();
        $response = array("status" => "success", "message" => "¡La pregunta se actualizó correctamente!");
        echo json_encode($response);
    } else {
        throw new PDOException("Error al actualizar la pregunta");
    }
} catch (PDOException $e) {
    $conexion->rollBack();
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}