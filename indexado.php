<?php
require "./conexion/session_start.php";

// Tiempo máximo de inactividad (en segundos)
$tiempo_inactividad = 300; // 5 minutos (300 segundos)

// Verificar si la sesión ya fue iniciada y si existe el tiempo de última actividad
if (isset($_SESSION['ultimo_movimiento'])) {
    // Calcular el tiempo que ha pasado desde la última actividad
    $tiempo_transcurrido = time() - $_SESSION['ultimo_movimiento'];

    // Si el tiempo transcurrido es mayor que el tiempo permitido, cerrar la sesión
    if ($tiempo_transcurrido > $tiempo_inactividad) {
        // Destruir la sesión y redirigir al logout
        session_unset();   // Borrar todas las variables de sesión
        session_destroy(); // Destruir la sesión
        include "./vistas/logout.php";
        exit();
    }
}

// Actualizar el tiempo de la última actividad
$_SESSION['ultimo_movimiento'] = time();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include "./inc/head.php"; ?>
</head>
<body class="nav-md">

    <?php
    // Sanitización del parámetro 'mostrar'
    $vista = isset($_GET['mostrar']) ? htmlspecialchars(basename($_GET['mostrar'])) : 'login';

    // Función para verificar la sesión
    function verificar_sesion() {
        if (empty($_SESSION['id']) || empty($_SESSION['usuario'])) {
            include "./vistas/logout.php";
            exit();
        }
    }

    // Determinar la vista a cargar
    $ruta_vista = "";

    if (is_file("./vistas/$vista.php") && !in_array($vista, ["pag", "login", "registrarse", "404"])) {
        verificar_sesion();
        $ruta_vista = "./vistas/$vista.php";
    } elseif (is_file("./vistas/interno/$vista.php") && !in_array($vista, ["pag", "login", "registrarse", "404"])) {
        verificar_sesion();
        $ruta_vista = "./vistas/interno/$vista.php";
    } else {
        // Cargar vistas específicas
        switch ($vista) {
            case "pag":
                $ruta_vista = "./vistas/pag.php";
                break;
            case "login":
                $ruta_vista = "./vistas/login.php";
                break;
            case "registrarse":
                $ruta_vista = "./vistas/registrarse.php";
                break;
            default:
                $ruta_vista = "./vistas/404.php";
        }
    }

    // Incluir las vistas
    if ($vista !== "login" && $vista !== "registrarse" && $vista !== "404") {
        include "./inc/navbar.php";
    }

    include $ruta_vista;

    if ($vista !== "login" && $vista !== "404") {
        include "./inc/footer.php";
        include "./inc/script.php";
    }
    ?>

</body>
</html>