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
$check_tema = $check_tema->query("select t.idtemax as idt, tr.tipox as tp, cu.nombre as curso, t.temx as tema, r.recurso as recur, r.enlace
 from temax t  inner join recursox r ON
r.idtemax=t.idtemax inner join cursox cu on t.idcursox=cu.idcursox inner join tipo_recursox tr
on r.idtipo_recursox=tr.idtipo_recursox where t.idtemax='$id';");

if ($check_tema->rowCount() > 0) {
    $datos1 = $check_tema->fetch();

    $extension=array('png','jpg','pdf','docx','doc','webp','mp4');
    
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
                    <div class="col-md-3">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><?php echo htmlspecialchars($rows['tipox'], ENT_QUOTES, 'UTF-8'); ?><small>Sesiones</small></h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <?php if ($rows['tipox'] == 'LIBROS') {

                                    $check_libro = $start->Conexiondb();
                                    $check_libro = $check_libro->query("select t.idtemax as idt, tr.tipox as tp, t.temx as tema, r.recurso as recur,r.icono as icon,r.f_regis as fecha, r.nom_recu as re,r.idrecursox,r.enlace
                                from temax t inner join recursox r ON
                                r.idtemax=t.idtemax inner join tipo_recursox tr
                                on r.idtipo_recursox=tr.idtipo_recursox where t.idtemax='$id' and tr.tipox='LIBROS' order by r.idrecursox desc;");
                                    $libro = $check_libro->fetchAll();
                                    
                                    foreach ($libro as $rows1) {
                                    $archivo=$rows1['recur'];
                                    $extensionarchivo = pathinfo($archivo, PATHINFO_EXTENSION);
                                ?>
                                        <article class="media event" style="color:white;padding:10px 5px;background: linear-gradient(to bottom, #05334b, #012232);">
                                            <div class="media-body">
                                                <?php 
                                                if (empty($rows1['recur'])){
                                                    $enlace = $rows1['enlace'];
                                                    if (strpos($enlace, 'http://') !== 0 && strpos($enlace, 'https://') !== 0) {
                                                        $enlace = 'http://' . $enlace;
                                                    }
                                                    ?>
                                                    <center><a type="button" class="btn" href="<?php echo htmlspecialchars($enlace) ?>" target="_blank">
                                                        <img src="./biblioteca/images/icon/<?php echo htmlspecialchars($rows1['icon'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image">
                                                    </a></center><p><?php echo htmlspecialchars($rows1['re'], ENT_QUOTES, 'UTF-8'); ?></p>
                                                    <?php
                                                }elseif(in_array($extensionarchivo, $extension)){
                                                ?>
                                                <center><a type="button" class="btn" data-toggle="modal" data-target="#modalprevisualizar" onclick="obtenerArchivoPorId('<?php echo $rows1['idrecursox']  ?>')">
                                                    <img src="./biblioteca/images/icon/<?php echo htmlspecialchars($rows1['icon'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image">
                                                </a></center><p><?php echo htmlspecialchars($rows1['re'], ENT_QUOTES, 'UTF-8'); ?></p>
                                                <?php } else{
                                                    ?>
                                                    <p>Archivo no soportado</p>
                                                    <?php
                                                } 
                                                ?>
                                                
                                                <p>F. Registro: <?php echo htmlspecialchars($rows1['fecha'], ENT_QUOTES, 'UTF-8'); ?></p>
                                            </div>
                                        </article>
                                    <?php
                                    }
                                } else if ($rows['tipox'] == 'VIDEOS') {
                                    $check_video = $start->Conexiondb();
                                    $check_video = $check_video->query("select t.idtemax as idt, tr.tipox as tp, t.temx as tema, r.recurso as recur,r.icono as icon,r.f_regis as fecha, r.nom_recu as re,r.idrecursox,r.enlace
                                from temax t  inner join recursox r ON
                                r.idtemax=t.idtemax inner join tipo_recursox tr
                                on r.idtipo_recursox=tr.idtipo_recursox where t.idtemax='$id' and tr.tipox='VIDEOS' order by r.idrecursox desc;");
                                    $libro = $check_video->fetchAll();

                                    foreach ($libro as $rows1) {
                                    $archivo=$rows1['recur'];
                                    $extensionarchivo = pathinfo($archivo, PATHINFO_EXTENSION);
                                    ?>
                                        <article class="media event" style="color:white;padding:10px 5px;background: linear-gradient(to bottom, #05334b, #012232);">
                                            <div class="media-body">
                                                <?php 
                                                if (empty($rows1['recur'])){
                                                    $enlace = $rows1['enlace'];
                                                    if (strpos($enlace, 'http://') !== 0 && strpos($enlace, 'https://') !== 0) {
                                                        $enlace = 'http://' . $enlace;
                                                    }
                                                    ?>
                                                    <center><a type="button" class="btn" href="<?php echo htmlspecialchars($enlace) ?>" target="_blank">
                                                        <img src="./biblioteca/images/icon/<?php echo htmlspecialchars($rows1['icon'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image">
                                                    </a></center><p><?php echo htmlspecialchars($rows1['re'], ENT_QUOTES, 'UTF-8'); ?></p>
                                                    <?php
                                                }elseif(in_array($extensionarchivo, $extension)){
                                                ?>
                                                <center><a type="button" class="btn" data-toggle="modal" data-target="#modalprevisualizar" onclick="obtenerArchivoPorId('<?php echo $rows1['idrecursox']  ?>')">
                                                    <img src="./biblioteca/images/icon/<?php echo htmlspecialchars($rows1['icon'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image">
                                                </a></center><p><?php echo htmlspecialchars($rows1['re'], ENT_QUOTES, 'UTF-8'); ?></p>
                                                <?php } else{
                                                    ?>
                                                    <p>Archivo no soportado</p>
                                                    <?php
                                                } 
                                                ?>
                                                
                                                <p>F. Registro: <?php echo htmlspecialchars($rows1['fecha'], ENT_QUOTES, 'UTF-8'); ?></p>
                                            </div>
                                        </article>
                                <?php
                                    }
                                } else if ($rows['tipox'] == 'RESUMENES') {
                                    $check_resumen = $start->Conexiondb();
                                    $check_resumen = $check_resumen->query("select t.idtemax as idt, tr.tipox as tp, t.temx as tema, r.recurso as recur,r.icono as icon,r.f_regis as fecha, r.nom_recu as re,r.idrecursox,r.enlace
                                from temax t  inner join recursox r ON
                                r.idtemax=t.idtemax inner join tipo_recursox tr
                                on r.idtipo_recursox=tr.idtipo_recursox where t.idtemax='$id' and tr.tipox='RESUMENES' order by r.idrecursox desc;");
                                    $libro = $check_resumen->fetchAll();

                                    foreach ($libro as $rows1) {
                                    $archivo=$rows1['recur'];
                                    $extensionarchivo = pathinfo($archivo, PATHINFO_EXTENSION);
                                    ?>
                                        <article class="media event" style="color:white;padding:10px 5px;background: linear-gradient(to bottom, #05334b, #012232);">
                                            <div class="media-body">
                                                <?php 
                                                if (empty($rows1['recur'])){
                                                    $enlace = $rows1['enlace'];
                                                    if (strpos($enlace, 'http://') !== 0 && strpos($enlace, 'https://') !== 0) {
                                                        $enlace = 'http://' . $enlace;
                                                    }
                                                    ?>
                                                    <center><a type="button" class="btn" href="<?php echo htmlspecialchars($enlace) ?>" target="_blank">
                                                        <img src="./biblioteca/images/icon/<?php echo htmlspecialchars($rows1['icon'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image">
                                                    </a></center><p><?php echo htmlspecialchars($rows1['re'], ENT_QUOTES, 'UTF-8'); ?></p>
                                                    <?php
                                                }elseif(in_array($extensionarchivo, $extension)){
                                                ?>
                                                <center><a type="button" class="btn" data-toggle="modal" data-target="#modalprevisualizar" onclick="obtenerArchivoPorId('<?php echo $rows1['idrecursox']  ?>')">
                                                    <img src="./biblioteca/images/icon/<?php echo htmlspecialchars($rows1['icon'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image">
                                                </a></center><p><?php echo htmlspecialchars($rows1['re'], ENT_QUOTES, 'UTF-8'); ?></p>
                                                <?php } else{
                                                    ?>
                                                    <p>Archivo no soportado</p>
                                                    <?php
                                                } 
                                                ?>
                                                
                                                <p>F. Registro: <?php echo htmlspecialchars($rows1['fecha'], ENT_QUOTES, 'UTF-8'); ?></p>
                                            </div>
                                        </article>
                                <?php
                                    }
                                } else if ($rows['tipox'] == 'INFOGRAFIAS') {
                                    $check_resumen = $start->Conexiondb();
                                    $check_resumen = $check_resumen->query("select t.idtemax as idt, tr.tipox as tp, t.temx as tema, r.recurso as recur,r.icono as icon,r.f_regis as fecha, r.nom_recu as re,r.idrecursox,r.enlace
                                from temax t  inner join recursox r ON
                                r.idtemax=t.idtemax inner join tipo_recursox tr
                                on r.idtipo_recursox=tr.idtipo_recursox where t.idtemax='$id' and tr.tipox='INFOGRAFIAS' order by r.idrecursox desc;");
                                    $libro = $check_resumen->fetchAll();

                                    foreach ($libro as $rows1) {
                                    $archivo=$rows1['recur'];
                                    $extensionarchivo = pathinfo($archivo, PATHINFO_EXTENSION);
                                    ?>
                                        <article class="media event" style="color:white;padding:10px 5px;background: linear-gradient(to bottom, #05334b, #012232);">
                                            <div class="media-body">
                                                <?php 
                                                if (empty($rows1['recur'])){
                                                    $enlace = $rows1['enlace'];
                                                    if (strpos($enlace, 'http://') !== 0 && strpos($enlace, 'https://') !== 0) {
                                                        $enlace = 'http://' . $enlace;
                                                    }
                                                    ?>
                                                    <center><a type="button" class="btn" href="<?php echo htmlspecialchars($enlace) ?>" target="_blank">
                                                        <img src="./biblioteca/images/icon/<?php echo htmlspecialchars($rows1['icon'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image">
                                                    </a></center><p><?php echo htmlspecialchars($rows1['re'], ENT_QUOTES, 'UTF-8'); ?></p>
                                                    <?php
                                                }elseif(in_array($extensionarchivo, $extension)){
                                                ?>
                                                <center><a type="button" class="btn" data-toggle="modal" data-target="#modalprevisualizar" onclick="obtenerArchivoPorId('<?php echo $rows1['idrecursox']  ?>')">
                                                    <img src="./biblioteca/images/icon/<?php echo htmlspecialchars($rows1['icon'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image">
                                                </a></center><p><?php echo htmlspecialchars($rows1['re'], ENT_QUOTES, 'UTF-8'); ?></p>
                                                <?php } else{
                                                    ?>
                                                    <p>Archivo no soportado</p>
                                                    <?php
                                                } 
                                                ?>
                                                
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
  include "modal_previsualizar.php";

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