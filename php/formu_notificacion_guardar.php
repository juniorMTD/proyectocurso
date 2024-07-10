<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";
$start = new Conexion();

$idusu=limpiar_cadena($_POST['idusu']);

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


if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{5,40}", $titulo)) {
    $response = array("status" => "error", "message" => "¡El nombre no cumple con el formato!");
    echo json_encode($response);
    exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{10,800}", $mensaje)) {
    $response = array("status" => "error", "message" => "¡El mensaje no cumple con el formato!");
    echo json_encode($response);
    exit();
}


#guardando datos
try {
    $guardar_notificacion = $start->Conexiondb();

    $guardar_notificacion = $guardar_notificacion->prepare('INSERT INTO notificacionx VALUES 
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
        $response = array("status" => "success", "message" => "¡Se registro correctamente!");
        echo json_encode($response);
    } else {
        throw new PDOException("Error al registrar la notificacion");
    }
    $guardar_notificacion = null;
} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}
