<?php

Class Alarma_Nombre_Estado{
    
    /**
     *
     * @var CI_Controller
     */
    protected $_ci;
    
    /**
     *
     * @var object 
     */
    protected $_estado_alarma;
    
    /**
     *
     * @var Emergencia_Estado_Model
     */
    public $alarma_estado_model;
    
    /**
     * 
     * @param type $ci
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->model("emergencia_estado_model");
        $this->alarma_estado_model = $this->_ci->emergencia_estado_model;
    }
    
    /**
     * 
     * @param int $id_tipo_emergencia
     */
    public function setId($id_estado){
        $this->_estado_alarma = $this->alarma_estado_model->getById($id_estado);
    }
    
    /**
     * 
     * @return string
     */
    public function getString(){
        if(!is_null($this->_estado_alarma)){
            return $this->_estado_alarma->est_c_nombre;
        } else {
            return "";
        }
    }
}

