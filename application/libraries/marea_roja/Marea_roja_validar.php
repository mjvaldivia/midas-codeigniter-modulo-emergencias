<?php

Class Marea_roja_validar{
    
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
        
        if(!$this->validar->validarVacio($params["form_coordenadas_latitud"])){
            $this->_correcto = false;
            $this->_error["form_coordenadas_latitud"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["form_coordenadas_latitud"] = "";
        }

        if(!$this->validar->validarVacio($params["form_coordenadas_longitud"])){
            $this->_correcto = false;
            $this->_error["form_coordenadas_longitud"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["form_coordenadas_longitud"] = "";
        }
        
        if(!$this->validar->validarVacio($params["calidad_de_georeferenciacion"])){
            $this->_correcto = false;
            $this->_error["calidad_de_georeferenciacion"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["calidad_de_georeferenciacion"] = "";
        }

        $separada = explode("/", $params["fecha"]);
        if(count($separada) == 3 AND strlen($separada[count($separada)-1]) == 4){
            if(!$this->validar->validarFechaSpanish($params["fecha"], "d/m/Y")){
                $this->_correcto = false;
                $this->_error["fecha"] = "La fecha no es válida: formato(dd/mm/yyyy)";
            } else {
                $this->_error["fecha"] = "";
            }
        } else {
            $this->_correcto = false;
            $this->_error["fecha"] = "La fecha no es válida: formato(dd/mm/yyyy)";
        }
        
        if(!$this->validar->validarVacio($params["recurso"])){
            $this->_correcto = false;
            $this->_error["recurso"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["recurso"] = "";
        }
        
        if(!$this->validar->validarVacio($params["origen"])){
            $this->_correcto = false;
            $this->_error["origen"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["origen"] = "";
        }
        
        if(!$this->validar->validarVacio($params["region"])){
            $this->_correcto = false;
            $this->_error["region"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["region"] = "";
        }
        
        /*if(!$this->validar->validarVacio($params["comuna"])){
            $this->_correcto = false;
            $this->_error["comuna"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["comuna"] = "";
        }*/
        
        if(!$this->validar->validarVacio($params["numero_de_muestra"])){
            $this->_correcto = false;
            $this->_error["numero_de_muestra"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["numero_de_muestra"] = "";
        }
        
        if(!$this->validar->validarVacio($params["laboratorio"])){
            $this->_correcto = false;
            $this->_error["laboratorio"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["laboratorio"] = "";
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

