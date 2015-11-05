<?php

/**
 * Nombre del tipo de emergencia
 */
Class Emergencia_Nombre_Tipo{
    
    /**
     *
     * @var type 
     */
    protected $ci;
    
    /**
     *
     * @var object 
     */
    protected $_tipo_emergencia;
    
    /**
     *
     * @var Emergencia_Tipo_Model
     */
    public $tipo_emergencia_model;
    
    /**
     * 
     * @param type $ci
     */
    public function __construct($ci) {
        $this->ci = $ci;
        $this->ci->load->model("tipo_emergencia_model");
        $this->tipo_emergencia_model = New Tipo_Emergencia_Model();
    }
    
    /**
     * 
     * @param int $id_tipo_emergencia
     */
    public function setId($id_tipo_emergencia){
        $this->_tipo_emergencia = $this->tipo_emergencia_model->getById($id_tipo_emergencia);
    }
    
    /**
     * 
     * @return string
     */
    public function getString(){
        if(!is_null($this->_tipo_emergencia)){
            return $this->_tipo_emergencia->aux_c_nombre;
        }
    }
}
