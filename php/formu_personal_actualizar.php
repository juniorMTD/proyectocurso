<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$start = new Conexion();


$id=limpiar_cadena($_POST['idempleado']);

$check_empleado = $start->Conexiondb();
$check_empleado=$check_empleado->query("SELECT * FROM empleado e inner join usux u on e.idusux=u.idusux where e.idempleado='$id'");

if($check_empleado->rowCount()<=0){

    $response = array("status" => "error", "message" => "¡No existe el empleado!");
    echo json_encode($response);
    exit();
}else{
    $datos=$check_empleado->fetch();
}

$check_empleado=null;



$nombres = limpiar_cadena($_POST['nom']);
$apellidos = limpiar_cadena($_POST['apel']);
$cargo = limpiar_cadena($_POST['cargo']);
$estado = isset($_POST['estado']) ? limpiar_cadena($_POST['estado']) : 0;

$usu = limpiar_cadena($_POST['user']);
$clave = limpiar_cadena($_POST['clv']);
$clave2 = limpiar_cadena($_POST['clv2']);





#validar los campos vacios
if (empty($nombres) || empty($apellidos) || empty($cargo) || empty($usu) ) {
    $response = array("status" => "error", "message" => "¡Todos los campos son (*) son obligatorios!");
    echo json_encode($response);
    exit();
}


#validar los tipos de datos

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}", $nombres)) {
    $response = array("status" => "error", "message" => "¡Los nombres no cumple con el formato solicitado!");
    echo json_encode($response);
    exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}", $apellidos)) {
    $response = array("status" => "error", "message" => "¡Los apellidos no cumple con el formato solicitado!");
    echo json_encode($response);
    exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}", $cargo)) {
    $response = array("status" => "error", "message" => "¡El cargo no cumple con el formato solicitado!");
    echo json_encode($response);
    exit();
}


if (verificar_datos("[a-zA-Z0-9]{2,30}", $usu)) {
    $response = array("status" => "error", "message" => "¡Elusuario no cumple con el formato solicitado!");
    echo json_encode($response);
    exit();
}


#verificar las validaciones de duplicado de datos
if($usu!=$datos['usux']){
    $check_usuario = $start->Conexiondb();
    $check_usuario = $check_usuario->query('select usux from usux where usux="' . $usu . '";');
    if ($check_usuario->rowCount() > 0) {
        $response = array("status" => "error", "message" => "¡El usuario ya esta registrado intento otro!");
        echo json_encode($response);
        exit();
    }
    $check_usuario = null;
}

//validacion si se cambia de clave
if($clave!="" || $clave2!=""){
    if (verificar_datos("[a-zA-Z0-9$@.-]{2,100}", $clave) || verificar_datos("[a-zA-Z0-9$@.-]{2,100}", $clave2)) {
        $response = array("status" => "error", "message" => "¡Las contraseñas no cumple con el formato solicitado!");
        echo json_encode($response);
        exit();
    }else{
        if ($clave != $clave2) {
            $response = array("status" => "error", "message" => "¡Las contraseñas no coinciden!");
            echo json_encode($response);
            exit();

        } 
    }
} else{
    $clave=$datos['clvx'];
}


#actualizando datos
try {
    $actualizar_personal=$start->Conexiondb();
    $actualizar_personal=$actualizar_personal->prepare("UPDATE empleado e inner join usux u on e.idusux=u.idusux
    set nomx=:nombre_emple,apelx=:apel_emple,cargo=:cargo_emple,usux=:usuario,clvx=:clave,estadox=:estado_emple
    where idempleado=:idemple");

    $marcadores=[
        ":nombre_emple"=>$nombres,
        ":apel_emple"=>$apellidos,
        ":cargo_emple"=>$cargo,
        ":usuario"=>$usu,
        ":clave"=>$clave,
        ":estado_emple"=>$estado,
        ":idemple"=>$id
    ];

    if ($actualizar_personal->execute($marcadores)) {
        $response = array("status" => "success", "message" => "¡Se actualizo correctamente!");
        echo json_encode($response);
    } else {
        throw new PDOException("Error al actualizar el el personal");
    }

    $actualizar_personal=null;
} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}
