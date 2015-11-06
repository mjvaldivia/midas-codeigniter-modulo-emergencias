<?php

require_once(APPPATH . "helpers/modulo/emergencia/form/element/SelectTipo.php");

/**
 * Retorna elemento de formulario Select
 * @param int $id_region identificador de region
 */
function formElementSelectEmergenciaTipo($input_nombre, $id_region, $input_valor = "", $atributos){
    $select = New Emergencia_Form_Element_SelectTipo();
    $select->getElement()->addAtributos($atributos);
    $select->setNombre($input_nombre);
    return $select->render($input_valor);
}

