<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";

$start = new Conexion();
$conn = $start->Conexiondb();
$datos = $conn->query("select * from categoriax;");
$datos = $datos->fetchAll();
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="animated flipInY col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="">
                    <h1>NUESTRAS CATEGORIAS</h1>
                </div>
            </div>
        </div>
        <br>
        <br>
        
        <div class="row top_tiles">
        <?php 
            foreach($datos as $rows){
        ?>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <a href="./index.php?mostrar=frmcategoria&id_mostrar=<?php echo htmlspecialchars($rows['idcategoriax'], ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="icon"><i class="fa fa-database"></i></div>
                        <div class="count">4</div>
                        <h3><?php echo htmlspecialchars($rows['nomx'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p><br><br></p>
                    </a>
                </div>
            </div>
            <?php
          } 
        ?>
        </div>
        
    </div>
</div>
<!-- /page content -->