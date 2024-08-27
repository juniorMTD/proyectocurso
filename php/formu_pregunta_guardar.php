<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$start = new Conexion();

$nombre_pregunta = limpiar_cadena($_POST['pregunta']);
$tipo_pregunta = limpiar_cadena($_POST['tipo_pregunta']);
$estado = isset($_POST['estado']) ? limpiar_cadena($_POST['estado']) : 0;


#validar los campos vacios
if (empty($nombre_pregunta) || empty($tipo_pregunta)) {
    $response = array("status" => "error", "message" => "¡Los datos con (*) son  obligatorio!");
    echo json_encode($response);
    exit();
}

// Validar que se haya seleccionado al menos una opción
$opciones = [];
if ($tipo_pregunta == '1') { // Opción simple
    $opciones = isset($_POST['opciones_simple']) ? $_POST['opciones_simple'] : [];
} elseif ($tipo_pregunta == '2') { // Opción múltiple
    $opciones = isset($_POST['opciones_multiple_text']) ? $_POST['opciones_multiple_text'] : [];
}

if (empty($opciones)) {
    // Mostrar un mensaje de error si no se agregaron opciones
    $response = array("status" => "error", "message" => "¡Agrega almenos una opcion!");
    echo json_encode($response);
    exit();
}
#validar los tipos de datos

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}", $nombre_pregunta)) {
    $response = array("status" => "error", "message" => "¡El nombre no cumple con el formato!");
    echo json_encode($response);
    exit();
}


#guardando datos
try {
    $guardar_pregunta = $start->Conexiondb();
    $guardar_pregunta = $guardar_pregunta->prepare('INSERT INTO preguntax VALUES 
(:id,:pregunta,:estado,:idencu,:idtipopre)');

    $maxmarcado = [
        ":id" => 'DEFAULT',
        ":pregunta" => $nombre_pregunta,
        ":estado" => $estado,
        ":idencu" => $celular,
        ":idtipopre" => $tipo_pregunta
    ];

    $guardar_pregunta->execute($maxmarcado);

    if ($guardar_pregunta->rowCount() == 1) {

        $pregunta_id = $conn->lastInsertId();

        // Insertar las opciones asociadas
        if ($tipo_pregunta == '1') { // Opción simple
            foreach ($opciones as $opcion) {
                $guardar_opcionsimple = $start->Conexiondb();
                $guardar_opcionsimple = $guardar_opcionsimple->prepare('INSERT INTO opcionx VALUES 
            (:id,:texto_opcion,:estado,:idpre)');

                $maxmarcado = [
                    ":id" => 'DEFAULT',
                    ":texto_opcion" => $opcion,
                    ":estado" => '1',
                    ":idpre" => $pregunta_id
                ];

                $guardar_opcionsimple->execute($maxmarcado);
            }
            if ($guardar_opcionsimple->rowCount() > 0) {
                $response = array("status" => "success", "message" => "¡Se registro correctamente!");
                echo json_encode($response);
            }else{
                throw new PDOException("Error al registrar las opciones");
            }
        } elseif ($tipo_pregunta == '2') { // Opción múltiple
            foreach ($opciones as $opcion) {
                $guardar_opcionmultiple = $start->Conexiondb();
                $guardar_opcionmultiple = $guardar_opcionmultiple->prepare('INSERT INTO opcionx VALUES 
            (:id,:texto_opcion,:estado,:idpre)');

                $maxmarcado = [
                    ":id" => 'DEFAULT',
                    ":texto_opcion" => $opcion,
                    ":estado" => '1',
                    ":idpre" => $pregunta_id
                ];

                $guardar_opcionmultiple->execute($maxmarcado);
            }
            if ($guardar_opcionmultiple->rowCount() > 0) {
                $response = array("status" => "success", "message" => "¡Se registro correctamente!");
                echo json_encode($response);
            }else{
                throw new PDOException("Error al registrar las opciones");
            }
        }else{
            throw new PDOException("Error no existe el tipo de pregunta");
        }
    } else {
        throw new PDOException("Error al registrar la pregunta");
    }
    $guardar_pregunta = null;
} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}
