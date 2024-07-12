<?php

$inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;
$tabla="";

if(isset($busqueda)&&$busqueda!=""){
    $consulta_datos="select * from sugerenciax s inner join usux u on s.idusux=u.idusux inner join usuariox usu on usu.idusux=u.idusux 
    where  usu.dnix like '%$busqueda%' or u.usux like '%$busqueda%' order by s.idsugerenciax desc limit 0,$registros";

    $consulta_total="select count(s.idsugerenciax) from sugerenciax s inner join usux u on s.idusux=u.idusux inner join usuariox usu on usu.idusux=u.idusux 
    where  usu.dnix like '%$busqueda%' or u.usux like '%$busqueda%';";
}else{
    $consulta_datos="select * from sugerenciax s inner join usux u on s.idusux=u.idusux inner join usuariox usu on usu.idusux=u.idusux 
    order by s.idsugerenciax desc limit 0,$registros";

    $consulta_total="select count(s.idsugerenciax) from sugerenciax s inner join usux u on s.idusux=u.idusux inner join usuariox usu on usu.idusux=u.idusux";
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
                <th class="column-title">Sugerencia</th>
                <th class="column-title">Usuario</th>
                <th class="column-title">DNI</th>
                <th class="column-title">Estado</th>
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
                <td class=" ">'.$rows['descx'].'</td>
                <td class=" ">'.$rows['usux'].'</td>
                <td class=" ">'.$rows['dnix'].'</td>
                <td class=" ">'.(($rows['estado_segu'] == 0) ? 'No Leido' : 'Leido').'</td>
                <td class=" ">'.$rows['f_registro'].'</td>
                <td class=" last"><a type="button" class="btn btn-primary" href="php/formu_sugerencia_actualizar.php?id_update='.$rows['idsugerenciax'].'"><i class="fa fa-eye"></i> Visualizar</a></td>
                <td class=" last"><button type="button" class="btn btn-danger delete-btn" data-url="php/formu_sugerencia_eliminar.php?id_delete='.$rows['idsugerenciax'].'"><i class="fa fa-trash"></i> Eliminar</button></td>
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
    <p class="has-text-right">Mostrando cursos <strong>"'.$pag_inicio.'"</strong> al <strong>"'.$pag_final.'"</strong> de un <strong>total de '.$total.'</strong></p>	
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