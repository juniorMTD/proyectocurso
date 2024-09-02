<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$start = new Conexion();

$nombres = limpiar_cadena($_POST['nom']);
$apellidos = limpiar_cadena($_POST['apel']);
$cargo = limpiar_cadena($_POST['cargo']);


$usu = limpiar_cadena($_POST['user']);
$clave = limpiar_cadena($_POST['clv']);
$clave2 = limpiar_cadena($_POST['clv2']);





#validar los campos vacios
if (empty($nombres) || empty($apellidos) || empty($cargo) || empty($usu) || empty($clave) || empty($clave2)) {
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

if (verificar_datos("[a-zA-Z0-9$@.-]{2,100}", $clave)) {
    $response = array("status" => "error", "message" => "¡La clave no cumple con el formato solicitado!");
    echo json_encode($response);
    exit();
}

if (verificar_datos("[a-zA-Z0-9$@.-]{2,100}", $clave2)) {
    $response = array("status" => "error", "message" => "¡La clave para confirmar no cumple con el formato solicitado!");
    echo json_encode($response);
    exit();
}

# Verificar si las contraseñas coinciden
if ($clave !== $clave2) {
    $response = array("status" => "error", "message" => "¡Las contraseñas no coinciden!");
    echo json_encode($response);
    exit();
}


#verificar las validaciones de duplicado de datos

$check_usuario = $start->Conexiondb();
$check_usuario = $check_usuario->query('select usux from usux where usux="' . $usu . '";');
if ($check_usuario->rowCount() > 0) {
    $response = array("status" => "error", "message" => "¡El usuario ya esta registrado intente con otro!");
    echo json_encode($response);
    exit();
}
$check_usuario = null;


#guardando datos
try {
    $guardar_usux = $start->Conexiondb();
    $guardar_usux = $guardar_usux->prepare('INSERT INTO usux VALUES 
                                            (:idu,:usu,:clv,:estado)');

    $maxmarcado = [
        ":idu" => "DEFAULT",
        ":usu" => $usu,
        ":clv" => $clave,
        ":estado" => '1'

    ];
    $guardar_usux->execute($maxmarcado);

    if ($guardar_usux->rowCount() == 1) {

        $check_max = $start->Conexiondb();
        $check_max = $check_max->query('select max(idusux) from usux');
        $ultimousuario = $check_max->fetch(PDO::FETCH_COLUMN);

        $guardar_personal = $start->Conexiondb();

        $guardar_personal = $guardar_personal->prepare('INSERT INTO empleado VALUES 
    (:id,:nom,:apel,:cargo,:idusuario)');

        $marcadofinal = [
            ":id" => 'DEFAULT',
            ":nom" => $nombres,
            ":apel" => $apellidos,
            ":cargo" => $cargo,
            ":idusuario" => $ultimousuario
        ];

        $guardar_personal->execute($marcadofinal);


        if ($guardar_personal->rowCount() == 1) {
            $response = array("status" => "success", "message" => "¡Se registro correctamente!");
            echo json_encode($response);
            exit();
        } else {
            throw new PDOException("Error al registrar en personal");
        }
    } else {
        throw new PDOException("Error al registrar en personal");
    }
} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}
