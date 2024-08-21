<?php
require_once "../conexion/conexion_db.php";
$start = new Conexion();

// Obtener el ID de la notificación de la URL
$id_notificacion = isset($_GET['id_n']) ? intval($_GET['id_n']) : 0;
$idusuario = isset($_GET['id_u']) ? intval($_GET['id_u']) : 0 ;

if ($id_notificacion > 0 && $idusuario > 0) {
    // Actualizar el estado de la notificación a 'leído'
    $actualizar_notificacion = $start->Conexiondb();
    $actualizar_notificacion = $actualizar_notificacion->prepare('UPDATE notificacionx_usuariox nu
     SET nu.leido = 1 WHERE nu.idnotificacionx_usuariox =:idnoti and nu.idusuariox=:idusu;');

    $maxmarcado = [
        ":idnoti" => $id_notificacion,
        ":idusu" => $idusuario
    ];

    if ($actualizar_notificacion->execute($maxmarcado)) {
        // Redirigir a la página de destino después de marcar como leído
        header("Location: ../index.php?mostrar=frmnotificaciones");
        exit();
    } else {
        echo "Error al marcar la notificación como leída.";
    }
} else {
    echo "ID de notificación o usuario no es válido";
}
?>