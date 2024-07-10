<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$start = new Conexion();

$descripcion = limpiar_cadena($_POST['descripcion']);
$idusu = limpiar_cadena($_POST['idusu']);


#validar los campos vacios
if (empty($descripcion)) {
    $response = array("status" => "error", "message" => "¡La descripcion es obligatorio!");
    echo json_encode($response);
    exit();
}

#validar los tipos de datos

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{10,40}", $descripcion)) {
    $response = array("status" => "error", "message" => "¡La descripcion es muy corta, no cumple con el formato!");
    echo json_encode($response);
    exit();
}

#guardando datos
try {
    $guardar_sugerencia = $start->Conexiondb();
    $guardar_sugerencia = $guardar_sugerencia->prepare('INSERT INTO sugerenciax VALUES 
(:id,:descrip,DEFAULT,:estado,:idusu)');

    $maxmarcado = [
        ":id" => 'DEFAULT',
        ":descrip" => $descripcion,
        ":estado" => '1',
        ":idusu" => $idusu
    ];

    $guardar_sugerencia->execute($maxmarcado);

    if ($guardar_sugerencia->rowCount() == 1) {
        $response = array("status" => "success", "message" => "¡Se registro correctamente!");
        echo json_encode($response);
    } else {
        throw new PDOException("Error al registrar la tema");
    }
    $guardar_sugerencia = null;
} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}
