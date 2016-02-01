<?php

Class Visor_Menu_CapaDetalleItem{
    
    /**
     *
     * @var CI_Controller
     */
    protected $_ci;
    
    protected $_detalle;
    
    /**
     * Constructor
     */
    public function __construct($id_detalle) {
        $this->_ci =& get_instance();
        $this->_ci->load->model("capa_detalle_model", "_capa_detalle_model");
        $this->_ci->load->model("comuna_model", "_comuna_model");
        $this->_ci->load->model("provincia_model", "_provincia_model");
        $this->_ci->load->model("region_model", "_region_model");
        
        $this->_detalle = $this->_ci->_capa_detalle_model->getById($id_detalle);
    }
    
    /**
     * 
     * @return string html
     */
    public function render(){
        return $this->_ci->load->view(
                "pages/mapa/menu/capas-detalle-item", 
                array(
                    "id" => $this->_detalle->geometria_id,
                    "nombre" => $this->_detalle->geometria_nombre
                ), 
                true
        );
    }
    
}

