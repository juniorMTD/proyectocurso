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


$usu = limpiar_cadena($_POST['user']);
$clave = limpiar_cadena($_POST['clv']);
$clave2 = limpiar_cadena($_POST['clv2']);





if (empty($dni) ) {
    $response = array("status" => "error", "message" => "¡Todos los campos son obligatorios!");
    echo json_encode($response);
    exit();
}



#validar los campos vacios
if ($dni == "") {
    echo "menjsae error";
    exit();
}
if ($nombres == "") {
    echo "!OOPSSS OCURRIO UN ERROR!,Los nombres son obligatorio completar,error";
    exit();

}
if ($apellidos == "") {
    echo "!OOPSSS OCURRIO UN ERROR!,Los apellidos son obligatorio completar,error";
    exit();

}
if ($universidad == "") {
    echo "!OOPSSS OCURRIO UN ERROR!,El nombre de la universidad es obligatorio completar,error";
    exit();
}

if ($facultad == "") {
    echo "!OOPSSS OCURRIO UN ERROR!,El nombre de la facultad es obligatorio completar,error";
    exit();
}
if ($escuela == "") {
    echo "!OOPSSS OCURRIO UN ERROR!,El nombre de la escuela es obligatorio completar,error";
    exit();
}
if ($email == "") {
    echo "!OOPSSS OCURRIO UN ERROR!,El email es obligatorio completar,error";
    exit();
}

if ($celular == "") {
    echo "!OOPSSS OCURRIO UN ERROR!,El celular es obligatorio completar,error";
    exit();

}

if ($usu == "") {
    echo "!OOPSSS OCURRIO UN ERROR!,El usuario es obligatorio completar,error";
    exit();

}
if ($clave == "") {
    echo "!OOPSSS OCURRIO UN ERROR!,La contraseña es obligatorio completar,error";
    exit();

}
if ($clave2 == "") {
    echo "!OOPSSS OCURRIO UN ERROR!,Repita su contraseña,error";
    exit();

}



#validar los tipos de datos

if (verificar_datos("[0-9]{8}", $dni)) {
    echo "!OOPSSS OCURRIO UN ERROR!,La DNI no cumple con el formato,error";
    exit();

}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombres)) {
    echo "!OOPSSS OCURRIO UN ERROR!,Los nombres no cumple con el formato,error";
    exit();

}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellidos)) {
    echo "!OOPSSS OCURRIO UN ERROR!,Los apellidos no cumple con el formato,error";
    exit();

}

if (verificar_datos("[0-9]{9}", $celular)) {
    echo "!OOPSSS OCURRIO UN ERROR!,El celular no cumple con el formato,error";
    exit();

}




#verificar las validaciones de duplicado de datos
$check_dni = $start->Conexiondb();
$check_dni = $check_dni->query('select dni from paciente where dni="' . $dni . '";');
if ($check_dni->rowCount() > 0) {
    echo "!OOPSSS OCURRIO UN ERROR!,El DNI ya esta registrado,error";
    exit();
}
$check_dni = null;

#guardando datos

$guardar_paciente = $start->Conexiondb();

$guardar_paciente = $guardar_paciente->prepare('INSERT INTO paciente VALUES 
(:id,:nom,:apel,:dni,:esci,:fecnac,:domicilio,:ocupacion,:lateral,:cel)');


$maxmarcado = [
    ":id" => 'DEFAULT',
    ":nom" => $nombres,
    ":apel" => $apellidos,
    ":dni" => $dni,
    ":esci" => 'ninguno',
    ":fecnac" => $fecnac,
    ":domicilio" => 'ninguno',
    ":ocupacion" => $ocupacion,
    ":lateral" => 'ninguno',
    ":cel" => $celular
];

$guardar_paciente->execute($maxmarcado);

if ($guardar_paciente->rowCount() == 1) {
    echo "!REGISTRADO!,Es paciente se registro correctamente,success";
} else {
    echo "!OOPSSS OCURRIO UN ERROR!,No se pudo registrar al paciente intentelo nuevamente,error";
}
$guardar_paciente=null;
