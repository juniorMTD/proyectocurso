<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$id_delete=limpiar_cadena($_GET['id_delete']); 



#eliminando datos

try {

//Estamos verificando la categoria
$start = new Conexion();
$check_encuesta = $start->Conexiondb();
$check_encuesta=$check_encuesta->query("select idencuestax from encuestax where idencuestax='".$id_delete."'");


if($check_encuesta->rowCount()==1){
    //verificando si realizo un registro 
    $check_consulta = $start->Conexiondb();
    $check_consulta=$check_consulta->query("select e.idencuestax from encuestax e inner join preguntax p on p.idencuestax=e.idencuestax 
    where e.idencuestax='".$id_delete."'");
    if($check_consulta->rowCount()==0){
        //verificando si realizo un registro 
        $check_consulta2 = $start->Conexiondb();
        $check_consulta2=$check_consulta2->query("select e.idencuestax from encuestax e inner join encuesta_usux eu on eu.idencuestax=e.idencuestax 
        where e.idencuestax='".$id_delete."'");
        if($check_consulta2->rowCount()==0){
            //luego eliminar
            $eliminar_encuesta = $start->Conexiondb();
            $eliminar_encuesta=$eliminar_encuesta->prepare("delete from encuestax where idencuestax=:id");

            $eliminar_encuesta->execute([":id"=>$id_delete]);
            if($eliminar_encuesta->rowCount()==1){
                $response = array("status" => "success", "message" => "¡Se elimino correctamente!");
                echo json_encode($response);
            } else {
                throw new PDOException("Error al registrar la encuesta");
            }
        } else {
            $response = array("status" => "error", "message" => "¡Este registro tiene un vinculo con alguna usuario que respondio la encuesta, no se puede eliminar!");
            echo json_encode($response);
        }

    } else {
        $response = array("status" => "error", "message" => "¡Este registro tiene un vinculo con alguna pregunta, no se puede eliminar!");
        echo json_encode($response);
    }

}   

} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}


?>