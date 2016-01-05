<?php
/**
 * View helpers para modulode de direccion
 */

require_once(APPPATH . "helpers/modulo/direccion/form/element/SelectComuna.php");

/**
 * Retorna elemento de formulario Select
 * @param int $id_region identificador de region
 */
function formElementSelectComunaUsuario($input_nombre, $input_valor = array()){
    $select = New Direccion_Form_Element_SelectComuna();
    $select->setNombre($input_nombre);
    return $select->render($input_valor);
}

