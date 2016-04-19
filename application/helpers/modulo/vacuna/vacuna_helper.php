<?php

require_once(__DIR__ . "/form/element/SelectTipo.php");

/**
 * @param string $input_nombre
 * @param int $valor
 * @param array $atributos
 * @return string html
 */
function formElementSelectVacuna($input_nombre, $valor = "", $atributos = array()){
    $select = New Vacuna_Form_Element_SelectTipo();
    $select->getElement()->addAtributos($atributos);
    $select->setNombre($input_nombre);
    return $select->render($valor);
}

