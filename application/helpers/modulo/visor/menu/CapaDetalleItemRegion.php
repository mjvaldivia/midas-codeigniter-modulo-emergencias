<?php

Class Visor_Menu_CapaDetalleItemRegion{
    
    /**
     *
     * @var CI_Controller
     */
    protected $_ci;
    
    /**
     * Valores de capa_geometria
     * @var array 
     */
    protected $_detalle;
    
    /**
     * Identificadores de capas asociadas a la emergencia
     * @var array
     */
    protected $_capas_emergencia = array();
    
    /**
     * Constructor
     */
    public function __construct($id_detalle) {
        $this->_ci =& get_instance();
        $this->_ci->load->model("capa_detalle_model", "_capa_detalle_model");
        $this->_ci->load->model("emergencia_capa_model", "_emergencia_capa_model");
        
        $this->_detalle = $this->_ci->_capa_detalle_model->getById($id_detalle);
    }
    
    
    public function setRegion($id_region){
        //void
    }
    
    /**
     * 
     * @return string html
     */
    public function render(){
        return $this->_ci->load->view(
                "pages/mapa/menu/capas-detalle-item", 
                array(
                    "id"     => $this->_detalle->geometria_id,
                    "nombre" => $this->_detalle->geometria_nombre,
                    "seleccionadas" => array()
                ), 
                true
        );
    }
    
}

