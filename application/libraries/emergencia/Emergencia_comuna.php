<?php

Class Emergencia_comuna{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     *
     * @var Emergencia_Comuna_Model
     */
    protected $_emergencia_comuna_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->model("emergencia_comuna_model");
        
        $this->_emergencia_comuna_model = New Emergencia_Comuna_Model();
    }
    
    /**
     * Retorna lista con Ids de region
     * @param int $id_emergencia
     * @return array
     */
    public function listRegiones($id_emergencia){
        $array = array();
        
        $lista = $this->_emergencia_comuna_model->listaRegionesPorEmergencia($id_emergencia);
        if(count($lista)>0){
            foreach($lista as $region){
                $array[] = $region["reg_ia_id"];
            }
        }
        
        return $array;
    }
    
     /**
     * Retorna lista con Ids de provincia
     * @param int $id_emergencia
     * @return array
     */
    public function listProvincias($id_emergencia){
        $array = array();
        
        $lista = $this->_emergencia_comuna_model->listaProvinciasPorEmergencia($id_emergencia);
        if(count($lista)>0){
            foreach($lista as $provincia){
                $array[] = $provincia["prov_ia_id"];
            }
        }
        
        return $array;
    }
    
    /**
     * Retorna lista con Ids de comuna
     * @param int $id_emergencia
     * @return array
     */
    public function listComunas($id_emergencia){
        $comunas = array();
        
        $lista_comunas = $this->_emergencia_comuna_model->listaComunasPorEmergencia($id_emergencia);
        if(count($lista_comunas)>0){
            foreach($lista_comunas as $comuna){
                $comunas[] = $comuna["com_ia_id"];
            }
        }
        
        return $comunas;
    }
}

