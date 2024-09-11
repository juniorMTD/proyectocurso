<div id="modalprevisualizar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Previsualizacion de Recursos</h4>
        <a type="button" class="clase" href="./biblioteca/images/archivos_recursos/<?php echo htmlspecialchars($rows1['recur'], ENT_QUOTES, 'UTF-8'); ?>" download>Descargar</a>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
        </button>
      </div>
      <div class="modal-body">
            <div id="archivoObtenido"></div>
      </div>
      <div class="modal-footer center">
      </div>
    </div>
  </div>
</div>