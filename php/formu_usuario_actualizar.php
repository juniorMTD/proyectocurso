<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$start = new Conexion();


$id=limpiar_cadena($_POST['idusu']);

$check_usuario = $start->Conexiondb();
$check_usuario=$check_usuario->query("SELECT * FROM usuariox usu inner join usux u on usu.idusux=u.idusux where usu.idusuariox='$id'");

if($check_usuario->rowCount()<=0){

    $response = array("status" => "error", "message" => "¡No existe el usuario!");
    echo json_encode($response);
    exit();
}else{
    $datos=$check_usuario->fetch();
}

$check_usuario=null;


$dni = limpiar_cadena($_POST['dni']);
$nombres = limpiar_cadena($_POST['nom']);
$apellidos = limpiar_cadena($_POST['apel']);
$universidad = limpiar_cadena($_POST['uni']);
$facu = limpiar_cadena($_POST['facu']);
$escuela = limpiar_cadena($_POST['escuela']);
$email = limpiar_cadena($_POST['email']);
$celular = limpiar_cadena($_POST['cel']);
$dire = limpiar_cadena($_POST['dire']);


$usu = limpiar_cadena($_POST['user']);
$clave = limpiar_cadena($_POST['clv']);
$clave2 = limpiar_cadena($_POST['clv2']);




#validar los campos vacios
if (empty($dni) || empty($nombres) || empty($apellidos) || empty($universidad) || empty($facu) || empty($escuela) || empty($email) || empty($celular) || empty($usu)) {
    $response = array("status" => "error", "message" => "¡Todos los campos son (*) son obligatorios!");
    echo json_encode($response);
    exit();
}





#validar los tipos de datos

if (verificar_datos("[0-9]{8}", $dni)) {
    $response = array("status" => "error", "message" => "¡El DNI no cumple con el formato solicitado!");
    echo json_encode($response);
    exit();
}

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

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,200}", $universidad)) {
    $response = array("status" => "error", "message" => "¡La universidad no cumple con el formato solicitado!");
    echo json_encode($response);
    exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,200}", $facu)) {
    $response = array("status" => "error", "message" => "¡La facultad no cumple con el formato solicitado!");
    echo json_encode($response);
    exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,200}", $escuela)) {
    $response = array("status" => "error", "message" => "¡La escuela no cumple con el formato solicitado!");
    echo json_encode($response);
    exit();
}



if (verificar_datos("[0-9]{9}", $celular)) {
    $response = array("status" => "error", "message" => "¡El celular no cumple con el formato solicitado!");
    echo json_encode($response);
    exit();
}

if (verificar_datos("[a-zA-Z0-9]{2,30}", $usu)) {
    $response = array("status" => "error", "message" => "¡Elusuario no cumple con el formato solicitado!");
    echo json_encode($response);
    exit();
}


#verificar las validaciones de duplicado de datos
if($dni!=$datos['dnix']){
    $check_dni = $start->Conexiondb();
    $check_dni = $check_dni->query('select dnix from usuariox where dnix="' . $dni . '";');
    if ($check_dni->rowCount() > 0) {
        $response = array("status" => "error", "message" => "¡El DNI ya esta registrado!");
        echo json_encode($response);
        exit();
    }
}
$check_dni = null;
if($usu!=$datos['usux']){
    $check_usuario = $start->Conexiondb();
    $check_usuario = $check_usuario->query('select usux from usux where usux="' . $usu . '";');
    if ($check_usuario->rowCount() > 0) {
        $response = array("status" => "error", "message" => "¡El usuario ya esta registrado, intente con otro!");
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
    $actualizar_usuario=$start->Conexiondb();
    $actualizar_usuario=$actualizar_usuario->prepare("UPDATE usuariox usu inner join usux u on usu.idusux=u.idusux
    set dnix=:dni_usu,apelx=:apel_usu,nomx=:nombre_usu,unix=:uni_usu,facux=:facu_usu,escux=:escu_usu,celx=:cel_usu,dirx=:dire_usu
    ,emailx=:email_usu,fotox=:foto_usu,usux=:usuario,clvx=:clave
    where idusuariox=:idusu");

    $marcadores=[
        ":dni_usu"=>$dni,
        ":apel_usu"=>$apellidos,
        ":nombre_usu"=>$nombres,
        ":uni_usu"=>$universidad,
        ":facu_usu"=>$facu,
        ":escu_usu"=>$escuela,
        ":cel_usu"=>$celular,
        ":dire_usu"=>$dire,
        ":email_usu"=>$email,
        ":foto_usu"=>'',
        ":usuario"=>$usu,
        ":clave"=>$clave,
        ":idusu"=>$id
    ];

    if ($actualizar_usuario->execute($marcadores)) {
        $response = array("status" => "success", "message" => "¡Se actualizo correctamente!");
        echo json_encode($response);
    } else {
        throw new PDOException("Error al actualizar el usuario");
    }

    $actualizar_usuario=null;
} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}
