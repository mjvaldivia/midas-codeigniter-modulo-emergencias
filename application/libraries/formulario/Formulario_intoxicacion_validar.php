<?php

Class Formulario_intoxicacion_validar{
    
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

        if(!$this->validar->validarVacio($params["apellido"])){
            $this->_correcto = false;
            $this->_error["apellido"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["apellido"] = "";
        }

        $separada = explode("/", $params["fecha_de_nacimiento"]);
        if(count($separada) == 3 AND strlen($separada[count($separada)-1]) == 4){
            if(!$this->validar->validarFechaSpanish($params["fecha_de_nacimiento"], "d/m/Y")){
                $this->_correcto = false;
                $this->_error["fecha_de_nacimiento"] = "La fecha no es válida: formato(dd/mm/yyyy)";
            } else {
                $this->_error["fecha_de_nacimiento"] = "";
            }
        } else {
            $this->_correcto = false;
            $this->_error["fecha_de_nacimiento"] = "La fecha no es válida: formato(dd/mm/yyyy)";
        }
        
        if(!$this->validar->validarVacio($params["direccion"])){
            $this->_correcto = false;
            $this->_error["direccion"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["direccion"] = "";
        }
        
        if(!$this->validar->validarFechaSpanish($params["fecha_fur"], "d/m/Y")){
            $this->_correcto = false;
            $this->_error["fecha_fur"] = "La fecha no es válida";
        } else {
            $this->_error["fecha_fur"] = "";
        }
        
        if(!$this->validar->validarFechaSpanish($params["fecha_fpp"], "d/m/Y")){
            $this->_correcto = false;
            $this->_error["fecha_fpp"] = "La fecha no es válida";
        } else {
            $this->_error["fecha_fpp"] = "";
        }
        
        if(trim($params["run"])!=""){
            if(!$this->_ci->rut->validar($params["run"])){
                $this->_correcto = false;
                $this->_error["run"] = "El rut ingresado no es válido";
            } else {
                $this->_error["run"] = "";
            }
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
