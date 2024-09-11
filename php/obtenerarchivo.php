<?php
require_once "../conexion/conexion_db.php";
require_once "./main.php";
$start = new Conexion();


$idArchivo = $_POST['idArchivo'];

$check_curso = $start->Conexiondb();
$check_curso = $check_curso->query("SELECT recurso FROM recursox WHERE idrecursox='$idArchivo'");
$datos = $check_curso->fetch();

$nombre=$datos['recurso'];

$extensionarchivo = pathinfo($nombre, PATHINFO_EXTENSION);

$img = tipoArchivo($nombre,$extensionarchivo);

if ($datos) {
    // Retorna el nombre del archivo encontrado
    $response = array("status" => "success", "archivo" => $img);
} else {
    $response = array("status" => "error", "message" => "Archivo no encontrado");
}

echo json_encode($response);

?>