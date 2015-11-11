<?php

require_once(APPPATH . "helpers/modulo/emergencia/form/element/SelectTipo.php");
require_once(APPPATH . "helpers/modulo/emergencia/form/element/SelectEstados.php");

/**
 * Genera elemento select de estados de emergencia
 * @param string $input_nombre
 * @param int $valor
 * @param array $atributos
 * @return string html
 */
function formElementSelectEmergenciaEstados($input_nombre, $valor = "", $atributos = array()){
    $select = New Emergencia_Form_Element_SelectEstados();
    $select->getElement()->addAtributos($atributos);
    $select->setNombre($input_nombre);
    return $select->render($valor);
}

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

