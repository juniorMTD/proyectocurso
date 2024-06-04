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
            <tr class="even pointer">
                <td class=" ">1</td>
                <td class=" ">Geotecnia</td>
                <td class=" ">Es una categoria de geotenica bla bla bla</td>
                <td class=" last"><a type="button" class="btn btn-primary" href="#">Editar</a></td>
                <td class=" last"><a type="button" class="btn btn-danger" href="#">Eliminar</a></td>
            </tr>
            </tbody>
        </table>
    </div>
    <p class="has-text-right">Mostrando usuarios <strong>"'.$pag_inicio.'"</strong> al <strong>"'.$pag_final.'"</strong> de un <strong>total de '.$total.'</strong></p>	
    <nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">
        <a class="pagination-previous is-disable" disabled >Anterior</a>
        <ul class="pagination-list">
            <li><a class="pagination-link" href="'.$url.'1">1</a></li>
            <li><span class="pagination-ellipsis">&hellip;</span></li> 
        </ul>
        <a class="pagination-next is-disabled" disabled >Siguiente</a>
    </nav>
    
    
</div>