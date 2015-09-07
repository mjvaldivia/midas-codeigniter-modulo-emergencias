<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * User: claudio
 * Date: 12-08-15
 * Time: 04:24 PM
 */
class Alarma extends CI_Controller {

    public function ingreso() {

        if (!file_exists(APPPATH . "/views/pages/alarma/ingreso.php")) {
            // Whoops, we don"t have a page for that!
            show_404();
        }

        // load basicos
        $this->load->library(array("template"));
        $this->load->helper("session");

        sessionValidation();

        $data = array(
        );

        $this->template->parse("default", "pages/alarma/ingreso", $data);
    }

    public function ingresoPaso2() {
        if (!file_exists(APPPATH . "/views/pages/alarma/ingreso_paso_2.php")) {
            // Whoops, we don"t have a page for that!
            show_404();
        }

        // $this->load->library(array("template", "form_validation", "parser"));
        $this->load->helper(array("session", "debug"));

        sessionValidation();

        $params = $this->input->post();

//        $validaciones = array(
//            array(
//                "field" => "iTiposEmergencias",
//                "label" => "Tipo de emergencia",
//                "rules" => "required|greater_than[0]",
//            ),
//        );
        $data = array();
//
//        $this->form_validation->set_rules($validaciones);
//
//        $errorFormulario = !$this->form_validation->run();
//
//        if ($errorFormulario) {
        $data["lastPage"] = "alarma/ingreso";
//            $this->template->parse("default", "pages/error_form", $data);
//            return;
//        }


        $this->load->library(array("template"));
        $this->load->model("alarma_model", "AlarmaModel");



        if ($res_guardar = $this->AlarmaModel->guardarAlarma($params)) {
            $tipoAlarma = $params['iTiposEmergencias'];
            $data["tipoAlarma"] = $tipoAlarma;
            switch ($tipoAlarma) {
                case 15: // radiologico
                    $data["formulario"] = $this->parser->parse("pages/alarma/formularios/radiologico", $data, true);
                    $this->template->parse("default", "pages/alarma/ingreso_paso_2", $data);
                    break;
                default :break;
            }
        }
        echo ($res_guardar) ? 1 : 0;
    }

    public function listado() {
        if (!file_exists(APPPATH . "/views/pages/alarma/listado.php")) {
            // Whoops, we don"t have a page for that!
            show_404();
        }

        // load basicos
        $this->load->library("template");
        $this->load->helper("session");

        sessionValidation();


        date_default_timezone_set("America/Buenos_Aires");
        $data = array(
            "anioActual" => date('Y')
        );

        $this->template->parse("default", "pages/alarma/listado", $data);
    }

    public function jsonAlarmasDT() {
        $this->load->model("alarma_model", "Alarma");
        $params = $this->uri->uri_to_assoc();

        $alarmas = $this->Alarma->filtrarAlarmas($params);

        $json["data"] = $alarmas;
        $json["columns"] = array(
            array("sTitle" => "Alarmas"),
        );

        echo json_encode($json);
    }

    public function jsonTiposEmergencias() {
        $this->load->model("tipo_emergencia_model", "TipoEmergencia");
        $tiposEmergencia = $this->TipoEmergencia->get();

        $json = array();
        foreach ($tiposEmergencia as $te) {
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
        foreach ($estados as $e) {
            $json[] = array(
                $e["est_ia_id"],
                $e["est_c_nombre"],
            );
        }

        echo json_encode($json);
    }

}
