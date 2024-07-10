<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$id_delete=limpiar_cadena($_GET['id_delete']); 

#eliminando datos

try {

//Estamos verificando la categoria
$start = new Conexion();
$check_notificacion = $start->Conexiondb();
$check_notificacion=$check_notificacion->query("select idnotificacionx from notificacionx where idnotificacionx='".$id_delete."'");


if($check_notificacion->rowCount()==1){
    //luego eliminar
    $eliminar_notificacion = $start->Conexiondb();
    $eliminar_notificacion=$eliminar_notificacion->prepare("delete from notificacionx where idnotificacionx=:id");

    $eliminar_notificacion->execute([":id"=>$id_delete]);
    if($eliminar_notificacion->rowCount()==1){
        $response = array("status" => "success", "message" => "¡Se elimino correctamente!");
        echo json_encode($response);
    } else {
        throw new PDOException("Error al eliminar la notificacion");
    }
}   

} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}


?>