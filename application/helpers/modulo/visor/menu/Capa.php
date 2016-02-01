<?php

require_once(__DIR__ . "/Abstract.php");

/**
 * 
 */
Class Visor_Menu_Capa extends Visor_Menu_Abstract{
            
    /**
     * Constructor
     */
    public function __construct($id_emergencia) {
        parent::__construct($id_emergencia);

        $this->_ci->load->model("capa_model", "_capa_model");
        $this->_ci->load->model("capa_detalle_model", "_capa_detalle_model");
        
        $this->_informacionEmergencia();
    }
    
    /**
     * 
     * @param int $id_categoria
     * @return string html
     */
    public function render($id_categoria){
        $html = "";
        $lista_capas = $this->_ci->_capa_model->listarCapasPorCategoria($id_categoria);
        if(count($lista_capas)>0){
            $html .= "<ul class=\"dropdown-menu\">";
            foreach($lista_capas as $capa){
                $html .= $this->_getHtmlCapa($capa["cap_ia_id"], $capa["cap_c_nombre"]);
            }
            $html .= "</ul>";
        }
        return $html;
    }
    
    /**
     * 
     * @param int $id_capa
     * @param nombre $nombre_capa
     * @return string html
     */
    protected function _getHtmlCapa($id_capa, $nombre_capa){
        $cantidad = $this->_ci->_capa_detalle_model->cantidadPorCapa(
                $id_capa, 
                $this->_lista_emergencia_comunas, 
                $this->_lista_emergencia_provincias,
                $this->_lista_emergencia_regiones
        );

        if($cantidad == 1){
            $detalle = $this->_ci->_capa_detalle_model->primerDetallePorCapa(
                $id_capa,
                $this->_lista_emergencia_comunas, 
                $this->_lista_emergencia_provincias,
                $this->_lista_emergencia_regiones
            );
            
            if(!is_null($detalle)){
                return visorMenuCapasDetalleItem($detalle->geometria_id);
            }
        } else {
            return $this->_ci->load->view("pages/mapa/menu/capas", 
                                        array(
                                            "id_emergencia" => $this->_id_emergencia,
                                            "id_capa" => $id_capa,
                                            "nombre" => $nombre_capa
                                        ), true
                                     );
        }
    }
}