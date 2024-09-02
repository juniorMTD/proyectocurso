<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$response = array();

$start = new Conexion();


$id = (isset($_GET['id_estado'])) ? $_GET['id_estado'] : 0;
$id=limpiar_cadena($id);

$start = new Conexion();

$check_usuario = $start->Conexiondb();
$check_usuario=$check_usuario->query("SELECT u.estadox FROM usuariox usu inner join usux u on usu.idusux=u.idusux where usu.idusuariox='$id'");
$estado=(int) $check_usuario->fetchColumn();

#actualizando datos
try {
    $actualizar_usuario = $start->Conexiondb();
    $actualizar_usuario = $actualizar_usuario->prepare('UPDATE usux u inner join usuariox usu on usu.idusux=u.idusux  SET estadox=:estado where idusuariox="'.$id.'"');
    if($estado=="1"){
        $maxmarcado = [
            ":estado" => '0'
        ];

        if ($actualizar_usuario->execute($maxmarcado)) {
            $response = array("status" => "success", "message" => "¡Se Desactivo la cuenta correctamente!");
            echo json_encode($response);
        } else {
            throw new PDOException("Error al actualizar al usuario");
        }
    } else if($estado=="0"){
        $maxmarcado = [
            ":estado" => '1'
        ];

        if ($actualizar_usuario->execute($maxmarcado)) {
            $response = array("status" => "success", "message" => "¡Se Activo la cuenta correctamente!");
            echo json_encode($response);
        } else {
            throw new PDOException("Error al actualizar al usuario");
        }
    }
    $actualizar_usuario = null;
} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}
