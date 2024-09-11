<?php

$inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;
$tabla="";

if(isset($busqueda)&&$busqueda!=""){
    $consulta_datos="select * from encuestax where titulox like '%$busqueda%' order by idencuestax desc limit 0,$registros";

    $consulta_total="select count(idencuestax) from encuestax where titulox like '%$busqueda%'";
}else{
    $consulta_datos="select * from encuestax ORDER BY idencuestax DESC LIMIT 0,$registros";

    $consulta_total="select count(idencuestax) from encuestax";
}

$start = new Conexion();
$conn = $start->Conexiondb();


$datos=$conn->query($consulta_datos);
$datos=$datos->fetchAll();/* si es mas de un registro*/

$total=$conn->query($consulta_total);
$total=(int) $total->fetchColumn();

$npaginas=ceil($total/$registros); /* para redondear un decimal se utiliza ceil*/


$tabla.='

<div class="x_content">
    <div class="table-responsive">
        <table id="delete-form" class="table table-striped jambo_table bulk_action">
            <thead>
            <tr class="headings">
                <th class="column-title">Numero</th>
                <th class="column-title">Encuesta</th>
                <th class="column-title">Descripción</th>
                <th class="column-title">PUBLICADO</th>
                <th colspan="3" class="column-title"><span class="nobr">REPORTES POR</span>
                </th>
            </tr>
            </thead>

            <tbody>
';

if($total>=1 && $pagina<=$npaginas){
    $contador=$inicio+1;
    $pag_inicio=$inicio+1;

    foreach($datos as $rows){

        $tabla.='
            <tr class="even pointer">
                <td class=" ">'.$contador.'</td>
                <td class=" ">'.$rows['titulox'].'</td>
                <td class=" ">'.$rows['descripx'].'</td>
                <td class=" ">'.(($rows['estado_encuesta'] == 1) ? 'SI' : 'NO').'</td>
                <td class=" last"><a type="button" class="btn btn-success" href="./indexado.php?mostrar=formu_encuesta_reporte_completada&id_reporte='.$rows['idencuestax'].'"><i class="fa fa-bar-chart"></i> Completadas o no</a></td>
                <td class=" last"><a type="button" class="btn btn-success" href="./indexado.php?mostrar=formu_encuesta_reporte_usuario&id_reporte='.$rows['idencuestax'].'"><i class="fa fa-bar-chart"></i> Usuario</a></td>
                <td class=" last"><a type="button" class="btn btn-success" href="./indexado.php?mostrar=formu_encuesta_reporte_respuesta&id_reporte='.$rows['idencuestax'].'"><i class="fa fa-bar-chart"></i> Respuesta por encuesta</a></td>
            </tr>
            ';
            $contador++;
    }   
    $pag_final=$contador-1;
}else{  
    if($total>=1){
        $tabla.='
        <tr class="has-text-centered">
        <td colspan="11">
            <a href="'.$url.'1" class="button is-link">
                Haga clic acá para recargar el listado
            </a>
        </td>
    </tr>
';
}else{
$tabla.='
    <tr class="has-text-centered ">
        <td colspan="11" class="notification is-primary">
            No hay registros en el sistema
        </td>
    </tr>
';
}
}

$tabla.='
            </tbody>
        </table>
    </div>
    ';

    if($total>=1 && $pagina<=$npaginas){
        $tabla.='
    <p class="has-text-right">Mostrando Encuestas <strong>"'.$pag_inicio.'"</strong> al <strong>"'.$pag_final.'"</strong> de un <strong>total de '.$total.'</strong></p>	
    ';
}


$conn=null;
echo $tabla;

if($total>=1 && $pagina<=$npaginas){
    echo paginador_tablas($pagina, $npaginas,$url,7);
}

$tabla.='    
</div>
';
?>