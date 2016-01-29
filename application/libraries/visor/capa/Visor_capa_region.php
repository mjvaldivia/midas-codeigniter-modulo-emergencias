<?php

require_once(__DIR__ . "/Visor_capa_elemento.php");

Class Visor_capa_region extends Visor_capa_elemento{
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->_ci->load->model("region_model", "_region_model");
    }
            
    /**
     * 
     * @param int $id_subcapa
     * @param int $id_emergencia
     * @return boolean
     */
    public function cargaCapa($id_emergencia){
        $data = array();
        $lista_regiones = $this->_listaRegiones($id_emergencia);
        if(count($lista_regiones)>0){
            $resultado = $this->_cargaCapa($lista_regiones);
            if(!is_null($resultado)){
                $data = $resultado;
            }
        }
        return $data;
    }
    
    /**
     * 
     * @param int $id_emergencia
     * @return array
     */
    protected function _listaRegiones($id_emergencia){
        $arr = array();
        $lista = $this->_ci->_region_model->listaRegionesPorEmergencia($id_emergencia);
        if(!is_null($lista)){
            foreach($lista as $row){
                $arr[] = $row["reg_ia_id"];
            }
        }
        return $arr;
    }
    
    
    /**
     * 
     * @param int $id_capa_detalle
     * @param array $lista
     * @return array
     */
    protected function _listElementos($id_capa_detalle, $lista){
        return $this->_ci->_capa_detalle_elemento_model->listarPorSubcapaRegion($id_capa_detalle, $lista);
    }
}