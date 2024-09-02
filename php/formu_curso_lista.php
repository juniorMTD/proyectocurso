<?php

$inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;
$tabla="";

if(isset($busqueda)&&$busqueda!=""){
    $consulta_datos="select * from cursox cu inner join categoriax ca on cu.idcategoriax=ca.idcategoriax where  ca.nomx like '%$busqueda%' or cu.docentex like '%$busqueda%' order by cu.idcursox desc limit 0,$registros";

    $consulta_total="select count(cu.idcursox) from cursox cu inner join categoriax ca on cu.idcategoriax=ca.idcategoriax where  ca.nomx like '%$busqueda%' or cu.docentex like '%$busqueda%'";
}else{
    $consulta_datos="select * from cursox cu inner join categoriax ca on cu.idcategoriax=ca.idcategoriax ORDER BY cu.idcursox DESC LIMIT 0,$registros";

    $consulta_total="select count(cu.idcursox) from cursox cu inner join categoriax ca on cu.idcategoriax=ca.idcategoriax";
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
                <th class="column-title">Curso</th>
                <th class="column-title">Categoria</th>
                <th class="column-title">Docente</th>
                <th class="column-title">Celular</th>
                <th class="column-title">Publicado</th>
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
                <td class=" ">'.$rows['nombre'].'</td>
                <td class=" ">'.$rows['nomx'].'</td>
                <td class=" ">'.$rows['docentex'].'</td>
                <td class=" ">'.$rows['celularx'].'</td>
                <td class=" ">'.(($rows['estadox'] == 1) ? 'SI' : 'NO').'</td>
                <td class=" last"><a type="button" class="btn btn-primary" href="./indexado.php?mostrar=formu_curso_update&id_update='.$rows['idcursox'].'"><i class="fa fa-edit"></i> Editar</a></td>
                <td class=" last"><button type="button" class="btn btn-danger delete-btn" data-url="php/formu_curso_eliminar.php?id_delete='.$rows['idcursox'].'"><i class="fa fa-trash"></i> Eliminar</button></td>
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