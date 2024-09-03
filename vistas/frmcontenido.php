<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";

$id = (isset($_GET['id_mostrar2'])) ? $_GET['id_mostrar2'] : 0;
$id = limpiar_cadena($id);

$start = new Conexion();

$check_tipo = $start->Conexiondb();
$check_tipo = $check_tipo->query("select * from tipo_recursox");
$datos = $check_tipo->fetchAll();


$check_tema = $start->Conexiondb();
$check_tema = $check_tema->query("select t.idtemax as idt, tr.tipox as tp, cu.nombre as curso, t.temx as tema, r.recurso as recur
 from temax t  inner join recursox r ON
r.idtemax=t.idtemax inner join cursox cu on t.idcursox=cu.idcursox inner join tipo_recursox tr
on r.idtipo_recursox=tr.idtipo_recursox where t.idtemax='$id';");

if ($check_tema->rowCount() > 0) {
    $datos1 = $check_tema->fetch();

?>

    <!-- page content -->
    <div class="right_col" role="main" id="fondototal">
        <div class="">
            <div class="page-title row">
                <div class="title_left">
                    <h6  class="titulos-contenido">CURSO: <?php echo htmlspecialchars($datos1['curso'], ENT_QUOTES, 'UTF-8'); ?> <br><br>TEMA: <br> <?php echo htmlspecialchars($datos1['tema'], ENT_QUOTES, 'UTF-8'); ?></h6>
                </div>
                <div class="title_right">
                    <a href="frmtema.html" type="button" class="btn btn-danger"><i class="fa fa-mail-reply"></i> Atras</a>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <?php
                foreach ($datos as $rows) {
                ?>
                    <div class="col-md-4">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><?php echo htmlspecialchars($rows['tipox'], ENT_QUOTES, 'UTF-8'); ?><small>Sesiones</small></h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <?php if ($rows['tipox'] == 'LIBROS') {

                                    $check_libro = $start->Conexiondb();
                                    $check_libro = $check_libro->query("select t.idtemax as idt, tr.tipox as tp, t.temx as tema, r.recurso as recur,r.icono as icon,r.f_regis as fecha, r.nom_recu as re
                                from temax t  inner join recursox r ON
                                r.idtemax=t.idtemax inner join tipo_recursox tr
                                on r.idtipo_recursox=tr.idtipo_recursox where t.idtemax='$id' and tr.tipox='LIBROS';");
                                    $libro = $check_libro->fetchAll();

                                    foreach ($libro as $rows1) {
                                ?>

                                        <article class="media event">
                                            <a class="pull-left date">
                                                <img src="./biblioteca/images/icon/<?php echo htmlspecialchars($rows1['icon'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image">
                                            </a>
                                            <div class="media-body">
                                                <p><?php echo htmlspecialchars($rows1['re'], ENT_QUOTES, 'UTF-8'); ?></p>
                                                <a class="title" href="./biblioteca/images/archivos_recursos/<?php echo htmlspecialchars($rows1['recur'], ENT_QUOTES, 'UTF-8'); ?>" download><img src="./biblioteca/images/icon/<?php echo htmlspecialchars($rows1['icon'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image"></a>
                                                <p>F. Registro: <?php echo htmlspecialchars($rows1['fecha'], ENT_QUOTES, 'UTF-8'); ?></p>
                                            </div>
                                        </article>
                                    <?php
                                    }
                                } else if ($rows['tipox'] == 'VIDEOS') {
                                    $check_video = $start->Conexiondb();
                                    $check_video = $check_video->query("select t.idtemax as idt, tr.tipox as tp, t.temx as tema, r.recurso as recur,r.icono as icon,r.f_regis as fecha, r.nom_recu as re
                                from temax t  inner join recursox r ON
                                r.idtemax=t.idtemax inner join tipo_recursox tr
                                on r.idtipo_recursox=tr.idtipo_recursox where t.idtemax='$id' and tr.tipox='VIDEOS';");
                                    $libro = $check_video->fetchAll();

                                    foreach ($libro as $rows1) {
                                    ?>
                                        <article class="media event">
                                            <a class="pull-left date">
                                                <img src="./biblioteca/images/icon/<?php echo htmlspecialchars($rows1['icon'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image">
                                            </a>
                                            <div class="media-body">
                                                <p><?php echo htmlspecialchars($rows1['re'], ENT_QUOTES, 'UTF-8'); ?></p>
                                                <a class="title" href="#"><?php echo htmlspecialchars($rows1['recur'], ENT_QUOTES, 'UTF-8'); ?></a>
                                                <p>F. Registro: <?php echo htmlspecialchars($rows1['fecha'], ENT_QUOTES, 'UTF-8'); ?></p>
                                            </div>
                                        </article>
                                <?php
                                    }
                                } else if ($rows['tipox'] == 'RESUMENES') {
                                    $check_resumen = $start->Conexiondb();
                                    $check_resumen = $check_resumen->query("select t.idtemax as idt, tr.tipox as tp, t.temx as tema, r.recurso as recur,r.icono as icon,r.f_regis as fecha, r.nom_recu as re
                                from temax t  inner join recursox r ON
                                r.idtemax=t.idtemax inner join tipo_recursox tr
                                on r.idtipo_recursox=tr.idtipo_recursox where t.idtemax='$id' and tr.tipox='RESUMENES';");
                                    $libro = $check_resumen->fetchAll();

                                    foreach ($libro as $rows1) {
                                    ?>
                                        <article class="media event">
                                            <a class="pull-left date">
                                                <img src="./biblioteca/images/icon/<?php echo htmlspecialchars($rows1['icon'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image">
                                            </a>
                                            <div class="media-body">
                                                <p><?php echo htmlspecialchars($rows1['re'], ENT_QUOTES, 'UTF-8'); ?></p>
                                                <a class="title" href="#"><?php echo htmlspecialchars($rows1['recur'], ENT_QUOTES, 'UTF-8'); ?></a>
                                                <p>F. Registro: <?php echo htmlspecialchars($rows1['fecha'], ENT_QUOTES, 'UTF-8'); ?></p>
                                            </div>
                                        </article>
                                <?php
                                    }
                                } else if ($rows['tipox'] == 'INFOGRAFIAS') {
                                    $check_resumen = $start->Conexiondb();
                                    $check_resumen = $check_resumen->query("select t.idtemax as idt, tr.tipox as tp, t.temx as tema, r.recurso as recur,r.icono as icon,r.f_regis as fecha, r.nom_recu as re
                                from temax t  inner join recursox r ON
                                r.idtemax=t.idtemax inner join tipo_recursox tr
                                on r.idtipo_recursox=tr.idtipo_recursox where t.idtemax='$id' and tr.tipox='INFOGRAFIAS';");
                                    $libro = $check_resumen->fetchAll();

                                    foreach ($libro as $rows1) {
                                    ?>
                                        <article class="media event">
                                            <a class="pull-left date">
                                                <img src="./biblioteca/images/icon/<?php echo htmlspecialchars($rows1['icon'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image">
                                            </a>
                                            <div class="media-body">
                                                <p><?php echo htmlspecialchars($rows1['re'], ENT_QUOTES, 'UTF-8'); ?></p>
                                                <a class="title" href="#"><?php echo htmlspecialchars($rows1['recur'], ENT_QUOTES, 'UTF-8'); ?></a>
                                                <p>F. Registro: <?php echo htmlspecialchars($rows1['fecha'], ENT_QUOTES, 'UTF-8'); ?></p>
                                            </div>
                                        </article>
                                <?php
                                    }
                                }

                                ?>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>

            </div>

        </div>
    </div>
    <!-- /page content -->

<?php
} else {
?>
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Los datos estan siendo procesados</h3>
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