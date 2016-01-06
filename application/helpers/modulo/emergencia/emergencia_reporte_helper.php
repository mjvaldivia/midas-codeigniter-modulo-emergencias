<?php

/**
 * 
 * @param string $tipo_lugar
 * @return string
 */
function reporteNombreLugar($form_tipo_lugar){
    if($form_tipo_lugar == "via_publica"){
        return "Vía publica";
    }elseif($form_tipo_lugar == "propiedad_privada"){
        return "Propiedad privada";
    }
}

/**
 * 
 * @param string $tipo
 * @return string
 */
function reporteNombreTipoPropiedadPrivada($tipo, $otro){
    if($tipo == "otro"){
        return $otro;
    } else {
        $string = str_replace("_", " ", $tipo);
        return ucfirst($string);
    }
}

/**
 * 
 * @param string $form_tipo_lugar_via_publica_donde_detalle
 * @return string
 */
function reporteNombreLugarDetalle($form_tipo_lugar_via_publica_donde_detalle, $otro = ""){
    if($form_tipo_lugar_via_publica_donde_detalle == "otro"){
        return $otro;
    } else {
        return ucfirst($form_tipo_lugar_via_publica_donde_detalle);
    }
}

