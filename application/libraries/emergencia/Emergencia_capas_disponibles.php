<?php

Class Emergencia_capas_disponibles{
    
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
     * @var Emergencia_zonas 
     */
    protected $_emergencia_zonas;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->_ci =& get_instance();
        
        $this->_ci->load->model("categoria_cobertura_model", "_tipo_capa_model");
        $this->_ci->load->model("capa_model", "_capa_model");
        $this->_ci->load->model("capa_detalle_model", "_capa_detalle_model");
        
        $this->_ci->load->library("emergencia/emergencia_zonas");
        $this->_emergencia_zonas = $this->_ci->emergencia_zonas;
    }
    
    /**
     * 
     * @param int $id_emergencia
     */
    public function setEmergencia($id_emergencia){
        $this->_id_emergencia = $id_emergencia;
        $this->_emergencia_zonas->setEmergencia($this->_id_emergencia);
    }
    
    /**
     * 
     * @return type
     */
    public function getListaCapas(){
        $lista = array();
        $lista_categorias = $this->_ci->_tipo_capa_model->listar();
        foreach($lista_categorias as $categoria){
            $lista[] = array(
                "id" => $categoria["ccb_ia_categoria"],
                "nombre" => $categoria["ccb_c_categoria"],
                "lista" => $this->_listaCapas($categoria["ccb_ia_categoria"])
            );
        }
        return $lista;
    }
    
    /**
     * 
     * @param type $id_categoria
     * @return type
     */
    protected function _listaCapas($id_categoria){
        $lista = array();
        
        $lista_capas = $this->_ci->_capa_model->listarCapasPorCategoria($id_categoria);
        if(!is_null($lista_capas)){
            foreach($lista_capas as $capa){
                $lista[] = array(
                    "id" => $capa["cap_ia_id"],
                    "nombre" => $capa["cap_c_nombre"],
                    "icono" => $capa["icon_path"],
                    "color" => $capa["color"],
                    "lista" => $this->_listaSubcapas($capa["cap_ia_id"])
                );
            }
        }
        
        return $lista;
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
            $this->_emergencia_zonas->getListaComunas(), 
            $this->_emergencia_zonas->getListaProvincias(),
            $this->_emergencia_zonas->getListaRegiones()
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

