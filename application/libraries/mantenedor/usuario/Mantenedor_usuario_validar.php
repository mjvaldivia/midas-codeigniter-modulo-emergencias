<?php

Class Mantenedor_usuario_validar{
    
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
        $this->_ci->load->library("validar");
        
        $this->validar = New Validar();
    }
    
    /**
     * 
     * @param array $params
     * @return boolean
     */
    public function esValido($params){
        
        if(!$this->validar->validarVacio($params["rut"])){
            $this->_correcto = false;
            $this->_error["rut"] = "Debe ingresar el rut del usuario";
        } else {
            $this->_error["rut"] = "";
        }

        if(!$this->validar->validarVacio($params["nombre"])){
            $this->_correcto = false;
            $this->_error["nombre"] = "Debe ingresar el nombre del usuario";
        } else {
            $this->_error["nombre"] = "";
        }

        if(!$this->validar->validarVacio($params["apellido_paterno"])){
            $this->_correcto = false;
            $this->_error["apellido_paterno"] = "Debe ingresar el apellido del usuario";
        } else {
            $this->_error["apellido_paterno"] = "";
        }
        
        if(!$this->validar->validarVacio($params["apellido_materno"])){
            $this->_correcto = false;
            $this->_error["apellido_materno"] = "Debe ingresar el apellido del usuario";
        } else {
            $this->_error["apellido_materno"] = "";
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

