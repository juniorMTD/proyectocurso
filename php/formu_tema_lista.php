<?php

$inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;
$tabla="";

if(isset($busqueda)&&$busqueda!=""){
    $consulta_datos="select t.idtemax as id,ca.nomx as cate,cu.nombre as curso, t.temx as tema, t.estadox as esta from categoriax ca inner join cursox cu on cu.idcategoriax=ca.idcategoriax 
    inner join temax t on t.idcursox=cu.idcursox where ca.nomx like '%$busqueda%' or cu.nombre like '%$busqueda%' or t.temx like '%$busqueda%'
    order by t.idtemax desc limit 0,$registros";

    $consulta_total="select count(t.idtemax) from categoriax ca inner join cursox cu on cu.idcategoriax=ca.idcategoriax 
    inner join temax t on t.idcursox=cu.idcursox where ca.nomx like '%$busqueda%' or cu.nombre like '%$busqueda%' or t.temx like '%$busqueda%'";
}else{
    $consulta_datos="select t.idtemax as id, ca.nomx as cate,cu.nombre as curso, t.temx as tema, t.estadox as esta from categoriax ca inner join cursox cu on cu.idcategoriax=ca.idcategoriax 
    inner join temax t on t.idcursox=cu.idcursox order by t.idtemax desc limit 0,$registros";

    $consulta_total="select count(t.idtemax) from categoriax ca inner join cursox cu on cu.idcategoriax=ca.idcategoriax 
    inner join temax t on t.idcursox=cu.idcursox";
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
                <th class="column-title">Categoria</th>
                <th class="column-title">Curso</th>
                <th class="column-title">Tema</th>
                <th class="column-title">Estado</th>
                <th colspan="3" class="column-title"><span class="nobr">Accion</span>
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
                <td class=" ">'.$rows['cate'].'</td>
                <td class=" ">'.$rows['curso'].'</td>
                <td class=" ">'.$rows['tema'].'</td>
                <td class=" ">'.(($rows['esta'] == 1) ? 'Activo' : 'Inactivo').'</td>
                <td class=" last"><a type="button" class="btn btn-primary" href="./index.php?mostrar=formu_tema_update&id_update='.$rows['id'].'"><i class="fa fa-edit"></i> Editar</a></td>
                <td class=" last"><button type="button" class="btn btn-danger delete-btn" data-url="php/formu_tema_eliminar.php?id_delete='.$rows['id'].'"><i class="fa fa-trash"></i> Eliminar</button></td>
                <td class=" last"><a type="button" class="btn btn-warning" href="./index.php?mostrar=formu_recurso&idtemax='.$rows['id'].'"><i class="fa fa-book"></i> Recursos</a></td>
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
    <p class="has-text-right">Mostrando temas <strong>"'.$pag_inicio.'"</strong> al <strong>"'.$pag_final.'"</strong> de un <strong>total de '.$total.'</strong></p>	
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