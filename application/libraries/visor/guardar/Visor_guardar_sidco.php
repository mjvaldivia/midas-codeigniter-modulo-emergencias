<?php

Class Visor_guardar_sidco{
    
    /**
     *
     * @var int 
     */
    protected $_id_emergencia;
    
    /**
     *
     * @var Emergencia_Mapa_Configuracion_Model 
     */
    protected $_emergencia_mapa_configuracion_model;
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
        /**
     * Constructor
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->library(array("cache"));
        $this->_ci->load->model("emergencia_mapa_configuracion_model");
        $this->_emergencia_mapa_configuracion_model = $this->_ci->emergencia_mapa_configuracion_model;
    }
    
    /**
     * Setea emergencia
     * @param int $id
     * @return \Visor_guardar_elemento
     */
    public function setEmergencia($id){
        $this->_id_emergencia = $id;
        return $this;
    }
    
    /**
     * 
     * @param array $lista_kml
     */
    public function guardar($bo_sidco){
        $data = array("id_emergencia" => $this->_id_emergencia,
                      "kml_sidco"     => $bo_sidco);
        
        $configuracion = $this->_emergencia_mapa_configuracion_model->getByEmergencia($this->_id_emergencia);
        if(is_null($configuracion)){
            $this->_emergencia_mapa_configuracion_model->insert($data);
        } else {
            $this->_emergencia_mapa_configuracion_model->updatePorEmergencia($this->_id_emergencia, $data);
        }
    }
}

