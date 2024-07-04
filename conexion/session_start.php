<?php

if (session_status() == PHP_SESSION_NONE) {
    session_name("CC");
    session_start();
    
}

?>