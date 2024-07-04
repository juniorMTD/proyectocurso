<?php

$inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;
$tabla="";

if(isset($busqueda)&&$busqueda!=""){
    $consulta_datos="select * from categoriax c where  c.nomx like '%$busqueda%' order by c.idcategoriax desc limit 0,$registros";

    $consulta_total="select count(c.idcategoriax) from categoriax c where  c.nomx like '%$busqueda%'";
}else{
    $consulta_datos="select * from categoriax C ORDER BY C.idcategoriax DESC LIMIT 0,$registros";

    $consulta_total="select count(idcategoriax) from categoriax";
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
        <table class="table table-striped jambo_table bulk_action">
            <thead>
            <tr class="headings">
                <th class="column-title">Numero</th>
                <th class="column-title">Nombre de categoria</th>
                <th class="column-title">Descripcion</th>
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
                <td class=" ">'.$rows['nomx'].'</td>
                <td class=" ">'.$rows['descx'].'</td>
                <td class=" last"><a type="button" class="btn btn-primary" href="#"><i class="fa fa-edit"></i> Editar</a></td>
                <td class=" last"><a type="button" class="btn btn-danger" href="#"><i class="fa fa-trash"></i> Eliminar</a></td>
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
    <p class="has-text-right">Mostrando categorias <strong>"'.$pag_inicio.'"</strong> al <strong>"'.$pag_final.'"</strong> de un <strong>total de '.$total.'</strong></p>	
    ';
}


$conn=null;
echo $tabla;

if($total>=1 && $pagina<=$npaginas){
    echo paginador_tablas($pagina, $npaginas,$url,7);
}


    // <nav class="my-pagination centered rounded" role="navigation" aria-label="pagination">
    //     <a class="prev-button disabled" disabled>Anterior</a>
    //     <ul class="pagination-items">
    //         <li><a class="page-link" href="'.$url.'1">1</a></li>
    //         <li><span class="page-ellipsis">&hellip;</span></li>
    //     </ul>
    //     <a class="next-button disabled" disabled>Siguiente</a>
    // </nav>
$tabla.='    
</div>
';
?>