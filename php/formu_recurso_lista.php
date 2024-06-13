<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
            <tr class="headings">
                <th class="column-title">Numero</th>
                <th class="column-title">Tipo de recurso</th>
                <th class="column-title">recurso</th>
                <th colspan="2" class="column-title"><span class="nobr">Accion</span>
                </th>
            </tr>
            </thead>

            <tbody>
            <tr class="even pointer">
                <td class=" ">1</td>
                <td class=" ">Libro</td>
                <td class=" "><i class="fa fa-book"></i></td>
                <td class=" last"><a type="button" class="btn btn-primary" href="#"><i class="fa fa-edit"></i> Editar</a></td>
                <td class=" last"><a type="button" class="btn btn-danger" href="#"><i class="fa fa-trash"></i> Eliminar</a></td>
            </tr>
            </tbody>
        </table>
    </div>
    <p class="has-text-right">Mostrando categorias <strong>"'.$pag_inicio.'"</strong> al <strong>"'.$pag_final.'"</strong> de un <strong>total de '.$total.'</strong></p>	
    <nav class="my-pagination centered rounded" role="navigation" aria-label="pagination">
        <a class="prev-button disabled" disabled>Anterior</a>
        <ul class="pagination-items">
            <li><a class="page-link" href="'.$url.'1">1</a></li>
            <li><span class="page-ellipsis">&hellip;</span></li>
        </ul>
        <a class="next-button disabled" disabled>Siguiente</a>
    </nav>
    
    
</div>