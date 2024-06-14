<!DOCTYPE html>
<html lang="es">

  <head>
      <?php include "./inc/head.php" ?>
  </head>

  <body class="nav-md">
    <?php


      if(is_file("./vistas/".$_GET['mostrar'].".php" && $_GET['mostrar']!="pag")){
    
        include "./inc/navbar.php";
        include "./vistas/".$_GET['mostrar'].".php";
        include "./inc/footer.php";
        include "./inc/script.php";
    
      } else {
        if(is_file("./vistas/interno/".$_GET['mostrar'].".php" && $_GET['mostrar']!="pag")){
          include "./inc/navbar.php";
          include "./vistas/interno/".$_GET['mostrar'].".php";
          include "./inc/footer.php";
          include "./inc/script.php";
        }else {
          if($_GET['mostrar']=="pag" ){
            include "./vistas/pag.php";
          } else if($_GET['mostrar']=="login"){
            include "./vistas/login.php";
          } else if($_GET['mostrar']=="registrarse"){
            include "./vistas/registrarse.php";
          }
          else{
            include "./vistas/404.php";
          }
        }
      }
    ?>

  </body>
</html>