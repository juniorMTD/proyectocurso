<?php
$consulta="SELECT p.texto_pregunta, o.texto_opcionx, COUNT(r.idopcionx) AS total_respuestas
FROM respuestax r
JOIN preguntax p ON r.idpreguntax = p.idpreguntax
JOIN opcionx o ON r.idopcionx = o.idopcionx
WHERE p.idencuestax = 5
GROUP BY p.texto_pregunta, o.texto_opcionx;";


?>


<h1>
    Hola soy reporte respusta
</h1>