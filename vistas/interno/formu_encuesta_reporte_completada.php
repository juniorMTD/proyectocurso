<?php
$consulta="SELECT u.usux, eu.completada
FROM usux u
LEFT JOIN encuesta_usux eu ON u.idusux = eu.idusux where eu.completada='1' AND eu.idencuestax = 5;";


?>


<h1>
    Hola soy reporte completado
</h1>