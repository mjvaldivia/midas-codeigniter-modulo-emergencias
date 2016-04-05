<?php

Class Rabia_vacunacion_validar{
    
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

        if(!$this->validar->validarVacio($params["direccion"])){
            $this->_correcto = false;
            $this->_error["direccion"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["direccion"] = "";
        }
        
        if(trim($params["run"])!=""){
            if(!$this->_ci->rut->validar($params["run"])){
                $this->_correcto = false;
                $this->_error["run"] = "El rut ingresado no es válido";
            } else {
                $this->_error["run"] = "";
            }
        }
        
        if(!$this->validar->validarVacio($params["nombre_animal"])){
            $this->_correcto = false;
            $this->_error["nombre_animal"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["nombre_animal"] = "";
        }
        
        if(!$this->validar->validarVacio($params["especie_animal"])){
            $this->_correcto = false;
            $this->_error["especie_animal"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["especie_animal"] = "";
        }
        
        if(!$this->validar->validarVacio($params["vacuna_tipo"])){
            $this->_correcto = false;
            $this->_error["vacuna_tipo"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["vacuna_tipo"] = "";
        }
        
        if(!$this->validar->validarVacio($params["vacuna_nombre"])){
            $this->_correcto = false;
            $this->_error["vacuna_nombre"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["vacuna_nombre"] = "";
        }
        
        if(!$this->validar->validarVacio($params["vacuna_laboratorio"])){
            $this->_correcto = false;
            $this->_error["vacuna_laboratorio"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["vacuna_laboratorio"] = "";
        }
        
        if(!$this->validar->validarVacio($params["vacuna_numero_serie"])){
            $this->_correcto = false;
            $this->_error["vacuna_numero_serie"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["vacuna_numero_serie"] = "";
        }
        
        $separada = explode("/", $params["vacuna_fecha"]);
        if(count($separada) == 3 AND strlen($separada[count($separada)-1]) == 4){
            if(!$this->validar->validarFechaSpanish($params["vacuna_fecha"], "d/m/Y")){
                $this->_correcto = false;
                $this->_error["vacuna_fecha"] = "La fecha no es válida: formato(dd/mm/yyyy)";
            } else {
                $this->_error["vacuna_fecha"] = "";
            }
        } else {
            $this->_correcto = false;
            $this->_error["vacuna_fecha"] = "La fecha no es válida: formato(dd/mm/yyyy)";
        }
        
        $separada = explode("/", $params["vacuna_fecha_revacunacion"]);
        if(count($separada) == 3 AND strlen($separada[count($separada)-1]) == 4){
            if(!$this->validar->validarFechaSpanish($params["vacuna_fecha_revacunacion"], "d/m/Y")){
                $this->_correcto = false;
                $this->_error["vacuna_fecha_revacunacion"] = "La fecha no es válida: formato(dd/mm/yyyy)";
            } else {
                $this->_error["vacuna_fecha_revacunacion"] = "";
            }
        } else {
            $this->_correcto = false;
            $this->_error["vacuna_fecha_revacunacion"] = "La fecha no es válida: formato(dd/mm/yyyy)";
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
