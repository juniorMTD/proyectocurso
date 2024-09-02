<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";
$start = new Conexion();

$nom = limpiar_cadena($_POST['categoria']);
$descrip = limpiar_cadena($_POST['descripcion']);


#validar los campos vacios
if (empty($nom)) {
    $response = array("status" => "error", "message" => "¡El nombre de la categoria es obligatorio!");
    echo json_encode($response);
    exit();
}


#validar los tipos de datos


if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,150}", $nom)) {
    $response = array("status" => "error", "message" => "¡El nombre no cumple con el formato!");
    echo json_encode($response);
    exit();
}



#verificar las validaciones de duplicado de datos
$check_nombre = $start->Conexiondb();
$check_nombre = $check_nombre->query('select nomx from categoriax where nomx="' . $nom . '";');
if ($check_nombre->rowCount() > 0) {
    $response = array("status" => "error", "message" => "¡El nombre de la categoria ya existe!");
    echo json_encode($response);
}
$check_nombre = null;

#guardando datos
try {
    $guardar_categoria = $start->Conexiondb();

    $guardar_categoria = $guardar_categoria->prepare('INSERT INTO categoriax VALUES 
(:id,:nom,:descrip)');


    $maxmarcado = [
        ":id" => 'DEFAULT',
        ":nom" => $nom,
        ":descrip" => $descrip
    ];

    $guardar_categoria->execute($maxmarcado);

    if ($guardar_categoria->rowCount() == 1) {
        $response = array("status" => "success", "message" => "¡Se registro correctamente!");
        echo json_encode($response);
    } else {
        throw new PDOException("Error al registrar la categoria");
    }
    $guardar_categoria = null;
} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}
