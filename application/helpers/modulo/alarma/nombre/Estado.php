<?php

Class Alarma_Nombre_Estado{
    
    /**
     *
     * @var CI_Controller
     */
    protected $ci;
    
    /**
     *
     * @var object 
     */
    protected $_estado_alarma;
    
    /**
     *
     * @var Alarma_Estado_Model
     */
    public $alarma_estado_model;
    
    /**
     * 
     * @param type $ci
     */
    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->load->model("alarma_estado_model");
        $this->alarma_estado_model = New Alarma_Estado_Model();
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
        }
    }
}

