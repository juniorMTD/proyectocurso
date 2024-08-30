<?php

session_destroy();

if( headers_sent()){
    echo "<script> window.location.href='indexado.php?mostrar=login'; </script>";
}else{
    header("Location: indexado.php?mostrar=login");
}

?>