<?php
    require_once "./conexion/conexion_db.php";
    require_once "./php/main.php";
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
    <div >
        <h3>ENCUESTA</h3>
        <strong>Por favor responda con sinceridad cada pregunta</strong>      
    </div>
    <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <?php
                                    if (isset($_POST['modulo_buscador'])) {
                                        require_once "./php/buscador.php";
                                    }
                                    if (!isset($_SESSION['busqueda_tema']) && empty($_SESSION['busqueda_tema'])) {
                                    ?>
                                        <div class="x_title">
                                            <form action="" method="POST" autocomplete="off" class="custom-search-form">
                                                <input type="hidden" name="modulo_buscador" value="tema">
                                                <div class="custom-field custom-has-addons">
                                                    <div class="custom-control custom-is-expanded">
                                                        <input class="custom-input custom-is-rounded" type="text" name="txt_buscador" placeholder="Puedes realizar la búsqueda por nombre de categoria, curso o por tema" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30" required>
                                                    </div>
                                                    <div class="custom-control">
                                                        <button class="custom-button custom-is-info" type="submit">Buscar</button>
                                                    </div>
                                                </div>
                                            </form>

                                            <div class="clearfix"></div>
                                        </div>

                                        <?php
                                        if (!isset($_GET['page'])) {
                                            $pagina = 1;
                                        } else {
                                            $pagina = (int) $_GET['page'];
                                            if ($pagina <= 1) {
                                                $pagina = 1;
                                            }
                                        }
                                        $pagina = limpiar_cadena($pagina);
                                        $url = "indexado.php?mostrar=formu_tema&page=";
                                        $registros = 15;
                                        $busqueda = "";

                                        require_once "./php/formu_tema_lista.php";
                                    } else {
                                        ?>
                                        <div class="columns">
                                            <div class="column">
                                                <form class="has-text-centered mt-6 mb-6" action="" method="POST" autocomplete="off">
                                                    <input type="hidden" name="modulo_buscador" value="tema">
                                                    <input type="hidden" name="eliminar_buscador" value="tema">
                                                    <p style="color:#000">Estas buscando <strong>"<?php echo $_SESSION['busqueda_tema'] ?>"</strong></p>
                                                    <br>
                                                    <button class="custom-button custom-is-danger" type="submit">Eliminar Busqueda</button>
                                                </form>
                                            </div>
                                        </div>

                                    <?php

                                        //para eliminar tema

                                        if (!isset($_GET['page'])) {
                                            $pagina = 1;
                                        } else {
                                            $pagina = (int) $_GET['page'];
                                            if ($pagina <= 1) {
                                                $pagina = 1;
                                            }
                                        }
                                        $pagina = limpiar_cadena($pagina);
                                        $url = "indexado.php?mostrar=formu_tema&page=";
                                        $registros = 15;
                                        $busqueda = $_SESSION['busqueda_tema'];

                                        require_once "./php/formu_tema_lista.php";
                                    }
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