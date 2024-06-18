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
if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $login_clv)) {
    echo    '<div class="notification is-danger is-light">
            <strong>¡La contraseña no cumple con el formato, completar!</strong><br>
            </div>';
    exit();
}


#conectar y verificar el acceso

$start = new Conexion();
$conn = $start->Conexiondb();

$check_usuario = $conn->query("SELECT * FROM usux ux inner join usuariox usx on ux.idusux=usx.idusuariox and usux='$login_usu' and estadox=1;");

if ($check_usuario->rowCount() == 1) {
    $check_usuario = $check_usuario->fetch();
    if ($check_usuario['usux'] == $login_usu && $check_usuario['clvx']==$login_clv) {
        $_SESSION['id'] = $check_usuario['idusuariox'];
        $_SESSION['nombres'] = $check_usuario['nomx'];
        $_SESSION['apellidos'] = $check_usuario['apelx'];
        $_SESSION['usuario'] = $check_usuario['usux'];

        if (headers_sent()) {
            echo "<script> window.location.href='index.php?mostrar=home'; </script>";
        } else {
            header("Location: index.php?mostrar=home");
        }
    } else {
        if ($login_usu == 'superadmin') {
                if ($check_usuario['usux'] == $login_usu && $check_usuario['clvx'] == $login_clv) {
                    $_SESSION['id'] = $check_usuario['idusux'];
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
                        <strong>¡Los datos ingresados no son validos, intente nuevamente!</strong><br>
                        </div>';
                }
        } else {
            echo    '<div class="notification is-danger is-light">
                    <strong>¡Los datos ingresados no son validos, intente nuevamente!</strong><br>
                    </div>';
        }
    }
} else {

    echo    '<div class="notification is-danger is-light">
                <strong>¡Los datos ingresados no son validos, intente nuevamente!</strong><br>
                </div>';
}

$check_usuario = null;
