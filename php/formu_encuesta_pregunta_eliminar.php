<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$id_delete = limpiar_cadena($_GET['id_delete']); 

try {
    // Verificar si existe la pregunta
    $conexion = new Conexion();
    $check_pregunta = $conexion->Conexiondb();
    $check_pregunta = $check_pregunta->query("SELECT idpreguntax FROM preguntax WHERE idpreguntax = '$id_delete'");

    if ($check_pregunta->rowCount() == 1) {
        // Verificar si las opciones han sido respondidas
        $check_opciones = $conexion->Conexiondb();
        $check_opciones = $check_opciones->query("SELECT o.idopcionx FROM opcionx o LEFT JOIN respuestax r ON r.idopcionx = o.idopcionx WHERE o.idpreguntax = '$id_delete' AND r.idopcionx IS NULL");

        // Eliminar solo las opciones no respondidas
        if ($check_opciones->rowCount() > 0) {
            $opciones_no_respondidas = $check_opciones->fetchAll(PDO::FETCH_COLUMN);

            // Eliminar las opciones no respondidas de una manera más segura usando una consulta preparada
            $eliminar_opciones = $conexion->Conexiondb();
            $sql = "DELETE FROM opcionx WHERE idopcionx IN (" . implode(',', array_fill(0, count($opciones_no_respondidas), '?')) . ")";
            $eliminar_opciones = $eliminar_opciones->prepare($sql);
            $eliminar_opciones->execute($opciones_no_respondidas);

            // Verificar si la pregunta tiene más opciones restantes
            $check_opciones_restantes = $conexion->Conexiondb();
            $check_opciones_restantes = $check_opciones_restantes->query("SELECT idopcionx FROM opcionx WHERE idpreguntax = '$id_delete'");

            if ($check_opciones_restantes->rowCount() == 0) {
                // Eliminar la pregunta si no tiene opciones restantes
                $eliminar_pregunta = $conexion->Conexiondb();
                $eliminar_pregunta = $eliminar_pregunta->prepare("DELETE FROM preguntax WHERE idpreguntax = :id");
                $eliminar_pregunta->execute([":id" => $id_delete]);

                if ($eliminar_pregunta->rowCount() == 1) {
                    $response = array("status" => "success", "message" => "¡Pregunta eliminada correctamente!");
                } else {
                    throw new PDOException("Error al eliminar la pregunta");
                }
            } else {
                $response = array("status" => "success", "message" => "¡Opciones no respondidas eliminadas, pero la pregunta tiene opciones restantes!");
            }

            echo json_encode($response);
        } else {
            $response = array("status" => "error", "message" => "No hay opciones no respondidas para eliminar.");
            echo json_encode($response);
        }

    } else {
        $response = array("status" => "error", "message" => "¡Pregunta no encontrada!");
        echo json_encode($response);
    }

} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}

?>