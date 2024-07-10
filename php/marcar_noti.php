<?php
require_once "../conexion/conexion_db.php";

// Obtener el ID de la notificación de la URL
$id_notificacion = isset($_GET['id_n']) ? intval($_GET['id_n']) : 0;

if ($id_notificacion > 0) {
    // Conectar a la base de datos
    $start = new Conexion();
    $conn = $start->Conexiondb();

    // Actualizar el estado de la notificación a 'leído'
    $stmt = $conn->prepare("UPDATE notificacionx SET leido = 1 WHERE idnotificacionx = :id");
    $stmt->bindParam(':id', $id_notificacion, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Redirigir a la página de destino después de marcar como leído
        header("Location: ../index.php?mostrar=frmnotificaciones");
        exit();
    } else {
        echo "Error al marcar la notificación como leída.";
    }
} else {
    echo "ID de notificación no válido.";
}
?>