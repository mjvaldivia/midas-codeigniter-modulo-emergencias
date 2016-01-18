<?php

class Oficina extends MY_Controller {
    
    /**
     *
     * @var Oficina_Model 
     */
    public $oficina_model;
    
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
        $this->load->model("oficina_model", "oficina_model");
        $this->load->model("region_model", "region_model");
    }
    
    /**
     * Servicio para retornar oficinas
     * de acuerdo a la region
     */
    public function rest()
    {
        header('Content-type: application/json');
        $params = $this->uri->uri_to_assoc();
        $lista_oficinas = array();
        
        
        $regiones = array();
        if(!empty($params["region"]) and $params["region"]!="null"){
            $regiones = explode(",",$params["region"]);
        }
        
        if(count($regiones)>0){
            $lista_oficinas = $this->oficina_model->listarPorRegiones($regiones);
            if(is_null($lista_oficinas)){
                $lista_oficinas = array();
            }
        } else {
            $lista_oficinas = $this->oficina_model->listar();
        }
        
        echo json_encode($lista_oficinas);
    }
}

