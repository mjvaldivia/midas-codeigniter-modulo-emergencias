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

    $sessionId = $ci->session->userdata('session_idUsuario');

    if(empty($sessionId)) {
        redirect("http://asdigital.minsal.cl/acceso");
    }
}

function isAdmin() {
    $ci =& get_instance();

    $rolID = $ci->session->userdata('session_roles');
    $cambioRapido = $ci->session->userdata('session_cambioRapido');

    return (strrpos($rolID, '27') > -1 || $cambioRapido == 1) ? 1 : 0;
}