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
        $this->_ci->load->library("emergencia/emergencia_comuna");
        $this->_ci->load->model("emergencia_model", "_emergencia_model");
        $this->_ci->load->model("emergencia_capa_model", "_emergencia_capa_model");
        $this->_ci->load->model("capa_geometria_model", "_capa_geometria_model");
        $this->_ci->load->model("capa_model", "_capa_model");
        $this->_ci->load->model("capa_poligono_comuna_model", "_capa_poligono_comuna_model");
    }
    
    /**
     * Carga las capas que pertenecen a la emergencia
     * @param int $id_emergencia
     * @return string
     */
    public function cargaEmergencia($id_emergencia){
        $data = array("correcto" => true,
                      "resultado" => array("capas" => array()));
        
        $emergencia = $this->_ci->_emergencia_model->getById($id_emergencia);
        if(!is_null($emergencia)){
            
            $lista_comunas = $this->_ci->emergencia_comuna->listComunas($emergencia->eme_ia_id);

            $lista_capas = $this->_ci->_emergencia_capa_model->listaPorEmergencia($emergencia->eme_ia_id);
            if(count($lista_capas)>0){
                foreach($lista_capas as $capa){
                    fb(__METHOD__ . " - Carga capa " . $capa["id_geometria"]);
                    $resultado = $this->_cargaCapa($capa["id_geometria"], $lista_comunas);
                    if(!is_null($resultado)){
                        $data["correcto"] = true;
                        $data["resultado"]["capas"][$capa["id_geometria"]] = $resultado;
                    }
                }
            }
        } else {
            $data["info"] = "La emergencia no existe";
        }
        
        return $data;
    }
    
    /**
     * Carga la capa 
     * @param type $id_geometria
     * @param type $lista_comunas
     * @return string
     */
    protected function _cargaCapa($id_geometria, $lista_comunas = array()){
        $retorno = null;
        
        $subcapa = $this->_ci->_capa_geometria_model->getById($id_geometria);
        if(!is_null($subcapa)){
            $capa = $this->_ci->_capa_model->getById($subcapa->geometria_capa);
            if(!is_null($capa)){
                $json = array();
                $lista_poligonos = $this->_ci->_capa_poligono_comuna_model->listarPorSubcapaComuna($subcapa->geometria_id, $lista_comunas);
                if(count($lista_poligonos)>0){
                    foreach($lista_poligonos as $poligono){
                        $json[] = array(
                            "id" => $poligono["poligono_id"],
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
                
                $retorno = array("zona"  => $capa->cap_c_geozone_number . $capa->cap_c_geozone_letter,
                                 "icono" => $icono,
                                 "color" => $capa->color,
                                 "json"  => $json);

            }
        }
        return $retorno;
    }
}

