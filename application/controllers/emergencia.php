<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Emergencia extends CI_Controller {

    public function generaEmergencia() {

        $params = $this->uri->uri_to_assoc();
        if (!file_exists(APPPATH . "/views/pages/emergencia/generaEmergencia.php")) {
            show_404();
        }

        $this->load->library("template");
        $this->load->helper("session");

        sessionValidation();
        
        $data['ala_ia_id'] = $params['id'];
        //var_dump($data);die;
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $this->load->model("emergencia_model", "EmergenciaModel");
        $estado_alerta = $this->EmergenciaModel->revisaEstado($params);

        switch ($estado_alerta){
            case $this->EmergenciaModel->activado: 
                $this->template->parse("default", "pages/emergencia/activada", $data);
                break;
            case $this->EmergenciaModel->noactivado: 
                $this->template->parse("default", "pages/emergencia/anulada", $data);
                break;
            default :$this->template->parse("default", "pages/emergencia/generaEmergencia", $data);
                break;
        }
            
        
        
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

    public function ingreso() {
        $this->load->helper(array("session", "debug"));
        sessionValidation();
        $params = $this->input->post();
        $data = array();
        $data["lastPage"] = "alarma/ingreso";
        $this->load->library(array("template"));
        $this->load->model("emergencia_model", "EmergenciaModel");
        if ($res_guardar = $this->EmergenciaModel->guardarEmergencia($params)) {
            
        }
        echo ($res_guardar) ? 1 : 0;
    }
    
    public function getAlarma() {
        $this->load->helper("utils");
        $params = $this->uri->uri_to_assoc();
        $this->load->model("emergencia_model", "EmergenciaModel");
        return $this->EmergenciaModel->getAlarma($params);
    }
    

}
