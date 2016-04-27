<?php

/**
 * 
 */
Class Capa_Preview_Subcapa{
    
    /**
     *
     * @var CI_Controller
     */
    protected $_ci;
        
    /**
     *
     * @var array 
     */
    protected $_subcapa;
    
    /**
     *
     * @var Capa_Model 
     */
    protected $_subcapa_model;
    
    /**
     *
     * @var Capa_Model 
     */
    protected $_capa_model;
    
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->model("capa_detalle_model");
        $this->_ci->load->model("capa_model");
        
        $this->_capa_model = $this->_ci->capa_model;
        $this->_subcapa_model = $this->_ci->capa_detalle_model;
    }
    
    /**
     * 
     * @return string html
     */
    public function render(){
        $capa = $this->_capa_model->getById($this->_subcapa->geometria_capa);
        if($capa->color != ""){
            if(!empty($this->_subcapa->geometria_icono)){
                $color = $this->_subcapa->geometria_icono;
            } else {
                $color = $capa->color;
            }
            return "<div class=\"color-capa-preview\" style=\"background-color:".$color."\"></div>";
        } elseif($capa->icon_path != ""){
            if(!empty($this->_subcapa->geometria_icono)){
                $icono = base_url($this->_subcapa->geometria_icono);
            } else {
                $icono = base_url($capa->icon_path);
            }
            return "<img src=\"" . $icono . "\" title=\"Icono de capa\" style=\"height: 15px;\"  >";
        }
    }
    
    /**
     * Setea la capa
     * @param int $id_capa
     * @throws Exception
     */
    public function setSubCapa($id_subcapa){
        $this->_subcapa = $this->_subcapa_model->getById($id_subcapa);
        if(is_null($this->_subcapa)){
            throw new Exception(__METHOD__ . " - La Subcapa no existe");
        }
    }
}

