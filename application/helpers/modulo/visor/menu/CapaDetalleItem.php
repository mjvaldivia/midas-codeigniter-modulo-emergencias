<?php

Class Visor_Menu_CapaDetalleItem{
    
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
    
    
    public function setEmergencia($id_emergencia){
        $lista = $this->_ci->_emergencia_capa_model->listaPorEmergencia($id_emergencia);
        if(!is_null($lista)){
            foreach($lista as $capa){
                $this->_capas_emergencia[] = $capa["id_geometria"];
            }
        }
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
                    "seleccionadas" => $this->_capas_emergencia
                ), 
                true
        );
    }
    
}

