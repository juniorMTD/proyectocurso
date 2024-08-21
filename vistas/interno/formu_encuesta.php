<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>
            <h3>ENCUESTAS</h3>
            <hr>
            <a href="./index.php?mostrar=formu_encuesta_new" type="button" class="btn btn-success"><i class="fa fa-plus"></i> AGREGAR ENCUESTA</a>
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
                                    <?php
                                    if (isset($_POST['modulo_buscador'])) {
                                        require_once "./php/buscador.php";
                                    }
                                    if (!isset($_SESSION['busqueda_encuesta']) && empty($_SESSION['busqueda_encuesta'])) {
                                    ?>
                                        <div class="x_title">
                                            <form action="" method="POST" autocomplete="off" class="custom-search-form">
                                                <input type="hidden" name="modulo_buscador" value="encuesta">
                                                <div class="custom-field custom-has-addons">
                                                    <div class="custom-control custom-is-expanded">
                                                        <input class="custom-input custom-is-rounded" type="text" name="txt_buscador" placeholder="Puedes realizar la búsqueda por Nombre de la encuesta" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30" required>
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
                                        $url = "index.php?mostrar=formu_encuesta&page=";
                                        $registros = 15;
                                        $busqueda = "";

                                        require_once "./php/formu_encuesta_lista.php";
                                    } else {
                                        ?>
                                        <div class="columns">
                                            <div class="column">
                                                <form class="has-text-centered mt-6 mb-6" action="" method="POST" autocomplete="off">
                                                    <input type="hidden" name="modulo_buscador" value="encuesta">
                                                    <input type="hidden" name="eliminar_buscador" value="encuesta">
                                                    <p style="color:#000">Estas buscando <strong>"<?php echo $_SESSION['busqueda_encuesta'] ?>"</strong></p>
                                                    <br>
                                                    <button class="custom-button custom-is-danger" type="submit">Eliminar Busqueda</button>
                                                </form>
                                            </div>
                                        </div>

                                    <?php

                                        //para eliminar encuesta

                                        if (!isset($_GET['page'])) {
                                            $pagina = 1;
                                        } else {
                                            $pagina = (int) $_GET['page'];
                                            if ($pagina <= 1) {
                                                $pagina = 1;
                                            }
                                        }
                                        $pagina = limpiar_cadena($pagina);
                                        $url = "index.php?mostrar=formu_encuesta&page=";
                                        $registros = 15;
                                        $busqueda = $_SESSION['busqueda_encuesta'];

                                        require_once "./php/formu_encuesta_lista.php";
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