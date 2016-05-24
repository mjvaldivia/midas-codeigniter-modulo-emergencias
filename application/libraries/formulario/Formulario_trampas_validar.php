<?php

Class Formulario_trampas_validar{

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
        $this->_correcto = true;
        if(!$this->validar->validarVacio($params["direccion"])){
            $this->_correcto = false;
            $this->_error["direccion"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["direccion"] = "";
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


        if(!$this->validar->validarVacio($params["acciones"])){
            $this->_correcto = false;
            $this->_error["acciones"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["acciones"] = "";
        }



        return $this->_correcto;
    }



    public function validarInspeccion($params){

        $this->_correcto = true;
        if(!$this->validar->validarVacio($params["fecha_inspeccion"])){
            $this->_correcto = false;
            $this->_error["fecha_inspeccion"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["fecha_inspeccion"] = "";
        }


        if($this->validar->validarNumero($params["hallazgo_inspeccion"])){
            $this->_error["hallazgo_inspeccion"] = "";
        } else {
            $this->_correcto = false;
            $this->_error["hallazgo_inspeccion"] = "Este dato no puede estar vacío";
        }

        if($this->validar->validarNumero($params["cantidad_inspeccion"])){
            $this->_error["cantidad_inspeccion"] = "";
        } else {
            $this->_correcto = false;
            $this->_error["cantidad_inspeccion"] = "Este dato no puede estar vacío";

        }

        if(!$this->validar->validarVacio($params["observaciones_inspeccion"])){
            $this->_correcto = false;
            $this->_error["observaciones_inspeccion"] = "Este dato no puede estar vacío";
        } else {
            $this->_error["observaciones_inspeccion"] = "";
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
