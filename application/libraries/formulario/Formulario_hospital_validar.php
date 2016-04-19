<?php

Class Formulario_hospital_validar{
    
    /**
     *
     * @var boolean
     */
    protected $_correcto = true;
    
    /**
     *
     * @var array
     */
    protected $_error = array();
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     *
     * @var Validar 
     */
    protected $validar;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->library(array("validar", "rut"));
        
        $this->validar = New Validar();
    }
    
    /**
     * 
     * @param array $params
     * @return boolean
     */
    public function esValido($params){
        
        if(!$this->validar->validarVacio($params["nombre"])){
            $this->_correcto = false;
            $this->_error["nombre"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["nombre"] = "";
        }

        

        return $this->_correcto;
    }
    
    /**
     * 
     * @return boolean
     */
    public function getCorrecto(){
        return $this->_correcto;
    }
    
    /**
     * 
     * @return array
     */
    public function getErrores(){
        return $this->_error;
    }
}
