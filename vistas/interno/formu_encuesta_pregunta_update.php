<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";

$idencuesta = (isset($_GET['idencuesta'])) ? $_GET['idencuesta'] : 0;
$idencuesta = limpiar_cadena($idencuesta);
$idpregunta = (isset($_GET['idpregunta'])) ? $_GET['idpregunta'] : 0;
$idpregunta = limpiar_cadena($idpregunta);

$start = new Conexion();
$conn = $start->Conexiondb();

// Cargar datos de la pregunta
$consulta_pregunta = "SELECT * FROM preguntax WHERE idpreguntax = :idpregunta";
$pregunta_stmt = $conn->prepare($consulta_pregunta);
$pregunta_stmt->execute([':idpregunta' => $idpregunta]);
$pregunta = $pregunta_stmt->fetch();

// Cargar tipos de preguntas
$consulta_tipos = "SELECT * FROM tipo_preguntax";
$tipos = $conn->query($consulta_tipos)->fetchAll();
?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div>
      <h3>ACTUALIZAR PREGUNTA</h3>
      <strong>Formulario de Actualización</strong>
      <hr>
    </div>
    <div class="clearfix"></div>

    <div class="custom-container">
      <form id="update-form" class="custom-form" action="./php/formu_pregunta_actualizar.php" method="POST" autocomplete="off" data-redirect-url="./indexado.php?mostrar=formu_encuesta_pregunta&id_pregunta=<?php echo $idencuesta ?>">

        <!-- mensaje de alerta -->
        <div id="alert" class="alert-overlay">
          <div class="alert-container">
            <span class="close" onclick="closeAlert()">&times;</span>
            <strong>¡Error!</strong> Los datos ingresados no son válidos, intente nuevamente.
          </div>
        </div>

        <input type="hidden" name="idencuesta" value="<?php echo $idencuesta ?>">
        <input type="hidden" name="idpregunta" value="<?php echo $idpregunta ?>">

        <div class="custom-form-row">
          <div class="custom-form-group">
            <label for="custom-pregunta">Nombre de la pregunta (*)</label>
            <input type="text" name="pregunta" class="custom-form-control" value="<?php echo $pregunta['texto_pregunta']; ?>" required>
          </div>
          <div class="custom-form-group">
            <label for="tipo_pregunta">Tipo de pregunta (*)</label>
            <select name="tipo_preguntas" class="custom-form-control" id="tipo_pregunta" required>
              <option value="">SELECCIONA...</option>
              <?php
              foreach ($tipos as $rows) {
              ?>
                <option value="<?php echo $rows['idtipo_preguntax']; ?>" <?php echo ($pregunta['idtipopre'] == $rows['idtipo_preguntax']) ? 'selected' : ''; ?>><?php echo $rows['tipo_pregunta']; ?></option>
              <?php
              }
              ?>
            </select>
          </div>
          <div class="custom-form-group">
            <label for="custom-estado">Estado de pregunta <small>(Marcar para activar)</small> </label>
            <input type="checkbox" name="estado" class="custom-form-control" value="1" <?php echo ($pregunta['estado_preg'] == 1) ? 'checked' : ''; ?>>
          </div>
        </div>

        <div id="tipo_1_div" class="tipo-pregunta" style="display: <?php echo ($pregunta['idtipopre'] == 1) ? 'block' : 'none'; ?>;">
          <p>Has seleccionado una pregunta de opción simple.</p>
          <div id="opciones-container-simple">
            <!-- Cargar opciones simples desde la base de datos -->
            <?php
            if ($pregunta['idtipopre'] == 1) {
              $consulta_opciones = "SELECT * FROM opcionx WHERE idpre = :idpregunta";
              $opciones_stmt = $conn->prepare($consulta_opciones);
              $opciones_stmt->execute([':idpregunta' => $idpregunta]);
              $opciones = $opciones_stmt->fetchAll();
              foreach ($opciones as $opcion) {
                echo '<div class="opcion-row custom-form-row">
                      <div class="custom-form-group">
                          <input type="radio" name="opcion_simple" value="' . $opcion['idopcion'] . '">
                      </div>
                      <div class="custom-form-group">
                          <input type="text" name="opciones_simple[]" class="custom-form-control" value="' . $opcion['texto_opcion'] . '">
                      </div>
                      <div class="custom-form-group">
                          <button type="button" class="btn-remove-opcion" onclick="removeOpcion(this)">Eliminar</button>
                      </div>
                    </div>';
              }
            }
            ?>
          </div>
          <center><button type="button" id="add-opcion-simple-btn" class="custom-btn custom-btn-secondary" onclick="addOpcion('simple')">+ Agregar</button></center>
        </div>

        <div id="tipo_2_div" class="tipo-pregunta" style="display: <?php echo ($pregunta['idtipopre'] == 2) ? 'block' : 'none'; ?>;">
          <p>Has seleccionado una pregunta de opción múltiple.</p>
          <div id="opciones-container-multiple">
            <!-- Cargar opciones múltiples desde la base de datos -->
            <?php
            if ($pregunta['idtipopre'] == 2) {
              $consulta_opciones = "SELECT * FROM opcionx WHERE idpre = :idpregunta";
              $opciones_stmt = $conn->prepare($consulta_opciones);
              $opciones_stmt->execute([':idpregunta' => $idpregunta]);
              $opciones = $opciones_stmt->fetchAll();
              foreach ($opciones as $opcion) {
                echo '<div class="opcion-row custom-form-row">
                      <div class="custom-form-group">
                          <input type="checkbox" name="opciones_multiple[]" value="' . $opcion['idopcion'] . '">
                      </div>
                      <div class="custom-form-group">
                          <input type="text" name="opciones_multiple_text[]" class="custom-form-control" value="' . $opcion['texto_opcion'] . '">
                      </div>
                      <div class="custom-form-group">
                          <button type="button" class="btn-remove-opcion" onclick="removeOpcion(this)">Eliminar</button>
                      </div>
                    </div>';
              }
            }
            ?>
          </div>
          <center><button type="button" id="add-opcion-multiple-btn" class="custom-btn custom-btn-secondary" onclick="addOpcion('multiple')">+ Agregar</button></center>
        </div>

        <div class="custom-form-row">
          <button type="submit" class="custom-btn custom-btn-primary">Actualizar</button>
          <a href="./indexado.php?mostrar=formu_encuesta_pregunta&id_pregunta=<?php echo $idencuesta ?>" type="button" class="custom-btn custom-btn-secondary">Salir</a>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /page content -->