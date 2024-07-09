<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$id_delete=limpiar_cadena($_GET['id_delete']); 



#eliminando datos

try {

//Estamos verificando la categoria
$start = new Conexion();
$check_curso = $start->Conexiondb();
$check_curso=$check_curso->query("select idcursox from cursox where idcursox='".$id_delete."'");


if($check_curso->rowCount()==1){
    //verificando si realizo un registro 
    $check_consulta = $start->Conexiondb();
    $check_consulta=$check_consulta->query("select cu.idcursox from cursox cu inner join temax t on t.idcursox=cu.idcursox 
    where cu.idcursox='".$id_delete."'");
    if($check_consulta->rowCount()==0){
        //luego eliminar
        $eliminar_curso = $start->Conexiondb();
        $eliminar_curso=$eliminar_curso->prepare("delete from cursox where idcursox=:id");

        $eliminar_curso->execute([":id"=>$id_delete]);
        if($eliminar_curso->rowCount()==1){
            $response = array("status" => "success", "message" => "¡Se elimino correctamente!");
            echo json_encode($response);
        } else {
            throw new PDOException("Error al registrar la categoria");
        }
    } else {
        $response = array("status" => "error", "message" => "¡Este registro tiene un vinculo con temas, no se puede eliminar!");
        echo json_encode($response);
    }

}   

} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}


?>