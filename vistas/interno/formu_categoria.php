<?php
    require_once "./conexion/conexion_db.php";
    require_once "./php/main.php";
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
    <div >
        <h3>CATEGORIA DE CURSOS</h3>
        <strong>Lista de categorias</strong>
        <hr>
        <a href="index.html" type="button" class="btn btn-success"><i class="fa fa-user"></i> AGREGAR CATEGORIA</a>
        <hr>
        
    </div>
    <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <input type="text"> <button>buscar</button>
                                        <div class="clearfix"></div>
                                    </div>

                                    <?php
                                        if(!isset($_GET['page'])){
                                            $pagina= 1;
                                        } else {
                                            $pagina = (int) $_GET['page'];
                                            if($pagina<=1){
                                                $pagina = 1;
                                            }
                                        }
                                        $pagina = limpiar_cadena($pagina);
                                        $url= "index.php?mostrar=formu_categoria&page=";
                                        $registros = 15;
                                        // $busqueda = $_SESSION['busqueda_categoria'];

                                        require_once "../../php/formu_categoria_lista.php";
                                    ?>


                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->