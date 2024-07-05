<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$start = new Conexion();

$nombre = limpiar_cadena($_POST['curso']);
$catego = limpiar_cadena($_POST['categoria']);
$estado = limpiar_cadena($_POST['estado']??'0');
$docente= limpiar_cadena($_POST['docente']);
$celular = limpiar_cadena($_POST['celular']);


#validar los campos vacios
if (empty($nombre) || empty($catego)|| empty($docente)|| empty($celular)) {
    $response = array("status" => "error", "message" => "¡Los datos con (*) son  obligatorio!");
    echo json_encode($response);
    exit();
}


#validar los tipos de datos


if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
    $response = array("status" => "error", "message" => "¡El nombre no cumple con el formato!");
    echo json_encode($response);
    exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $docente)) {
    $response = array("status" => "error", "message" => "¡El nombre del docente no cumple con el formato!");
    echo json_encode($response);
    exit();
}

if (verificar_datos("[0-9]{9}", $celular)) {
    $response = array("status" => "error", "message" => "¡El celular del docente no cumple con el formato!");
    echo json_encode($response);
    exit();
}


#verificar las validaciones de duplicado de datos
$check_nombre = $start->Conexiondb();
$check_nombre = $check_nombre->query('select nombre from cursox where nombre="' . $nombre . '";');
if ($check_nombre->rowCount() > 0) {
    $response = array("status" => "error", "message" => "¡El nombre del curso ya existe!");
    echo json_encode($response);
    exit();
}

#guardando datos
try {
    $guardar_curso = $start->Conexiondb();

    $guardar_curso = $guardar_curso->prepare('INSERT INTO cursox VALUES 
(:id,:nom,:doc,:cel,:esta,:idcat)');


    $maxmarcado = [
        ":id" => 'DEFAULT',
        ":nom" => $nombre,
        ":doc" => $docente,
        ":cel" => $celular,
        ":esta" => $estado,
        ":idcat" => $catego
    ];

    $guardar_curso->execute($maxmarcado);

    if ($guardar_curso->rowCount() == 1) {
        $response = array("status" => "success", "message" => "¡Se registro correctamente!");
        echo json_encode($response);
    } else {
        throw new PDOException("Error al registrar la categoria");
    }
    $guardar_curso = null;
} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}
