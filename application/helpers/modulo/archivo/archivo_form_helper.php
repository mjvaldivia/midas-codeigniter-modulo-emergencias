<?php

require_once(__DIR__ . "/form/element/Tipo.php");
require_once(__DIR__ . "/form/element/Upload.php");

/**
 * Genera elemento select 
 * @param string $input_nombre
 * @param int $valor
 * @param array $atributos
 * @return string html
 */
function formElementSelectArchivoTipo($input_nombre, $valor = "", $atributos = array()){
    $select = New Archivo_Form_Element_Tipo();
    $select->getElement()->addAtributos($atributos);
    $select->setNombre($input_nombre);
    return $select->render($valor);
}

function formElementArchivosUpload($lista_archivos){
    $elemento = New Archivo_Form_Element_Upload();
    $elemento->setArchivos($lista_archivos);
    return $elemento->render();
}