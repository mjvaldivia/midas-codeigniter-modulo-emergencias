<?php

Class Layout_Tab_Show{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
    }
    
    /**
     * 
     * @param string $actual
     * @param string $activo
     * @param string $tipo
     */
    public function render($actual, $activo, $tipo = "header"){
        if($actual == $activo){
            return $this->_retornaTipo($tipo);
        }
    }
    
    /**
     * 
     * @param string $tipo
     * @return string
     */
    protected function _retornaTipo($tipo){
        if($tipo == "header"){
            return "active";
        } else {
            return "in active";
        }
    }
}
