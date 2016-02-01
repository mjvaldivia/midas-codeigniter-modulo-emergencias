<?php
require_once(__DIR__ . "/menu/Categorias.php");
require_once(__DIR__ . "/menu/categorias/CantidadCapas.php");
require_once(__DIR__ . "/menu/CapaDetalleItem.php");
require_once(__DIR__ . "/menu/CapaDetalle.php");
require_once(__DIR__ . "/menu/Capa.php");
require_once(__DIR__ . "/propiedades/Informacion.php");
require_once(__DIR__ . "/elemento/Editar.php");
require_once(__DIR__ . "/elemento/Instalaciones.php");
require_once(__DIR__ . "/capa/Comuna.php");

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

/**
 * 
 * @return html
 */
function visorMenuCapasCategoria($id_emergencia){
    $html = New Visor_Menu_Categorias($id_emergencia);
    return $html->render();
}

/**
 * 
 * @param int $id_categoria
 * @return int
 */
function cantidadCapasCategoria($id_categoria, $id_emergencia){
    $cantidad = New Visor_Menu_Categorias_CantidadCapas($id_emergencia);
    return $cantidad->cantidad($id_categoria);
}

/**
 * 
 * @return html
 */
function visorMenuCapas($id_emergencia, $id_categoria){
    $html = New Visor_Menu_Capa($id_emergencia);
    return $html->render($id_categoria);
}

/**
 * 
 * @return html
 */
function visorMenuCapasDetalleItem($id_detalle, $id_emergencia){
    $html = New Visor_Menu_CapaDetalleItem($id_detalle);
    $html->setEmergencia($id_emergencia);
    return $html->render();
}

/**
 * 
 * @return html
 */
function visorMenuCapasDetalle($id_capa, $id_emergencia){
    $html = New Visor_Menu_CapaDetalle($id_emergencia);
    return $html->render($id_capa);
}

/**
 * 
 * @param array $lista_categorias
 * @param array $comunas
 * @return string
 */
function visorHtmlCapasComuna($lista_categorias, $comunas){
    $html = New Visor_Capa_Comuna($lista_categorias, $comunas);
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

