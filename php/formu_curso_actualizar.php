<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$start = new Conexion();

$id=limpiar_cadena($_POST['idcu']);

$check_curso = $start->Conexiondb();
$check_curso=$check_curso->query("SELECT * FROM cursox where idcursox='$id'");

if($check_curso->rowCount()<=0){

    $response = array("status" => "error", "message" => "¡No existe el tema!");
    echo json_encode($response);
    exit();
}else{
    $datos=$check_curso->fetch();
}

$check_curso=null;


$nombre = limpiar_cadena($_POST['curso']);
$catego = limpiar_cadena($_POST['categoria']);
$estado = isset($_POST['estado']) ? limpiar_cadena($_POST['estado']) : 0;
$docente= limpiar_cadena($_POST['docente']);
$celular = limpiar_cadena($_POST['celular']);


#validar los campos vacios
if (empty($nombre) || empty($catego)|| empty($docente)|| empty($celular)) {
    $response = array("status" => "error", "message" => "¡Los datos con (*) son  obligatorio!");
    echo json_encode($response);
    exit();
}


#validar los tipos de datos


if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}", $nombre)) {
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

if($nombre!=$datos['nombre']){
    $check_nombre = $start->Conexiondb();
    $check_nombre = $check_nombre->query('select nombre from cursox where nombre="' . $nombre . '";');
    if ($check_nombre->rowCount() > 0) {
        $response = array("status" => "error", "message" => "¡El nombre del curso ya existe!");
        echo json_encode($response);
        exit();
    }
}

#actualizando datos
try {
    $actualizar_curso = $start->Conexiondb();

    $actualizar_curso = $actualizar_curso->prepare('UPDATE cursox set nombre=:nom,docentex=:doc,celularx=:cel,estadox=:esta,idcategoriax=:idcat where idcursox="'.$id.'"');


    $maxmarcado = [
        ":nom" => $nombre,
        ":doc" => $docente,
        ":cel" => $celular,
        ":esta" => $estado,
        ":idcat" => $catego
    ];

    if ($actualizar_curso->execute($maxmarcado)) {
        $response = array("status" => "success", "message" => "¡Se actualizo correctamente!");
        echo json_encode($response);
    } else {
        throw new PDOException("Error al registrar la categoria");
    }
    $actualizar_curso = null;
} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}
