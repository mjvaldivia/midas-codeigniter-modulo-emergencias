<?php

require_once(__DIR__ . "/mapa.php");

/**
 * 
 */
class Mapa_publico extends Mapa {
    
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        //sessionValidation();
        $this->_cargaModel();
    }
    
    /**
     * Carga de mapa publico
     * @throws Exception
     */
    public function index(){
        $this->load->helper("modulo/visor/visor");
        $params = $this->uri->uri_to_assoc();
        
        $emergencia = $this->_emergencia_model->getById($params["id"]);

        $this->load->model('Permiso_Model','PermisoModel');
        $this->load->model('Modulo_Model','ModuloModel');
        $guardar = $this->PermisoModel->tienePermisoVisorEmergenciaGuardar($this->session->userdata('session_roles'),7);
        
        if(!is_null($emergencia)){
            $data = array("id" => $params["id"],
                          "guardar" => $guardar,
                          "js" => $this->load->view("pages/mapa/js-plugins", array(), true));

            
            $this->template->parse("default", "pages/mapa/index", $data);
        } else {
            throw new Exception(__METHOD__ . " - La emergencia no existe");
        }
    }
}

