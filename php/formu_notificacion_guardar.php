<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";
$start = new Conexion();
$conexion = $start->Conexiondb();


$idusu = limpiar_cadena($_POST['idusu']);

$titulo = limpiar_cadena($_POST['titulo']);
$mensaje = limpiar_cadena($_POST['mensaje']);

#validar los campos vacios
if (empty($titulo)) {
    $response = array("status" => "error", "message" => "¡El titulo de la categoria es obligatorio!");
    echo json_encode($response);
    exit();
}

if (empty($mensaje)) {
    $response = array("status" => "error", "message" => "¡El mensaje es obligatorio!");
    echo json_encode($response);
    exit();
}


#validar los tipos de datos


if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{5,100}", $titulo)) {
    $response = array("status" => "error", "message" => "¡El nombre no cumple con el formato!");
    echo json_encode($response);
    exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{10,800}", $mensaje)) {
    $response = array("status" => "error", "message" => "¡El mensaje no cumple con el formato!");
    echo json_encode($response);
    exit();
}


#guardando datos
try {
    // Iniciar una transacción si uno falla ninguno se registra
    $conexion->beginTransaction();

    $guardar_notificacion = $conexion->prepare('INSERT INTO notificacionx VALUES 
    (:id,:titu,:men,:estado,DEFAULT,:idusu)');

    $maxmarcado = [
        ":id" => 'DEFAULT',
        ":titu" => $titulo,
        ":men" => $mensaje,
        ":estado" => '0',
        ":idusu" => $idusu
    ];

    $guardar_notificacion->execute($maxmarcado);

    if ($guardar_notificacion->rowCount() == 1) {

        $ultimanotificacion = $conexion->lastInsertId();

        // Obtener todos los usuarios
        $usuarios = $conexion->query('SELECT idusuariox FROM usuariox')->fetchAll(PDO::FETCH_COLUMN);

        if (count($usuarios) > 0) {

            $guardar_notificacion_usuario = $conexion->prepare('INSERT INTO notificacionx_usuariox VALUES 
        (:id2,:leido,:idnoti,:idusu)');

            foreach ($usuarios as $idusuariox) {
                $marcadofinal = [
                    ":id2" => "DEFAULT",
                    ":leido" => '0',
                    ":idnoti" => $ultimanotificacion,
                    ":idusu" => $idusuariox
                ];

                $guardar_notificacion_usuario->execute($marcadofinal);
            }
        
            if ($guardar_notificacion_usuario->rowCount() > 0) {
                // Confirmar la transacción
                $conexion->commit();
                $response = array("status" => "success", "message" => "¡Se registro correctamente!");
                echo json_encode($response);
            } else {
                throw new PDOException("Error al registrar la notificacion por usuario");
            }
        }else {
            throw new PDOException("Error aun no existe ningun usuario para notifica");
        }
        
    } else {
        throw new PDOException("Error al registrar la notificacion");
    }
    $guardar_notificacion = null;
} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}
