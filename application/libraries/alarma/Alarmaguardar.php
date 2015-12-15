<?php

Class Alarmaguardar{
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     *
     * @var array 
     */
    protected $_tipo_emergencia;
    
    /**
     *
     * @var array 
     */
    protected $_alarma;
    
    /**
     *
     * @var Tipo_Emergencia_Model 
     */
    protected $_emergencia_tipo_model;
    
    /**
     *
     * @var Alarma_Model 
     */
    protected $_alarma_model;
    
     /**
     * Constructor
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->model("tipo_emergencia_model");
        $this->_ci->load->model("alarma_model");
        $this->_emergencia_tipo_model   = New Tipo_Emergencia_Model();
        $this->_alarma_model = New Alarma_Model();
    }
    
    /**
     * 
     * @param int $id_alarma
     * @throws Exception
     */
    public function setAlarma($id_alarma){
        $this->_alarma = $this->_alarma_model->getById($id_alarma);
        if(is_null($this->_alarma)){
            throw new Exception(__METHOD__ . " - No existe la alarma");
        }
    }
    
    /**
     * 
     * @param int $id_tipo
     */
    public function setTipo($id_tipo){
        $this->_tipo_emergencia = $this->_emergencia_tipo_model->getById($id_tipo);
        if(is_null($this->_tipo_emergencia)){
            throw new Exception(__METHOD__ . " - No existe el tipo de emergencia");
        }
    }
    
    /**
     * Guarda los campos del tipo de emergencia
     * @param array $parametros
     */
    public function guardarDatosTipoEmergencia($parametros){
        
        switch ($this->_tipo_emergencia->aux_ia_id) {
            case Tipo_Emergencia_Model::EMERGENCIA_RADIOLOGICA:
                $guardar = true;
                break;
            default:
                $guardar = false;
                break;
        }
        
        if($guardar){
            $datos = array();
            foreach($parametros as $nombre => $valor){
                $existe_campo = strpos($nombre, "form_tipo_");
                if($existe_campo !== false){
                    $campo = str_replace("form_tipo_", "", $nombre);
                    $datos[$campo] = $valor;
                }
            }
            
            $this->_guardaDatosTipoEmergencia($datos);
        }
    }
    
    /**
     * 
     * @param array $datos
     */
    protected function _guardaDatosTipoEmergencia($datos){
        $update = array("ala_c_datos_tipo_emergencia" => serialize($datos));
        $this->_alarma_model->update($update, $this->_alarma->ala_ia_id);
    }
}

