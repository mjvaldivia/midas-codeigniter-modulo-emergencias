<?php

require_once(APPPATH . "helpers/modulo/alarma/nombre/Comunas.php");
require_once(APPPATH . "helpers/modulo/alarma/nombre/Estado.php");

/**
 * Retorna comunas separadas por coma
 * @param int $id_emergencia
 * @return string
 */
function comunasAlarmaConComa($id_alarma){
    $comunas = New Alarma_Nombre_Comunas();
    $comunas->setIdAlarma($id_alarma);
    return $comunas->getString();
}

/**
 * Retorna el nombre del tipo de emergencia
 * @param int $id_tipo_emergencia
 * @return string
 */
function nombreAlarmaEstado($id_estado){
    $nombre = New Alarma_Nombre_Estado();
    $nombre->setId($id_estado);
    return $nombre->getString();
}


function nivelEmergencia($nivel){
    if($nivel == 1){
        return 'Nivel I';
    }elseif($nivel == 2){
        return 'Nivel II';
    }elseif($nivel == 3){
        return 'Nivel III';
    }elseif($nivel == 4){
        return 'Nivel IV';
    }
}