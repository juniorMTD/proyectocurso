<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$id_delete=limpiar_cadena($_GET['id_delete']); 


#eliminando datos

try {

//Estamos verificando el tema
$start = new Conexion();
$check_recurso = $start->Conexiondb();
$check_recurso=$check_recurso->query("select idrecursox from recursox where idrecursox='".$id_delete."'");


if($check_recurso->rowCount()==1){
    //verificando si realizo un registro 
    $check_consulta = $start->Conexiondb();
    $check_consulta=$check_consulta->query("select r.idrecursox from recursox r inner join pagox p on p.idrecursox=r.idrecursox 
    where r.idrecursox='".$id_delete."'");
    if($check_consulta->rowCount()==0){
        //luego eliminar
        $eliminar_tema = $start->Conexiondb();
        $eliminar_tema=$eliminar_tema->prepare("delete from recursox where idrecursox=:id");

        $eliminar_tema->execute([":id"=>$id_delete]);
        if($eliminar_tema->rowCount()==1){
            $response = array("status" => "success", "message" => "¡Se elimino correctamente!");
            echo json_encode($response);
        } else {
            throw new PDOException("Error al eliminar el recurso");
        }
    } else {
        $response = array("status" => "error", "message" => "¡Este registro tiene un vinculo con un pago, no se puede eliminar!");
        echo json_encode($response);
    }

}   

} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}


?>