<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$id_delete=limpiar_cadena($_GET['id_delete']); 



#eliminando datos

try {

//Estamos verificando el tema
$start = new Conexion();
$check_tema = $start->Conexiondb();
$check_tema=$check_tema->query("select idtemax from temax where idtemax='".$id_delete."'");


if($check_tema->rowCount()==1){
    //verificando si realizo un registro 
    $check_consulta = $start->Conexiondb();
    $check_consulta=$check_consulta->query("select t.idtemax from temax t inner join recursox r on r.idtemax=t.idtemax 
    where t.idtemax='".$id_delete."'");
    if($check_consulta->rowCount()==0){
        //luego eliminar
        $eliminar_tema = $start->Conexiondb();
        $eliminar_tema=$eliminar_tema->prepare("delete from temax where idtemax=:id");

        $eliminar_tema->execute([":id"=>$id_delete]);
        if($eliminar_tema->rowCount()==1){
            $response = array("status" => "success", "message" => "¡Se elimino correctamente!");
            echo json_encode($response);
        } else {
            throw new PDOException("Error al registrar el tema");
        }
    } else {
        $response = array("status" => "error", "message" => "¡Este registro tiene un vinculo con recursos, no se puede eliminar!");
        echo json_encode($response);
    }

}   

} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}


?>