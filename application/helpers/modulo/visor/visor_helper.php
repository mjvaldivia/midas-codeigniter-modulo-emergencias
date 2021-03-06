<?php
require_once(__DIR__ . "/menu/Categorias.php");
require_once(__DIR__ . "/menu/CategoriasRegion.php");
require_once(__DIR__ . "/menu/categorias/CantidadCapas.php");
require_once(__DIR__ . "/menu/categorias/CantidadCapasRegion.php");
require_once(__DIR__ . "/menu/CapaDetalleItem.php");
require_once(__DIR__ . "/menu/CapaDetalleItemRegion.php");
require_once(__DIR__ . "/menu/CapaDetalle.php");
require_once(__DIR__ . "/menu/CapaDetalleRegion.php");
require_once(__DIR__ . "/menu/Capa.php");
require_once(__DIR__ . "/menu/CapaRegion.php");
require_once(__DIR__ . "/propiedades/Informacion.php");
require_once(__DIR__ . "/elemento/Editar.php");
require_once(__DIR__ . "/elemento/editar/LugarEmergencia.php");
require_once(__DIR__ . "/elemento/informacion/Marcadores.php");
require_once(__DIR__ . "/elemento/informacion/Formas.php");
require_once(__DIR__ . "/elemento/informacion/Totales.php");
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
function visorMenuCapasCategoriaRegion($id_region){
    $html = New Visor_Menu_CategoriasRegion($id_region);
    return $html->render();
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
function cantidadCapasCategoriaRegion($id_categoria, $id_region){
    $cantidad = New Visor_Menu_Categorias_CantidadCapasRegion($id_region);
    return $cantidad->cantidad($id_categoria);
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
function visorMenuCapasRegion($id_region, $id_categoria){
    $html = New Visor_Menu_CapaRegion($id_region);
    return $html->render($id_categoria);
}

/**
 * 
 * @return html
 */
function visorMenuCapasDetalleItemRegion($id_detalle, $id_region){
    $html = New Visor_Menu_CapaDetalleItemRegion($id_detalle);
    $html->setRegion($id_region);
    return $html->render();
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
 * @return html
 */
function visorMenuCapasDetalleRegion($id_capa, $id_region){
    $html = New Visor_Menu_CapaDetalleRegion($id_region);
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
 * @param type $propiedades
 * @return type
 */
function visorEdicionLugarEmergencia($tipo, $propiedades, $color = null, $imagen = null){
    $html = New Visor_Elemento_Editar_LugarEmergencia($tipo);
    $html->setPropiedades($propiedades);
    $html->setColor($color);
    return $html->render();
}

/**
 * 
 * @param type $lista
 * @return type
 */
function visorElementoInstalaciones($lista){
    $html = New Visor_Elemento_Informacion_Marcadores($lista);
    return $html->render();
}

/**
 * 
 * @param type $lista
 * @return type
 */
function visorElementoFormas($lista){
    $html = New Visor_Elemento_Informacion_Formas($lista);
    return $html->render();
}

/**
 * 
 * @param array $lista
 * @return string hmtl
 */
function visorElementosTotales($lista){
    $html = New Visor_Elemento_Informacion_Totales($lista);
    return $html->render();
}

/**
 * Genera tabla con las coordenadas de un poligono
 * @param string $tipo
 * @param array $coordenadas
 * @return string html
 */
function visorElementoCoordenadas($tipo, $coordenadas){
    $_ci =& get_instance();
    $_ci->load->library("module/mapa/mapa_conversor_coordenadas");
    $lista = array();
    switch ($tipo) {
        case "CIRCULO":
        case "RECTANGULO":
        case "POLIGONO":
            foreach($coordenadas as $latLon){
                $gms_lat = $_ci->mapa_conversor_coordenadas->gradosToGms($latLon["lat"]);
                $gms_lon = $_ci->mapa_conversor_coordenadas->gradosToGms($latLon["lng"]);

                $lista[] = array(
                    "decimales_latitud" => $latLon["lat"],
                    "decimales_longitud" => $latLon["lng"],
                    "gms_grados_latitud" => $gms_lat["grados"],
                    "gms_minutos_latitud" => $gms_lat["minutos"],
                    "gms_segundos_latitud" => $gms_lat["segundos"],
                    "gms_grados_longitud" => $gms_lon["grados"],
                    "gms_minutos_longitud" => $gms_lon["minutos"],
                    "gms_segundos_longitud" => $gms_lon["segundos"],
                );
            }
            break;
        default:
            break;
    }
    
    return $_ci->load->view("pages/mapa/grilla-coordenadas", array("lista" => $lista), true);
}