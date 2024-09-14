<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";

$id = (isset($_GET['id_mostrar1'])) ? $_GET['id_mostrar1'] : 0;
$id = limpiar_cadena($id);

$start = new Conexion();

$consulta="select t.idtemax,t.temx, t.estadox as estado,cu.nombre,c.idcategoriax from temax t  
    inner join cursox cu ON
    t.idcursox=cu.idcursox inner join categoriax c ON
    cu.idcategoriax=c.idcategoriax
     where cu.idcursox='$id';";

$check_curso = $start->Conexiondb();
$check_curso = $check_curso->query($consulta);
$datos = $check_curso->fetchAll();

$check_curso = $start->Conexiondb();
$check_curso = $check_curso->query($consulta);


if($check_curso->rowCount()>0){
    $datos1=$check_curso->fetch();

?>
<!-- page content -->
<div class="right_col" role="main" id="fondototal">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3 class="titulos-contenido">CURSO: <?php echo htmlspecialchars($datos1['nombre'], ENT_QUOTES, 'UTF-8'); ?></h3>
            </div>
            <div class="title_right">
                <a href="./indexado.php?mostrar=frmcategoria&id_mostrar=<?php echo htmlspecialchars($datos1['idcategoriax'], ENT_QUOTES, 'UTF-8'); ?>" type="button" class="btn btn-danger"><i class="fa fa-mail-reply"></i>  Atras</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>TEMAS</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <!-- start project list -->
                        <table class="table table-striped projects">
                            <thead>
                                <tr>
                                    <th style="width: 10%">N°</th>
                                    <th style="width: 70%">Nombre del tema</th>
                                    <!-- <th>Estado</th> -->
                                    <!-- <th style="width: 20%"></th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $contador=0;
                                    foreach($datos as $rows){      
                                        if($rows['estado']=='1'){          
                                        $contador++;
                                ?>
                                <tr>
                                    <td><?php echo $contador ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($rows['temx'], ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td>
                                    <a href="indexado.php?mostrar=frmcontenido&id_mostrar2=<?php echo htmlspecialchars($rows['idtemax'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> Visualizar </a>
                                    </td>
                                </tr>
                                <?php
                                        }
                                    } 
                                ?>
                            </tbody>
                        </table>
                        <!-- end project list -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<?php
    }else{
        ?> 
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Aun no hay temas para este curso, regrese pronto</h3>
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