<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$start = new Conexion();

$idnoti=limpiar_cadena($_POST['idnoti']);

$check_curso = $start->Conexiondb();
$check_curso=$check_curso->query("SELECT * FROM notificacionx where idnotificacionx='$idnoti'");

if($check_curso->rowCount()<=0){

    $response = array("status" => "error", "message" => "¡No existe la notificacion!");
    echo json_encode($response);
    exit();
}else{
    $datos=$check_curso->fetch();
}

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


if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{5,80}", $titulo)) {
    $response = array("status" => "error", "message" => "¡El titulo no cumple con el formato!");
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
    $guardar_notificacion = $start->Conexiondb();

    $guardar_notificacion = $guardar_notificacion->prepare('UPDATE notificacionx set 
titulo=:titu,mensaje=:men,fec=DEFAULT WHERE idnotificacionx="'.$idnoti.'"' );


    $maxmarcado = [
        ":titu" => $titulo,
        ":men" => $mensaje
    ];

    if ($guardar_notificacion->execute($maxmarcado)) {
        $response = array("status" => "success", "message" => "¡Se actualizo correctamente!");
        echo json_encode($response);
    } else {
        throw new PDOException("Error al actualizar la notificacion");
    }

    $guardar_notificacion = null;
} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}
