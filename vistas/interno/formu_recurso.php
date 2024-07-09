<?php
    require_once "./conexion/conexion_db.php";
    require_once "./php/main.php";

    $id = (isset($_GET['idtemax'])) ? $_GET['idtemax'] : 0;

    $id=limpiar_cadena($id);

    $start = new Conexion();
    $check_consulta = $start->Conexiondb();
    $check_consulta=$check_consulta->query("select * from temax t  inner join cursox cu ON
    t.idcursox=cu.idcursox inner join categoriax ca on cu.idcategoriax=ca.idcategoriax 
    where t.idtemax='$id';");
    
    if($check_consulta->rowCount()>0){
        $datos=$check_consulta->fetch();

?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
    <div >
        <h3>RECURSOS</h3>
        <strong>Lista de Recursos del <?php echo $datos['temx']?> </strong>
        <hr>
        <?php echo '<a href="./index.php?mostrar=formu_recurso_new&idtex='.$id.'" type="button" class="btn btn-success"><i class="fa fa-user"></i> AGREGAR RECURSOS</a>' ?>
        <a href="./index.php?mostrar=formu_tema" type="button" class="custom-btn custom-btn-secondary"><i class="fa fa-return"></i> SALIR</a>
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
                                    if(isset($_POST['modulo_buscador'])){
                                        require_once "./php/buscador.php";
                                    }
                                    if (!isset($_SESSION['busqueda_recurso']) && empty($_SESSION['busqueda_recurso'])) {
                                ?>
                                    <div class="x_title">
                                        <form action="" method="POST" autocomplete="off" class="custom-search-form">
                                            <input type="hidden" name="modulo_buscador" value="recurso">
                                            <div class="custom-field custom-has-addons">
                                                <div class="custom-control custom-is-expanded">
                                                    <input class="custom-input custom-is-rounded" type="text" name="txt_buscador" 
                                                        placeholder="¿Puedes realizar la búsqueda por tipo de recurso?" 
                                                        pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30" required>
                                                </div>
                                                <div class="custom-control">
                                                    <button class="custom-button custom-is-info" type="submit">Buscar</button>
                                                </div>
                                            </div>
                                        </form>

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
                                        $url= "index.php?mostrar=formu_recurso&page=";
                                        $registros = 10;
                                        $busqueda = '';

                                        require_once "./php/formu_recurso_lista.php";
                                    } else {
                                    ?>
                                    <div class="columns">
                                        <div class="column">
                                            <form class="has-text-centered mt-6 mb-6" action="" method="POST" autocomplete="off">
                                                <input type="hidden" name="modulo_buscador" value="recurso">
                                                <input type="hidden" name="eliminar_buscador" value="recurso">
                                                <p style="color:#000">Estas buscando <strong>"<?php echo $_SESSION['busqueda_recurso'] ?>"</strong></p>
                                                <br>
                                                <button class="custom-button custom-is-danger" type="submit">Eliminar Busqueda</button>
                                            </form>
                                        </div>
                                    </div>

                                    <?php

                                        //para eliminar recurso

                                        if(!isset($_GET['page'])){
                                            $pagina= 1;
                                        } else {
                                            $pagina = (int) $_GET['page'];
                                            if($pagina<=1){
                                                $pagina = 1;
                                            }
                                        }
                                        $pagina = limpiar_cadena($pagina);
                                        $url= "index.php?mostrar=formu_recurso&page=";
                                        $registros = 10;
                                        $busqueda = $_SESSION['busqueda_recurso'];

                                        require_once "./php/formu_recurso_lista.php";
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

<?php
		}else{
			include "./inc/error_alert.php";
		}
		
		$check_consulta=null;
	?>