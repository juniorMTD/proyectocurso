<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";

$id = isset($_GET['id_mostrar2']) ? $_GET['id_mostrar2'] : 0;
$id = limpiar_cadena($id);

$start = new Conexion();
$conexion = $start->Conexiondb();

// Consulta combinada para todos los tipos de recursos
$query = "
    SELECT t.idtemax as idt, tr.tipox as tp, cu.nombre as curso, t.temx as tema, r.recurso as recur, r.icono as icon, r.f_regis as fecha, r.nom_recu as re, r.idrecursox, r.enlace,cu.idcursox as idcursox
    FROM temax t
    INNER JOIN recursox r ON r.idtemax = t.idtemax
    INNER JOIN cursox cu ON t.idcursox = cu.idcursox
    INNER JOIN tipo_recursox tr ON r.idtipo_recursox = tr.idtipo_recursox
    WHERE t.idtemax = :id
    ORDER BY tr.tipox, r.idrecursox DESC;
";
$statement = $conexion->prepare($query);
$statement->execute(['id' => $id]);
$datos = $statement->fetchAll();

// Verificar si hay resultados
if ($datos) {
    $extension = ['png', 'jpg', 'pdf', 'docx', 'doc', 'webp', 'mp4'];
?>
    <!-- page content -->
    <div class="right_col" role="main" id="fondototal">
        <div class="">
            <div class="page-title row">
                <div class="title_left">
                    <h6 class="titulos-contenido">CURSO: <?php echo htmlspecialchars($datos[0]['curso'], ENT_QUOTES, 'UTF-8'); ?> <br><br>TEMA: <br> <?php echo htmlspecialchars($datos[0]['tema'], ENT_QUOTES, 'UTF-8'); ?></h6>
                </div>
                <div class="title_right">
                    <a href="indexado.php?mostrar=frmtema&id_mostrar1=<?php echo htmlspecialchars($datos[0]['idcursox'], ENT_QUOTES, 'UTF-8'); ?>" type="button" class="btn btn-danger"><i class="fa fa-mail-reply"></i> Atras</a>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <?php
                $currentType = '';
                foreach ($datos as $row) {
                    if ($row['tp'] !== $currentType) {
                        if ($currentType !== '') {
                            echo '</div></div></div>'; // Cerrar divs anteriores
                        }
                        $currentType = $row['tp'];
                        ?>
                        <div class="col-md-3">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2><?php echo htmlspecialchars($currentType, ENT_QUOTES, 'UTF-8'); ?><small>Sesiones</small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                        <?php
                    }
                    $archivo = $row['recur'];
                    $extensionarchivo = pathinfo($archivo, PATHINFO_EXTENSION);
                    ?>
                    <article class="media event" style="color:white;padding:10px 5px;background: linear-gradient(to bottom, #05334b, #012232);">
                        <div class="media-body">
                            <?php
                            if (empty($row['recur'])) {
                                $enlace = $row['enlace'];
                                if (strpos($enlace, 'http://') !== 0 && strpos($enlace, 'https://') !== 0) {
                                    $enlace = 'http://' . $enlace;
                                }
                                ?>
                                <center>
                                    <a type="button" class="btn" href="<?php echo htmlspecialchars($enlace) ?>" target="_blank">
                                        <img src="./biblioteca/images/icon/<?php echo htmlspecialchars($row['icon'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image">
                                    </a>
                                 </center>
                                <p><?php echo htmlspecialchars($row['re'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <?php
                            } elseif (in_array($extensionarchivo, $extension)) {
                                ?>
                                <center>
                                    <a type="button" class="btn" data-toggle="modal" data-target="#modalprevisualizar" onclick="obtenerArchivoPorId('<?php echo htmlspecialchars($row['idrecursox'], ENT_QUOTES, 'UTF-8'); ?>')">
                                        <img src="./biblioteca/images/icon/<?php echo htmlspecialchars($row['icon'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image">
                                    </a>
                                </center>
                                <p><?php echo htmlspecialchars($row['re'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <?php
                            } else {
                                ?>
                                <p>Archivo no soportado</p>
                                <?php
                            }
                            ?>
                            <p>F. Registro: <?php echo htmlspecialchars($row['fecha'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                    </article>
                    <?php
                }
                if ($currentType !== '') {
                    echo '</div></div></div>'; // Cerrar divs finales
                }
                ?>
            </div>
        </div>
    </div>
    <!-- /page content -->
<?php
    include "modal_previsualizar.php";
} else {
?>
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Los datos están siendo procesados</h3>
                </div>
                <div class="title_right">
                    <a href="./indexado.php?mostrar=frmprincipal" type="button" class="btn btn-danger"><i class="fa fa-mail-reply"></i> Atras</a>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
<?php
}
?>