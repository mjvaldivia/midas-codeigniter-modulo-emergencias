<?php

require_once(__DIR__ . "/html/grilla/Historial.php");
require_once(__DIR__ . "/html/grilla/Documento.php");
require_once(__DIR__ . "/html/grilla/Reporte.php");

/**
 * 
 * @param int $id_emergencia
 * @return string hmtl
 */
function emergenciaGrillaHistorial($id_emergencia){
    $historial = New Emergencia_Html_Grilla_Historial($id_emergencia);
    return $historial->render();
}

/**
 * 
 * @param int $id_emergencia
 * @return string hmtl
 */
function emergenciaGrillaDocumento($id_emergencia){
    $documento = New Emergencia_Html_Grilla_Documento($id_emergencia);
    return $documento->render();
}

/**
 * 
 * @param int $id_emergencia
 * @return string hmtl
 */
function emergenciaGrillaReporte($id_emergencia){
    $documento = New Emergencia_Html_Grilla_Reporte($id_emergencia);
    return $documento->render();
}