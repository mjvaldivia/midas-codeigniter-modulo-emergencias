<?php

require_once(__DIR__ . "/Element/SelectComuna.php");

/**
 * Retorna elemento de formulario Select
 * @param int $id_region identificador de region
 */
function formElementSelectComunaUsuario($input_nombre, $id_region, $input_valor = array()){
    $select = New Direccion_Element_SelectComuna(get_instance());
    $select->setNombre($input_nombre);
    return $select->render($input_valor);
}

