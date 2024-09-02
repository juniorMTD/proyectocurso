<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";

$id = (isset($_GET['id_mostrar'])) ? $_GET['id_mostrar'] : 0;
$id = limpiar_cadena($id);

$start = new Conexion();
$check_curso = $start->Conexiondb();
$check_curso = $check_curso->query("select * from cursox cu  inner join categoriax ca ON
    cu.idcategoriax=ca.idcategoriax where ca.idcategoriax='$id';");
$datos = $check_curso->fetchAll();

$check_cate = $start->Conexiondb();
$check_cate = $check_cate->query("select * from cursox cu  inner join categoriax ca ON
    cu.idcategoriax=ca.idcategoriax where ca.idcategoriax='$id';");



if($check_curso->rowCount()>0){
    $datos1=$check_cate->fetch();

?>

<!-- page content -->
<div class="right_col" role="main"  id="fondototal">
    <div >
        <div class="page-title">
            <div class="title_left">
                <h3 class="titulos-contenido" >CATEGORIA: <?php echo htmlspecialchars($datos1['nomx'], ENT_QUOTES, 'UTF-8'); ?></h3>
            </div>
            <div class="title_right">
                <a href="./indexado.php?mostrar=frmprincipal" type="button" class="btn btn-danger"><i class="fa fa-mail-reply"></i> Atras</a>
            </div>
        </div>
        <br><br><br>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
            </div>

            <div class="clearfix"></div>
            <?php 
                foreach($datos as $rows){
                    if($rows['estadox']=='1'){

                    
            ?>
            <div class="col-md-4 col-sm-4 col-xs-12 profile_details" >
                <div class="profile_view1">
                    <div class="content">
                        <div class="col-sm-12">
                            <div class="left col-xs-7">
                                <h5><i class="fa fa-cc"></i> <strong>CURSO: <br> </strong> <?php echo htmlspecialchars($rows['nombre'], ENT_QUOTES, 'UTF-8'); ?></h5>
                                <p><i class="fa fa-child"></i> <strong>Docente: <br> </strong> <?php echo htmlspecialchars($rows['docentex'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <p><i class="fa fa-phone"></i> <strong>Docente: <br> </strong> <?php echo htmlspecialchars($rows['celularx'], ENT_QUOTES, 'UTF-8'); ?></p>
                            </div>
                            <div class="right col-xs-5 text-center">
                                <img src="./biblioteca/images/img.jpg" alt="" class="img-circle img-responsive">
                            </div>
                        </div>
                    </div>
                    <div class="overlay">
                        <a href="indexado.php?mostrar=frmtema&id_mostrar1=<?php echo htmlspecialchars($rows['idcursox'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-success">
                            Ver Temas
                        </a>
                    </div>
                </div>
            </div>
            <?php }
                } 
            ?>
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