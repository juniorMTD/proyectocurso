<!DOCTYPE html>
<html lang="es">

<head>
    <?php include "./inc/head.php" ?>
</head>

<body class="nav-md"></body>
<?php
if (!isset($_GET['mostrar']) || $_GET['mostrar'] == "") {
    $_GET['mostrar'] = "pag";
}
if ($_GET['mostrar'] == "pag") {
    include "./vistas/pag.php";
}
?>

</body>

</html>