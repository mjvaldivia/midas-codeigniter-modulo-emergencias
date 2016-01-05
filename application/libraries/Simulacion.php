<?php

Class Simulacion{
    
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
     * @return string
     */
    public function __toString() {
        if($this->_enviroment->esSimulacion()){
            return "[SIMULACIÓN] ";
        } else {
            return "";
        }
    }
}
