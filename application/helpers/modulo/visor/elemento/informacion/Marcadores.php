<?php

/**
 * Muestra informacion de los marcadores
 * pertenecientes a un elemento shape
 */
Class Visor_Elemento_Informacion_Marcadores{
    
    /**
     * Lista de marcadores pertenecientes a una capa
     * @var array
     */
    protected $_lista_capas = array();
    
    /**
     * Lista de marcadores pertenecientes a capas externas
     * @var array
     */
    protected $_lista_externos = array();
    
    /**
     * Lista de marcadores agregados
     * @var array
     */
    protected $_lista_otros = array();
    
    /**
     *
     * @var Capa_Model 
     */
    protected $_capa_model;
    
    /**
     *
     * @var Capa_Detalle_Model 
     */
    protected $_capa_detalle_model;
    
    /**
     *
     * @var Capa_Detalle_Elemento_Model 
     */
    protected $_capa_detalle_elemento_model;
    
    /**
     *
     * @var CI_Controller
     */
    protected $_ci;
    
    /**
     * Prefijo para tabs
     * @var string
     */
    protected $_prefix = "marcadores";
    
    /**
     * 
     * @param array $lista lista de elementos
     */
    public function __construct($lista) {
        $this->_ci =& get_instance();
        $this->_ci->load->model("capa_model");
        $this->_ci->load->helper("modulo/capa/capa");
        $this->_ci->load->model("capa_detalle_model");
        $this->_ci->load->model("capa_detalle_elemento_model");
        
        $this->_capa_model           = $this->_ci->capa_model;
        $this->_capa_detalle_model   = $this->_ci->capa_detalle_model;
        $this->_capa_detalle_elemento_model = $this->_ci->capa_detalle_elemento_model;
        
        $this->_llenaListasMarcadores($lista);
    }
    
    /**
     * 
     * @return string html
     */
    public function render(){
        if((count($this->_lista_capas) + count($this->_lista_otros) + count($this->_lista_externos))>0){
            $html = $this->_ci->load->view(
                    "pages/mapa/popup-informacion/tab-header", 
                    array("prefix" => $this->_prefix,
                          "lista_capas" => $this->_lista_capas,
                          "lista_otros" => $this->_lista_otros,
                          "lista_externos" => $this->_lista_externos), 
                    true);
            
            $html .= $this->_ci->load->view(
                    "pages/mapa/popup-informacion/tab-content", 
                    array("prefix" => $this->_prefix,
                          "lista_capas" => $this->_lista_capas,
                          "lista_otros" => $this->_lista_otros,
                          "lista_externos" => $this->_lista_externos), 
                    true);
            
            return $html;
        } else {
            return $this->_ci->load->view(
                "pages/mapa/popup-informacion/no-existen-items", 
                array(), 
                true
            );
       
        }
    }
    
    /**
     * Carga la informacion de los marcadores
     * @param array $lista
     */
    protected function _llenaListasMarcadores($lista){
        if(count($lista)>0){
            foreach($lista as $key => $marcador){
                $subcapa = $this->_capa_detalle_model->getById($marcador->CAPA);
                if(!is_null($subcapa)){
                    if(!isset($this->_lista_capas[$subcapa->geometria_id])){
                        $this->_lista_capas[$subcapa->geometria_id] = array("preview" => getSubCapaPreview($subcapa->geometria_id),
                                                                            "nombre"  => $subcapa->geometria_nombre);
                    }
                    $this->_lista_capas[$subcapa->geometria_id]["marcadores"][] = $marcador;
                } else {
                    if(count($marcador)>0){
                        if(isset($marcador->informacion->TIPO)){
                            $this->_lista_externos[$marcador->informacion->TIPO][] = $marcador;
                        } else {
                            $this->_lista_otros[] = $marcador;
                        }
                    }
                }
            }
        }
    }
}

