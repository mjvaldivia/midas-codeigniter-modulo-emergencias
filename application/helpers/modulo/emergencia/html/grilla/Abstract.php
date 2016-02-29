<?php

Abstract Class Emergencia_Html_Grilla_Abstract{
    
    /**
    *
    * @var array 
    */
    protected $_emergencia;
    
    /**
    *
    * @var CI_Controller
    */
    protected $_ci;
    
    /**
     * 
     */
    public function __construct($id_emergencia) {
        $this->_ci =& get_instance();
        $this->_ci->load->model("emergencia_model","_emergencia_model");
        
        $this->setEmergencia($id_emergencia);
    }
    
    /**
     * 
     * @param int $id_emergencia
     */
    public function setEmergencia($id_emergencia){
        $this->_emergencia = $this->_ci->_emergencia_model->getById($id_emergencia);
        if(is_null($this->_emergencia)){
            throw new Exception(__METHOD__ . " - La emergencia no existe");
        }
    }
}

