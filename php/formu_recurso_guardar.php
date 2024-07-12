<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

$start = new Conexion();

$nom_re = limpiar_cadena($_POST['nomrecur']);
$idtem = limpiar_cadena($_POST['idtex']);
$tipo_re = limpiar_cadena($_POST['tipo_recurso']);
$icono= limpiar_cadena($_POST['icono']);


#validar los campos vacios
if (empty($nom_re)) {
    $response = array("status" => "error", "message" => "¡El nombre es obligatorio!");
    echo json_encode($response);
    exit();
}

if (!isset($_FILES['recurso']) || $_FILES['recurso']['error'] != UPLOAD_ERR_OK) {
    $response = array("status" => "error", "message" => "¡Seleccione un archivo, es obligatorio!");
    echo json_encode($response);
    exit();
}

if (empty($tipo_re)) {
    $response = array("status" => "error", "message" => "¡Seleccione el tipo de recurso es obligatorio!");
    echo json_encode($response);
    exit();
}




// Carpeta de destino para los archivos

$carpeta_destino = "../biblioteca/images/archivos_recursos/";

// Verificar si la carpeta de destino existe, si no, crearla
if (!file_exists($carpeta_destino)) {
    mkdir($carpeta_destino, 0777, true); // Ajustar permisos según necesidad de seguridad
}

// Obtener nombre y extensión del archivo de recurso
$nombre_archivo = $_FILES['recurso']['name'];
$archivo_temporal = $_FILES['recurso']['tmp_name'];


#verificar las validaciones de duplicado de archivo

// si hay un problema modificar y que registre los archivos creando automaticamente otro nombre del archivo
// Generar un nombre único para el archivo
$extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
$nombre_sin_extension = pathinfo($nombre_archivo, PATHINFO_FILENAME);
$nombre_unico = $nombre_sin_extension . '_' . time() . '.' . $extension;
$archivo_destino = $carpeta_destino . $nombre_unico;

// Verificar si el archivo ya existe y generar un nuevo nombre si es necesario
while (file_exists($archivo_destino)) {
    $nombre_unico = $nombre_sin_extension . '_' . time() . '.' . $extension;
    $archivo_destino = $carpeta_destino . $nombre_unico;
}


// Mover el archivo de recurso a la carpeta de destino
if (move_uploaded_file($archivo_temporal, $archivo_destino)) {
    $recurso=$nombre_unico;

} else {
    $response = array("status" => "error", "message" => "¡Hubo un problema al subir el recurso!");
    echo json_encode($response);
}


#guardando datos
try {
    $guardar_recurso = $start->Conexiondb();

    $guardar_recurso = $guardar_recurso->prepare('INSERT INTO recursox VALUES 
(:id,:nom,:recu,DEFAULT,:ico,:gratuito,:idtr,:idtema)');


    $maxmarcado = [
        ":id" => 'DEFAULT',
        ":nom" => $nom_re,
        ":recu" => $recurso,
        ":ico" => $icono,
        ":gratuito" => '0',
        ":idtr" => $tipo_re,
        ":idtema" => $idtem
    ];

    $guardar_recurso->execute($maxmarcado);

    if ($guardar_recurso->rowCount() == 1) {
        $response = array("status" => "success", "message" => "¡Se registro correctamente!");
        echo json_encode($response);
    } else {
        throw new PDOException("Error al registrar la recurso");
    }
    $guardar_recurso = null;
} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}



?>