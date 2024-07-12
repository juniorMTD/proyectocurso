<?php

session_destroy();

if( headers_sent()){
    echo "<script> window.location.href='index.php?mostrar=login'; </script>";
}else{
    header("Location: index.php?mostrar=login");
}

?>