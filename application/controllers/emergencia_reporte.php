<?php

Class Emergencia_reporte extends MY_Controller {
    
    /**
    *
    * @var Emergencia_Model 
    */
    public $_emergencia_model;
        
    /**
    * Constructor
    */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("emergencia_model", "_emergencia_model");
    }
    
    public function index(){
        $params = $this->uri->uri_to_assoc();
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            $data = array("id" => $emergencia->eme_ia_id,
                          "js" => $this->load->view("pages/mapa/js-plugins", array(), true));
            $this->load->view("pages/emergencia_reporte/index.php", $data);
        }
    }
}
