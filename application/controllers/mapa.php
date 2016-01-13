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
     * @var Emergencia_Capas_Geometria_Model 
     */
    public $_emergencia_capas_model;
    
    /**
     *
     * @var Capa_Poligono_Informacion_Model
     */
    public $_capa_poligono_informacion_model;
    
    /**
     *
     * @var Capa_Geometria_Model 
     */
    public $_capa_geometria_model;
    
    /**
     *
     * @var Categoria_Cobertura_Model
     */
    public $_tipo_capa_model;
    
    /**
     *
     * @var Emergencia_Comuna 
     */
    public $emergencia_comuna;
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->load->library("emergencia/emergencia_comuna");
        $this->load->model("emergencia_model", "_emergencia_model");
        $this->load->model("emergencia_capas_geometria_model", "_emergencia_capas_model");
        $this->load->model("emergencia_comuna_model","_emergencia_comuna_model");
        $this->load->model("alarma_model", "_alarma_model");
        $this->load->model("capa_model", "_capa_model");
        $this->load->model("capa_poligono_informacion_model", "_capa_poligono_informacion_model");
        $this->load->model("capa_geometria_model", "_capa_geometria_model");
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
     * Guarda configuracion del mapa
     */
    public function save(){
        header('Content-type: application/json');
        $params = $this->input->post(null, true);
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            $this->_emergencia_capas_model->query()
                                          ->insertOneToMany("id_emergencia", 
                                                            "id_geometria", 
                                                            $emergencia->eme_ia_id, 
                                                            $params["capas"]);
            $data = array("correcto" => true,
                          "error" => "");
        } else {
            $data = array("correcto" => false,
                          "error" => "La emergencia no existe");
        }
        
        echo json_encode($data);
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
            
            $lista_comunas = $this->emergencia_comuna->listComunas($emergencia->eme_ia_id);
            
            if(count($lista_comunas)>0){
                $lista_capas = array();
                
                $lista_tipos = $this->_tipo_capa_model->listarCategoriasPorComunas($lista_comunas);
                if(count($lista_tipos)>0){
                    foreach($lista_tipos as $tipo){
                        $lista_capas[] = array("id_categoria" => $tipo["ccb_ia_categoria"],
                                               "nombre_categoria" => $tipo["ccb_c_categoria"]);
                    }
                }
                
                $this->load->view("pages/mapa/popup-capas", 
                                   array("capas" => $lista_capas,
                                         "seleccionadas" => $params["capas"],
                                         "comunas" => $lista_comunas));
            }
        } else {
            throw new Exception("La emergencia no existe");
        }
    }
    
    /**
     * Muestra información del poligono
     */
    public function popup_poligono_informacion(){
        $this->load->helper(array("modulo/visor/visor"));
        
        $params = $this->input->post(null, true);
        $informacion = $params["informacion"];
        
        $geometria = $this->_capa_poligono_informacion_model->getById($params["capa"]);
        
        if(is_null($geometria)){
            $nombre_subcapa = "";
            $nombre_capa    = "";
            $nombre_tipo    = "";
        } else {
            $subcapa = $this->_capa_geometria_model->getById($geometria->poligono_capitem);
            $capa    = $this->_capa_model->getById($subcapa->geometria_capa);
            $tipo    = $this->_tipo_capa_model->getById($capa->ccb_ia_categoria);
            $nombre_subcapa  = $subcapa->geometria_nombre;
            $nombre_capa     = $capa->cap_c_nombre;
            $nombre_tipo     = $tipo["ccb_c_categoria"];
        }        
        

        
        $this->load->view("pages/mapa/popup-poligono-informacion", 
                          array("nombre_subcapa" => $nombre_subcapa,
                                "nombre_capa"    => $nombre_capa,
                                "nombre_tipo"   => $nombre_tipo,
                                "informacion" => $informacion,
                                "lista_marcadores"  => $params["marcadores"]));
    }
    
    /**
     * Carga datos de una capa
     */
    public function ajax_capa(){
        header('Content-type: application/json');
        $data = array("correcto" => false,
                      "error" => "La capa no existe o no pudo ser cargada");
        
        $params = $this->input->post(null, true);
        
        $lista_comunas = $this->emergencia_comuna->listComunas($params["id_emergencia"]);
        if(count($lista_comunas)>0){
            $resultado = $this->_cargaCapa($params["id"], $lista_comunas);
            if(!is_null($resultado)){
                $data = array("correcto" => true,
                              "capa" => $resultado);
            }
        }
        
        echo json_encode($data);
    }
    
    /**
     * Retorna las capas asociadas a una emergencia
     */
    public function ajax_capas_emergencia(){
        header('Content-type: application/json');
        $data = array("correcto" => true,
                      "resultado" => array("capas" => array()));
        
        $params = $this->input->post(null, true);
        $emergencia = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            
            $lista_comunas = $this->emergencia_comuna->listComunas($emergencia->eme_ia_id);

            $lista_capas = $this->_emergencia_capas_model->listaPorEmergencia($emergencia->eme_ia_id);
            if(count($lista_capas)>0){
                foreach($lista_capas as $capa){
                    $resultado = $this->_cargaCapa($capa["id_geometria"], $lista_comunas);
                    if(!is_null($resultado)){
                        $data["correcto"] = true;
                        $data["resultado"]["capas"][$capa["id_geometria"]] = $resultado;
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
        header('Content-type: application/json');
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
    protected function _cargaCapa($id_subcapa, $comunas = array()){
        fb("Cargando capa " . $id_subcapa);
        $retorno = null;
        
        $subcapa = $this->_capa_geometria_model->getById($id_subcapa);
        if(!is_null($subcapa)){
            $capa = $this->_capa_model->getById($subcapa->geometria_capa);
            if(!is_null($capa)){
                $json = array();
                $lista_poligonos = $this->_capa_poligono_informacion_model->listarPorSubcapaComuna($subcapa->geometria_id, $comunas);
                if(count($lista_poligonos)>0){
                    foreach($lista_poligonos as $poligono){
                        $json[] = array("id" => $poligono["poligono_id"],
                                        "propiedades" => $this->_limpiarUnserialize($poligono["poligono_propiedades"]),
                                        "geojson"     => unserialize($poligono["poligono_geometria"]));
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
    
    /**
     * Limpia datos de caracteres extraños
     * para envio como parametros
     * @param string $string
     * @return array
     */
    protected function _limpiarUnserialize($string){

        $filter = New Zend_Filter_Alnum();
        
        $nuevo = array();
        
        $array = unserialize($string);
        if(count($array)>0){
            foreach($array as $nombre => $valor){
              
                $nuevo[$filter->filter($nombre)] = htmlentities($valor);
            }    
        }
         return $nuevo;
    }
}