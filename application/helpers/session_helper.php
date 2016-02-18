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

    $url = base_url("login");

    $sessionId = $ci->session->userdata('session_idUsuario');

    if(empty($sessionId)) {
        if ($ci->input->is_ajax_request()){
            header("HTTP/1.1 403 Forbidden");
            header('Content-type: application/json');
            $data = array("correcto" => false,
                          "error" => "Su sesión ha expirado");
            echo Zend_Json::encode($data);
            die();
        } else {
            redirect($url);
        }
    }
}

function isAdmin() {
    $ci =& get_instance();

    $rolID = $ci->session->userdata('session_roles');
    $cambioRapido = $ci->session->userdata('session_cambioRapido');

    return (strrpos($rolID, '27') > -1 || $cambioRapido == 1) ? 1 : 0;
}

