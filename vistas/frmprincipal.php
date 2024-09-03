<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";

$start = new Conexion();
$conn = $start->Conexiondb();
$datos = $conn->query("select * from categoriax;");
$datos = $datos->fetchAll();


$check_encuesta=$start->Conexiondb();
$check_encuesta=$check_encuesta->query("select estado_encuesta from encuestax order by idencuestax desc limit 0,1");
$estado_encuesta=$check_encuesta->fetch();


if($estado_encuesta==1){
?>

<div class="right_col" role="main">
    <div class="">
    <div >
        <h3>ENCUESTA</h3>
        <strong>Por favor responda con sinceridad cada pregunta</strong>      
    </div>
</div>


<?php
} else if($estado_encuesta==0) {
?>

<!-- page content -->
<div  class="right_col" role="main" id="fondototal">
    <div  class="">
        <div class="row">
            <div class="animated flipInY col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="">
                    <h1 class="titulos-contenido">
                        NUESTRAS CATEGORIAS</h1>
                </div>
            </div>
        </div>
        <br>
        <br>
        
        <div class="row top_tiles">
        <?php 
            foreach($datos as $rows){
        ?>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" >
                <div class="tile-stats" id="form-categorias">
                    <a href="./indexado.php?mostrar=frmcategoria&id_mostrar=<?php echo htmlspecialchars($rows['idcategoriax'], ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="icon"><i class="fa fa-codepen"></i></div><br>
                        <div class="count"><br></div>
                        <h3><?php echo htmlspecialchars($rows['nomx'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p><br></p>
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

<?php
}
?>