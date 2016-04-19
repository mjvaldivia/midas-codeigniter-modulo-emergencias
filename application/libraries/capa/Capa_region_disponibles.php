<?php

require_once(__DIR__ . "/../emergencia/Emergencia_capas_disponibles.php");

Class Capa_region_disponibles extends Emergencia_capas_disponibles{
    
    /**
     *
     * @var int
     */
    protected $_id_region;
    
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
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->_ci->load->model("comuna_model", "_comuna_model");
        $this->_ci->load->model("provincia_model", "_provincia_model");
        $this->_ci->load->model("region_model", "_region_model");
    }
    
    /**
     * 
     * @param type $id_region
     */
    public function setRegion($id_region){
        $this->_id_region = $id_region;
        
        $this->_informacion();
    }
    
    /**
     * Informacion de emergencia
     */
    protected function _informacion(){
        $lista_comunas = $this->_ci->_comuna_model->getComunasPorRegion($this->_id_region);
        foreach($lista_comunas as $comuna){
            $this->_lista_emergencia_comunas[] = $comuna->com_ia_id;
        }
        
        $lista_provincias = $this->_ci->_provincia_model->listaProvinciasPorRegion($this->_id_region);
        foreach($lista_provincias as $provincia){
            $this->_lista_emergencia_provincias[] = $provincia["prov_ia_id"];
        }
        

        $this->_lista_emergencia_regiones[] = $this->_id_region;
        
    }
    
    /**
     * 
     * @param type $id_capa
     * @return type
     */
    protected function _listaSubcapas($id_capa){
        $lista = array();
        
        
        $lista_subcapas = $this->_ci->_capa_detalle_model->listarPorCapa(
            $id_capa, 
            $this->_lista_emergencia_comunas, 
            $this->_lista_emergencia_provincias,
            $this->_lista_emergencia_regiones
        );
        
        if(!is_null($lista_subcapas)){
            foreach($lista_subcapas as $subcapa){
                $lista[] = array(
                    "id" => $subcapa["geometria_id"],
                    "nombre" => $subcapa["geometria_nombre"],
                    "icono" => $subcapa["geometria_icono"],
                    "color" => $subcapa["color"]
                );
            }
        }
        
        
        return $lista;
    }
}

