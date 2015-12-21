<?php

require_once(APPPATH . "helpers/modulo/direccion/form/element/SelectRegion.php");
require_once(APPPATH . "helpers/modulo/direccion/nombre/Region.php");

/**
 * 
 * @param string $input_nombre
 * @param string $input_valor valor por defecto
 * @return string html
 */
function formElementSelectRegion($input_nombre, $input_valor = array(), $atributos){
    $select = New Direccion_Form_Element_SelectRegion();
    $select->setNombre($input_nombre);
    $select->setAtributos($atributos);
    return $select->render($input_valor);
}

/**
 * Retorna el nombre de la region
 * @param int $id_region
 * @return Direccion_Nombre_Region
 */
function nombreRegion($id_region){
    $nombre = New Direccion_Nombre_Region();
    $nombre->setId($id_region);
    return $nombre;
}

