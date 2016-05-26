<?php

function permisoCasosFebriles($accion){
    $_ci =& get_instance();
    $_ci->load->library("module/casos_febriles/permiso");
    return $_ci->permiso->permiso($accion, $_ci->session->userdata('session_idUsuario'));
}