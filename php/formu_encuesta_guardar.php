<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$start = new Conexion();

$nombre = limpiar_cadena($_POST['encuesta']);
$descrip = limpiar_cadena($_POST['descripcion']);
$estado = isset($_POST['estado']) ? limpiar_cadena($_POST['estado']) : 0;


#validar los campos vacios
if (empty($nombre) || empty($descrip)) {
    $response = array("status" => "error", "message" => "¡Los datos con (*) son  obligatorio!");
    echo json_encode($response);
    exit();
}


#validar los tipos de datos


if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,200}", $nombre)) {
    $response = array("status" => "error", "message" => "¡El nombre no cumple con el formato!");
    echo json_encode($response);
    exit();
}


#verificar las validaciones de duplicado de datos
$check_nombre = $start->Conexiondb();
$check_nombre = $check_nombre->query('select titulox from encuestax where titulox="' . $nombre . '";');
if ($check_nombre->rowCount() > 0) {
    $response = array("status" => "error", "message" => "¡El nombre de la encuesta ya existe!");
    echo json_encode($response);
    exit();
}

#guardando datos
try {
    $guardar_encuesta = $start->Conexiondb();

    $guardar_encuesta = $guardar_encuesta->prepare('INSERT INTO encuestax VALUES 
(:id,:nom,:descrip,DEFAULT,:esta)');


    $maxmarcado = [
        ":id" => 'DEFAULT',
        ":nom" => $nombre,
        ":descrip" => $descrip,
        ":esta" => $estado
    ];

    $guardar_encuesta->execute($maxmarcado);

    if ($guardar_encuesta->rowCount() == 1) {
        $response = array("status" => "success", "message" => "¡Se registro correctamente!");
        echo json_encode($response);
    } else {
        throw new PDOException("Error al registrar la encuesta");
    }
    $guardar_encuesta = null;
} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}
