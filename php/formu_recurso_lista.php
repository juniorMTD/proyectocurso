<?php

$inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;
$tabla="";



if(isset($busqueda)&&$busqueda!=""){
    $consulta_datos="SELECT * FROM recursox r inner join tipo_recursox tr on r.idtipo_recursox=tr.idtipo_recursox
    inner join temax t on r.idtemax=t.idtemax where t.idtemax='$id' and tr.tipox like '%$registros%' or r.recurso like '%$registros%'
    order by r.idrecursox desc limit 0,$registros";

    $consulta_total="select count(r.idrecursox) FROM recursox r inner join tipo_recursox tr on r.idtipo_recursox=tr.idtipo_recursox
    inner join temax t on r.idtemax=t.idtemax where tr.tipox like '%$registros%' or r.recurso like '%$registros%'";
}else{
    $consulta_datos="SELECT * FROM recursox r inner join tipo_recursox tr on r.idtipo_recursox=tr.idtipo_recursox
    inner join temax t on r.idtemax=t.idtemax where t.idtemax='$id'  order by r.idrecursox desc limit 0,$registros";

    $consulta_total="select count(r.idrecursox) FROM recursox r inner join tipo_recursox tr on r.idtipo_recursox=tr.idtipo_recursox
    inner join temax t on r.idtemax=t.idtemax where t.idtemax='$id'" ;
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
                <th class="column-title">Nombre</th>
                <th class="column-title">Tipo de recurso</th>
                <th class="column-title">Recurso</th>
                <th class="column-title">Icono</th>
                <th class="column-title">Fecha</th>
                <th colspan="2" class="column-title"><span class="nobr">Accion</span>
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
                <td class=" ">'.$rows['nom_recu'].'</td>
                <td class=" ">'.$rows['tipox'].'</td>
                <td class=" ">';
                if (!empty($rows['recurso'])) {
                    // Mostrar el enlace para descargar el archivo
                    $tabla .= '<a href="./biblioteca/images/archivos_recursos/' . htmlspecialchars($rows['recurso']) . '" download>' . htmlspecialchars($rows['recurso']) . '</a>';
                } elseif (!empty($rows['enlace'])) {
                    // Verificar si el enlace tiene "http://" o "https://" al inicio, si no lo tiene, agregarlo
                    $enlace = $rows['enlace'];
                    if (strpos($enlace, 'http://') !== 0 && strpos($enlace, 'https://') !== 0) {
                        $enlace = 'http://' . $enlace;
                    }
                    // Mostrar el enlace guardado en la base de datos
                    $tabla .= '<a href="' . htmlspecialchars($enlace) . '" target="_blank">Ver recurso en línea</a>';
                } else {
                    // Si ambos están vacíos, mostrar un mensaje o dejarlo en blanco
                    $tabla .= 'No hay archivo ni enlace disponible';
                }
    
        $tabla .= '
                </td>
                <td class=" ">';

        if ($rows['icono']) {
            $tabla .= '<img style="width:30px;height:30;" src="./biblioteca/images/icon/' . htmlspecialchars($rows['icono']) . '" alt="Recurso">';
        } else {
            $tabla .= 'No se subió ningún icono';
        }

        $tabla.='</td>
                <td class=" ">'.$rows['f_regis'].'</td>
                <td class=" last"><a type="button" class="btn btn-primary" href="./indexado.php?mostrar=formu_recurso_update&id_update='.$rows['idrecursox'].'"><i class="fa fa-edit"></i> Editar</a></td>
                <td class=" last"><button type="button" class="btn btn-danger delete-btn" data-url="php/formu_recurso_eliminar.php?id_delete='.$rows['idrecursox'].'"><i class="fa fa-trash"></i> Eliminar</button></td>
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
    <p class="has-text-right">Mostrando recursos <strong>"'.$pag_inicio.'"</strong> al <strong>"'.$pag_final.'"</strong> de un <strong>total de '.$total.'</strong></p>	
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