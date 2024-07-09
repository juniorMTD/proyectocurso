<?php

require_once "../conexion/conexion_db.php";
require_once "./main.php";

// $start = new Conexion();


// $id=limpiar_cadena($_POST['idrecurso']);

// $check_recurso = $start->Conexiondb();
// $check_recurso=$check_recurso->query("SELECT * FROM recursox where idrecursox='$id'");

// if($check_recurso->rowCount()<=0){

//     $response = array("status" => "error", "message" => "¡No existe el recurso!");
//     echo json_encode($response);
//     exit();
// }else{
//     $datos=$check_recurso->fetch();
// }

// $check_recurso=null;


// $idtem = limpiar_cadena($_POST['idtex']);
// $tipo_re = limpiar_cadena($_POST['tipo_recurso']);
// $icono= limpiar_cadena($_POST['icono']);


// #validar los campos vacios

// if (!isset($_FILES['recurso']) || $_FILES['recurso']['error'] != UPLOAD_ERR_OK) {
//     $response = array("status" => "error", "message" => "¡Seleccione un archivo, es obligatorio!");
//     echo json_encode($response);
//     exit();
// }


// if (empty($tipo_re)) {
//     $response = array("status" => "error", "message" => "¡Seleccione el tipo de recurso es obligatorio!");
//     echo json_encode($response);
//     exit();
// }




// Carpeta de destino para los archivos

// $carpeta_destino = "../biblioteca/images/archivos_recursos/";

// Verificar si la carpeta de destino existe, si no, crearla
// if (!file_exists($carpeta_destino)) {
//     mkdir($carpeta_destino, 0777, true); // Ajustar permisos según necesidad de seguridad
// }

// Obtener nombre y extensión del archivo de recurso
// $nombre_archivo = $_FILES['recurso']['name'];
// $archivo_temporal = $_FILES['recurso']['tmp_name'];


// #verificar las validaciones de duplicado de archivo

// Si se ha seleccionado un nuevo archivo
// if (!empty($nombre_archivo_nuevo)) {
//     $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
//     $nombre_sin_extension = pathinfo($nombre_archivo, PATHINFO_FILENAME);
//     $nombre_unico = $nombre_sin_extension . '_' . time() . '.' . $extension;
//     $archivo_destino = $carpeta_destino . $nombre_unico;

//     Verificar si el archivo ya existe y generar un nuevo nombre si es necesario
//     while (file_exists($archivo_destino)) {
//         $nombre_unico = $nombre_sin_extension . '_' . time() . '.' . $extension;
//         $archivo_destino = $carpeta_destino . $nombre_unico;
//     }

//     Mover el archivo de recurso a la carpeta de destino
//     if (move_uploaded_file($archivo_temporal, $archivo_destino)) {
//         Limpia el archivo anterior si existe y es diferente al nuevo
//         if (!empty($nombre_archivo_actual) && $nombre_archivo_actual !== $nombre_unico) {
//             $ruta_archivo_anterior = $carpeta_destino . $nombre_archivo_actual;
//             if (file_exists($ruta_archivo_anterior)) {
//                 unlink($ruta_archivo_anterior); // Elimina el archivo anterior si ya no se necesita
//             }
//         }
//        Actualizar el nombre del archivo actual
//        $nombre_archivo_actual = $nombre_unico;
    
//     } else {
//         $response = array("status" => "error", "message" => "¡Hubo un problema al subir el recurso!");
//         echo json_encode($response);
//     }

// }



// #actualizando datos
// try {
//     $guardar_recurso = $start->Conexiondb();

//     $guardar_recurso = $guardar_recurso->prepare('UPDATE recursox SET recurso=:recu,icono=:ico,idtipo_recursox=:idtr,idtemax=:idtema where idrecursox="'.$id.'"');

//     $maxmarcado = [
//         ":recu" => $recurso,
//         ":ico" => $icono,
//         ":idtr" => $tipo_re,
//         ":idtema" => $idtem
//     ];

//     if ($guardar_recurso->execute($maxmarcado)) {
//         $response = array("status" => "success", "message" => "¡Se actualizo correctamente!");
//         echo json_encode($response);
//     } else {
//         throw new PDOException("Error al registrar la recurso");
//     }
//     $guardar_recurso = null;
// } catch (PDOException $e) {
//     $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
//     echo json_encode($response);
//     exit();
// }



?>