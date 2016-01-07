<?php

require_once(APPPATH . "helpers/modulo/usuario/form/element/SelectActivo.php");
require_once(APPPATH . "helpers/modulo/usuario/form/element/SelectSexo.php");
require_once(APPPATH . "helpers/modulo/usuario/form/element/SelectCargo.php");
require_once(APPPATH . "helpers/modulo/usuario/form/element/SelectRoles.php");
require_once(APPPATH . "helpers/modulo/usuario/form/element/SelectAmbito.php");
require_once(APPPATH . "helpers/modulo/usuario/form/element/SelectOficina.php");
require_once(APPPATH . "helpers/modulo/usuario/form/element/SelectPerfil.php");

/**
 * 
 * @param string $input_nombre
 * @param int $input_valor
 * @param array $atributos
 * @return string html
 */
function formElementSelectCargo($input_nombre, $input_valor = "", $atributos){
    $select = New Usuario_Form_Element_SelectCargo();
    $select->setAtributos($atributos);
    $select->setNombre($input_nombre);
    return $select->render($input_valor);
}

/**
 * 
 * @param string $input_nombre
 * @param int $input_valor
 * @param array $atributos
 * @return string html
 */
function formElementSelectRoles($input_nombre, $input_valor = "", $atributos){
    $select = New Usuario_Form_Element_SelectRoles();
    $select->setAtributos($atributos);
    $select->setNombre($input_nombre);
    return $select->render($input_valor);
}

/**
 * 
 * @param string $input_nombre
 * @param int $input_valor
 * @param array $atributos
 * @return string html
 */
function formElementSelectPerfil($input_nombre, $input_valor = "", $atributos){
    $select = New Usuario_Form_Element_SelectPerfil();
    $select->setAtributos($atributos);
    $select->setNombre($input_nombre);
    return $select->render($input_valor);
}

/**
 * 
 * @param string $input_nombre
 * @param int $input_valor
 * @param array $atributos
 * @return string html
 */
function formElementSelectSexo($input_nombre, $input_valor = "", $atributos){
    $select = New Usuario_Form_Element_SelectSexo();
    $select->setAtributos($atributos);
    $select->setNombre($input_nombre);
    return $select->render($input_valor);
}

/**
 * 
 * @param string $input_nombre
 * @param int $input_valor
 * @param array $atributos
 * @return string html
 */
function formElementSelectActivo($input_nombre, $input_valor = "", $atributos){
    $select = New Usuario_Form_Element_SelectActivo();
    $select->setAtributos($atributos);
    $select->setNombre($input_nombre);
    return $select->render($input_valor);
}

/**
 * 
 * @param string $input_nombre
 * @param int $input_valor
 * @param array $atributos
 * @return string html
 */
function formElementSelectAmbito($input_nombre, $input_valor = "", $atributos){
    $select = New Usuario_Form_Element_SelectAmbito();
    $select->setAtributos($atributos);
    $select->setNombre($input_nombre);
    return $select->render($input_valor);
}

/**
 * 
 * @param string $input_nombre
 * @param int $input_valor
 * @param array $atributos
 * @return string html
 */
function formElementSelectOficinas($input_nombre, $input_valor = "", $id_region = NULL, $atributos = array()){
    $select = New Usuario_Form_Element_SelectOficina();
    $select->setAtributos($atributos);
    $select->setRegion($id_region);
    $select->setNombre($input_nombre);
    return $select->render($input_valor);
}