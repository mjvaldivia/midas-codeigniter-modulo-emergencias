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
        
        $region = NULL;
        if(!empty($params["region"])){
            $region = $this->region_model->getById($params["region"]);
        }
        
        if(!is_null($region)){
            $lista_oficinas = $this->oficina_model->listarPorRegion($region->reg_ia_id);
        } else {
            $lista_oficinas = $this->oficina_model->listar();
        }
        
        echo json_encode($lista_oficinas);
    }
}

