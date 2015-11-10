<?php
/**
 * View helpers para modulo emergencias
 */

require_once(APPPATH . "helpers/modulo/emergencia/nombre/Tipo.php");
require_once(APPPATH . "helpers/modulo/emergencia/nombre/Comunas.php");
require_once(APPPATH . "helpers/modulo/emergencia/html/IconoTipoEmergencia.php");

/**
 * Retorna el icono que le corresponde al tipo de emergencia
 * @param int $id_tipo_emergencia
 * @return string html
 */
function htmlIconoEmergenciaTipo($id_tipo_emergencia){
    $html = New Emergencia_Html_IconoTipoEmergencia();
    $html->setEmergenciaTipo($id_tipo_emergencia);
    return $html->render();
}

/**
 * Retorna el nombre del tipo de emergencia
 * @param int $id_tipo_emergencia
 * @return string
 */
function nombreEmergenciaTipo($id_tipo_emergencia){
    $nombre = New Emergencia_Nombre_Tipo();
    $nombre->setId($id_tipo_emergencia);
    return $nombre->getString();
}

/**
 * Retorna comunas separadas por coma
 * @param int $id_emergencia
 * @return string
 */
function comunasEmergenciaConComa($id_emergencia){
    $comunas = New Emergencia_Nombre_Comunas();
    $comunas->setIdEmergencia($id_emergencia);
    return $comunas->getString();
}