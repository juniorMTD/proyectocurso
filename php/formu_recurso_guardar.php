<?php
require_once "../conexion/conexion_db.php";
require_once "./main.php";

$start = new Conexion();

$nom_re = limpiar_cadena($_POST['nomrecur']);
$idtem = limpiar_cadena($_POST['idtex']);
$tipo_re = limpiar_cadena($_POST['tipo_recurso']);
$enlace = limpiar_cadena($_POST['enlace']);
$icono= limpiar_cadena($_POST['icono']);


#validar los campos vacios
if (empty($nom_re)) {
    $response = array("status" => "error", "message" => "¡El nombre es obligatorio!");
    echo json_encode($response);
    exit();
}

# Validar que al menos un recurso (archivo o enlace) esté presente
if ((!isset($_FILES['recurso']) || $_FILES['recurso']['error'] != UPLOAD_ERR_OK) && empty($enlace)) {
    $response = array("status" => "error", "message" => "¡Seleccione un archivo o cargue un enlace!");
    echo json_encode($response);
    exit();
}

if (empty($tipo_re)) {
    $response = array("status" => "error", "message" => "¡Seleccione el tipo de recurso, es obligatorio!");
    echo json_encode($response);
    exit();
}

// Inicializar la variable recurso
$recurso = '';

# Procesar archivo solo si está presente y sin errores
if (isset($_FILES['recurso']) && $_FILES['recurso']['error'] == UPLOAD_ERR_OK) {

    // Carpeta de destino para los archivos
    $carpeta_destino = "../biblioteca/images/archivos_recursos/";

    // Verificar si la carpeta de destino existe, si no, crearla
    if (!file_exists($carpeta_destino)) {
        mkdir($carpeta_destino, 0777, true); // Ajustar permisos según necesidad de seguridad
    }

    // Obtener nombre y extensión del archivo de recurso
    $nombre_archivo = $_FILES['recurso']['name'];
    $archivo_temporal = $_FILES['recurso']['tmp_name'];

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
        $recurso = $nombre_unico; // Guardar el nombre único para la base de datos
    } else {
        $response = array("status" => "error", "message" => "¡Hubo un problema al subir el recurso!");
        echo json_encode($response);
        exit(); // Terminar la ejecución si hay un error
    }
}


# Guardar datos en la base de datos
try {
    $guardar_recurso = $start->Conexiondb();

    $guardar_recurso = $guardar_recurso->prepare('INSERT INTO recursox VALUES 
    (:id,:nom,:recu,:enlace,DEFAULT,:ico,:gratuito,:idtr,:idtema)');

    // Si no se subió ningún archivo, dejar el campo de recurso como NULL
    $recurso = !empty($recurso) ? $recurso : null;

    $maxmarcado = [
        ":id" => 'DEFAULT',
        ":nom" => $nom_re,
        ":recu" => $recurso,  // Puede ser NULL si no hay archivo
        ":enlace" => $enlace,
        ":ico" => $icono,
        ":gratuito" => '0',
        ":idtr" => $tipo_re,
        ":idtema" => $idtem
    ];

    $guardar_recurso->execute($maxmarcado);

    if ($guardar_recurso->rowCount() == 1) {
        $response = array("status" => "success", "message" => "¡Se registró correctamente!");
        echo json_encode($response);
    } else {
        throw new PDOException("Error al registrar el recurso");
    }
    $guardar_recurso = null;
} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
    echo json_encode($response);
    exit();
}