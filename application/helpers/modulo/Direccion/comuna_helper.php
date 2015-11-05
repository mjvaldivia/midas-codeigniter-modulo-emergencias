<?php
/**
 * View helpers para modulode de direccion
 */

require_once(APPPATH . "helpers/Modulo/Direccion/Element/SelectComuna.php");

/**
 * Retorna elemento de formulario Select
 * @param int $id_region identificador de region
 */
function formElementSelectComunaUsuario($input_nombre, $id_region, $input_valor = array(),$atributos = array()){
    $select = New Direccion_Element_SelectComuna(get_instance());
    $select->setNombre($input_nombre);
    $select->getElement()->addAtributos($atributos);
    return $select->render($input_valor);
}

