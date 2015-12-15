<?php

require_once(__DIR__ . "/../alarma/Alarmaguardar.php");

/**
 * Guarda emergencia
 */
Class Emergenciaguardar extends Alarmaguardar{
    
    /**
     *
     * @var Emergencia_Model
     */
    protected $_emergencia_model;
    
    /**
     *
     * @var array
     */
    protected $_emergencia;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->_ci->load->model("emergencia_model");
        $this->_emergencia_model = New Emergencia_Model();
    }
    
    /**
     * 
     * @param int $id_emergencia
     * @throws Exception
     */
    public function setEmergencia($id_emergencia){
        $this->_emergencia = $this->_emergencia_model->getById($id_emergencia);
        if(is_null($this->_emergencia)){
            throw new Exception(__METHOD__ . " - No existe la emergencia");
        }
    }
    
    /**
     * 
     * @param array $datos
     */
    protected function _guardaDatosTipoEmergencia($datos){
        $update = array("eme_c_datos_tipo_emergencia" => serialize($datos));
        $this->_emergencia_model->update($update, $this->_emergencia->eme_ia_id);
    }
}
