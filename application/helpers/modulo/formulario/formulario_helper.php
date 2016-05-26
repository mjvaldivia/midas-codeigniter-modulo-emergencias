<?php

require_once(__DIR__ . "/nombre/Estado.php");
require_once(__DIR__ . "/form/element/SelectEnfermedades.php");

/**
 * 
 * @param int $id_estado
 * @return string
 */
function nombreFormularioEstado($id_estado){
    $estado = New Formulario_Nombre_Estado();
    $estado->setId($id_estado);
    return (string) $estado->getString();
}

/**
 * 
 * @param string $nombre
 * @param array $valores
 * @return string
 */
function formSelectEnfermedades($nombre, $valores){
    $form = New Formulario_Form_Element_SelectEnfermedades();
    $form->setAtributos(array("class" => "form-control select2-tags", "multiple" => "true"));
    $form->setNombre($nombre);
    return $form->render($valores);
}
