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
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><?php echo htmlspecialchars($datos1['nomx'], ENT_QUOTES, 'UTF-8'); ?></h3>
            </div>
            <div class="title_right">
                <a href="./index.php?mostrar=frmprincipal" type="button" class="btn btn-danger"><i class="fa fa-mail-reply"></i> Atras</a>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            </div>

                            <div class="clearfix"></div>
                            <?php 
                                foreach($datos as $rows){
                            ?>
                            <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                            
                                <div class="well profile_view">
                                
                                    <div class="col-sm-12">
                                        <h4 class="brief"><i>CURSO</i></h4>
                                        <div class="left col-xs-7">
                                            <h2><?php echo htmlspecialchars($rows['nombre'], ENT_QUOTES, 'UTF-8'); ?></h2>
                                            <p><strong>Docente: </strong> <?php echo htmlspecialchars($rows['docentex'], ENT_QUOTES, 'UTF-8'); ?></p>
                                            <ul class="list-unstyled">
                                                <li><i class="fa fa-phone"></i> <strong>Celular: </strong> <?php echo htmlspecialchars($rows['celularx'], ENT_QUOTES, 'UTF-8'); ?></li>
                                            </ul>
                                        </div>
                                        <div class="right col-xs-5 text-center">
                                            <img src="./biblioteca/images/img.jpg" alt="" class="img-circle img-responsive">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 bottom text-center">
                                        <div class="col-xs-12 col-sm-6 emphasis">
                                            <p class="ratings">
                                                <span class="fa fa-user"> <?php echo htmlspecialchars(($rows['estadox']== 1) ? 'Activo' : 'Inactivo', ENT_QUOTES, 'UTF-8'); ?></span>
                                            </p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 emphasis">
                                            <a href="index.php?mostrar=frmtema&id_mostrar1=<?php echo htmlspecialchars($rows['idcursox'], ENT_QUOTES, 'UTF-8'); ?>" type="button" class="btn btn-success btn-xs">
                                                <i class="fa fa-book"> </i> TEMAS
                                            </a>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            <?php
                                } 
                            ?>

                        </div>
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
                        <h3>Los datos estan siendo procesados</h3>
                    </div>
                    <div class="title_right">
                        <a href="./index.php?mostrar=frmprincipal" type="button" class="btn btn-danger"><i class="fa fa-mail-reply"></i> Atras</a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    <?php
    }
?>