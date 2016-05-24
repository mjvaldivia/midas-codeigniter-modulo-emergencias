<?php

Class Visor_capa_elemento{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     *
     * @var array 
     */
    protected $_emergencia;
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->library("emergencia/emergencia_comuna");
        $this->_ci->load->model("emergencia_model", "_emergencia_model");
        $this->_ci->load->model("emergencia_capa_model", "_emergencia_capa_model");
        $this->_ci->load->model("capa_detalle_model", "_capa_detalle_model");
        $this->_ci->load->model("capa_model", "_capa_model");
        $this->_ci->load->model("capa_detalle_elemento_model", "_capa_detalle_elemento_model");
    }
    
    /**
     * 
     * @param int $id_emergencia
     */
    public function setEmergencia($id_emergencia){
        $emergencia = $this->_ci->_emergencia_model->getById($id_emergencia);
        if(!is_null($emergencia)){
            $this->_emergencia = $emergencia;
        }
    }
    
    /**
     * 
     * @param int $id_subcapa
     * @param int $id_emergencia
     * @return boolean
     */
    public function cargaCapa($id_subcapa)
    {
        $data = array("correcto" => false,
                      "capa" => array());

        $resultado = $this->_cargaCapa($id_subcapa);
        if(!is_null($resultado)){
            $data = array("correcto" => true,
                          "capa" => $resultado);
        }
        
        return $data;
    }
    
    /**
     * Carga las capas que pertenecen a la emergencia
     * @param int $id_emergencia
     * @return string
     */
    public function cargaCapasEmergencia($id_emergencia){
        $data = array("correcto" => true,
                      "resultado" => array("capas" => array()));
        
        $this->setEmergencia($id_emergencia);

        $lista_capas = $this->_ci->_emergencia_capa_model->listaPorEmergencia($this->_emergencia->eme_ia_id);
        if(count($lista_capas)>0){
            foreach($lista_capas as $capa){
                $resultado = $this->_cargaCapa($capa["id_geometria"]);
                if(!is_null($resultado)){
                    $data["correcto"] = true;
                    $data["resultado"]["capas"][$capa["id_geometria"]] = $resultado;
                }
            }
        }

        
        return $data;
    }
    
    /**
     * Carga la capa 
     * @param type $id_geometria
     * @param type $lista_comunas
     * @return string
     */
    protected function _cargaCapa($id_geometria){
        $retorno = null;
        $subcapa = $this->_ci->_capa_detalle_model->getById($id_geometria);
        if(!is_null($subcapa)){
            $capa = $this->_ci->_capa_model->getById($subcapa->geometria_capa);
            if(!is_null($capa)){
                $json = array();
                $lista_poligonos = $this->_listElementos($subcapa->geometria_id);
                if(count($lista_poligonos)>0){
                    foreach($lista_poligonos as $poligono){
                        $json[] = array(
                            "id" => $poligono["poligono_id"],
                            "nombre" => $subcapa->geometria_nombre,
                            "propiedades" => unserialize($poligono["poligono_propiedades"]),
                            "geojson"     => unserialize($poligono["poligono_geometria"])
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
                                 "nombre" => $subcapa->geometria_nombre,
                                 "color" => $color,
                                 "json"  => $json);

            }
        }
        return $retorno;
    }
    
    /**
     * 
     * @param int $id_capa_detalle
     * @param array $lista
     * @return array
     */
    protected function _listElementos($id_capa_detalle){
        return $this->_ci->_capa_detalle_elemento_model->listarPorSubcapa(
                $id_capa_detalle, 
                $this->_ci->emergencia_comuna->listComunas($this->_emergencia->eme_ia_id),
                $this->_ci->emergencia_comuna->listProvincias($this->_emergencia->eme_ia_id),
                $this->_ci->emergencia_comuna->listRegiones($this->_emergencia->eme_ia_id)
        );
    }
}

