<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$response = array();

$start = new Conexion();

$tema = limpiar_cadena($_POST['tema']);
$estado = isset($_POST['estado']) ? limpiar_cadena($_POST['estado']) : 0;;
$curso = limpiar_cadena($_POST['curso']);


#validar los campos vacios
if (empty($tema)) {
    $response = array("status" => "error", "message" => "¡El nombre del tema es obligatorio!");
    echo json_encode($response);
    exit();
}
if (empty($curso)) {
    $response = array("status" => "error", "message" => "¡Seleccionar el curso es obligatorio!");
    echo json_encode($response);
    exit();
}


#validar los tipos de datos

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}", $tema)) {
    $response = array("status" => "error", "message" => "¡El nombre del tema no cumple con el formato!");
    echo json_encode($response);
    exit();
}


#verificar las validaciones de duplicado de datos
$check_nombre = $start->Conexiondb();
$check_nombre = $check_nombre->query('select temx from temax where temx="' . $tema. '";');
if ($check_nombre->rowCount() > 0) {
    $response = array("status" => "error", "message" => "¡El nombre del tema ya existe!");
    echo json_encode($response);
    exit();
}


#guardando datos
try {
    $guardar_tema = $start->Conexiondb();
    $guardar_tema = $guardar_tema->prepare('INSERT INTO temax VALUES 
(:id,:nom,:estado,:idcurso)');


    $maxmarcado = [
        ":id" => 'DEFAULT',
        ":nom" => $tema,
        ":estado" => $estado,
        ":idcurso" => $curso
    ];

    $guardar_tema->execute($maxmarcado);

    if ($guardar_tema->rowCount() == 1) {
        $response = array("status" => "success", "message" => "¡Se registro correctamente!");
        echo json_encode($response);
    } else {
        throw new PDOException("Error al registrar la tema");
    }
    $guardar_tema = null;
} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}
