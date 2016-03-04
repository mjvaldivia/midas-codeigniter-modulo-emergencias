<?php

class Usuario extends MY_Controller {
    
    /**
     *
     * @var Usuario_Model 
     */
    public $_usuario_model;
    
    /**
     *
     * @var Usuario_Region_Model 
     */
    public $_usuario_region_model;
    
    /**
     *
     * @var Emergencia_Model 
     */
    public $_emergencia_model;
    
    /**
     *
     * @var Region_Model
     */
    public $region_model;
    
    /**
     * Constructor
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->library("session");
        $this->load->model("usuario_model", "_usuario_model");
        $this->load->model("usuario_region_model", "_usuario_region_model");
        $this->load->model("emergencia_model", "_emergencia_model");
    }
    
    public function json_regiones()
    {
        $this->load->helper("modulo/direccion/region");
        header('Content-type: application/json');
        $regiones = $this->_usuario_region_model->listarPorUsuario($this->session->userdata("session_idUsuario"));
        if(!is_null($regiones)){
            
            $lista_regiones = array();
            foreach($regiones as $region){
                $lista_regiones[] = array(
                    "id" => $region["id_region"],
                    "nombre" => nombreRegion($region["id_region"])
                );
            }
            
            echo json_encode(array("correcto" => true,
                                   "regiones" => $lista_regiones));
        } else {
             echo json_encode(array("correcto" => false));
        }
    }
    
    /**
     * Servicio para retornar oficinas
     * de acuerdo a la region
     */
    public function emails_emergencia()
    {
        header('Content-type: application/json');
        $params = $this->input->post(null, true);
        
        $correos = array();
        
        
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            $lista_regiones = $this->_emergencia_model->listarRegionesPorEmergencia($params["id"]);
        } else {
            $lista_regiones = $this->_usuario_region_model->listarPorUsuario($this->session->userdata("session_idUsuario"));
        }

        if(!is_null($lista_regiones)){
            foreach ($lista_regiones as $region){
                $lista = $this->_usuario_model->listarUsuariosPorRegion($region["id_region"]);
                if(!is_null($lista)){
                    foreach($lista as $usuario){
                        $correos[] = array("email" => $usuario["usu_c_email"],
                                           "name"  => $usuario["usu_c_nombre"] . " " . $usuario["usu_c_apellido_paterno"]);
                    }
                }
            }
        }
        
        
        
        echo json_encode($correos);
    }
}
