<?php
date_default_timezone_set('America/Lima');
// veriricar los tipos de datos
function verificar_datos($filtro,$cadena){
    if(preg_match("/^".$filtro."$/",$cadena)){
        return false;
    }
    else{
        return true;
    }
}

//limpiar  cadenas de texto

function limpiar_cadena($cadena){
    $cadena=trim($cadena);//quitar espacios en blanco o sobreescribirlos
    $cadena=stripslashes($cadena); // para evitar inyeccion sql
    //quita las sentencia mostradas
    $cadena=str_ireplace("<script>","",$cadena); // para evitar inyeccion sql con javascript 
    $cadena=str_ireplace("</script>","",$cadena); // para evitar inyeccion sql con javascript
    $cadena=str_ireplace("<script src","",$cadena); // para evitar inyeccion sql con javascript
    $cadena=str_ireplace("<script type=","",$cadena); // para evitar inyeccion sql con javascript
    $cadena=str_ireplace("SELECT * FROM","",$cadena); // para evitar inyeccion sql con sql
    $cadena=str_ireplace("DELETE FROM","",$cadena); // para evitar inyeccion sql con sql
    $cadena=str_ireplace("INSERT INTO","",$cadena); // para evitar inyeccion sql con sql
    $cadena=str_ireplace("DROP TABLE","",$cadena); // para evitar inyeccion sql con sql
    $cadena=str_ireplace("DROP DATABASE","",$cadena); // para evitar inyeccion sql con sql
    $cadena=str_ireplace("TRUNCATE TABLE","",$cadena); // para evitar inyeccion sql con sql
    $cadena=str_ireplace("SHOW TABLES","",$cadena); // para evitar inyeccion sql con sql
    $cadena=str_ireplace("SHOW DATABASES","",$cadena); // para evitar inyeccion sql con sql
    $cadena=str_ireplace("<?php","",$cadena); // para evitar inyeccion con php
    $cadena=str_ireplace("?>","",$cadena); // para evitar inyeccion sql con php
    $cadena=str_ireplace("--","",$cadena); // para evitar inyeccion sql con php
    $cadena=str_ireplace("^","",$cadena); // para evitar inyeccion sql con php
    $cadena=str_ireplace("<","",$cadena); // para evitar inyeccion sql con php
    $cadena=str_ireplace("[","",$cadena); // para evitar inyeccion sql con php
    $cadena=str_ireplace("]","",$cadena); // para evitar inyeccion sql con php
    $cadena=str_ireplace("==","",$cadena); // para evitar inyeccion sql con php
    $cadena=str_ireplace(";","",$cadena); // para evitar inyeccion sql con php
    $cadena=str_ireplace("::","",$cadena); // para evitar inyeccion sql con php
    $cadena=trim($cadena);//quitar espacios en blanco o sobreescribirlos
    $cadena=stripslashes($cadena); // para evitar inyeccion sql

    return $cadena;
}

// renombrar las fotos
function renombrar_fotos($nombre){
    $nombre=str_ireplace(" ","_",$nombre);
    $nombre=str_ireplace("/","_",$nombre);
    $nombre=str_ireplace("#","_",$nombre);
    $nombre=str_ireplace("-","_",$nombre);
    $nombre=str_ireplace("$","_",$nombre);
    $nombre=str_ireplace(".","_",$nombre);
    $nombre=str_ireplace(",","_",$nombre);
    $nombre=str_ireplace("%","_",$nombre);
    $nombre=str_ireplace("&","_",$nombre);
    $nombre=str_ireplace("@","_",$nombre);
    $nombre=str_ireplace("*","_",$nombre);
    $nombre=str_ireplace("+","_",$nombre);

    $nombre=$nombre."_".rand(0,100); // para que no haya repeticion en nombres de la fotos le asigna un numero aleatorio

    return $nombre;
}

// funcion paginador de tablas
function paginador_tablas($pagina, $npaginas,$url,$botones){
    $tabla='<nav class="my-pagination centered rounded" role="navigation" aria-label="pagination">';

        //boton anterior
        if($pagina<=1){
            $tabla.='
            <a class="prev-button disabled" disabled >Anterior</a>
            <ul class="pagination-items">
            ';
        }else{
            $tabla.='<a class="prev-button" href="'.$url.($pagina-1).'">Anterior</a>;
            <ul class="pagination-items">
                <li><a class="page-link" href="'.$url.'1">1</a></li>
                <li><span class="page-ellipsis">&hellip;</span></li>
            ';
        }


        $contadori=0;
        for($i=$pagina;$i<=$npaginas;$i++){

            if($contadori>=$botones){
                break;
            }
            if($pagina==$i){
                $tabla.='<li><a class="page-link" href="'.$url.$i.'">'.$i.'</a></li>';
            }else{
                $tabla.='<li><a class="page-link" href="'.$url.$i.'">'.$i.'</a></li>';
            }

            $contadori++;
        }

        // boton siguiente
        if($pagina==$npaginas){
            $tabla.='
            </ul>
            <a class="next-button disabled" disabled >Siguiente</a>
            ';
        }else{
            $tabla.='
                <li><span class="page-ellipsis">&hellip;</span></li>
                <li><a class="page-link" href="'.$url.$npaginas.'">'.$npaginas.'</a></li>
            </ul>
            <a class="next-button" href="'.$url.($pagina+1).'">Siguiente</a>
            ';
        }

    $tabla.='</nav>';
    return $tabla;
}


// para calcular en notificaciones para saber el tiempo que se envio 
function tiempo_transcurrido($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff_in_days = $diff->days;
    $weeks = floor($diff_in_days / 7);
    $days = $diff_in_days % 7;

    $string = array(
        'y' => 'año',
        'm' => 'mes',
        'w' => 'semana',
        'd' => 'día',
        'h' => 'hora',
        'i' => 'minuto',
        's' => 'segundo',
    );

    $values = array(
        'y' => $diff->y,
        'm' => $diff->m,
        'w' => $weeks,
        'd' => $days,
        'h' => $diff->h,
        'i' => $diff->i,
        's' => $diff->s,
    );

    foreach ($values as $k => &$v) {
        if ($v) {
            $v = $v . ' ' . $string[$k] . ($v > 1 ? 's' : '');
        } else {
            unset($values[$k]);
        }
    }

    if (!$full) $values = array_slice($values, 0, 1);
    return $values ? 'hace ' . implode(', ', $values) : 'justo ahora';
}

function tipoArchivo($nombre,$extension){
    $ruta="./biblioteca/images/archivos_recursos/".$nombre;
    switch ($extension) {
        case 'jpg':
        case 'png':
        case '':
            return '<img src="'.$ruta.'" style="width:100%;height:500px;">';
            break;
        case 'pdf':
            return '<iframe src="'.$ruta.'" style="width:100%; height:400px;" frameborder="0"></iframe>';
            break;
        case 'mp4':
            return '<video controls style="width:100%"><source src="' . $ruta . '" type="video/mp4"></video>';
            break;
        case 'docx':  // Previsualización de archivos Word usando Google Docs Viewer
        case 'doc':
            return '<iframe src="https://docs.google.com/gview?url=' . $ruta . '&embedded=true" style="width:100%; height:400px;" frameborder="0"></iframe>';
            break;
        default:
            return '<p>Archivo no soportado para previsualización.</p>';
            break;
    }
}

?>