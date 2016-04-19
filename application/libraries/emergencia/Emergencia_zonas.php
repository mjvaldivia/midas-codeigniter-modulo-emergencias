<?php

/**
 * Permite obtener las comunas, provincias y regiones
 * asociadas a una emergencia
 */
Class Emergencia_zonas{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     *
     * @var int 
     */
    protected $_id_emergencia;
    
    /**
     *
     * @var Emergencia_Comuna_Model 
     */
    protected $_emergencia_comuna_model;
    
    /**
     *
     * @var array 
     */
    protected $_lista_emergencia_comunas = array();
    
    /**
     *
     * @var array 
     */
    protected $_lista_emergencia_provincias = array();
    
    /**
     *
     * @var array 
     */
    protected $_lista_emergencia_regiones = array();
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->model("emergencia_comuna_model", "_emergencia_comuna_model");
        $this->_emergencia_comuna_model = $this->_ci->_emergencia_comuna_model;
    }
    
    /**
     * 
     * @param int $id_emergencia
     */
    public function setEmergencia($id_emergencia){
        $this->_id_emergencia = $id_emergencia;
        $this->_informacionEmergencia();
    }
    
    /**
     * 
     * @return array
     */
    public function getListaComunas(){
        return $this->_lista_emergencia_comunas;
    }
    
    /**
     * 
     * @return array
     */
    public function getListaProvincias(){
        return $this->_lista_emergencia_provincias;
    }
    
    /**
     * 
     * @return array
     */
    public function getListaRegiones(){
        return $this->_lista_emergencia_regiones;
    }
    
    /**
     * Informacion de emergencia
     */
    protected function _informacionEmergencia(){
        $lista_comunas = $this->_emergencia_comuna_model->listaComunasPorEmergencia($this->_id_emergencia);
        foreach($lista_comunas as $comuna){
            $this->_lista_emergencia_comunas[] = $comuna["com_ia_id"];
        }
        
        $lista_provincias = $this->_emergencia_comuna_model->listaProvinciasPorEmergencia($this->_id_emergencia);
        foreach($lista_provincias as $provincia){
            $this->_lista_emergencia_provincias[] = $provincia["prov_ia_id"];
        }
        
        $lista_regiones = $this->_emergencia_comuna_model->listaRegionesPorEmergencia($this->_id_emergencia);
        foreach($lista_regiones as $region){
            $this->_lista_emergencia_regiones[] = $region["reg_ia_id"];
        }
    }
}

