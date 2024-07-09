<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$id_delete=limpiar_cadena($_GET['id_delete']); 



#eliminando datos

try {

//Estamos verificando la categoria
$start = new Conexion();
$check_categoria = $start->Conexiondb();
$check_categoria=$check_categoria->query("select idcategoriax from categoriax where idcategoriax='".$id_delete."'");


if($check_categoria->rowCount()==1){
    //verificando si realizo un registro
    $check_consulta = $start->Conexiondb();
    $check_consulta=$check_consulta->query("select ca.idcategoriax from categoriax ca inner join cursox cu on cu.idcategoriax=ca.idcategoriax 
    where ca.idcategoriax='".$id_delete."'");
    if($check_consulta->rowCount()==0){
        //luego eliminar 
        $eliminar_categoria = $start->Conexiondb();
        $eliminar_categoria=$eliminar_categoria->prepare("delete from categoriax where idcategoriax=:id");

        $eliminar_categoria->execute([":id"=>$id_delete]);
        if($eliminar_categoria->rowCount()==1){
            $response = array("status" => "success", "message" => "¡Se elimino correctamente!");
            echo json_encode($response);
        } else {
            throw new PDOException("Error al registrar la categoria");
        }
    } else {
        $response = array("status" => "error", "message" => "¡Este registro tiene un vinculo con los cursos, no se puede eliminar!");
        echo json_encode($response);
    }

}   

} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}


?>