<?php

class Usuario extends MY_Controller {
    
    /**
     *
     * @var Usuario_Model 
     */
    public $_usuario_model;
    
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
        $this->load->model("emergencia_model", "_emergencia_model");
    }
    
    /**
     * Servicio para retornar oficinas
     * de acuerdo a la region
     */
    public function emails_emergencia()
    {
        header('Content-type: application/json');
        $params = $this->uri->uri_to_assoc();
        
        $correos = array();
        
        
        $lista_regiones = $this->_emergencia_model->listarRegionesPorEmergencia($params["id"]);
        if(!is_null($lista_regiones)){
            foreach ($lista_regiones as $region){
                $lista = $this->_usuario_model->listarUsuariosPorRegion($region["reg_ia_id"]);
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
