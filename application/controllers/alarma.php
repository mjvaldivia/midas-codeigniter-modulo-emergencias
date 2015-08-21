<?php if (!defined("BASEPATH")) exit("No direct script access allowed");

/**
 * User: claudio
 * Date: 12-08-15
 * Time: 04:24 PM
 */
class Alarma extends CI_Controller
{
    public function ingreso () {

        if ( ! file_exists(APPPATH."/views/pages/alarma/ingreso.php"))
        {
            // Whoops, we don"t have a page for that!
            show_404();
        }

        // load basicos
        $this->load->library("template");
        $this->load->library("form_validation");
        $this->load->helper("session");

        sessionValidation();

        $data = array(
        );

        $this->template->parse("default", "pages/alarma/ingreso", $data);
    }

    public function listado () {
        if ( ! file_exists(APPPATH."/views/pages/alarma/listado.php"))
        {
            // Whoops, we don"t have a page for that!
            show_404();
        }

        // load basicos
        $this->load->library("template");
        $this->load->library("form_validation");
        $this->load->helper("session");

        sessionValidation();

        $data = array(
        );

        $this->template->parse("default", "pages/alarma/listado", $data);
    }

    public function jsonTiposEmergencias() {
        $this->load->model("tipo_emergencia_model", "TipoEmergencia");
        $tiposEmergencia = $this->TipoEmergencia->get();

        $json = array();
        foreach($tiposEmergencia as $te) {
            $json[] = array(
                $te["aux_ia_id"],
                $te["aux_c_nombre"],
            );
        }

        echo json_encode($json);
    }

    public function jsonEstadosAlarmas() {
        $this->load->model("alarma_model", "AlarmaModel");
        $estados = $this->AlarmaModel->obtenerEstados();

        $json = array();
        foreach($estados as $e) {
            $json[] = array(
                $e["est_ia_id"],
                $e["est_c_nombre"],
            );
        }

        echo json_encode($json);
    }
}