<?php

require_once(__DIR__ . "/categorias/CantidadCapasRegion.php");

/**
 * 
 */
Class Visor_Menu_CapaRegion extends Visor_Menu_Categorias_CantidadCapasRegion{
            
    /**
     * Constructor
     */
    public function __construct($id_region) {
        parent::__construct($id_region);
        $this->_ci->load->helper("modulo/capa/capa");
        $this->_ci->load->model("capa_model", "_capa_model");
        $this->_ci->load->model("capa_detalle_model", "_capa_detalle_model");
        
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
            $html .= "<ul class=\"dropdown-menu\">\n"
                    . "<li class=\"divider\"></li>";
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
                return visorMenuCapasDetalleItemRegion($detalle->geometria_id, $this->_id_region);
            }
        } elseif($cantidad > 1) {
            return $this->_ci->load->view("pages/visor/menu/capas", 
                                        array(
                                            "id_region" => $this->_id_region,
                                            "id_capa" => $id_capa,
                                            "nombre" => $nombre_capa
                                        ), true
                                     ) . "<li class=\"divider\"></li>";
        }
    }
}