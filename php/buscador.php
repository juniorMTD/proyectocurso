<?php
ob_start();

$modulo_buscador = limpiar_cadena($_POST['modulo_buscador']);
$modulos = ["categoria", "curso", "tema", "recurso", "sugerencia", "encuesta", "usuario", "personal"];

if (in_array($modulo_buscador, $modulos)) {
    $modulos_url = [
        "categoria" => "formu_categoria",
        "curso" => "formu_curso",
        "tema" => "formu_tema",
        "recurso" => "formu_recurso",
        "sugerencia" => "formu_sugerencias",
        "encuesta" => "formu_encuesta",
        "usuario" => "formu_usuario",
        "personal" => "formu_personal"
    ];

    $modulos_url = $modulos_url[$modulo_buscador];
    $modulo_buscador = "busqueda_" . $modulo_buscador;

    // Iniciar la búsqueda
    if (isset($_POST['txt_buscador'])) {
        $txt = limpiar_cadena($_POST['txt_buscador']);

        if ($txt == "") {
            echo '<div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    Introducir un término de búsqueda
                  </div>';
        } else {
            $_SESSION[$modulo_buscador] = $txt;
            echo "<script>window.location.href='indexado.php?mostrar=$modulos_url';</script>";
            exit();
        }
    }

    // Eliminar la búsqueda
    if (isset($_POST['eliminar_buscador'])) {
        unset($_SESSION[$modulo_buscador]);
        echo "<script>window.location.href='indexado.php?mostrar=$modulos_url';</script>";
        exit();
    }

} else {
    echo '<div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No podemos procesar la petición
          </div>';
}

ob_end_flush();
?>