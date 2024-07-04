<?php
require_once "./conexion/conexion_db.php";
require_once "./php/main.php";
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div>
            <h3>CURSOS A CARGOS POR LOS DOCENTES</h3>
            <strong>Lista de cursos</strong>
            <hr>
            <a href="./index.php?mostrar=formu_curso_new" type="button" class="btn btn-success"><i class="fa fa-user"></i> AGREGAR CURSOS</a>
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
                                    if (!isset($_SESSION['busqueda_curso']) && empty($_SESSION['busqueda_curso'])) {
                                    ?>
                                        <div class="x_title">
                                            <form action="" method="POST" autocomplete="off" class="custom-search-form">
                                                <input type="hidden" name="modulo_buscador" value="curso">
                                                <div class="custom-field custom-has-addons">
                                                    <div class="custom-control custom-is-expanded">
                                                        <input class="custom-input custom-is-rounded" type="text" name="txt_buscador" placeholder="Puedes realizar la búsqueda por Nombre de curso, nombre del docente" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30" required>
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
                                        $url = "index.php?mostrar=formu_curso&page=";
                                        $registros = 15;
                                        $busqueda = "";

                                        require_once "./php/formu_curso_lista.php";
                                    } else {
                                        ?>
                                        <div class="columns">
                                            <div class="column">
                                                <form class="has-text-centered mt-6 mb-6" action="" method="POST" autocomplete="off">
                                                    <input type="hidden" name="modulo_buscador" value="curso">
                                                    <input type="hidden" name="eliminar_buscador" value="curso">
                                                    <p style="color:#000">Estas buscando <strong>"<?php echo $_SESSION['busqueda_curso'] ?>"</strong></p>
                                                    <br>
                                                    <button class="custom-button custom-is-danger" type="submit">Eliminar Busqueda</button>
                                                </form>
                                            </div>
                                        </div>

                                    <?php

                                        //para eliminar curso

                                        if (!isset($_GET['page'])) {
                                            $pagina = 1;
                                        } else {
                                            $pagina = (int) $_GET['page'];
                                            if ($pagina <= 1) {
                                                $pagina = 1;
                                            }
                                        }
                                        $pagina = limpiar_cadena($pagina);
                                        $url = "index.php?mostrar=formu_curso&page=";
                                        $registros = 15;
                                        $busqueda = $_SESSION['busqueda_curso'];

                                        require_once "./php/formu_curso_lista.php";
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