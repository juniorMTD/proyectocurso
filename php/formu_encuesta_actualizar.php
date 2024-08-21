<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$start = new Conexion();

$id=limpiar_cadena($_POST['idencu']);

$check_encuesta = $start->Conexiondb();
$check_encuesta=$check_encuesta->query("SELECT * FROM encuestax where idencuestax='$id'");

if($check_encuesta->rowCount()<=0){

    $response = array("status" => "error", "message" => "¡No existe la encuesta!");
    echo json_encode($response);
    exit();
}else{
    $datos=$check_encuesta->fetch();
}

$check_encuesta=null;


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


if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}", $nombre)) {
    $response = array("status" => "error", "message" => "¡El titulo no cumple con el formato!");
    echo json_encode($response);
    exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}", $descrip)) {
    $response = array("status" => "error", "message" => "¡La descripcion no cumple con el formato!");
    echo json_encode($response);
    exit();
}



#verificar las validaciones de duplicado de datos

if($nombre!=$datos['titulox']){
    $check_nombre = $start->Conexiondb();
    $check_nombre = $check_nombre->query('select titulox from encuestax where titulox="' . $nombre . '";');
    if ($check_nombre->rowCount() > 0) {
        $response = array("status" => "error", "message" => "¡El nombre de la encuesta ya existe!");
        echo json_encode($response);
        exit();
    }
}

#actualizando datos
try {
    $actualizar_encuesta = $start->Conexiondb();

    $actualizar_encuesta = $actualizar_encuesta->prepare('UPDATE encuestax set titulox=:nom,descripx=:descrip,estado_encuesta=:esta where idencuestax="'.$id.'"');


    $maxmarcado = [
        ":nom" => $nombre,
        ":descrip" => $descrip,
        ":esta" => $estado
    ];

    if ($actualizar_encuesta->execute($maxmarcado)) {
        $response = array("status" => "success", "message" => "¡Se actualizo correctamente!");
        echo json_encode($response);
    } else {
        throw new PDOException("Error al actualizar la encuesta");
    }
    $actualizar_encuesta = null;
} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}
