<?php
/**
 * View helpers para modulode de direccion
 */

require_once(APPPATH . "helpers/modulo/direccion/element/SelectComuna.php");

/**
 * Retorna elemento de formulario Select
 * @param int $id_region identificador de region
 */
function formElementSelectComunaUsuario($input_nombre, $id_region, $input_valor = array()){
    $select = New Direccion_Element_SelectComuna(get_instance());
    $select->setNombre($input_nombre);
    return $select->render($input_valor);
}

