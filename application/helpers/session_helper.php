<?php
/**
 * User: claudio
 * Date: 19-08-15
 * Time: 11:00 AM
 */


function sessionValidation()
{
    $ci =& get_instance();
    $ci->load->helper(array("url", "debug"));

    $url = "http://asdigital.minsal.cl/acceso";

    $sessionId = $ci->session->userdata('session_idUsuario');

    if(empty($sessionId)) {
        if ($ci->input->is_ajax_request())
            show_error("Su sesión ha expirado", 401, "Error");
        else
            redirect($url);
    }
}

function isAdmin() {
    $ci =& get_instance();

    $rolID = $ci->session->userdata('session_roles');
    $cambioRapido = $ci->session->userdata('session_cambioRapido');

    return (strrpos($rolID, '27') > -1 || $cambioRapido == 1) ? 1 : 0;
}

