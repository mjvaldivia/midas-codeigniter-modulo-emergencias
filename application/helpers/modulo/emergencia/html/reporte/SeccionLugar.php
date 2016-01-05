<?php

Class Emergencia_Html_Reporte_SeccionLugar{
    
    /**
     *
     * @var string 
     */
    protected $_tipo_lugar;
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    public function __construct() {
        $this->_ci =& get_instance();
    }
    
    public function setParametros($parametros){
        $this->_tipo_lugar = $parametros[""]
    }
}

