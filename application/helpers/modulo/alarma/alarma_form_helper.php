<?php

require_once(APPPATH . "helpers/modulo/alarma/form/element/SelectEstados.php");

/**
 * Genera elemento select de estados de alarma
 * @param string $input_nombre
 * @param int $valor
 * @param array $atributos
 * @return string html
 */
function formElementSelectAlarmaEstados($input_nombre, $valor = "", $atributos = array()){
    $select = New Alarma_Form_Element_SelectEstados();
    $select->getElement()->addAtributos($atributos);
    $select->setNombre($input_nombre);
    return $select->render($valor);
}

