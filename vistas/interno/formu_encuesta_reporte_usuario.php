<?php

$consulta="SELECT u.usux, e.titulox, p.texto_pregunta, o.texto_opcionx
FROM respuestax r
JOIN preguntax p ON r.idpreguntax = p.idpreguntax
JOIN opcionx o ON r.idopcionx = o.idopcionx
JOIN usux u ON r.idusux = u.idusux
JOIN encuestax e ON p.idencuestax = e.idencuestax
WHERE r.idusux = 4;";

?>

<h1>
    Hola soy reporte por usuario
</h1>