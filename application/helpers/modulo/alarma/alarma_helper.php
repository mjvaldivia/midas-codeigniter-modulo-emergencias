<?php

require_once(APPPATH . "helpers/modulo/alarma/nombre/Comunas.php");

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