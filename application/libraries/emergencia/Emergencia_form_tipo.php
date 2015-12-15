<?php

require_once(__DIR__ . "/../alarma/Alarma_form_tipo.php");

Class Emergencia_form_tipo extends Alarma_form_tipo{
    
    /**
     *
     * @var array
     */
    protected $_emergencia = NULL;
    
    /**
     *
     * @var Emergencia_Model
     */
    protected $_emergencia_model;
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->_emergencia_model = New Emergencia_Model();
    }
    
    /**
     * 
     * @param int $id_emergencia
     */
    public function setEmergencia($id_emergencia){
        $this->_emergencia = $this->_emergencia_model->getById($id_emergencia);
    }
    
    /**
     * Retorna la data
     * @return string
     */
    protected function _getDataFromBd(){
        if(!is_null($this->_emergencia)){
            return $this->_emergencia->eme_c_datos_tipo_emergencia;
        } else {
            return "";
        }
    }
}

