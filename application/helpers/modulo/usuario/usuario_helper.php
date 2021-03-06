<?php

require_once( __DIR__ . "/nombre/Base.php");
require_once( __DIR__ . "/nombre/Regiones.php");

/**
 * Retorna el nombre del usuario
 * @param int $id_tipo_emergencia
 * @return string
 */
function nombreUsuario($id_usuario = null){
    
   /* if($id_usuario == ""){
        return "";
    } else {*/
    
    $_ci =& get_instance();
    $_ci->load->library("session");

    if($id_usuario == NULL){
        $id_usuario = $_ci->session->userdata("session_idUsuario");
    } 

    $nombre = New Usuario_Nombre_Base();
    $nombre->setUsuario($id_usuario);
    return $nombre;
    //}
}


/**
 * Retorna el nombre de las regiones asociadas al usuario
 * @param int $id_tipo_emergencia
 * @return string
 */
function nombreRegionesUsuario($id_usuario){
    $nombre = New Usuario_Nombre_Regiones();
    $nombre->setUsuario($id_usuario);
    return $nombre;
}

