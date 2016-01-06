<?php

Class Alarmavalidar{
    
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
        if(!$this->validar->validarVacio($params["nombre_informante"])){
            $this->_correcto = false;
            $this->_error["nombre_informante"] = "Debe ingresar el nombre del informante";
        } else {
            $this->_error["nombre_informante"] = "";
        }

        if(!$this->validar->validarVacio($params["nombre_emergencia"])){
            $this->_correcto = false;
            $this->_error["nombre_emergencia"] = "Debe ingresar el nombre de la emergencia";
        } else {
            $this->_error["nombre_emergencia"] = "";
        }

        if(!$this->validar->validarVacio($params["nombre_lugar"])){
            $this->_correcto = false;
            $this->_error["nombre_lugar"] = "Debe ingresar el nombre del lugar";
        } else {
            $this->_error["nombre_lugar"] = "";
        }

        if(!$this->validar->validarVacio($params["tipo_emergencia"])){
            $this->_correcto = false;
            $this->_error["tipo_emergencia"] = "Debe ingresar un tipo de emergencia";
        } else {
            $this->_error["tipo_emergencia"] = "";
        }

        if(!$this->validar->validarArregloVacio($params["comunas"])){
            $this->_correcto = false;
            $this->_error["comunas"] = "Debe ingresar al menos una comuna";
        } else {
            $this->_error["comunas"] = "";
        }
        
        /*$fecha_recepcion = DateTime::createFromFormat("d-m-Y H:i", $params["fecha_recepcion"]);
        if($fecha_recepcion instanceof DateTime){
            $this->_error["fecha_recepcion"] = "";
        } else {
            $this->_correcto = false;
            $this->_error["fecha_recepcion"] = "Debe ingresarse una fecha de válida";
        }*/
        
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

