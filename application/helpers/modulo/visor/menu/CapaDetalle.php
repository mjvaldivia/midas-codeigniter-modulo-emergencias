<?php

require_once(__DIR__ . "/Abstract.php");

/**
 * 
 */
Class Visor_Menu_CapaDetalle extends Visor_Menu_Abstract{

    /**
     * Constructor
     */
    public function __construct($id_emergencia) {
        parent::__construct($id_emergencia);
        $this->_ci->load->model("capa_detalle_model", "_capa_detalle_model");
    }
    
    /**
     * 
     * @param int $id_categoria
     * @return string html
     */
    public function render($id_capa){
        $html = "";
        $lista_detalle = $this->_ci->_capa_detalle_model->listarPorCapa(
            $id_capa, 
            $this->_lista_emergencia_comunas, 
            $this->_lista_emergencia_provincias,
            $this->_lista_emergencia_regiones
        );
        
        if(count($lista_detalle)>0){
            foreach($lista_detalle as $detalle){
                fb($detalle);
                $html .= visorMenuCapasDetalleItem($detalle["geometria_id"], $this->_id_emergencia);
            }
        }
        
        return $html;
    }
}

