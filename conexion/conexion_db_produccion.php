<?php

class Conexion
{
    function Conexiondb(){
        $host='localhost';
        $dbname='terracivilingeni_dbcursouni';
        $username='terracivilingeni_defays';
        $password='terracivil2024*';

        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname",$username, $password);
            $conn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exp) {
            echo("Se conecto correctamente a la base de datos, error:$exp");
        }
        return $conn;
    }
}


?>