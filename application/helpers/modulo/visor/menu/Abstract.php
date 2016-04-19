<?php

Class Visor_Menu_Abstract{
    
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
    
    protected $_lista_emergencia_comunas = array();
    
    protected $_lista_emergencia_provincias = array();
    
    protected $_lista_emergencia_regiones = array();
    
     /**
     * Constructor
     */
    public function __construct($id_emergencia) {
        $this->_id_emergencia = $id_emergencia;
        
        $this->_ci =& get_instance();
        $this->_ci->load->model("emergencia_comuna_model", "_emergencia_comuna_model");
        $this->_ci->load->helper("modulo/capa/capa");
        $this->_informacionEmergencia();
    }
    
    /**
     * Informacion de emergencia
     */
    protected function _informacionEmergencia(){
        $lista_comunas = $this->_ci->_emergencia_comuna_model->listaComunasPorEmergencia($this->_id_emergencia);
        foreach($lista_comunas as $comuna){
            $this->_lista_emergencia_comunas[] = $comuna["com_ia_id"];
        }
        
        $lista_provincias = $this->_ci->_emergencia_comuna_model->listaProvinciasPorEmergencia($this->_id_emergencia);
        foreach($lista_provincias as $provincia){
            $this->_lista_emergencia_provincias[] = $provincia["prov_ia_id"];
        }
        
        $lista_regiones = $this->_ci->_emergencia_comuna_model->listaRegionesPorEmergencia($this->_id_emergencia);
        foreach($lista_regiones as $region){
            $this->_lista_emergencia_regiones[] = $region["reg_ia_id"];
        }
    }
}

