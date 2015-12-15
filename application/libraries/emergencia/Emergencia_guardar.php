<?php

require_once(__DIR__ . "/../alarma/Alarmaguardar.php");

/**
 * Guarda emergencia
 */
Class Emergencia_guardar extends Alarmaguardar{
    
    /**
     *
     * @var Emergencia_Model
     */
    protected $_emergencia_model;
    
    /**
     *
     * @var Emergencia_Comuna_Model 
     */
    protected $_emergencia_comuna_model;
    
    /**
     *
     * @var array
     */
    protected $_emergencia = null;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->_ci->load->model("emergencia_model");
        $this->_emergencia_model = New Emergencia_Model();
        $this->_emergencia_comuna_model = New Emergencia_Comuna_Model();
    }
    
    /**
     * Retorna identificador de la emergencia
     * @return int
     */
    public function getId(){
        if(!is_null($this->_emergencia)){
            return $this->_emergencia->eme_ia_id;
        }
    }
    
    /**
     * Guarda la emergencia
     * @param array $datos
     */
    public function guardar($datos){
        if(is_null($this->_emergencia)){
            $id = $this->_emergencia_model->query()->insert($datos);
            $this->setEmergencia($id);
        } else {
            $this->_emergencia_model->query()->update($datos, "eme_ia_id", $this->_emergencia->eme_ia_id);
        }
    }
    
    /**
     * 
     * @param array $comunas
     */
    public function setComunas($comunas){
        if(!is_null($this->_emergencia)){
            $this->_emergencia_comuna_model->query()->insertOneToMany("eme_ia_id", 
                                                                      "com_ia_id", 
                                                                      $this->_emergencia->eme_ia_id, 
                                                                      $comunas);
        }
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
        
        $this->setTipo($this->_emergencia->tip_ia_id);
        
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
