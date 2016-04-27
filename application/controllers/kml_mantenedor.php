<?php

Class Kml_mantenedor extends MY_Controller {
    
    /**
     *
     * @var Emergencia_Kml_Model 
     */
    public $_emergencia_kml_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model("emergencia_kml_model", "_emergencia_kml_model");
        $this->load->model("emergencia_kml_elemento_model", "_emergencia_kml_elemento_model");
    }
    
    /**
     * 
     */
    public function index(){
    
        $this->template->parse("default", "pages/kml_mantenedor/index", array("cantidad" => 0));
    }
}
