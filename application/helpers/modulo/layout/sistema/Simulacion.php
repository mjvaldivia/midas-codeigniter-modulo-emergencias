<?php

Class Layout_Sistema_Simulacion{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     *
     * @var Enviroment
     */
    protected $_enviroment;
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->library("enviroment");
        
        $this->_enviroment = New Enviroment();
    }
    
    /**
     * 
     * @return string html
     */
    public function render(){
        if($this->_enviroment->getDatabase() == "simulacion"){
            return $this->_ci->load->view("pages/layout/simulacion", array());
        } else {
            return "";
        }
    }
    
}

