<?php

Class Visor_capa_region{
        
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->library("cache");
        $this->_ci->load->model("emergencia_model", "_emergencia_model");
        $this->_ci->load->model("emergencia_capa_model", "_emergencia_capa_model");
        $this->_ci->load->model("capa_geometria_model", "_capa_geometria_model");
        $this->_ci->load->model("capa_model", "_capa_model");
        $this->_ci->load->model("capa_poligono_region_model", "_capa_poligono_region_model");
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
        fb($lista_regiones);
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
     * @param int $geometria_id
     * @param array $lista_regiones
     * @return string
     */
    protected function _getGeojson($geometria_id, $lista_regiones){
        $json = array();
        $lista_poligonos = $this->_ci->_capa_poligono_region_model->listarPorSubcapaRegion($geometria_id, $lista_regiones);
        if(!is_null($lista_poligonos)){
            foreach($lista_poligonos as $poligono){

                $hash = "poligono_region_serialize" . $poligono["poliregion_id"];
                $cache = Cache::iniciar();
                if(!($geometria = $cache->load($hash))){
                    $geojson = $this->_ci->_capa_poligono_region_model->getById($poligono["poliregion_id"]);
                    $geometria = array(
                        "id" => "region-" . $poligono["poliregion_id"],
                        "propiedades" => unserialize($geojson->poliregion_propiedades),
                        "geojson"     => unserialize($geojson->poliregion_geometria)
                    );
                    $cache->save($geometria, $hash);
                }
                $json[] = $geometria;
                
            }
        }
        
        return $json;
    }
    
    /**
     * Carga la capa 
     * @param type $id_geometria
     * @param type $lista_regiones
     * @return string
     */
    protected function _cargaCapa($lista_regiones = array()){
        $retorno = null;
        
        $lista_subcapa = $this->_ci->_capa_geometria_model->listarGeometriaRegion($lista_regiones);
        if(!is_null($lista_subcapa)){

            foreach($lista_subcapa as $subcapa){
                $capa = $this->_ci->_capa_model->getById($subcapa["geometria_capa"]);
                if(!is_null($capa)){

                    $json = $this->_getGeojson($subcapa["geometria_id"], $lista_regiones);

                    $icono = "";
                    if(!empty($subcapa->geometria_icono)){
                        $icono = base_url($subcapa->geometria_icono);
                    } else {
                        if(!empty($capa->icon_path)){
                            $icono = base_url($capa->icon_path);
                        }
                    }

                    $color = "";
                    if(!empty($subcapa->geometria_icono)){
                        $color = $subcapa->geometria_icono;
                    } else {
                        if(!empty($capa->color)){
                            $color = $capa->color;
                        }
                    }

                    $retorno[] = array("id"    => $subcapa["geometria_id"],
                                       "zona"  => $capa->cap_c_geozone_number . $capa->cap_c_geozone_letter,
                                       "icono" => $icono,
                                       "color" => $color,
                                       "json"  => $json);

                }
            }
        }
        return $retorno;
    }
}