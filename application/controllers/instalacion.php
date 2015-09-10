<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * User: claudio
 * Date: 09-09-15
 * Time: 03:05 PM
 */
class Instalacion extends CI_Controller {

    public function obtenerJsonTipos() {
        $this->load->helper("session");

        sessionValidation();

        $this->load->model("tipo_instalacion_model", "TipoInstalacion");

        $tipos = $this->TipoInstalacion->obtenerTodos();

        echo json_encode(array("data" => $tipos));
    }
}