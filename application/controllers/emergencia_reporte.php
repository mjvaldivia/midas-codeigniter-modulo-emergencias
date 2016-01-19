<?php

Class Emergencia_finalizar extends MY_Controller {
    
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
            
        }
    }
}
