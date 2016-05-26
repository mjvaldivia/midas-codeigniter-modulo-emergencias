<?php

Class Usuario_geozone{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->model("usuario_model");
    }
    
    
    
}

