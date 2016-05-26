<?php

function permisoMareaRoja($accion){
    $_ci =& get_instance();
    $_ci->load->library("module/marea_roja/marea_roja_permiso");
    return $_ci->marea_roja_permiso->permiso($accion, $_ci->session->userdata('session_idUsuario'));
}