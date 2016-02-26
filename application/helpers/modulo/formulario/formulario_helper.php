<?php

require_once(__DIR__ . "/nombre/Estado.php");


function nombreFormularioEstado($id_estado){
    $estado = New Formulario_Nombre_Estado();
    $estado->setId($id_estado);
    return (string) $estado->getString();
}

