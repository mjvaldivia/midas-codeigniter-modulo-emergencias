<?php

Class Marea_roja_resultado_validar{
    
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
        
        if(!$this->validar->validarVacio($params["resultado"])){
            $this->_correcto = false;
            $this->_error["resultado"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["resultado"] = "";
        }
        
        $separada = explode("/", $params["resultado_fecha"]);
        if(count($separada) == 3 AND strlen($separada[count($separada)-1]) == 4){
            if(!$this->validar->validarFechaSpanish($params["resultado_fecha"], "d/m/Y")){
                $this->_correcto = false;
                $this->_error["resultado_fecha"] = "La fecha no es válida: formato(dd/mm/yyyy)";
            } else {
                $this->_error["resultado_fecha"] = "";
            }
        } else {
            $this->_correcto = false;
            $this->_error["resultado_fecha"] = "La fecha no es válida: formato(dd/mm/yyyy)";
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

