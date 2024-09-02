<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";


$start = new Conexion();
$conexion = $start->Conexiondb();

$idencuesta = limpiar_cadena($_POST['idencuesta']);
$nombre_pregunta = limpiar_cadena($_POST['pregunta']);
$tipo_pregunta = limpiar_cadena($_POST['tipo_preguntas']);
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


#guardando datos
try {

    $conexion->beginTransaction();

    $guardar_pregunta = $conexion->prepare('INSERT INTO preguntax VALUES 
(:id,:pregunta,:estado,:idencu,:idtipopre)');

    $maxmarcado = [
        ":id" => 'DEFAULT',
        ":pregunta" => $nombre_pregunta,
        ":estado" => $estado,
        ":idencu" => $idencuesta,
        ":idtipopre" => $tipo_pregunta
    ];

    $guardar_pregunta->execute($maxmarcado);

    if ($guardar_pregunta->rowCount() == 1) {
        
        $ultimapregunta = $conexion->lastInsertId();

        // Insertar las opciones asociadas
        if ($tipo_pregunta == '1') { // Opción simple
            foreach ($opciones as $opcion) {
                $guardar_opcionsimple = $conexion->prepare('INSERT INTO opcionx VALUES 
            (:ido,:texto_opcion,:esta,:idpre)');

                $opcionmarcado = [
                    ":ido" => 'DEFAULT',
                    ":texto_opcion" => $opcion,
                    ":esta" => '1',
                    ":idpre" => $ultimapregunta
                ];

                $guardar_opcionsimple->execute($opcionmarcado);
            }
            if ($guardar_opcionsimple->rowCount() > 0) {
                // Confirmar la transacción
                $conexion->commit();
                $response = array("status" => "success", "message" => "¡Se registro correctamente!");
                echo json_encode($response);
            }else{
                throw new PDOException("Error al registrar las opciones");
            }
        } else if ($tipo_pregunta == '2') { // Opción múltiple
            foreach ($opciones as $opcion) {
                $guardar_opcionmultiple = $conexion->prepare('INSERT INTO opcionx VALUES 
            (:ido,:texto_opcion,:esta,:idpre)');

                $opcionmarcado = [
                    ":ido" => 'DEFAULT',
                    ":texto_opcion" => $opcion,
                    ":esta" => '1',
                    ":idpre" => $ultimapregunta
                ];

                $guardar_opcionmultiple->execute($opcionmarcado);
            }
            if ($guardar_opcionmultiple->rowCount() > 0) {
                // Confirmar la transacción
                $conexion->commit();
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
