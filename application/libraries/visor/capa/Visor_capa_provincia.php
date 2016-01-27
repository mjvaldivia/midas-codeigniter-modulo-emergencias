<?php

Class Visor_capa_provincia{
        
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

        $this->_ci->load->model("emergencia_model", "_emergencia_model");
        $this->_ci->load->model("emergencia_capa_model", "_emergencia_capa_model");
        $this->_ci->load->model("capa_geometria_model", "_capa_geometria_model");
        $this->_ci->load->model("capa_model", "_capa_model");
        $this->_ci->load->model("capa_poligono_provincia_model", "_capa_poligono_provincia_model");
        $this->_ci->load->model("provincia_model", "_provincia_model");
    }
    
    /**
     * 
     * @param int $id_subcapa
     * @param int $id_emergencia
     * @return boolean
     */
    public function cargaCapa($id_subcapa, $id_emergencia){
        $data = array();
        $lista_provincias = $this->_listaProvincias($id_emergencia);
        if(count($lista_provincias)>0){
            $resultado = $this->_cargaCapa($id_subcapa, $lista_provincias);
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
    protected function _listaProvincias($id_emergencia){
        $arr = array();
        $lista_provincias = $this->_ci->_provincia_model->listaProvinciasPorEmergencia($id_emergencia);
        if(!is_null($lista_provincias)){
            foreach($lista_provincias as $provincia){
                $arr[] = $provincia["prov_ia_id"];
            }
        }
        return $arr;
    }
    
    /**
     * Carga la capa 
     * @param type $id_geometria
     * @param type $lista_comunas
     * @return string
     */
    protected function _cargaCapa($id_geometria, $lista_provincias = array()){
        $retorno = null;
        
        $subcapa = $this->_ci->_capa_geometria_model->getById($id_geometria);
        if(!is_null($subcapa)){
            $capa = $this->_ci->_capa_model->getById($subcapa->geometria_capa);
            if(!is_null($capa)){
                $json = array();
                
                $lista_poligonos = $this->_ci->_capa_poligono_provincia_model->listarPorSubcapaProvincia($subcapa->geometria_id, $lista_provincias);
                if(count($lista_poligonos)>0){
                    foreach($lista_poligonos as $poligono){
                        $json[] = array(
                            "id" => "provincia-" . $poligono["poliprovincias_id"],
                            "propiedades" => unserialize($poligono["poliprovincias_propiedades"]),
                            "geojson"     => unserialize($poligono["poliprovincias_geometria"])
                            );
                    }
                }
                
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
                
                $retorno = array("zona"  => $capa->cap_c_geozone_number . $capa->cap_c_geozone_letter,
                                 "icono" => $icono,
                                 "color" => $color,
                                 "json"  => $json);

            }
        }
        return $retorno;
    }
}