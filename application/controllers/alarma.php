<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * User: claudio
 * Date: 12-08-15
 * Time: 04:24 PM
 */
class Alarma extends CI_Controller {

    /**
     *
     * @var Alarma_Model
     */
    public $AlarmaModel;
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->load->model("alarma_model", "AlarmaModel");
    }
    
    /**
     * Formulario de ingreso de alarma
     */
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

    /**
     * Guarda formulario de alarma
     */
    public function guardaAlarma() {
        if (!file_exists(APPPATH . "/views/pages/alarma/ingreso_paso_2.php")) {
            // Whoops, we don"t have a page for that!
            show_404();
        }
        $this->load->helper(array("session", "debug"));
        sessionValidation();
        $params = $this->input->post(null, true);
        $data = array();
        $data["lastPage"] = "alarma/ingreso";
        $this->load->library(array("template",'parser'));
        echo $this->AlarmaModel->guardarAlarma($params);
    }
    
    /**
     * Elimina la alarma
     */
    public function eliminarAlarma() { 
        $this->load->helper(array("session", "debug"));
        sessionValidation();
        $params = $this->uri->uri_to_assoc();
        $res = $this->AlarmaModel->eliminarAlarma($params['id']);
        echo ($res) ? 1 : 0;
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

        $data = array(
            "anioActual" => date('Y')
        );

        $this->template->parse('alone',"pages/alarma/listado", $data);
    }

    public function jsonAlarmasDT() {
        $params = $this->uri->uri_to_assoc();
        $alarmas = $this->AlarmaModel->filtrarAlarmas($params);

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
    
    public function paso2() {

        if (!file_exists(APPPATH . "/views/pages/alarma/ingreso_paso_2.php")) {
            // Whoops, we don"t have a page for that!
            show_404();
        }
        $params = $this->uri->uri_to_assoc();
        // load basicos
        $this->load->library(array("template",'parser'));
        $this->load->helper("session");
        
        sessionValidation();
        $data['ala_ia_id'] = $params['id'];
        $data['tipoAlarma'] = $params['tip_ia_id'];
        switch ($params['tip_ia_id']){
            case 15: $data["formulario"] = $this->parser->parse("pages/alarma/formularios/radiologico", $data, true);
                break;   
        }
        
        $this->template->parse("default", "pages/alarma/ingreso_paso_2", $data);
    }

}
