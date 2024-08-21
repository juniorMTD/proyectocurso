<?php
$login_usu = limpiar_cadena($_POST['login_usu']);
$login_clv = limpiar_cadena($_POST['login_clv']);


#verificar si los datos son vacios
if ($login_usu == "") {
    echo    '<div class="notification is-danger is-light">
            <strong>¡El usuario es obligatorio, completar!</strong><br>
            </div>';
    exit();
}
if ($login_clv == "") {
    echo    '<div class="notification is-danger is-light">
            <strong>¡La clave es obligatorio, completar!</strong><br>
            </div>';
    exit();
}


#verificar la integridad de los datos
if (verificar_datos("[a-zA-Z0-9]{4,20}", $login_usu)) {
    echo    '<div class="notification is-danger is-light">
            <strong>¡El usuario no cumple con el formato, completar!</strong><br>
            </div>';
    exit();
}
if (verificar_datos("[a-zA-Z0-9$@.-]{6,100}", $login_clv)) {
    echo    '<div class="notification is-danger is-light">
            <strong>¡La contraseña no cumple con el formato, completar!</strong><br>
            </div>';
    exit();
}


#conectar y verificar el acceso

$start = new Conexion();
$conn = $start->Conexiondb();

$check_usuario = $conn->query("SELECT * FROM usux ux inner join usuariox usx on ux.idusux=usx.idusux and usux='$login_usu' and estadox=1;");
$check_empleado = $conn->query("SELECT * FROM usux ux inner join empleado e on e.idusux=ux.idusux and ux.usux='$login_usu' and ux.estadox=1;");

if ($check_usuario->rowCount() == 1) {
    $check_usuario = $check_usuario->fetch();
    if ($check_usuario['usux'] == $login_usu && $check_usuario['clvx'] == $login_clv) {
        $_SESSION['id'] = $check_usuario['idusuariox'];
        $_SESSION['idusu'] = $check_usuario['idusux'];
        $_SESSION['nombres'] = $check_usuario['nomx'];
        $_SESSION['apellidos'] = $check_usuario['apelx'];
        $_SESSION['usuario'] = $check_usuario['usux'];

        if (headers_sent()) {
            echo "<script> window.location.href='index.php?mostrar=home'; </script>";
        } else {
            header("Location: index.php?mostrar=home");
        }
    } else {
        echo    '<div class="notification is-danger is-light">
                <strong>¡Los datos del usuario ingresados no son validos, intente nuevamente!</strong><br>
                </div>';
    }
} else {
    if ($check_empleado->rowCount() == 1) {
        $check_empleado = $check_empleado->fetch();
        if ($check_empleado['usux'] == $login_usu && $check_empleado['clvx'] == $login_clv) {
            $_SESSION['id'] = $check_empleado['idusux'];
            $_SESSION['idusu'] = $check_empleado['idusux'];
            $_SESSION['nombres'] = $check_empleado['nomx'];
            $_SESSION['apellidos'] = $check_empleado['apelx'];
            $_SESSION['usuario'] = $check_empleado['usux'];

            if (headers_sent()) {
                echo "<script> window.location.href='index.php?mostrar=home'; </script>";
            } else {
                header("Location: index.php?mostrar=home");
            }
        } else {
            echo    '<div class="notification is-danger is-light">
                <strong>¡Los datos del empleado ingresados no son validos, intente nuevamente!</strong><br>
                </div>';
        }
    } else {
        echo    '<div class="notification is-danger is-light">
            <strong>¡Los datos ingresados no son validos, intente nuevamente!</strong><br>
            </div>';
    }
}

$check_usuario = null;
