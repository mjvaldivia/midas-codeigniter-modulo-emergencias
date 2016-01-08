<?php

class Mapa extends MY_Controller {
    
    /**
     *
     * @var template
     */
    public $template;
    
    /**
     *
     * @var Emergencia_Model 
     */
    public $emergencia_model;
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->load->model("emergencia_model", "emergencia_model");
        
    }
    
    public function index(){
        $this->template->parse("default", "pages/mapa/index", array());
    }
}
