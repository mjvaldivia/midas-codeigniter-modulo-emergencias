<?php
/**
 * @author Vladimir
 * @since 14-09-15
 */
if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Emergencia extends CI_Controller {

    public function obtenerJsonLimitesVisor() {
        $params = $this->uri->uri_to_assoc();

        $this->load->helper("session");

        sessionValidation();

        $this->load->model("emergencia_model", "EmergenciaModel");

        $limites = $this->EmergenciaModel->obtenerLimitesVisor($params);
        echo json_encode($limites);
    }

    public function generaEmergencia() {
        $params = $this->uri->uri_to_assoc();
        if (!file_exists(APPPATH . "/views/pages/emergencia/generaEmergencia.php")) {
            show_404();
        }

        $this->load->library("template");
        $this->load->helper("session");
        
        if(isset($params['k']) && !$this->session->userdata('session_idUsuario'))
        {
            $this->load->model("usuario_model", "UsuarioModel");
            $val = $this->UsuarioModel->validaKey($params['k']);
            if ($val['activo']==1){
                $this->UsuarioModel->nologin($val['usu_c_rut']);
            }
            else{
                 sessionValidation(); 
            }
        }
        else if(!isset($params['k'])){
            
            sessionValidation(); 
        }
        $data['ala_ia_id'] = $params['id'];
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $this->load->model("emergencia_model", "EmergenciaModel");
        $estado_alerta = $this->EmergenciaModel->revisaEstado($params);

        switch ($estado_alerta){
            case $this->EmergenciaModel->activado: 
                $this->template->parse("default", "pages/emergencia/activada", $data);
                break;
            case $this->EmergenciaModel->rechazado: 
                $this->template->parse("default", "pages/emergencia/anulada", $data);
                break;
            default :$this->template->parse("default", "pages/emergencia/generaEmergencia", $data);
                break;
        }
            
        
        
    }

    public function rechaza() {
        $this->load->helper(array("session", "debug"));
        sessionValidation();
        $params = $this->input->post(null, true);
        $this->load->library(array("template"));
        $this->load->model("emergencia_model", "EmergenciaModel");
        if ($res_guardar = $this->EmergenciaModel->rechazaEmergencia($params)) {
            
        }
        echo ($res_guardar) ? 1 : 0;
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
        $params = $this->input->post(null, true);
        $data = array();
        $data["lastPage"] = "alarma/ingreso";
        $this->load->library(array("template"));
        $this->load->model("emergencia_model", "EmergenciaModel");
        echo $this->EmergenciaModel->guardarEmergencia($params);
    }
    
    public function getAlarma() {
        $this->load->helper("utils");
        $params = $this->uri->uri_to_assoc();
        $this->load->model("emergencia_model", "EmergenciaModel");
        return $this->EmergenciaModel->getAlarma($params);
    }
    
    public function listado() {
        if (!file_exists(APPPATH . "/views/pages/emergencia/listado.php")) {
            // Whoops, we don"t have a page for that!
            show_404();
        }

        // load basicos
        $this->load->library("template");
        $this->load->helper("session");

        sessionValidation();


        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $data = array(
            "anioActual" => date('Y')
        );

        $this->template->parse("default", "pages/emergencia/listado", $data);
    }
    
    public function jsonEmergenciasDT() {
        $this->load->model("emergencia_model", "Emergencia");
        $params = $this->uri->uri_to_assoc();

        $emergencias = $this->Emergencia->filtrarEmergencias($params);
        //var_dump($emergencias);die;
        $json["data"] = $emergencias;
        $json["columns"] = array(
            array("sTitle" => "Emergencias"),
        );

        echo json_encode($json);
    }
    
    public function editar() {
        if (!file_exists(APPPATH . "/views/pages/emergencia/editarEmergencia.php")) {
            // Whoops, we don"t have a page for that!
            show_404();
        }

        // load basicos
        $this->load->library("template");
        $this->load->helper("session");

        sessionValidation();

        $params = $this->uri->uri_to_assoc();
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $data['eme_ia_id'] = $params['id'];

        $this->template->parse("default", "pages/emergencia/editarEmergencia", $data);
    }
    
    public function getEmergencia() {
        $this->load->helper("utils");
        $params = $this->uri->uri_to_assoc();
        $this->load->model("emergencia_model", "EmergenciaModel");
        return $this->EmergenciaModel->getJsonEmergencia($params);
    }
    
    public function editarEmergencia() { //edicion de una emergencia
        $this->load->helper(array("session", "debug"));
        sessionValidation();
        $params = $this->input->post(null, true);
        $this->load->model("emergencia_model", "EmergenciaModel");
        $res = $this->EmergenciaModel->editarEmergencia($params);
        return ($res)?1:0;
    }
            
}
