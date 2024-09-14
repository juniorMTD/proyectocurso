<?php
require_once "../conexion/conexion_db.php";
require_once "./main.php";
$start = new Conexion();

$idArchivo = $_POST['idArchivo'];

$check_curso = $start->Conexiondb();
$check_curso = $check_curso->query("SELECT recurso FROM recursox WHERE idrecursox='$idArchivo'");
$datos = $check_curso->fetch();

if ($datos) {
    $nombre = $datos['recurso'];
    $extensionarchivo = pathinfo($nombre, PATHINFO_EXTENSION);

    // Supongamos que el archivo está en un directorio accesible, ajusta la ruta según sea necesario
    $fileUrl = './biblioteca/images/archivos_recursos/' . $nombre;

    $img = tipoArchivo($nombre, $extensionarchivo);

    // Retorna el nombre del archivo y la URL para descarga
    $response = array(
        "status" => "success",
        "archivo" => $img,
        "fileUrl" => $fileUrl,
        "fileName" => $nombre
    );
} else {
    $response = array("status" => "error", "message" => "Archivo no encontrado");
}

echo json_encode($response);
?>