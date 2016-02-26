<?php

Class Visor_guardar_configuracion{
    
    /**
     *
     * @var int 
     */
    protected $_id_emergencia;
    
    /**
     *
     * @var boolean 
     */
    protected $_bo_sidco_conaf;
    
    /**
     *
     * @var boolean 
     */
    protected $_bo_casos_febriles;
    
    /**
     *
     * @var string 
     */
    protected $_tipo_mapa;
    
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
     * @param string $string
     */
    public function setTipoMapa($string){
        $this->_tipo_mapa = $string;
        return $this;
    }
    
    /**
     * 
     * @param boolean $boolean
     */
    public function setSidcoConaf($boolean){
        $this->_bo_sidco_conaf = $boolean;
        return $this;
    }
    
    public function setCasosFebriles($boolean){
        $this->_bo_casos_febriles = $boolean;
        return $this;
    }
    
    /**
     * 
     */
    public function guardar(){
        $data = array("id_emergencia" => $this->_id_emergencia,
                      "tipo_mapa" => $this->_tipo_mapa,
                      "kml_sidco"     => $this->_bo_sidco_conaf,
                      "bo_casos_febriles" => $this->_bo_casos_febriles);
        
        $configuracion = $this->_emergencia_mapa_configuracion_model->getByEmergencia($this->_id_emergencia);
        if(is_null($configuracion)){
            $this->_emergencia_mapa_configuracion_model->insert($data);
        } else {
            $this->_emergencia_mapa_configuracion_model->updatePorEmergencia($this->_id_emergencia, $data);
        }
    }
}

