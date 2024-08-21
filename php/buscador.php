<?php
ob_start();
    // $paciente_id=limpiar_cadena($_POST['paciente_id']);
    
    $modulo_buscador=limpiar_cadena($_POST['modulo_buscador']);
    $modulos=["categoria","curso","tema","recurso","sugerencia","encuesta"];  //cadena para los diferentes modulos de busqueda

    if(in_array($modulo_buscador,$modulos)){
        $modulos_url=[
            "categoria"=>"formu_categoria",
            "curso"=>"formu_curso",
            "tema"=>"formu_tema",
            "recurso"=>"formu_recurso",
            "sugerencia"=>"formu_sugerencias",
            "encuesta"=>"formu_encuesta"
            // "consulta"=>"consulta_form",
            // "historiaantigua"=>"historial_form_antiguo",
            // "historiapaciente"=>"historia_consulta_form&idpaciente_form_lista=$paciente_id",
            // "consultapaciente"=>"paciente_form_lista&idpaciente_form_lista=$paciente_id",
            // "historiaxconsulta"=>""
        ];

        $modulos_url=$modulos_url[$modulo_buscador];

        $modulo_buscador="busqueda_".$modulo_buscador;

        // iniciar la busqueda
        if(isset($_POST['txt_buscador'])){
            $txt=limpiar_cadena($_POST['txt_buscador']);

            if($txt==""){
                echo    '<div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        Introducir un termino de busqueda
                        </div>';
            }else{
                    $_SESSION[$modulo_buscador]=$txt;
                    header("Location: index.php?mostrar=$modulos_url",true,303);
                    exit();
                
            }
        }
        //eliminar la busqueda
        if(isset($_POST['eliminar_buscador'])){
            unset($_SESSION[$modulo_buscador]);
            header("Location: index.php?mostrar=$modulos_url",true,303);
            exit();
        }


    }else{
        echo    '<div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No podemos procesar la petición
            </div>';
    }
    ob_end_flush();
?>