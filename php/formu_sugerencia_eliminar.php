<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$id_delete=limpiar_cadena($_GET['id_delete']); 

#eliminando datos

try {

//Estamos verificando la categoria
$start = new Conexion();
$check_sugerencia = $start->Conexiondb();
$check_sugerencia=$check_sugerencia->query("select idsugerenciax from sugerenciax where idsugerenciax='".$id_delete."'");


if($check_sugerencia->rowCount()==1){
    //luego eliminar
    $eliminar_sugerencia = $start->Conexiondb();
    $eliminar_sugerencia=$eliminar_sugerencia->prepare("delete from sugerenciax where idsugerenciax=:id");

    $eliminar_sugerencia->execute([":id"=>$id_delete]);
    if($eliminar_sugerencia->rowCount()==1){
        $response = array("status" => "success", "message" => "¡Se elimino correctamente!");
        echo json_encode($response);
    } else {
        throw new PDOException("Error al eliminar la sugerencia");
    }
}   

} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}


?>