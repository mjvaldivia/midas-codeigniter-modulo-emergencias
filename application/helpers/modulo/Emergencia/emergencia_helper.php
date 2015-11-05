<?php
/**
 * View helpers para modulo emergencias
 */

require_once(APPPATH . "helpers/modulo/emergencia/element/SelectTipo.php");
require_once(APPPATH . "helpers/modulo/emergencia/nombre/Tipo.php");
require_once(APPPATH . "helpers/modulo/emergencia/nombre/Comunas.php");

/**
 * Retorna elemento de formulario Select
 * @param int $id_region identificador de region
 */
function formElementSelectEmergenciaTipo($input_nombre, $id_region, $input_valor = "", $atributos){
    $select = New Emergencia_Element_SelectTipo(get_instance());
    $select->getElement()->addAtributos($atributos);
    $select->setNombre($input_nombre);
    return $select->render($input_valor);
}

/**
 * Retorna el nombre del tipo de emergencia
 * @param int $id_tipo_emergencia
 * @return string
 */
function nombreEmergenciaTipo($id_tipo_emergencia){
    $nombre = New Emergencia_Nombre_Tipo(get_instance());
    $nombre->setId($id_tipo_emergencia);
    return $nombre->getString();
}

/**
 * Retorna comunas separadas por coma
 * @param int $id_emergencia
 * @return string
 */
function comunasEmergenciaConComa($id_emergencia){
    $comunas = New Emergencia_Nombre_Comunas(get_instance());
    $comunas->setIdEmergencia($id_emergencia);
    return $comunas->getString();
}