<?php

require_once(APPPATH . "helpers/modulo/permiso/rol/AccesoEstado.php");

/**
 * 
 * @param int $rol_id
 * @return string
 */
function estadoAccesoEmergencias($rol_id){
    $acceso = New Permiso_Rol_AccesoEstado();
    return $acceso->render($rol_id);
}