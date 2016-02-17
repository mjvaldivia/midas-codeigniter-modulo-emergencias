<?php

require_once(APPPATH . "helpers/modulo/alarma/form/element/SelectEstados.php");
require_once(APPPATH . "helpers/modulo/alarma/form/element/Archivos.php");
require_once(APPPATH . "helpers/modulo/alarma/form/value/EmergenciaTipoChecked.php");


function formElementArchivos($id_emergencia){
    $elemento = New Alarma_Form_Element_Archivos();
    $elemento->setEmergencia($id_emergencia);
    return $elemento->render();
}

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

/**
 * 
 * @param string $value
 * @param string $selected
 * @return string html
 */
function formValueEmergenciaTipoChecked($value, $selected){
    $checked = New Alarma_Form_Value_EmergenciaTipoChecked();
    $checked->setValue($value);
    return $checked->render($selected);
}

