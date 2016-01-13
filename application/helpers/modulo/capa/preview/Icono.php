<?php

/**
 * 
 */
Class Capa_Preview_Icono{
    
    /**
     *
     * @var CI_Controller
     */
    protected $_ci;
    
    /**
     *
     * @var array 
     */
    protected $_capa;
    
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
        $this->_ci->load->model("capa_model");
        
        $this->_capa_model = New Capa_Model();
    }
    
    /**
     * 
     * @return string html
     */
    public function render(){
        if($this->_capa->color != ""){
            return "<div class=\"color-capa-preview\" style=\"background-color:".$this->_capa->color."\"></div>";
        } elseif($this->_capa->icon_path != ""){
            return "<img src=\"" . base_url($this->_capa->icon_path) . "\" title=\"Icono de capa\" style=\"height: 30px;\"  >";
        }
    }
    
    /**
     * Setea la capa
     * @param int $id_capa
     * @throws Exception
     */
    public function setCapa($id_capa){
        $this->_capa = $this->_capa_model->getById($id_capa);
        if(is_null($this->_capa)){
            throw new Exception(__METHOD__ . " - La capa no existe");
        }
    }
}

