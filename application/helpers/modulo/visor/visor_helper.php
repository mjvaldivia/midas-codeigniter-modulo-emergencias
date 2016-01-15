<?php

require_once(__DIR__ . "/propiedades/Informacion.php");
require_once(__DIR__ . "/elemento/Editar.php");
require_once(__DIR__ . "/elemento/Instalaciones.php");
require_once(__DIR__ . "/capa/Disponibles.php");

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

function visorHtmlCapasDisponibles($lista_categorias, $comunas){
    $html = New Visor_Capa_Disponibles($lista_categorias, $comunas);
    return $html->render();
}

/**
 * 
 * @param type $propiedades
 * @return type
 */
function visorInformacion($propiedades){
    $html = New Visor_Propiedades_Informacion($propiedades);
    return $html->render();
}

/**
 * 
 * @param type $propiedades
 * @return type
 */
function visorEdicionElemento($tipo, $propiedades, $color = null, $imagen = null){
    $html = New Visor_Elemento_Editar($tipo);
    $html->setPropiedades($propiedades);
    $html->setColor($color);
    return $html->render();
}

/**
 * 
 * @param type $lista
 * @return type
 */
function visorPoligonoInstalaciones($lista){
    $html = New Visor_Elemento_Instalaciones($lista);
    return $html->render();
}

