<?php

require_once "../conexion/conexion_db.php";


// Obtener el ID de la sugerencia de la URL
$id_sugerencia = isset($_GET['id_update']) ? intval($_GET['id_update']) : 0;

if ($id_sugerencia > 0) {
    // Conectar a la base de datos
    $start = new Conexion();
    $conn = $start->Conexiondb();

    // Actualizar el estado de la sugerencia a 'leído'
    $stmt = $conn->prepare("UPDATE sugerenciax SET estado_segu = 1 WHERE idsugerenciax = :id");
    $stmt->bindParam(':id', $id_sugerencia, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Redirigir a la página de destino después de marcar como leído
        header("Location: ../indexado.php?mostrar=formu_sugerencia_update&id_update=$id_sugerencia");
        exit();
    } else {
        echo "Error al marcar la sugerencia como leída.";
    }
} else {
    echo "ID de sugerencia no válido.";
}


?>