<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";
$start = new Conexion();

$dni = limpiar_cadena($_POST['dni']);
$nombres = limpiar_cadena($_POST['nom']);
$apellidos = limpiar_cadena($_POST['apel']);
$universidad = limpiar_cadena($_POST['uni']);
$facu = limpiar_cadena($_POST['facultad']);
$escuela = limpiar_cadena($_POST['escuela']);
$email = limpiar_cadena($_POST['email']);
$celular = limpiar_cadena($_POST['celular']);
$dire = limpiar_cadena($_POST['dire']);


$usu = limpiar_cadena($_POST['user']);
$clave = limpiar_cadena($_POST['clv']);
$clave2 = limpiar_cadena($_POST['clv2']);





#validar los campos vacios
if (empty($dni) || empty($nombres) || empty($apellidos) || empty($universidad) || empty($facu) || empty($escuela) || empty($email) || empty($celular) || empty($usu) || empty($clave) || empty($clave2)) {
    $response = array("status" => "error", "message" => "¡Todos los campos son obligatorios!");
    echo json_encode($response);
    exit();
}



#validar los tipos de datos

if (verificar_datos("[0-9]{8}", $dni)) {
    $response = array("status" => "error", "message" => "¡El DNI no cumple con el formato solicitado!");
    echo json_encode($response);
    exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombres)) {
    $response = array("status" => "error", "message" => "¡Los nombres no cumple con el formato solicitado!");
    echo json_encode($response);
    exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellidos)) {
    $response = array("status" => "error", "message" => "¡Los apellidos no cumple con el formato solicitado!");
    echo json_encode($response);
    exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $universidad)) {
    $response = array("status" => "error", "message" => "¡La universidad no cumple con el formato solicitado!");
    echo json_encode($response);
    exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $facu)) {
    $response = array("status" => "error", "message" => "¡La facultad no cumple con el formato solicitado!");
    echo json_encode($response);
    exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $escuela)) {
    $response = array("status" => "error", "message" => "¡La escuela no cumple con el formato solicitado!");
    echo json_encode($response);
    exit();
}



if (verificar_datos("[0-9]{9}", $celular)) {
    $response = array("status" => "error", "message" => "¡El celular no cumple con el formato solicitado!");
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
$check_dni = $start->Conexiondb();
$check_dni = $check_dni->query('select dnix from usuariox where dnix="' . $dni . '";');
if ($check_dni->rowCount() > 0) {
    $response = array("status" => "error", "message" => "¡El DNI ya esta registrado!");
    echo json_encode($response);
    exit();
}
$check_dni = null;

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

        $guardar_usuario = $start->Conexiondb();

        $guardar_usuario = $guardar_usuario->prepare('INSERT INTO usuariox VALUES 
    (:id,:dni,:apel,:nom,:unix,:facux,:escux,:cel, :dire, :correo,:foto,DEFAULT,:idusuario)');

        $marcadofinal = [
            ":id" => 'DEFAULT',
            ":dni" => $dni,
            ":apel" => $apellidos,
            ":nom" => $nombres,
            ":unix" => $universidad,
            ":facux" => $facu,
            ":escux" => $escuela,
            ":cel" => $celular,
            ":dire" => $dire,
            ":correo" => $email,
            ":foto" => null,
            ":idusuario" => $ultimousuario
        ];

        $guardar_usuario->execute($marcadofinal);



        if ($guardar_usuario->rowCount() == 1) {
            $response = array("status" => "success", "message" => "¡Se registro correctamente!");
            echo json_encode($response);
            exit();
        } else {
            throw new PDOException("Error al registrar en usux");
        }
    } else {
        throw new PDOException("Error al registrar en usuario");
    }
} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}
