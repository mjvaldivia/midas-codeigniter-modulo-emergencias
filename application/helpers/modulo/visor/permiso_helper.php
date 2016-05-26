<?php

/**
 * Permisos para editar mapa
 * @param string $accion
 * @return boolean
 */
function permisoMapa($accion){
    $_ci =& get_instance();
    $_ci->load->library("module/mapa/mapa_permiso");
    return $_ci->mapa_permiso->permiso($accion, $_ci->session->userdata('session_idUsuario'));
}

