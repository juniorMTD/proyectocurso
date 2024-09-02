<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$response = array();

$start = new Conexion();


$id=limpiar_cadena($_POST['idtema']);

$check_tema = $start->Conexiondb();
$check_tema=$check_tema->query("SELECT * FROM temax where idtemax='$id'");

if($check_tema->rowCount()<=0){

    $response = array("status" => "error", "message" => "¡No existe el curso!");
    echo json_encode($response);
    exit();
}else{
    $datos=$check_tema->fetch();
}

$check_tema=null;



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

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,200}", $tema)) {
    $response = array("status" => "error", "message" => "¡El nombre del tema no cumple con el formato!");
    echo json_encode($response);
    exit();
}


#verificar las validaciones de duplicado de datos
if($tema!=$datos['temx']){
    $check_nombre = $start->Conexiondb();
    $check_nombre = $check_nombre->query('select temx from temax where temx="' . $tema. '";');
    if ($check_nombre->rowCount() > 0) {
        $response = array("status" => "error", "message" => "¡El nombre del tema ya existe!");
        echo json_encode($response);
        exit();
    }
}


#actualizando datos
try {
    $guardar_tema = $start->Conexiondb();
    $guardar_tema = $guardar_tema->prepare('UPDATE temax SET temx=:nom,estadox=:estado,idcursox=:idcurso where idtemax="'.$id.'"');


    $maxmarcado = [
        ":nom" => $tema,
        ":estado" => $estado,
        ":idcurso" => $curso
    ];

    ;

    if ($guardar_tema->execute($maxmarcado)) {
        $response = array("status" => "success", "message" => "¡Se actualizo correctamente!");
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
