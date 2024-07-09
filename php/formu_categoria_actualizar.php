<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";


$start = new Conexion();


$check_categoria = $start->Conexiondb();

$id=limpiar_cadena($_POST['idcate']);
$check_categoria=$check_categoria->query("SELECT * FROM categoriax where idcategoriax='$id'");



if($check_categoria->rowCount()<=0){

    $response = array("status" => "error", "message" => "¡No existe la categoria!");
    echo json_encode($response);
    exit();

}else{
    $datos=$check_categoria->fetch();
}

$check_categoria=null;



$nom = limpiar_cadena($_POST['categoria']);
$descrip = limpiar_cadena($_POST['descripcion']);


#validar los campos vacios
if (empty($nom)) {
    $response = array("status" => "error", "message" => "¡El nombre de la categoria es obligatorio!");
    echo json_encode($response);
    exit();
}


#validar los tipos de datos


if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nom)) {
    $response = array("status" => "error", "message" => "¡El nombre no cumple con el formato!");
    echo json_encode($response);
    exit();
}



#verificar las validaciones de duplicado de datos

if($nom!=$datos['nomx']){
    $check_nombre = $start->Conexiondb();
    $check_nombre = $check_nombre->query('select nomx from categoriax where nomx="' . $nom . '";');
    if ($check_nombre->rowCount() > 0) {
        $response = array("status" => "error", "message" => "¡El nombre de la categoria ya existe!");
        echo json_encode($response);
    }
    $check_nombre = null;
}


#guardando datos
try {
    $actualizar_categoria = $start->Conexiondb();

    $actualizar_categoria = $actualizar_categoria->prepare('UPDATE categoriax set  nomx=:nom,descx=:descrip where idcategoriax="'.$id.'"');


    $maxmarcado = [
        ":nom" => $nom,
        ":descrip" => $descrip
    ];

    if ( $actualizar_categoria->execute($maxmarcado)) {
        $response = array("status" => "success", "message" => "¡Se actualizo correctamente!");
        echo json_encode($response);
    } else {
        throw new PDOException("Error al actualizar la categoria");
    }
    $actualizar_categoria = null;
} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}
