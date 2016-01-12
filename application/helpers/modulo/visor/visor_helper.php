<?php

require_once(__DIR__ . "/propiedades/Informacion.php");
require_once(__DIR__ . "/poligono/Instalaciones.php");
/**
 * 
 * @param int $valor
 * @param array $seleccionados
 * @return string
 */
function visorCapasSeleccionadasChecked($valor, $seleccionados){
    if(is_array($seleccionados)){
        $existe = in_array($valor, $seleccionados);
        if($existe === false){
            return "";
        } else {
            return "checked=\"checked\"";
        }
    }
}

function visorInformacion($propiedades){
    $html = New Visor_Propiedades_Informacion($propiedades);
    return $html->render();
}

/**
 * 
 * @param type $lista
 * @return type
 */
function visorPoligonoInstalaciones($lista){
    $html = New Visor_Poligono_Instalaciones($lista);
    return $html->render();
}

