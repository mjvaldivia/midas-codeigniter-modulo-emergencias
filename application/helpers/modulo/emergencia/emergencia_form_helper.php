<?php

require_once(APPPATH . "helpers/modulo/emergencia/form/element/SelectArchivos.php");
require_once(APPPATH . "helpers/modulo/emergencia/form/element/SelectTipo.php");
require_once(APPPATH . "helpers/modulo/emergencia/form/element/SelectDestinatarios.php");
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
function formElementSelectEmergenciaTipo($input_nombre, $input_valor = "", $atributos){
    $select = New Emergencia_Form_Element_SelectTipo();
    $select->getElement()->addAtributos($atributos);
    $select->setNombre($input_nombre);
    return $select->render($input_valor);
}

/**
 * 
 * @param int $id_emergencia
 * @param string $input_nombre
 * @param string $input_valor
 * @param array $atributos
 * @return string hmtl
 */
function formElementSelectArchivos($id_emergencia, $input_nombre, $input_valor = "", $atributos){
    $select = New Emergencia_Form_Element_SelectArchivos();
    $select->setEmergencia($id_emergencia);
    $select->getElement()->addAtributos($atributos);
    $select->setNombre($input_nombre);
    return $select->render($input_valor);
}

/**
 * 
 * @param int $id_emergencia
 * @param string $input_nombre
 * @param string $input_valor
 * @param array $atributos
 * @return string hmtl
 */
function formElementSelectDestinatarios($id_emergencia, $input_nombre, $input_valor = "", $atributos){
    $select = New Emergencia_Form_Element_SelectDestinatarios();
    $select->setEmergencia($id_emergencia);
    $select->getElement()->addAtributos($atributos);
    $select->setNombre($input_nombre);
    return $select->render($input_valor);
}

