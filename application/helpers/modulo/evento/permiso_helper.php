<?php

function permisoEvento($accion){
    $_ci =& get_instance();
    $_ci->load->library("module/evento/evento_permiso");
    return $_ci->evento_permiso->permiso($accion, $_ci->session->userdata('session_idUsuario'));
}

