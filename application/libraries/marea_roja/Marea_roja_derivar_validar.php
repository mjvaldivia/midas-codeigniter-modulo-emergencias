<?php

Class Marea_roja_derivar_validar{
    
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
        if(!$this->validar->validarVacio($params["laboratorio"])){
            $this->_correcto = false;
            $this->_error["laboratorio"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["laboratorio"] = "";
        }

        if(count($params['analisis'] == 0)){
            $this->_correcto = false;
            $this->_error["analisis"] = "Falta seleccionar tipos de análisis";
        }else{
            $this->_error["analisis"] = "";
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

