<?php

class Mapa extends MY_Controller {
    
    /**
     *
     * @var template
     */
    public $template;
    
    /**
     *
     * @var Emergencia_Model 
     */
    public $_emergencia_model;
    
    /**
     *
     * @var Emergencia_Comuna_Model 
     */
    public $_emergencia_comuna_model;
    
    /**
     *
     * @var Alarma_Model 
     */
    public $_alarma_model;
    
    /**
     *
     * @var Capa_Model 
     */
    public $_capa_model;
    
    /**
     *
     * @var Archivo_Model 
     */
    public $_archivo_model;
    
    /**
     *
     * @var Emergencia_Capas_Model 
     */
    public $_emergencia_capas_model;
    
    /**
     *
     * @var Capa_Punto_Informacion 
     */
    public $_capa_poligono_informacion_model;
    
    /**
     *
     * @var Categoria_Cobertura_Model
     */
    public $_tipo_capa_model;
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->load->model("emergencia_model", "_emergencia_model");
        $this->load->model("emergencia_capas_geometria_model", "_emergencia_capas_model");
        $this->load->model("emergencia_comuna_model","_emergencia_comuna_model");
        $this->load->model("alarma_model", "_alarma_model");
        $this->load->model("capa_model", "_capa_model");
        $this->load->model("capa_poligono_informacion_model", "_capa_poligono_informacion_model");
        $this->load->model("categoria_cobertura_model", "_tipo_capa_model");
        $this->load->model("archivo_model", "_archivo_model");
    }
    
    /**
     * Carga de mapa para emergencia
     * @throws Exception
     */
    public function index(){
        $params = $this->uri->uri_to_assoc();
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            $data = array("id" => $emergencia->eme_ia_id);
            $this->template->parse("default", "pages/mapa/index", $data);
        } else {
            throw new Exception(__METHOD__ . " - La emergencia no existe");
        }
    }
    
    /**
     * Popup que muestra capas
     * @throws Exception
     */
    public function popup_capas(){
        $this->load->helper(array("modulo/capa/capa",
                                  "modulo/visor/visor"));
        $params = $this->input->post(null, true);
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            $lista_comunas = $this->_emergencia_comuna_model->listaComunasPorEmergencia($emergencia->eme_ia_id);
            if(count($lista_comunas)>0){
                $comunas = array();
                foreach($lista_comunas as $comuna){
                    $comunas[] = $comuna["com_ia_id"];
                }
                
                $lista_capas = array();
                
                $lista_tipos = $this->_tipo_capa_model->listarCategoriasPorComunas($comunas);
                if(count($lista_tipos)>0){
                    foreach($lista_tipos as $tipo){
                        $lista_capas[] = array("id_categoria" => $tipo["ccb_ia_categoria"],
                                               "nombre_categoria" => $tipo["ccb_c_categoria"]);
                    }
                }
                
                
                $this->load->view("pages/mapa/popup-capas", 
                                   array("capas" => $lista_capas,
                                         "seleccionadas" => $params["capas"],
                                         "comunas" => $comunas));
            }
        } else {
            throw new Exception("La emergencia no existe");
        }
    }
    
    public function popup_poligono_informacion(){
        $this->load->helper(array("modulo/visor/visor"));
        
        $params = $this->input->post(null, true);
        $informacion = $params["informacion"];
        
        $capa = $this->_capa_model->getById($params["capa"]);
        
        if(is_null($capa)){
            
            if(isset($informacion["NAME"])){
                $nombre = $informacion["NAME"];
                unset($informacion["NAME"]);
            }
            
            if(isset($informacion["NOMBRE"])){
                $nombre = $informacion["NOMBRE"];
                unset($informacion["NOMBRE"]);
            }
            
            $id_capa = NULL;
            
        } else {
            $id_capa = $capa->cap_ia_id;
            $nombre = $capa->cap_c_nombre;
        }        
        
        $this->load->view("pages/mapa/popup-poligono-informacion", 
                          array("nombre" => $nombre,
                                "informacion" => $informacion,
                                "lista_marcadores"  => $params["marcadores"]));
    }
    
    /**
     * Carga datos de una capa
     */
    public function ajax_capa(){
        $data = array("correcto" => false,
                      "error" => "La capa no existe o no pudo ser cargada");
        
        $params = $this->input->post(null, true);
        $resultado = $this->_cargaCapa($params["id"]);
        if(!is_null($resultado)){
            $data = array("correcto" => true,
                          "capa" => $resultado);
        }
        
        echo json_encode($data);
    }
    
    /**
     * Retorna las capas asociadas a una emergencia
     */
    public function ajax_capas_emergencia(){
        $data = array("correcto" => true,
                      "resultado" => array("capas" => array()));
        
        $params = $this->input->post(null, true);
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            $lista_capas = $this->_emergencia_capas_model->listaPorEmergencia($emergencia->eme_ia_id);
            if(count($lista_capas)>0){
                foreach($lista_capas as $capa){
                    $resultado = $this->_cargaCapa($capa->id_capa);
                    if(!is_null($resultado)){
                        $data["correcto"] = true;
                        $data["resultado"]["capas"][$capa->cap_ia_id] = $resultado;
                    }
                }
            }
        } else {
            $data["info"] = "La emergencia no tiene capas asociadas";
        }
        
        echo json_encode($data);
    }
    
    /**
     * Retorna datos de ubicacion de la alarma
     * @throws Exception
     */
    public function ajax_marcador_lugar_alarma(){
        $data = array("correcto" => false);
        
        $params = $this->input->post(null, true);
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            
            $alarma = $this->_alarma_model->getById($emergencia->ala_ia_id);
            if(!is_null($alarma)){
                $data = array("correcto"  => true,
                              "resultado" => array("lat" => $alarma->ala_c_utm_lat,
                                                   "lon" => $alarma->ala_c_utm_lng,
                                                   "zona" => $alarma->ala_c_geozone));
            } else {
                $data["error"] = "La alarma no existe";
            }
            
        } else {
            $data["error"] = "La emergencia no existe";
        }
        
        echo json_encode($data);
    }
    
    /**
     * Carga datos de una capa
     * @param int $id_capa
     * @return array
     */
    protected function _cargaCapa($id_capa){
        $retorno = null;
        $capa = $this->_capa_model->getById($id_capa);
        if(!is_null($capa)){
            
            $retorno = array("zona"  => $capa->cap_c_geozone_number . $capa->cap_c_geozone_letter,
                             "icono" => $capa->icon_path,
                             "color" => $capa->color,
                             "json"  => json_decode(file_get_contents(base_url($archivo->arch_c_nombre))));
            
        }
        return $retorno;
    }
}
