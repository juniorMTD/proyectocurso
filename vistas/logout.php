<?php
// Iniciar sesión si no está ya iniciada
session_start();

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al login
if (headers_sent()) {
    // Si ya se enviaron los encabezados, usa JavaScript para redirigir
    echo "<script> window.location.href='indexado.php?mostrar=login'; </script>";
} else {
    // Si no se han enviado los encabezados, usa la función header
    header("Location: indexado.php?mostrar=login");
    exit();
}
?>